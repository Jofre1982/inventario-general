<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Sale;

class ReportController extends Controller
{ 
     public function _construct(){
        $this->middleware('auth');
        $this->middleware('can:reports.day')->only(['reports_day']);
        $this->middleware('can:reports.date')->only(['reports_date']);
}

    public function reports_day(){
        $sales = Sale::whereDate('sale_date', Carbon::today())->get();
        $total = $sales->sum('total');
        return view('report.reports_day', compact('sales', 'total'));
    }
    public function reports_date(){
        $sales = Sale::whereDate('sale_date', Carbon::today())->get();
        $total = $sales->sum('total');
        return view('report.reports_date', compact('sales', 'total'));
    }
    public function report_results(Request $request){
        $fi = $request->fecha_ini.'00:00:00';
        $ff = $request->fecha_fin.'23:59:59';
        $sales = Sale::whereBetween('sale_date',[ $fi, $ff])->get();
        $total = $sales->sum('total');
        return redirect()->route('reports.date', compact('sales', 'total'));
    }
    
}
