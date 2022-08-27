<?php

namespace App\Http\Controllers;

use App\Models\Expense;
use App\Models\User;
use Illuminate\Http\Request;

class ExpenseController extends Controller
{
    public function view(){
        return view('admin.expenses.list');
    }

    public function filters(){
        $users= User::latest()->where('isAdmin',  true)->get();
        $min= Expense::orderBy('amount', 'asc')->first();
        $max= Expense::orderBy('amount', 'desc')->first()->amount;
        
        return response()->json(['users'=>$users, 'min'=>$min->amount, 'max'=>$max]);
    }

    public function get(){
        return response()->json(['expenses'=>Expense::latest()->filter(request(['max','min','since','until','user', 'search']))->get()]);
    }

    public function update(Request $request, Expense $expense){
        $formBody=[
            
            'amount'=>$request->amount,
            'description'=>$request->description
        ];

        $expense->update($formBody);

        return response(200);
    }
}
