<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Printer;
use App\Http\Request\Printer\UpdateRequest;

class PrinterController extends Controller
{
    public function index()
    {
        $printer = Printer::where('id', 1)->firstOrFail();
        return view('printer.index', compact('printer'));
    }
    public function update(UpdateRequest $request, Printer $printer)
    {
        $printer->update($request->all());
        return redirect()->route('printers.index');
    }
}