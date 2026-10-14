<?php

namespace App\Http\Controllers;

use App\Http\Requests\Printer\UpdateRequest;
use App\Models\Printer;
use App\Services\TicketPrinter;

class PrinterController extends Controller
{
    public function __construct()
    {
        $this->middleware('can:printer.index')->only('index');
        $this->middleware('can:printer.edit')->only(['update', 'test']);
    }

    public function index()
    {
        $printer = Printer::current();

        return view('printer.index', compact('printer'));
    }

    public function update(UpdateRequest $request)
    {
        Printer::current()->update($request->validated() + ['port' => 9100]);

        return redirect()->route('printer.index')->with('success', 'Configuración de la impresora guardada.');
    }

    public function test(TicketPrinter $printer)
    {
        try {
            $printer->printTest();
        } catch (\Throwable $e) {
            report($e);

            return back()->with('error', 'No se pudo imprimir: ' . $e->getMessage());
        }

        return back()->with('success', 'Página de prueba enviada a la impresora.');
    }
}
