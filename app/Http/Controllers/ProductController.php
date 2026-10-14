<?php

namespace App\Http\Controllers;

use App\Http\Requests\Product\StoreRequest;
use App\Http\Requests\Product\UpdateRequest;
use App\Models\Category;
use App\Models\Product;
use App\Models\Provider;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    public function __construct()
    {
        $this->protectWithPermissions('products', [
            'change.status.products' => 'change_status',
        ]);
    }

    public function index(Request $request)
    {
        $products = Product::with('category')
            ->when($request->q, fn ($q, $term) => $q->where(fn ($w) => $w
                ->where('name', 'like', "%{$term}%")
                ->orWhere('code', $term)))
            ->when($request->category, fn ($q, $id) => $q->where('category_id', $id))
            ->when($request->boolean('low'), fn ($q) => $q->lowStock())
            ->orderBy('name')
            ->paginate(25)
            ->withQueryString();

        return view('product.index', compact('products'));
    }

    public function create()
    {
        $categories = Category::orderBy('name')->get();
        $providers = Provider::orderBy('name')->get();

        return view('product.create', compact('categories', 'providers'));
    }

    public function store(StoreRequest $request)
    {
        $data = $request->safe()->except('picture');
        $data['image'] = $this->storeImage($request);

        $product = Product::create($data);

        // Si no se escribió un código de barras se usa el ID como código interno.
        if (! $product->code) {
            $product->update(['code' => (string) $product->id]);
        }

        return redirect()->route('products.index')->with('success', 'Producto creado.');
    }

    public function show(Product $product)
    {
        return view('product.show', compact('product'));
    }

    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        $providers = Provider::orderBy('name')->get();

        return view('product.edit', compact('product', 'categories', 'providers'));
    }

    public function update(UpdateRequest $request, Product $product)
    {
        $data = $request->safe()->except('picture');

        if ($image = $this->storeImage($request)) {
            $data['image'] = $image;
        }
        if (empty($data['code'])) {
            $data['code'] = (string) $product->id;
        }

        $product->update($data);

        return redirect()->route('products.index')->with('success', 'Producto actualizado.');
    }

    public function destroy(Product $product)
    {
        return $this->deleteOrExplain($product, 'products.index', 'No se puede eliminar: el producto tiene ventas o compras. Puede desactivarlo.');
    }

    public function change_status(Product $product)
    {
        $product->update([
            'status' => $product->isActive() ? Product::INACTIVE : Product::ACTIVE,
        ]);

        return back()->with('success', $product->isActive() ? 'Producto activado.' : 'Producto desactivado.');
    }

    /**
     * Busca un producto por código de barras (exacto) o por nombre.
     * Lo usan los lectores de código de barras en ventas y compras.
     */
    public function lookup(Request $request)
    {
        $user = $request->user();
        abort_unless($user->can('sales.create') || $user->can('purchases.create') || $user->can('products.index'), 403);

        $term = trim((string) $request->q);

        if ($term === '') {
            return response()->json([]);
        }

        $exact = Product::where('code', $term)->first();
        $products = $exact
            ? collect([$exact])
            : Product::where('name', 'like', "%{$term}%")->orderBy('name')->limit(10)->get();

        return response()->json($products->map(fn (Product $p) => [
            'id' => $p->id,
            'code' => $p->code,
            'name' => $p->name,
            'stock' => $p->stock,
            'sell_price' => $p->sell_price,
            'active' => $p->isActive(),
        ])->values());
    }

    private function storeImage(Request $request): ?string
    {
        if (! $request->hasFile('picture')) {
            return null;
        }

        $file = $request->file('picture');
        $name = time() . '_' . Str::slug(pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME)) . '.' . $file->extension();
        $file->move(public_path('image'), $name);

        return $name;
    }
}
