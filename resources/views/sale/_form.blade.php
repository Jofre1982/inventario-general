<div class="form-group">
    <label for="provider_id">Cliente</label>
    <select style="background-color: #1e1e2f;" class="form-control" name="client_id" id="client_id">
        @foreach($clients as $client)
        <option value="{{$client ->id}}">{{$client->name}} </option>
        @endforeach
    </select>
</div>
<div class="form-group">
    <label for="tax">Impuesto</label>
    <input type="number" class="form-control" name="tax" id="tax" aria-describedby="helpId" placeholder="%18">
</div>
<div class="form-group">
    <label for="product_id">Producto</label>
    <select style="background-color: #1e1e2f;" class="form-control" name="product_id" id="product_id">
        @foreach($products as $product)
        <option value="{{$product->id}}_{{$product->stock}}_{{$product->sell_price}}">{{$product->name}}</option>
        @endforeach
    </select>
</div class="form-group">
<label for="">Stock Actual</label>
<input type="text" class="form-control" name="" id="stock" value="" disabled>
<div>
</div>
<div class="form-group">
    <label for="quantity">Cantidad</label>
    <input type="number" class="form-control" name="quantity" id="quantity" aria-describedby="helpId" placeholder="">
</div>
<div class="form-group">
    <label for="price">Precio de Venta</label>
    <input type="number" class="form-control" name="price" id="price" aria-describedby="helpId" disabled>
</div>
<div class="form-group">
    <label for="discount">Descuento %</label>
    <input type="number" class="form-control" name="discount" id="discount" aria-describedby="helpId" value="0">
</div>
<div class="form-group" style="text-align:right">
    <button type="button" id="agregar" class="btn btn-primary floath-righ">Agregar Producto</button>
</div>
<div class="form-group">
    <h4 class="card-title">Detalle de la Venta</h4>
    <div class="table-responsive col-md-12">
        <table id="detalles" class="table table-striped">
            <thead>
                <th>Eliminar</th>
                <th>Producto</th>
                <th>Precio de venta</th>
                <th>Descuento</th>
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
                <tr>
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
