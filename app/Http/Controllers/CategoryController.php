<?php

namespace App\Http\Controllers;

use App\Http\Requests\Category\StoreRequest;
use App\Http\Requests\Category\UpdateRequest;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function __construct()
    {
        $this->protectWithPermissions('categories');
    }

    public function index(Request $request)
    {
        $categories = Category::withCount('products')
            ->when($request->q, fn ($q, $term) => $q->where('name', 'like', "%{$term}%"))
            ->orderBy('name')
            ->paginate(25)
            ->withQueryString();

        return view('category.index', compact('categories'));
    }

    public function create()
    {
        return view('category.create');
    }

    public function store(StoreRequest $request)
    {
        Category::create($request->validated());

        return redirect()->route('categories.index')->with('success', 'Categoría creada.');
    }

    public function show(Category $category)
    {
        return redirect()->route('products.index', ['category' => $category->id]);
    }

    public function edit(Category $category)
    {
        return view('category.edit', compact('category'));
    }

    public function update(UpdateRequest $request, Category $category)
    {
        $category->update($request->validated());

        return redirect()->route('categories.index')->with('success', 'Categoría actualizada.');
    }

    public function destroy(Category $category)
    {
        return $this->deleteOrExplain($category, 'categories.index', 'No se puede eliminar: la categoría tiene productos.');
    }
}
