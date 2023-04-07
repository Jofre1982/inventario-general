@extends('layouts.app', ['page' => __('Compras'), 'pageSlug' => 'Registerpurchases'])

@section('content')
<section class="content-header">
    <div class="container-fluid">
        <div class="row mb-2">
            <div class="col-sm-6">
                <h1>Crear Compra</h1>
            </div>
        </div>

    </div>
</section>


{!! Form::open(['route'=>'purchases.store','method'=>'POST']) !!}

@include('purchase._form')



<a href="{{ route('purchases.index') }}" class="btn btn -ligth">Cancelar</a>
<button type="submit" id="guardar" class="btn btn-primary mr-2">Registrar</button>

{!! Form::close() !!}
@endsection

@push('js')
<script>
    $(document).ready(function() {
         $("#agregar").click(function() {
             agregar();
         });
    });
    var cont = 0;
    total = 0;
    subtotal = [];

    $("#guardar").hide();

    function agregar() {
        product_id = $("#product_id").val();
        producto = $("#product_id option:selected").text();
        quantity = $("#quantity").val();
        price = $("#price").val();
        impuesto = $("#tax").val();
        if (product_id != "" && quantity != "" && quantity > 0 && price != "") {
            subtotal[cont] = quantity * price;
            total = total + subtotal[cont];
            var fila = '<tr class="selected" id="fila' + cont + '"><td><button type="button class="btn btn-danger btn-sm" onclick="eliminar(' + cont + ');"><i class="fa fa-times"></button></td> <td><input type="hidden" name="product_id[]" value"' + product_id + '">' + producto + '</td> <td> <input type = "hidden" id="price[]" name="price[]" value="' + price +'"> <input class="form-control" type="number" id="price[]" value="' + price +'" disabled> </td> <td> <input type="hidden" name="quantity[]" value="' + quantity + '"> <input class="form-control" type="number" value="' + quantity + '"disabled> </td> <td aling="right">s/' + subtotal[cont] + ' </td></tr>';
            cont++;
            limpiar();
            totales();
            evaluar();
            $('#detalles').append(fila);

        } else {
            Swal.fire({
                type: 'error',
                text: 'Rellene todos los campos del detalle de las compras',
            })
        }
    }

    function limpiar() {
        $('#quantity').val("");
        $('#price').val("");
    }

    function totales() {
        $('#total').html("PEN" + total.toFixed(2));
        total_impuesto = total * impuesto / 100;
        total_pagar = total + total_impuesto;
        $("#total_impuesto").html("PEN" + total_impuesto.toFixed(2));
        $("#total_pagar_html").html("PEN" + total_pagar.toFixed(2));
        $("#total_pagar").val(total_pagar.toFixed(2));

    }

    function evaluar(){
        if(total>0){
            $("#guardar").show();
        } else{
            $("#guardar").hide();
        }
    }

    function eliminar(index){
        total = total-subtotal[index];
        total_impuesto = total*impuesto / 100;
        total_pagar_html = total + total_impuesto;
        $("#total").html("PEN" + total);
        $("#total_impuesto").html("PEN" + total_impuesto);
        $("#total_pagar_html").html("PEN" + total_pagar_html);
        $("#total_pagar").val(total_pagar_html.toFixed(2));
        $("#fila" + index).remove();
        evaluar();
    }
</script>
@endpush


