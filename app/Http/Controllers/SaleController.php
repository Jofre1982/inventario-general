<?php

namespace App\Http\Controllers;

use App\Http\Requests\Sale\StoreRequest;
use App\Models\Business;
use App\Models\Client;
use App\Models\Sale;
use App\Services\InventoryService;
use App\Services\TicketPrinter;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function __construct(private InventoryService $inventory)
    {
        $this->protectWithPermissions('sales', [
            'sales.pdf' => 'pdf',
            'sales.print' => 'print',
            'change.status.sales' => 'change_status',
        ]);
    }

    public function index(Request $request)
    {
        $sales = Sale::with(['client', 'user'])
            ->when($request->q, fn ($q, $term) => $q->where(fn ($w) => $w
                ->where('id', $term)
                ->orWhereHas('client', fn ($c) => $c->where('name', 'like', "%{$term}%")->orWhere('document', $term))))
            ->latest('sale_date')
            ->latest('id')
            ->paginate(25)
            ->withQueryString();

        return view('sale.index', compact('sales'));
    }

    public function create()
    {
        $clients = Client::orderBy('name')->get();

        return view('sale.create', compact('clients'));
    }

    public function store(StoreRequest $request)
    {
        $sale = $this->inventory->registerSale(
            (int) $request->client_id,
            $request->user()->id,
            (float) ($request->tax ?? 0),
            $request->items()
        );

        return redirect()->route('sales.show', $sale)->with('success', "Venta #{$sale->id} registrada.");
    }

    public function show(Sale $sale)
    {
        $sale->load(['client', 'user', 'saleDetails.product']);

        return view('sale.show', compact('sale'));
    }

    public function pdf(Sale $sale)
    {
        $sale->load(['client', 'user', 'saleDetails.product']);
        $business = Business::current();

        return Pdf::loadView('sale.pdf', compact('sale', 'business'))
            ->download('Venta_' . $sale->id . '.pdf');
    }

    public function print(Sale $sale, TicketPrinter $printer)
    {
        try {
            $printer->printSale($sale);
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'No se pudo imprimir el ticket: ' . $e->getMessage() . ' Revise la configuración de la impresora.');
        }

        return back()->with('success', 'Ticket enviado a la impresora.');
    }

    public function change_status(Sale $sale)
    {
        $sale = $this->inventory->toggleSale($sale);

        return back()->with('success', $sale->isValid()
            ? "Venta #{$sale->id} reactivada; se descontó el stock."
            : "Venta #{$sale->id} anulada; el stock fue devuelto.");
    }
}
