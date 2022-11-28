<?php

namespace App\Http\Controllers;

use App\Models\Item;
use App\Models\Expense;
use App\Models\Storage;
use App\Models\StorageSpace;
use App\Models\Writeoff;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Unique;

class StorageController extends Controller
{
    public function getTotal($item){
        if($item==null){
            return 'Dostupnost neznámá';
        }
        $total=0;
        foreach($item->isStored as $storage){
            $total += $storage -> amount;
        }
        return $total;
    }

    public function getStatus($item){
        if ($item == null){
            return 'Dostupnost neznámá';
        }
        $total = StorageController::getTotal($item);
        if ($total == 0) {
            return 'Momentálně nedostupné';
        }
        return ('Skladem '.$total.' kusů');
    }

    public function mainStorage(){
        $items=Item::all();
        foreach($items as $item){
            $item->total=StorageController::getTotal($item);
        }
        return view('admin.storage.main', ['items'=>$items]);
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
        if($request->has('through')){
            $formdata['through']=true;
        }

        $item=$item->create($formdata);
        Storage::create(['amount'=>0, 'in'=>1, 'item_id'=>$item->id]);

        return redirect('/admin/storage')->with('message', 'Položka vytvořena na skladě');
    }

    public function saveStockUp(Request $request, Item $item, Storage $storage, Expense $expense){
        $formdata=request()->validate([
            'price'=>['required', 'numeric'],
            'amount'=>'required|numeric',
            'storage'=>'required',
            'description'=>'required',

        ]);        

        $total=$item['total']+$formdata['amount'];
        
        $stockup=['item_id'=>$item['id'],
        'in'=>$formdata['storage'],
        'amount'=>$formdata['amount']];

        Storage::create($stockup);

        $item->update(['total'=>StorageController::getTotal($item)]);

        $expenseData=[
            'description'=>$formdata['description'],
            'amount'=>$formdata['price'],
            'user_id'=>Auth()->user()->id
        ];
        
        if($request->hasFile('document')) {
            $expenseData['document'] = $request->file('document')->store('documents', 'public');            
        }

        //dd($expenseData);

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
        foreach($storages as $item_value) {
            
            $pid = $item_value['in'];
            if(!isset($final_array[$pid])) {
              $final_array[$pid] = $item_value;
            } else {
              $final_array[$pid]['amount'] += $item_value['amount'];
            }
         }
        
         $item['isStored']=$final_array; 
        return view('admin.storage.item', ['item'=>$item]);
    }

    public function writeOff(Item $item){
        $storages=$item->isStored;
        //$storageSpaces=[];
        foreach($storages as $storage){
            $storage->storageSpace;
        }

        return view('admin.storage.writeoff', ['item'=>$item, 'storageSpaces'=>$item->storageSpaces(), ]);
    }

    public function remove(Item $item, Writeoff $writeoff,Storage $storage){
        $formdata=request()->validate([
            'amount'=>'required|numeric',
            'storage_space_id'=>'required',
            'description'=>'required'
        ]);
        $writeoffData=[
            'amount'=>$formdata['amount'],
            'storage_space_id'=>$formdata['storage_space_id'],
            'description'=>$formdata['description'],
            'user_id'=>Auth()->user()->id,
            'item_id'=>$item->id
        ];
        $writeoff->create($writeoffData);
        $total=$item->total-$formdata['amount'];
        $item->update(['total'=>$total]);
        $storage=$storage->where('item_id', $item->id)->where('in', $formdata['storage_space_id'])->first();
        $storage->amount=$storage->amount-$formdata['amount'];
        $storage->save();
        return redirect('/admin/storage')->with('message', 'Položka byla odepsána');
    }

}
