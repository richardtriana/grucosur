<?php

namespace App\Http\Controllers;

use App\Models\Fee;
use App\Models\Sede;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use Mike42\Escpos\EscposImage;
use Mike42\Escpos\PrintConnectors\WindowsPrintConnector;
use Mike42\Escpos\Printer;


class PrintTicketController extends Controller
{
    public function printFee($id)
    {
        // Orden
        $sede = Sede::first();

        if (!$sede->impresora_pos || $sede->impresora_pos == '') {
            return false;
        }
        $fee = Fee::findOrFail($id);
        $credit = $fee->credit;
        $client = $credit['client'];

        // Config de impresora
        $connector = new WindowsPrintConnector($sede->impresora_pos);

        try {

            $printer = new Printer($connector);
            $printer->initialize();
            $printer->setJustification(Printer::JUSTIFY_CENTER);
            try {
                $logo = EscposImage::load('logo.jpg', false);
                $printer->bitImage($logo);
            } catch (Exception $e) {
                /* Images not supported on your PHP, or image file not found */
                //$printer->text($e->getMessage() . "\n");
            }

            $printer->setTextSize(1, 2);
            $printer->setEmphasis(true);
            $printer->text($sede->sede . "\n");
            $printer->setTextSize(1, 1);
            $printer->setEmphasis(false);
            $printer->text("NIT: ");
            $printer->text($sede->nit . "\n");
            $printer->text("Dirección: ");
            $printer->text($sede->direccion . "\n");

            $printer->setEmphasis(true);
            $printer->setTextSize(1, 2);
            $printer->text("\n");
            $printer->text("Reporte de pago");
            $printer->text("\n");
            $printer->text("\n");
            $printer->setTextSize(1, 1);
            // $printer->text("Cajero(a): ");
            // $printer->text($system_user->name . "\n");
            $printer->setEmphasis(false);

            $printer->text(sprintf('%-20s %-20s', 'Client', $client->nombres . ' ' . $client->apellidos));
            $printer->text("\n");
            $printer->text(sprintf('%-20s %-20s', 'Fecha', date('Y-m-d h:i:s A')));
            $printer->text("\n");
            $printer->text(sprintf('%-20s %-20s', 'Crédito', $credit->valor_credit));
            $printer->text("\n");
            $printer->text(sprintf('%-20s %-20s', 'Nro Operacion', $fee->id));
            $printer->text("\n");
            $printer->text(sprintf('%-20s %-20s', 'Fecha Fee', $fee->fecha_pago));
            $printer->text("\n");
            $printer->text(sprintf('%-20s %-20s', 'Monto Cancelado', $fee->valor));
            $printer->text("\n");
            $printer->text("\n");
            $printer->setLineSpacing(2);
            $printer->setEmphasis(false);
            $printer->setFont(Printer::MODE_FONT_B);
            $printer->text("Tecnoplus");
            $printer->text("\nwww.tecnoplus.com\n");
            $printer->cut();
            $printer->pulse();
            $printer->close();

            return redirect()->back()->with("mensaje", "Ticket impreso");
        } catch (\Throwable $th) {
            return 'NO se pudo imprimri';
        }
    }
}