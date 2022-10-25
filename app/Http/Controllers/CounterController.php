<?php

namespace App\Http\Controllers;

use App\Models\Check;
use App\Models\Storage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CounterController extends Controller
{
    function show(){
        return view('admin.counter');
    }//

    function checkOut(Request $request){
        $checkData=[
            'name'=>$request->name,
            'cart'=>json_encode($request->check),
            'user_id'=>Auth()->user()->id,
            'payment'=>$request->payment
        ];
        if($request->check==[]){
            return response('Prázdný košík', 404)->header('Content-Type', 'text/plain');
        }
        if(isset($request->id)){
            $check=Check::find($request->id);
            $check->update($checkData);
        }
        else{
            $check=Check::create($checkData);
        }
        foreach ($request->check as $key => $item) {
            if (isset($item->id)) {
                $wotever =RecipeController::removeFromStorage($item->id, $item->amount, 1);
            }
        }
        return response()->json(['check'=>$check]);

    }

    function storeCheck(Request $request, Check $check){
        $checkData=[
            'name'=>$request->name,
            'cart'=>json_encode($request->check),
            'user_id'=>Auth()->user()->id,
        ];
        //dd($request);
        if((!isset($request->id)) and ($request->name!=null and $request->check!=[])){
            $check=$check->create($checkData);            
            //return response()->json(['check'=>$check]);
        }
        elseif(isset($request->id) and ($request->name!=null and $request->check!=[])){
            $check=Check::find($request->id);
            $check->update($checkData);
            
            //return response()->json(['check'=>$check]);
        }
        elseif(isset($request->id) and ($request->name==null and $request->check==[])){
            $check=Check::find($request->id)->delete();
            //return response()->json(['check'=>$check]);
        }
        
        
        return response()->json(['check'=>$check]);
    }

    function checks(){
        return response()->json(['checks'=>Check::latest()->where('payment', null)->get()]);
    }
}
