<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Contracts\Session\Session;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //přidá item do košíku
    public function add(Request $request){
        $id=$request['id'];
        $amount=$request['amount'];
        $cart = session()->get('cart', []);
        if($amount==0){
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        if($amount>0){        
            $cart[$id]=$amount;        
            session()->put('cart', $cart);
        }
        
        return redirect('/')->with('message', 'Zboží přidáno do košíku');
    }

    public function addAndSum(Request $request){
        $id=$request['id'];
        $amount=$request['amount'];
        $cart = session()->get('cart', []);
        if($amount==0){
            unset($cart[$id]);
            session()->put('cart', $cart);
        }
        if($amount>0){        
            $cart[$id]=$amount;        
            session()->put('cart', $cart);
        }
        $sum=0;
        foreach($request->session()->get('cart', []) as $id=>$amount){
            $product=Product::find($id);
            $sum=$sum+$product['price']*$amount;
        }
        
        return response()->json(['sum'=>$sum]);
    }
    
    //zobrazí košík
    public function show(Request $request){
        $pairs=array();
        $product=null;
        foreach($request->session()->get('cart', []) as $id=>$amount){
            $product=json_decode(Product::find($id), true);
            array_push($pairs, [$amount=>$product]);
        }
        //dd($pairs);
        return view('cart', ['data'=>$pairs]);
    }

    public function get(Request $request){
        $response=array();
        //dd($request->cart);
        foreach(json_decode($request->cart) as $id=>$amount){
            $product=Product::find($id);
            if($product==null){
                
            }
            array_push($response, [
                'amount'=>$amount,
                'product'=>$product
            ]);
        };

        return response()->json($response);

    }

    public function delete(Request $request)
    {
        $request->session()->flush();
    }
}
