<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\orderArchive;
use App\Models\Product;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function admin(Request $request){
        return view('admin.admin');
    }
    public function products(){
        //dd(Product::latest()->filter(request(['tags', 'search'])));
        return view('admin.products', ['products' => Product::all()]);
    }
    public function ordersView(Request $request){
        return view('admin.orders');
    }

    public function orderJson(Request $request)
    {
        $orders=Order::oldest()->filter(request(['status', 'search']))->/*where('taken_by', auth()->user()->id)->*/orWhere('taken_by', null)->get();
        foreach($orders as $order){
            $order['payment_status']=OrderController::getOrderPayment($order->payment_method);
        }
        return response()->json(['orders'=>$orders]);
    }

    public function moveOrder(Request $request, orderArchive $orderArchive){
        $order=Order::find($request['order']);
        
        if($request['to']<6&&$request['to']>=0){$fields=[
            'taken_by'=>auth()->user()->id,
            'status'=>$request['to'],
        ];
        if($request['to']<=1){$fields=['taken_by'=>null, 'status'=>$request['to']];
            
        }
        $order->update($fields);
            
        }
        elseif($request['to']==6){
            $orderArchive->user_id=$order['user_id'];
            $orderArchive->cart=$order['cart'];
            $orderArchive->total=$order['total'];
            $orderArchive->name=$order['name'];
            $orderArchive->address=$order['address'];
            $orderArchive->invoiceName=$order['invoiceName'];
            $orderArchive->invoiceAddress=$order['invoiceAddress'];
            $orderArchive->email=$order['email'];
            $orderArchive->status=$order['id'];
            $orderArchive->archived_by=auth()->user()->id;
            $orderArchive->payment_method=$order['payment_method'];
            $orderArchive->save();
            $order->delete();
        }
        elseif($request['to']==7){$fields=[
            'status'=>6];
            $order->update($fields);
        }
        return true;
    }
    
}
