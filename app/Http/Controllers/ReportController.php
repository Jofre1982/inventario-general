<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetails;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:reports.day')->only('reports_day');
        $this->middleware('can:reports.date')->only('reports_date');
    }

    public function reports_day()
    {
        return view('report.reports_day', $this->report(Carbon::today(), Carbon::today()));
    }

    public function reports_date(Request $request)
    {
        $request->validate([
            'fecha_ini' => ['nullable', 'date'],
            'fecha_fin' => ['nullable', 'date', 'after_or_equal:fecha_ini'],
        ], [], ['fecha_ini' => 'fecha inicial', 'fecha_fin' => 'fecha final']);

        $from = $request->fecha_ini ? Carbon::parse($request->fecha_ini) : Carbon::today()->startOfMonth();
        $to = $request->fecha_fin ? Carbon::parse($request->fecha_fin) : Carbon::today();

        return view('report.reports_date', $this->report($from, $to));
    }

    private function report(Carbon $from, Carbon $to): array
    {
        $range = [$from->copy()->startOfDay(), $to->copy()->endOfDay()];

        $sales = Sale::with(['client', 'user'])
            ->whereBetween('sale_date', $range)
            ->latest('sale_date')
            ->get();

        $valid = $sales->where('status', Sale::VALID);

        $topProducts = SaleDetails::query()
            ->join('sales', 'sales.id', '=', 'sale_details.sale_id')
            ->join('products', 'products.id', '=', 'sale_details.product_id')
            ->where('sales.status', Sale::VALID)
            ->whereBetween('sales.sale_date', $range)
            ->groupBy('products.id', 'products.name')
            ->orderByDesc('units')
            ->limit(10)
            ->get([
                'products.name',
                DB::raw('SUM(sale_details.quantity) as units'),
                DB::raw('SUM(sale_details.quantity * sale_details.price * (1 - sale_details.discount / 100)) as amount'),
            ]);

        return [
            'from' => $from,
            'to' => $to,
            'sales' => $sales,
            'total' => $valid->sum('total'),
            'count' => $valid->count(),
            'canceled' => $sales->count() - $valid->count(),
            'topProducts' => $topProducts,
        ];
    }
}
