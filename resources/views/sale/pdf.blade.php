<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de Compra</title>
    <style>
        body {
            font-family: Arial, san-serif;
            font-size: 14px;
        }

        #datos {
            float: left;
            margin-top: 0%;
            margin-left: 2%;
            margin-right: 2%;
        }

        #encabezado {
            text-align: center;
            margin-left: 35%;
            margin-right: 35%;
            font-size: 15px;
        }

        #fact {
            float: right;
            margin-top: 2%;
            margin-left: 2%;
            margin-right: 2%;
            font-size: 20px;
            background: #33afff;
        }

        section {
            clear: left;
        }

        #cliente {
            text-align: left;
        }

        #faproveedor {
            width: 40%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 15px;            
        }

        #fac,
        #fv,
        #fa {
            color: #ffffff;
            font-size: 15px;
        }

        #faproveedor  thead {
            padding: 20px;
            background: #33afff;
            text-align: left;
            border-bottom: 1px solid #ffffff; 
        }

        #faccomprador {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 15px; 
        }

        #faccomprador  thead {
            padding: 20px;
            background: #33afff;
            text-align: center;
            border-bottom: 1px solid #ffffff; 
        }

        #facproducto {
            width: 100%;
            border-collapse: collapse;
            border-spacing: 0;
            margin-bottom: 15px; 
        }

        #facproducto  thead {
            padding: 20px;
            background: #33afff;
            text-align: center;
            border-bottom: 1px solid #ffffff; 
        }

    </style>
</head>
<body>
    <header>
        <div id="Logo">
            <img src="" alt="" id="imagen">
        </div>
        <div>
            <table id="datos">
                <thead>
                    <tr>
                        <th id="">DATOS DEL VENDEDOR</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <th>
                            <p id="proveedor">Nombre: {{$sale->user->name}} <br>
                            <!-- Direccion: {{$sale->user->address}} <br>
                            Telefono: {{$sale->user->phone}} <br> -->
                            Email: {{$sale->user->email}}
                            </p>
                        </th>
                    </tr>
                </tbody>
            </table>
        </div>
        <div id="fact">
            <p>NUMERO DE VENTA<br />
                {{$sale->id}}</p>
        </div>
    </header>
    <br>

    <br>
    <section>
        <div>
            <table id="facprodcuto">
                <thead>
                    <tr id="fa">
                        <th>CANTIDAD</th>
                        <th>PRODUCTO</th>
                        <th>PRECIO VENTA (PEN)</th>
                        <th>DESCUENTO (%)</th>
                        <th>SUBTOTAL (PEN)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($saleDetails as $saleDetail)
                    <tr>
                        <td>{{$saleDetail->quantity}}</td>
                        <td>{{$saleDetail->product->name}}</td>
                        <td>{{$saleDetail->price}}</td>
                        <td>{{$saleDetail->discount}}</td>
                        <td>{{number_format ($saleDetail->quantity*$saleDetail->price-$saleDetail->quantity*$saleDetail->price*$saleDetail->discount/100,2)}}</td>
                    </tr>
                    @endforeach
                </tbody>
                <tfoot> 
                    <tr>
                        <th colspan="3">
                            <p aling="right">SUBTOTAL:</p>
                        </th>
                        <td>
                            <p aling="right">s/ {{number_format($subtotal,2)}}</p>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="3">
                            <p aling="right">TOTAL IMPUESTO ({{$sale->tax}}%):</p>
                        </th>
                        <td>
                            <p aling="right">s/ {{number_format($subtotal*$sale->tax/100,2)}}</p>
                        </td>
                    </tr>
                    <tr>
                        <th colspan="3">
                            <p aling="right">TOTAL A PAGAR:</p>
                        </th>
                        <td>
                            <p aling="right">s/ {{number_format($sale->total,2)}}</p>
                        </td>
                    </tr>
                </tfoot>
            </table>
        </div>
    </section>
    <br>
    <br>
    <footer>
    <div id="datos">
        <p id="encabezado">
            <b>{{$company->name}}</b><br>{{$company->description}}<br>Telefono:{{$company->phone}}<br>Email:{{$company->email}}
        </p>
    </div>

    </footer>  
</body>
</html>