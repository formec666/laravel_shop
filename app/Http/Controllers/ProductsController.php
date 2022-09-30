<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Item;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function viewSingle($id){
        return response( 
            view('product', ['product'=>Product::find($id)])
        );
    }//
    public function viewEdit($id){
        $product=Product::find($id);
        $storage=[];
        $items=Item::all();
        foreach($items as $item){
        foreach($item->isStored as $isStored){
            $isStored->storageSpace;
        }}
        
        //dd($items);
        return response(view('admin.edit', ['listing'=>$product, 'items'=>$items]));
    }

    public function add(){
        return response(view('admin.add', ['items'=>Item::all()]));
    }

    public function edit(Request $request, Product $product){
        $formFields = $request->validate([
            'name' => 'required',
            'tags' => [],
            'description' => 'required',
            'price' => 'required|numeric',
            'item_id'=>'numeric'
            
        ]);

        if($request->hasFile('logo')) {
            $formFields['image'] = $request->file('logo')->store('logos', 'public');
        }

        $product->update($formFields);

        return back()->with('message', 'Product '.$product['id'].' updated successfully!');
    }

    public function store(Request $request, Product $product){
        $formFields = $request->validate([
            'name' => 'required',
            'tags' => [],
            'description' => 'required',
            'price' => 'required|numeric',
            'item_id'=>'numeric'
            
        ]);

        if($request->hasFile('logo')) {
            $formFields['image'] = $request->file('logo')->store('logos', 'public');
        }

        $product->create($formFields);

        return redirect('/admin/products')->with('message', 'Product '.$product['id'].' created successfully!');
    }

    public function destroy(Product $product){
        $product->delete();
        return back()->with('message', 'Produkt smazán');
    }
}
