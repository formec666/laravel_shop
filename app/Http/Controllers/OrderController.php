<?php

namespace App\Http\Controllers;


use App\Models\User;
use App\Models\Order;
use App\Models\orderArchive;
use App\Models\Product;
use App\Models\Storage;
use GuzzleHttp\Psr7\Message;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use Mail;
use Stripe\StripeClient;

class OrderController extends Controller
{

    public function show(Request $request){
        $pairs=array();
        foreach($request->session()->get('cart', []) as $id=>$amount){
            $product=json_decode(Product::find($id), true);
            array_push($pairs, [$amount=>$product]);
        }
        //dd($pairs);
        return view('order', ['data'=>$pairs, 'cart'=>$request->session()->get('cart', [])]);
    }
    //
    public function store(Request $request){
        

        $formFields = $request->validate([
            'name'=>['required', 'min:3'],
            'email'=>['required', 'email'],
            'address'=>'required',
            'invoiceName'=>[],
            'invoiceAddress'=>[],
            'total'=>['required', 'numeric'],
            'cart'=>[],
            'payment_method'=>'required',
            'note'=>[]
        ]);
        if($formFields['total']==0){
            return redirect('/')->with('message', 'Objednávka nebyla vytvořena, košík je prázdný');
        }
        //dd($request);

            $response=array();
            $line_items=array();
        
            foreach(json_decode($formFields['cart']) as $id=>$amount){
                $product=Product::find($id);
                RecipeController::removeFromStorage($product->item->id, $amount, 1);
                array_push($response, [
                    'amount'=>$amount,
                    'product'=>$product
                ]);
                array_push($line_items, [
                    'price_data'=>[
                        'currency'=>'czk',
                        'unit_amount'=>$product->price*100,
                        'product_data'=>[
                            'name'=>$product->name,
                            'images'=>[asset('storage/'.$product->image)],
                            'description'=>$product->description
                        ]
                    ],
                    'quantity'=>$amount
                ]);
            };
            $url=false;
            if ($request->payment_method=='card'){
                \Stripe\Stripe::setApiKey(env('STRIPE_KEY'));

                $checkout_session= \Stripe\Checkout\Session::create([
                    'line_items'=>$line_items,
                    'mode'=>'payment',
                    'success_url'=>'http://127.0.0.1:8000/',
                    'cancel_url'=>'http://127.0.0.1:8000/'
                ]);
                $formFields['payment_method']=$checkout_session->id;
                $url=$checkout_session->url;
            }
        
        $formFields['cart']=json_encode($response);
        
        if(isset(auth()->user()->name)){
        $formFields['user_id']=auth()->user()->id;}
        $request->session()->put('cart', []);
        $order=Order::create($formFields);
        Mail::to($order->email)->send(new \App\Mail\OrderCreate($order, $order->payment_method, $url));
        return view('admin.mail', ['order'=>$order, 'payment'=>$order->payment_method, 'url'=>$url]);
    }

    public function getOrderPayment($payment_method){
        if($payment_method=='Dobírka' || $payment_method=='post'){
            return 'Platbla dobírkou';
        }
        else{
            $stripe=new \Stripe\StripeClient(env('STRIPE_KEY'));
            $session=$stripe->checkout->sessions->retrieve($payment_method);
            //dd($session);
            switch ($session->payment_status){
                
                case 'paid':
                    return ('<span class="text-green-500"><a href="https://dashboard.stripe.com/test/payments/'.$session->payment_intent.'">Zaplaceno</a></span>');
                    break;
                case 'unpaid':
                    return ('<span class="text-red-500"><a href="https://dashboard.stripe.com/test/payments/'.$session->payment_intent.'">Nezaplaceno</a></span>');
                    break;
                default:
                    return('<span class="text-green-500">Neznámý stav platby, <a href="https://dashboard.stripe.com/test/payments/'.$session->payment_intent.'">zkontrolovat</a></span>');
            }
        }
    }

   

    public function users(Request $request){
        $orders=User::find(auth()->user()->id)->orders;
        $archivedOrders=User::find(auth()->user()->id)->archived;
        //dd($archivedOrders);
        return view('userOrders', ['data'=>['orders'=>$orders, 'archived'=>$archivedOrders], 'archive'=>false]);
    }

    public function showArchive(Request $request){
        //$orders=User::find(auth()->user()->id)->orders;
        $archivedOrders=[];
        return view('userOrders', ['data'=>['archived'=>orderArchive::latest()->filter(request(['search']))->get(), 'orders'=>[]], 'archive'=>true]);
    }

    public function activate(Request $request, orderArchive $order){
        $data=['id'=>$order->status,
        'user_id'=>$order->user_id,
        'cart'=>$order->cart,
        'total'=>$order->total,
        'name'=>$order->name,
        'address'=>$order->address,
        'invoiceName'=>$order->invoiceName,
        'invoiceAddress'=>$order->invoiceAddress,
        'status'=>0,
        'email'=>$order->email,
        'payment_method'=>$order->payment_method,
        'note'=>$order->note
    ];
        Order::create($data);
        $order->delete();
        //dd($order);
        return redirect('showArchive');
    }

    public function admin(Request $request){
        //dd(Order::all());
        return view('userOrders', ['data'=>Order::latest()->get()]);
    }
}
