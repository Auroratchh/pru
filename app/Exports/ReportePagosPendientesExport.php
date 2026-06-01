<?php

namespace App\Exports;

use Illuminate\Contracts\Queue\ShouldQueue;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;



class ReportePagosPendientesExport implements FromView, ShouldAutoSize, WithColumnWidths,WithColumnFormatting,WithTitle,WithDrawings
{
    protected $pendientes;

    public function __construct($pendientes)
    {
        $this->pendientes = $pendientes;
    }

    public function columnWidths(): array
    {
        return [
            'A' => 35, // Nombre
            'B' => 18, // Celular
            'C' => 18, // Último pago
            'D' => 18, // Fecha límite
            'E' => 18, // Estatus
            'F' => 22, // Referencia
        ];
    }

    public function columnFormats(): array
    {
        return [
            'C' => NumberFormat::FORMAT_DATE_DDMMYYYY, // Último pago
            'D' => NumberFormat::FORMAT_DATE_DDMMYYYY, // Fecha límite
        ];
    }

    public function drawings()
    {
        $drawing = new Drawing();
        $drawing->setName('Logotipo');
        $drawing->setDescription('Logotipo ALPHA VENUS');
        $drawing->setPath(public_path().'/img/logos/logo-dark.png');
        $drawing->setHeight(80);
        $drawing->setCoordinates('A1');

        return $drawing;
    }

    public function title(): string
    {
        return 'Pagos Pendientes Alpha Venus';
    }


    public function view(): View
    {
        return view('exports.reporte_pagos_pendientes_export', [
            'pendientes' => $this->pendientes
        ]);
    }
}