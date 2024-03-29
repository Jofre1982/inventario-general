<div class="form-group">
    <label for="provider_id">Proveedor</label>
    <select style="background-color: #1e1e2f;" class="form-control" name="provider_id" id="provider_id">
        @foreach($providers as $provider)
        <option value="{{$provider->id}}">{{$provider->name}} </option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="tax">Impuesto</label>
    <input type="number" class="form-control" name="tax" id="tax" aria-describedby="helpId">
</div>
<div class="form-group">
    <label for="product_id">Producto</label>
    <select style="background-color: #1e1e2f;" class="form-control" name="product_id" id="product_id">
        @foreach($products as $product)
        <option value="{{$product->id}}">{{$product->name}}</option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="quantity">Cantidad</label>
    <input type="number" class="form-control" name="quantity" id="quantity" aria-describedby="helpId" placeholder="">
</div>
<div class="form-group">
    <label for="price">Precio</label>
    <input type="number" class="form-control" name="price" id="price" aria-describedby="helpId" placeholder="">
</div>
<div class="form-group" style="text-align:right">
    <button type="button" id="agregar" class="btn btn-primary floath-righ">Agregar Producto</button>
</div>
<div class="form-group">
    <h4 class="card-title">Detalle de la Compra</h4>
    <div class="table-responsive col-md-12">
        <table id="detalles" class="table table-striped">
            <thead>
                <th>Eliminar</th>
                <th>Producto</th>
                <th>Precio</th>
                <th>Cantidad</th>
                <th>Subtotal</th>
            </thead>
            <tfoot>
                <tr>
                    <th colspan="4">
                        <p style="text-align:right">TOTAL</p>
                    </th>
                    <th>
                        <p style="text-align:right">
                            <span id="total">PEN  0.00:</span>
                        </p>
                    </th>
                </tr>
                <tr id="dvOcultar">
                    <th colspan="4">
                        <p style="text-align:right">TOTAL IMPUESTO (18%):</p>
                    </th>
                    <th>
                        <p style="text-align:right">
                            <span id="total_impuesto">PEN  0.00</span>
                        </p>
                    </th>
                </tr>
                <tr>
                    <th colspan="4">
                        <p style="text-align:right">TOTAL PAGAR:</p>
                    </th>
                    <th>
                        <p style="text-align:right">
                            <span aling="right" id="total_pagar_html">PEN  0.00</span>
                            <input type="hidden" name="total" id="total_pagar">
                        </p>
                    </th>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
