<div class="row">
    <div class="col-md-8 form-group">
        <label for="name">Nombre *</label>
        <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $product->name) }}" required autofocus>
    </div>
    <div class="col-md-4 form-group">
        <label for="code">Código de barras</label>
        <input type="text" class="form-control" name="code" id="code" value="{{ old('code', $product->code) }}" maxlength="50" placeholder="Escanéelo aquí">
        <small class="form-text text-muted">Si lo deja vacío se usa el número interno del producto.</small>
    </div>
    <div class="col-md-4 form-group">
        <label for="sell_price">Precio de venta *</label>
        <input type="number" class="form-control" name="sell_price" id="sell_price" value="{{ old('sell_price', $product->sell_price) }}" min="0" step="any" required>
    </div>
    <div class="col-md-4 form-group">
        <label for="min_stock">Stock mínimo</label>
        <input type="number" class="form-control" name="min_stock" id="min_stock" value="{{ old('min_stock', $product->min_stock ?? 5) }}" min="0" step="1">
        <small class="form-text text-muted">Al llegar a esta cantidad aparece como “stock bajo”.</small>
    </div>
    <div class="col-md-4 form-group">
        <label>Stock actual</label>
        <input type="text" class="form-control" value="{{ $product->stock ?? 0 }}" disabled>
        <small class="form-text text-muted">Cambia solo con compras y ventas.</small>
    </div>
    <div class="col-md-6 form-group">
        <label for="category_id">Categoría *</label>
        <select class="form-control" name="category_id" id="category_id" required>
            <option value="">Seleccione...</option>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 form-group">
        <label for="provider_id">Proveedor *</label>
        <select class="form-control" name="provider_id" id="provider_id" required>
            <option value="">Seleccione...</option>
            @foreach ($providers as $provider)
                <option value="{{ $provider->id }}" @selected(old('provider_id', $product->provider_id) == $provider->id)>{{ $provider->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-md-6 form-group">
        <label for="picture" class="d-block">Imagen</label>
        @if ($product->image)
            <img src="{{ $product->image_url }}" alt="" class="product-thumb mb-2 d-block">
        @endif
        <input type="file" id="picture" name="picture" accept="image/*">
    </div>
</div>
@if ($categories->isEmpty() || $providers->isEmpty())
    <div class="alert alert-warning">
        Antes de crear productos debe registrar al menos una
        <a href="{{ route('categories.create') }}" class="alert-link">categoría</a> y un
        <a href="{{ route('providers.create') }}" class="alert-link">proveedor</a>.
    </div>
@endif
