<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    public function viewSingle($id){
        return response( 
            view('product', ['product'=>Product::find($id)])
        );
    }//
    public function viewEdit($id){
        return response(view('admin.edit', ['listing'=>Product::find($id)]));
    }

    public function add(){
        return response(view('admin.add'));
    }

    public function edit(Request $request, Product $product){
        $formFields = $request->validate([
            'name' => 'required',
            'tags' => [],
            'description' => 'required',
            'price' => 'required|numeric',
            
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
