<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Client;
use App\Http\Requests\Sale\StoreRequest;
use App\Http\Requests\Sale\UpdateRequest;
use App\Models\Provider;
use App\Models\Product;
use Barryvdh\DomPDF\Facade as PDF;

class SaleController extends Controller
{
    public function index()
    {
       $sales = Sale::get();
       return view('sale.index', compact('sales'));
    }


    public function create()
    {
        $clients = Client::get();
        $providers = Provider::get();
        $products = Product::get();
        return view('sale.create', compact('clients','providers','products'));
    }


    public function store(StoreRequest $request)
    {
        $sale = Sale::create($request->all());

        foreach ($request->product_id as $key => $product){
        $result[] = array("product_id"=>$request->product_id[$key],
        "quantity"=>$request->quantity[$key], "price"=>$request->price[$key],
        "discount"=>$request->discount[$key] );
        }
        $sale->saleDetails()->createMany($result);

        return redirect()->route('sale.index');

    }

    public function show(Sale $sale)
    {
        $subtotal = 0;
        $saleDetails = $sale->saleDetails;
        foreach ($saleDetails as $saleDetail) {
            $subtotal += $saleDetail->quantity*$saleDetail->price-$saleDetail->quantity*$saleDetail->sale;
        }
        return view('sale.show', compact('sale','saleDetails', 'subtotal'));
    }

   function edit(Sale $sale)
    {
        $clinets = Client::get();
        return view('sale.show', compact('sale'));
    }


    public function update(UpdateRequest $request, Sale $sale)
    {
       $sale->update($request->all());
       return redirect()->route('sales.index');
    }


    public function destroy(Sale $sale)
    {
        $sale->delete();
        return redirect()->route('sales.index');

    }
    
    public function pdf (Sale $sale)
    {
        $subtotal = 0;
        $saleDetails = $sale->saleDetails;
        foreach ($saleDetails as $saleDetail) {
            $subtotal += $saleDetail->quantity*$saleDetail->price-$saleDetail->quantity*$saleDetail->sale;
        }
       $pdf = PDF::loadview('sale.pdf', compact('sale','subtotal','saleDetails'));
       return $pdf->download('Reporte_de_venta_'.$sale->id.'.pdf');
    }
}
