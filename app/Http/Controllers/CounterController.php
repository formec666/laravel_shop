<?php

namespace App\Http\Controllers;

use App\Models\Check;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CounterController extends Controller
{
    function show(){
        return view('admin.counter');
    }//

    function storeCheck(Request $request, Check $check){
        $checkData=[
            'name'=>$request->name,
            'cart'=>$request->check,
            'user_id'=>Auth()->user()->id

        ];
        if(isset($request->id)){
            $check=$check->where('id',$request->id)->first();
            if((!isset($request->name)) && ($request->cart==[])){
                //dd($check);
                $check->delete();
                $helper=[
                    'id'=> null,
                    'name'=>null,
                    'cart'=>[]
                ];
                return response()->json(['check'=>$helper]);
            }
            $check->update($checkData);
        }
        else{$check=$check->create($checkData);}
        return response()->json(['check'=>$check]);
    }

    function checks(){
        return response()->json(['checks'=>Check::latest()->where('payment', null)->get()]);
    }
}
