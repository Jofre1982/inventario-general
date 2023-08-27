<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Client;
use App\Http\Requests\Sale\StoreRequest;
use App\Http\Requests\Sale\UpdateRequest;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

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
        $products = Product::get();
        return view('sale.create', compact('clients','products'));
    }


    public function store(StoreRequest $request)
    {
        $sale = Sale::create($request->all()+[
            'user_id'=>Auth::user()->id,
            'sale_date'=>Carbon::now('America/Bogota'),
        ]);
           

        foreach ($request->product_id as $key => $product){
        $results[] = ["product_id"=>$request->product_id[$key],"quantity"=>$request->quantity[$key], "price"=>$request->price[$key],"discount"=>$request->discount[$key]];
        }
       
        $sale->saleDetails()->createMany($results);
        return redirect()->route('sales.index');

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

    public function edit(Sale $sale)
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
    
    public function pdf(Sale $sale)
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
