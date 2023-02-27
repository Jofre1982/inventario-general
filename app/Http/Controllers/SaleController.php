<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\Client;
use App\Http\Requests\Sale\StoreRequest;
use App\Http\Requests\Sale\UpdateRequest;

class SaleController extends Controller
{
    public function index()
    {
       $sales = Sale::get();
       return view('sale.index', compact('sales'));
    }

   
    public function create()
    {
        $clinets = Client::get();
        return view('sale.index', compact('clients'));
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
        return view('sale.show', compact('sale'));
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
}
