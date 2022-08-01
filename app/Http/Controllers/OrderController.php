<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Order;
use App\Models\orderArchive;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

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
            'cart'=>[]
        ]);
        if($formFields['total']==0){
            return redirect('/')->with('message', 'Objednávka nebyla vytvořena, košík je prázdný');
        }
        else{

            $response=array();
        //
            foreach(json_decode($formFields['cart']) as $id=>$amount){
            $product=Product::find($id);
            if($product==null){
                
            }
            array_push($response, [
                'amount'=>$amount,
                'product'=>$product
            ]);
        };
        
        $formFields['cart']=json_encode($response);
        
        if(isset(auth()->user()->name)){
        $formFields['user_id']=auth()->user()->id;}
        $request->session()->put('cart', []);
        $order=Order::create($formFields);
        return view('orderView', ['order'=>$order]);}
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
        'email'=>$order->email    
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
