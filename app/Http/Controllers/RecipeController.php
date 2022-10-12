<?php

namespace App\Http\Controllers;

use App\Models\Recipe;
use App\Models\Item;
use App\Models\Storage;
use App\Models\StorageSpace;
use Illuminate\Http\Request;
use stdClass;

class RecipeController extends Controller
{
    public function showAll(){
        $recipes=[];
        
        return response(view('admin.fabrication.all', ['items'=>Item::all()]));
    }//

    public function new(){
        return response(view('admin.fabrication.new', ['items'=>Item::all(), 'storageSpaces'=>StorageSpace::all()]));
    }

    public function store(Request $request){
        $formFields=$request->validate([
            'input'=>'required',
            'amount'=>'required|numeric',
            'output'=>'required',
            'from'=> ' required'
        ]);
        //$formFields['from']=1;
        $recipe=Recipe::create($formFields);
        return redirect('/admin/fabrication');
    }

    public function showItem(Request $request, Item $item, Recipe $recipes){
        $recipes=$item->recipes()->get();
        
        foreach($recipes as $recipe){
            $recipe['ingredient']=$recipe->recipe;
            $helper=[];
            foreach($recipe['ingredient']->isStored as $isStored){
                $helper[$isStored->id]=$isStored->storageSpace;            
            }
            $recipe['ingredient']['storages']=$helper;
        }
        //dd($recipes);
        return response(view('admin.fabrication.fabricate', ['item'=>$item, 'recipes'=>$recipes, 'storageSpaces'=>StorageSpace::all()]));

    }

    public function move(Request $request, Item $item, Recipe $recipes){
        foreach($item->isStored as $isStored){
            
            $pid = $isStored['in'];
            if(!isset($final_array[$pid])) {
              $final_array[$pid] = $isStored;
            } else {
              $final_array[$pid]['amount'] += $isStored['amount'];
            }
        }
        //dd($final_array);
        foreach($final_array as $isStored){
            $helper[$isStored->id]=$isStored->storageSpace;
        }

        $item->storages=$helper;
        
        //dd($item);
        return response(view('admin.fabrication.move', ['item'=>$item, 'storageSpaces'=>StorageSpace::all()]));

    }

    public function fabricate(Request $request, Item $item){
        $formFields=$request->validate([
            'amount'=>'required|numeric',
            'takeFrom'=>'required',
            'storeIn'=>'required',
            'takeFrom.*'=>'required'
        ]);
        $addition=[
            'amount'=>$formFields['amount'],
            'item_id'=>$item->id,
            'in'=>$formFields['storeIn']
        ];
        foreach($formFields['takeFrom'] as $key => $value){
            $required = Recipe::all()->where('input', $key)->where('output', $item->id)->first();
            if($required==null){
                $required=new stdClass();
                $required->amount=1;
            }
            $storageData=[
                'item_id'=>$key,
                'in'=>$value,
                'amount'=> - ($required->amount*$formFields['amount']),

            ];
            //$item=Item::find($key);
            RecipeController::removeFromStorage($key, $storageData['amount'], $value);
            //Storage::create($storageData);
        }
        Storage::create($addition);
        return redirect('/admin/fabrication')->with('message', 'Vyrobeno '.$item->name);
    }

    public function removeFromStorage($itemId, $amount, $in){
        $item=Item::find($itemId);
        if($item->through==true){
            foreach($item->pivotedRecipes as $recipe){
                RecipeController::removeFromStorage($recipe->id, $recipe->pivot->amount, $recipe->pivot->from);
            }
        }
        else{
            Storage::create(['item_id'=>$item->id, 'amount'=>-$amount, 'in'=>$in]);
        }
        
    }

    public function editation(Item $item){
        return response(view('admin.fabrication.edit', ['item'=>$item, 'recipes'=>$item->pivotedRecipes]));
    }
}
