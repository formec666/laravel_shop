<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Expense;
use App\Models\Storage;
use App\Models\StorageSpace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class StorageController extends Controller
{
    public function mainStorage(){
        return view('admin.storage.main', ['items'=>Item::all()]);
    }

    public function spaces(){
        return view('admin.storage.spaces', ['spaces'=>StorageSpace::all()]);
    }

    public function createSpace(){
        return view('admin.storage.spaceform');
    }

    public function storeSpace(Request $request, StorageSpace $space){
        $formdata=$request->validate([
            'name'=>'required',
            'description'=>[],
        ]);
        $space->create($formdata);
        return redirect('/admin/storage/spaces');
    }

    public function saveSpace(Request $request, StorageSpace $space){
        $formdata=$request->validate([
            'name'=>'required',
            'description'=>'required',
        ]);
        $space->update($formdata);
        return redirect('/admin/storage/spaces');
    }

    public function editSpaces(StorageSpace $space){
        return view('admin.storage.spaceform', ['space'=>$space]);
    }

    public function createItem(StorageSpace $space){
        return view('admin.storage.itemform', ['space'=>$space]);
    }
    public function storeItem(Request $request, Item $item){
        $formdata=$request->validate([
            'name'=>['required', Rule::unique('items', 'name')],
            'unit'=>'required',
            'distributor'=>'required',
            'description'=>'required'
        ]);

        $item->create($formdata);

        return redirect('/admin/storage')->with('message', 'Položka vytvořena na skladě');
    }

    public function saveStockUp(Request $request, Item $item, Storage $storage, Expense $expense){
        $formdata=request()->validate([
            'price'=>['required', 'numeric'],
            'amount'=>'required|numeric',
            'storage'=>'required',
            'description'=>'required'
        ]);

        if($request->hasFile('document')) {
            $formFields['document'] = $request->file('document')->store('documents', 'public');
        }
        //dd($formdata);

        $total=$item['total']+$formdata['amount'];
        
        $stockup=['item_id'=>$item['id'],
        'in'=>$formdata['storage'],
        'amount'=>$formdata['amount']];

        if(!$storage->where('item_id', $stockup['item_id'])->where('in', $stockup['in'])->exists()){
            
            $storage->create($stockup);
        }
        else{
            $storage=$storage->where('item_id', $stockup['item_id'])->where('in', $stockup['in'])->first();
            $stockup['amount']=$storage['amount']+$stockup['amount'];
            
            $storage=$storage->update($stockup);
           
        }

        $item->update(['total'=>$total]);

        $expenseData=[
            'description'=>$formdata['description'],
            'amount'=>$formdata['price'],
            'user'=>Auth()->user()->id
        ];

        $expense->create($expenseData);

        return redirect('/admin/storage')->with('message', 'Položka vytvořena na skladě');
    }

    public function viewStockupForm(Item $item){

        return view('admin.storage.stockup', ['item'=>$item, 'storages'=>StorageSpace::all()]);
    }

    public function showItem(Item $item){
        //dd($item->isStored);
        $storages=$item->isStored;
        //$storageSpaces=[];
        foreach($storages as $storage){
            $storage->storageSpace;
        }
        return view('admin.storage.item', ['item'=>$item]);
    }

}
