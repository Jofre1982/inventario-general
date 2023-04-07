<?php

namespace App\Http\Controllers;

use App\Models\Provider;
use App\Models\Purchase;
use App\Models\Product;
use App\Http\Requests\Purchase\StoreRequest;
use App\Http\Requests\Purchase\UpdateRequest;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

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
        $purchase = Purchase::create($request->all()+[
            'user_id'=>Auth::user()->id,
            'purchase_date'=>Carbon::now('America/Bogota'),
        ]);

        foreach ($request->product_id as $key => $product){
        $result[] = array("product_id"=>$request->product_id[$key],
        "quantity"=>$request->quantity[$key], "price"=>$request->price[$key]);
        }
        $purchase->purchaseDetails()->createMany($result);

        return redirect()->route('purchase.index');

    }

    public function show(Purchase $purchase)
    {
        $subtotal = 0;
        $purchaseDetails = $purchase->purchaseDetails;
        foreach ( $purchaseDetails as  $purchaseDetail) {
            $subtotal += $purchaseDetails->quantity * $purchaseDetails->price;
        }

        return view('purchase.show', compact('purchase', 'purchaseDetails', 'subtotal'));
    }

   function edit(Purchase $purchase)
    {
        $providers = Provider::get();
         return view('purchase.show', compact('purchase'));
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
}
