<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests;
use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;



class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::get();
        return view('category.index', compact('categories'));
    }

   
    public function create()
    {
        return view('category.create');
    }

    
    public function store(StoreRequest $request)
    {
        Category::create($request->all());
        return redirect()->route('categories.index');
    }

   
    public function show(Category $category)
    {
        return view('category.show', compact('category'));
    }

   function edit(Category $category)
    {
        return view('category.edit', compact('category'));    
    }

   
    public function update(UpdateRequest $request, Category $category)
    {
        $category->update($request->all());
        return redirect()->route('categories.index');
    }

 
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('categories.index');

    }
}
