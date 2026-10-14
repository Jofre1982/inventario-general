<div class="form-group">
    <label for="name">Nombre *</label>
    <input type="text" name="name" id="name" value="{{ old('name', $category->name) }}" class="form-control" maxlength="50" required autofocus>
</div>
<div class="form-group">
    <label for="descriptions">Descripción</label>
    <textarea class="form-control" name="descriptions" id="descriptions" rows="3" maxlength="255">{{ old('descriptions', $category->descriptions) }}</textarea>
</div>
