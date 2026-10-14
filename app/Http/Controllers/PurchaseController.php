<?php

namespace App\Http\Controllers;

use App\Http\Requests\Purchase\StoreRequest;
use App\Models\Business;
use App\Models\Provider;
use App\Models\Purchase;
use App\Services\InventoryService;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class PurchaseController extends Controller
{
    public function __construct(private InventoryService $inventory)
    {
        $this->protectWithPermissions('purchases', [
            'purchases.pdf' => 'pdf',
            'upload.purchases' => 'upload',
            'change.status.purchases' => 'change_status',
        ]);
    }

    public function index(Request $request)
    {
        $purchases = Purchase::with(['provider', 'user'])
            ->when($request->q, fn ($q, $term) => $q->where(fn ($w) => $w
                ->where('id', $term)
                ->orWhereHas('provider', fn ($p) => $p->where('name', 'like', "%{$term}%"))))
            ->latest('purchase_date')
            ->latest('id')
            ->paginate(25)
            ->withQueryString();

        return view('purchase.index', compact('purchases'));
    }

    public function create()
    {
        $providers = Provider::orderBy('name')->get();

        return view('purchase.create', compact('providers'));
    }

    public function store(StoreRequest $request)
    {
        $purchase = $this->inventory->registerPurchase(
            (int) $request->provider_id,
            $request->user()->id,
            (float) ($request->tax ?? 0),
            $request->items()
        );

        return redirect()->route('purchases.show', $purchase)->with('success', "Compra #{$purchase->id} registrada; el stock fue actualizado.");
    }

    public function show(Purchase $purchase)
    {
        $purchase->load(['provider', 'user', 'purchaseDetails.product']);

        return view('purchase.show', compact('purchase'));
    }

    public function pdf(Purchase $purchase)
    {
        $purchase->load(['provider', 'user', 'purchaseDetails.product']);
        $business = Business::current();

        return Pdf::loadView('purchase.pdf', compact('purchase', 'business'))
            ->download('Compra_' . $purchase->id . '.pdf');
    }

    /** Adjunta la foto o PDF de la factura del proveedor. */
    public function upload(Request $request, Purchase $purchase)
    {
        $request->validate([
            'picture' => ['required', 'file', 'mimes:jpg,jpeg,png,webp,pdf', 'max:5120'],
        ], [], ['picture' => 'comprobante']);

        $file = $request->file('picture');
        $name = 'compra_' . $purchase->id . '_' . time() . '.' . $file->extension();
        $file->move(public_path('image/purchases'), $name);

        $purchase->update(['picture' => $name]);

        return back()->with('success', 'Comprobante adjuntado.');
    }

    public function change_status(Purchase $purchase)
    {
        $purchase = $this->inventory->togglePurchase($purchase);

        return back()->with('success', $purchase->isValid()
            ? "Compra #{$purchase->id} reactivada; se sumó el stock."
            : "Compra #{$purchase->id} anulada; se descontó el stock.");
    }
}
