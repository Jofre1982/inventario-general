<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Purchase;
use App\Models\Sale;
use Illuminate\Support\Carbon;

class HomeController extends Controller
{
    /** Inicio con los números reales del negocio. */
    public function index()
    {
        $today = Carbon::today();
        $monthStart = $today->copy()->startOfMonth();

        $salesToday = Sale::valid()->whereDate('sale_date', $today);
        $salesMonth = Sale::valid()->where('sale_date', '>=', $monthStart);

        // Ventas de los últimos 14 días para la gráfica (incluye días sin ventas).
        $days = collect(range(13, 0))->map(fn ($i) => $today->copy()->subDays($i));
        $byDay = Sale::valid()
            ->where('sale_date', '>=', $days->first())
            ->get(['sale_date', 'total'])
            ->groupBy(fn ($s) => $s->sale_date->toDateString())
            ->map->sum('total');

        $chart = [
            'labels' => $days->map(fn ($d) => $d->format('d/m'))->values(),
            'values' => $days->map(fn ($d) => round($byDay[$d->toDateString()] ?? 0, 2))->values(),
        ];

        return view('dashboard', [
            'todayTotal' => (clone $salesToday)->sum('total'),
            'todayCount' => (clone $salesToday)->count(),
            'monthTotal' => (clone $salesMonth)->sum('total'),
            'monthPurchases' => Purchase::valid()->where('purchase_date', '>=', $monthStart)->sum('total'),
            'productCount' => Product::active()->count(),
            'lowStock' => Product::active()->lowStock()->orderBy('stock')->limit(10)->get(),
            'lowStockCount' => Product::active()->lowStock()->count(),
            'latestSales' => Sale::with('client')->latest('sale_date')->latest('id')->limit(8)->get(),
            'chart' => $chart,
        ]);
    }
}
