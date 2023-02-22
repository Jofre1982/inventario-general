<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Provider;
use App\Models\Product;
use App\Http\Requests;
use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;

class ProductController extends Controller
{ 
    public function index()
    {
        $products = Product::get();
        return view('product.index', compact('products'));
    }

   
    public function create()
    {
        $categories = Category::get();
        $providers = Provider::get();
        return view('product.create',compact('categories','providers'));
    }

    
    public function store(StoreRequest $request)
    {
        if($request->hasFile('picture')){
            $file = $request->file('picture');
            $image_name = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('/image'), $image_name);
        }
        $product = Product::create($request->all()+['image'=>$image_name,
        ]);
        $product->update(['code'=>$product->id]);
        return redirect()->route('products.index');
    }

   
    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }

   function edit(Product $product)
    {
        $categories = Category::get();
        $providers = Provider::get();
        return view('product.edit', compact('product','categories','providers'));    
    }

   
    public function update(UpdateRequest $request, Product $product)
    {
        if($request->hasFile('picture')){
            $file = $request->file('picture');
            $image_name = time().'_'.$file->getClientOriginalName();
            $file->move(public_path('/image'), $image_name);
        }
        $product->update($request->all()+['image'=>$image_name,]);

        return redirect()->route('products.index');
    }

 
    public function destroy(Product $product)
    {
        $product->delete();
        return redirect()->route('products.index');

    }
}
