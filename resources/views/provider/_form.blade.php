<div class="row">
    <div class="col-md-6 form-group">
        <label for="name">Nombre *</label>
        <input type="text" class="form-control" name="name" id="name" value="{{ old('name', $provider->name) }}" required autofocus>
    </div>
    <div class="col-md-6 form-group">
        <label for="nit">NIT *</label>
        <input type="text" class="form-control" name="nit" id="nit" value="{{ old('nit', $provider->nit) }}" maxlength="20" required>
    </div>
    <div class="col-md-6 form-group">
        <label for="email">Correo *</label>
        <input type="email" class="form-control" name="email" id="email" value="{{ old('email', $provider->email) }}" required>
    </div>
    <div class="col-md-6 form-group">
        <label for="phone">Teléfono *</label>
        <input type="text" class="form-control" name="phone" id="phone" value="{{ old('phone', $provider->phone) }}" maxlength="20" required>
    </div>
    <div class="col-12 form-group">
        <label for="adress">Dirección</label>
        <input type="text" class="form-control" name="adress" id="adress" value="{{ old('adress', $provider->adress) }}">
    </div>
</div>
