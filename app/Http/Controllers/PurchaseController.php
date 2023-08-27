<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\Purchase;
use App\Models\Product;
use App\Http\Requests\Purchase\StoreRequest;
use App\Http\Requests\Purchase\UpdateRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade\Pdf;

class PurchaseController extends Controller
{
    public function index()
    {
        $purchases = Purchase::get();
        return view('purchase.index', compact('purchases'));
    }

    public function create()
    {
        $providers = Provider::get();
        $products = Product::get();
        return view('purchase.create', compact('providers', 'products'));
    }


    public function store(StoreRequest $request)
    {
        $purchase = Purchase::create($request->all() + [
            'user_id' => Auth::user()->id,
            'purchase_date' => Carbon::now('America/Bogota'),
        ]);
        foreach ($request->product_id as $key => $product) {
            $results[] = ["product_id" => $request->product_id[$key],"quantity" => $request->quantity[$key],"price" => $request->price[$key],];                     
        }
        $purchase->purchaseDetails()->createMany($results);
        return redirect()->route('purchases.index');
    }

    public function show(Purchase $purchase)
    {
        $subtotal = 0;
        $purchaseDetails = $purchase->purchaseDetails;
        foreach ($purchaseDetails as  $purchaseDetail) {
            $subtotal += $purchaseDetail->quantity*$purchaseDetail->price;
        }
        return view('purchase.show', compact('purchase', 'purchaseDetails', 'subtotal'));
    }

    public function edit(Purchase $purchase)
    {
        $providers = Provider::get();
        return view('purchase.edit', compact('purchase'));
    }


    public function update(UpdateRequest $request, Purchase $purchase)
    {
        $purchase->update($request->all());
        return redirect()->route('purchases.index');
    }


    public function destroy(Purchase $purchase)
    {
        $purchase->delete();
        return redirect()->route('purchases.index');
    }

    public function pdf(Purchase $purchase)
    {
        $subtotal = 0;
        $purchaseDetails = $purchase->purchaseDetails;
        foreach ($purchaseDetails as  $purchaseDetail) {
            $subtotal += $purchaseDetail->quantity*$purchaseDetail->price;
        }
        $pdf = PDF::loadView('purchase.pdf', compact('purchase','subtotal','purchaseDetails'));
        return $pdf->download('Reporte_de_compras_'.$purchase->id.'.pdf');
    }

    
}
