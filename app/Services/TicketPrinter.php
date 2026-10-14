<?php

namespace App\Services;

use App\Models\Business;
use App\Models\Printer as PrinterSettings;
use App\Models\Sale;
use Mike42\Escpos\PrintConnectors\CupsPrintConnector;
use Mike42\Escpos\PrintConnectors\NetworkPrintConnector;
use Mike42\Escpos\PrintConnectors\PrintConnector;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Illuminate\Support\Str;
use Mike42\Escpos\Printer;

/**
 * Imprime tickets en impresoras térmicas ESC/POS (Epson TM-T20, etc.)
 * usando la configuración de "Administrar > Impresora".
 *
 * Importante: la impresión la hace el servidor. Si el sistema corre en el
 * mismo computador de la caja (XAMPP, Laragon) use la conexión "Windows"
 * con el nombre con que se compartió la impresora. Si corre en un servidor
 * en internet, use una impresora de red (IP) accesible desde ese servidor.
 */
class TicketPrinter
{
    /** Permite inyectar otro conector en las pruebas. */
    public ?PrintConnector $connector = null;

    public function printSale(Sale $sale): void
    {
        $sale->loadMissing(['client', 'user', 'saleDetails.product']);

        $this->print(function (Printer $printer, int $width) use ($sale) {
            $this->header($printer);

            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $this->out($printer, $this->pair('Venta N.', '#' . $sale->id, $width));
            $this->out($printer, $this->pair('Fecha', $sale->sale_date->format('d/m/Y h:i a'), $width));
            $this->out($printer, $this->pair('Cliente', $sale->client->name ?? '-', $width));
            if ($sale->client && $sale->client->document) {
                $this->out($printer, $this->pair('Documento', $sale->client->document, $width));
            }
            $this->out($printer, $this->pair('Atendió', $sale->user->name ?? '-', $width));

            if (! $sale->isValid()) {
                $printer->setEmphasis(true);
                $this->out($printer, str_pad('*** VENTA ANULADA ***', $width, ' ', STR_PAD_BOTH) . "\n");
                $printer->setEmphasis(false);
            }

            $this->out($printer, str_repeat('-', $width) . "\n");

            foreach ($sale->saleDetails as $detail) {
                $this->out($printer, $this->clip($detail->product->name ?? 'Producto', $width) . "\n");
                $line = $detail->quantity . ' x ' . $this->money($detail->price);
                if ($detail->discount > 0) {
                    $line .= ' -' . rtrim(rtrim(number_format($detail->discount, 2, ',', '.'), '0'), ',') . '%';
                }
                $this->out($printer, $this->pair('  ' . $line, $this->money($detail->subtotal), $width));
            }

            $this->out($printer, str_repeat('-', $width) . "\n");
            $this->out($printer, $this->pair('Subtotal', $this->money($sale->subtotal), $width));
            if ($sale->tax > 0) {
                $this->out($printer, $this->pair('Impuesto (' . rtrim(rtrim(number_format($sale->tax, 2, ',', '.'), '0'), ',') . '%)', $this->money($sale->tax_amount), $width));
            }
            $printer->setEmphasis(true);
            $this->out($printer, $this->pair('TOTAL', $this->money($sale->total), $width));
            $printer->setEmphasis(false);

            $printer->feed();
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            $this->out($printer, "¡Gracias por su compra!\n");
        });
    }

    public function printTest(): void
    {
        $this->print(function (Printer $printer, int $width) {
            $this->header($printer);
            $printer->setJustification(Printer::JUSTIFY_LEFT);
            $this->out($printer, str_repeat('-', $width) . "\n");
            $this->out($printer, $this->pair('Prueba de impresión', now()->format('d/m/Y h:i a'), $width));
            $this->out($printer, $this->pair('Ancho', $width . ' caracteres', $width));
            $this->out($printer, str_repeat('-', $width) . "\n");
            $this->out($printer, "Si ve este texto completo y alineado,\nla impresora está bien configurada.\n");
        });
    }

    private function print(callable $body): void
    {
        $settings = PrinterSettings::current();
        $printer = new Printer($this->connector ?? $this->makeConnector($settings));

        try {
            $body($printer, $settings->width ?: 42);
            $printer->feed(3);
            $printer->cut();
        } finally {
            $printer->close();
        }
    }

    private function header(Printer $printer): void
    {
        $business = Business::current();

        $printer->setJustification(Printer::JUSTIFY_CENTER);
        $printer->setEmphasis(true);
        $printer->setTextSize(1, 2);
        $this->out($printer, $business->name . "\n");
        $printer->setTextSize(1, 1);
        $printer->setEmphasis(false);

        foreach (['nit' => 'NIT ', 'address' => '', 'mail' => ''] as $field => $prefix) {
            if ($business->$field) {
                $this->out($printer, $prefix . $business->$field . "\n");
            }
        }
        $printer->feed();
    }

    private function makeConnector(PrinterSettings $settings): PrintConnector
    {
        return match ($settings->connector) {
            'network' => new NetworkPrintConnector($settings->host, $settings->port ?: 9100, 5),
            'cups' => new CupsPrintConnector($settings->name),
            default => new WindowsPrintConnector($settings->name),
        };
    }

    /** Las térmicas no traen tildes en su juego de caracteres por defecto. */
    private function out(Printer $printer, string $text): void
    {
        $printer->text(Str::ascii($text));
    }

    /** "Texto ........ valor" alineado al ancho del papel. */
    private function pair(string $left, string $right, int $width): string
    {
        $left = $this->clip($left, max($width - mb_strlen($right) - 1, 1));
        $spaces = max($width - mb_strlen($left) - mb_strlen($right), 1);

        return $left . str_repeat(' ', $spaces) . $right . "\n";
    }

    private function clip(string $text, int $width): string
    {
        return mb_strlen($text) > $width ? mb_substr($text, 0, $width) : $text;
    }

    private function money(float $value): string
    {
        return '$' . number_format($value, 0, ',', '.');
    }
}
