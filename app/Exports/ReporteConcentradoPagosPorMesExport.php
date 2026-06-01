<?php

namespace App\Exports;

use App\Models\Gasto;
use App\Models\Pago;
use Carbon\Carbon;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ReporteConcentradoPagosPorMesExport implements FromView,ShouldAutoSize,WithColumnFormatting, WithDrawings, ShouldQueue,WithTitle
{
    protected $idStatus;
    protected $txtBuscar;
    protected $yearIni;
    protected $reporte;


    public function __construct($idStatus, $txtBuscar,$yearIni)
    {
        $this->idStatus     = $idStatus;
        $this->txtBuscar    = $txtBuscar;
        $this->yearIni      = $yearIni;
    }

    public function columnFormats(): array
    {
        $formats['C'] = NumberFormat::FORMAT_DATE_DDMMYYYY;

        // A = ID, B = Usuario, C en adelante = meses
        $columnaInicialMeses = 5;

        foreach ($this->reporte['meses'] as $index => $mes) {
            $numeroColumna = $columnaInicialMeses + $index;
            $letraColumna = Coordinate::stringFromColumnIndex($numeroColumna);

            $formats[$letraColumna] = '"$"#,##0.00_-';
        }

        return $formats;


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
        return 'Concentrado de Pagos Alpha Venus';
    }

    public function view(): View
    {

        if(empty($this->yearIni)){
            $this->yearIni = '2024';
        }

        $fechaInicial = Carbon::create($this->yearIni, 1, 1)->startOfMonth();
        $this->reporte = Pago::getReportePagosPorMesApartir($fechaInicial,$this->txtBuscar, $this->idStatus);


        return view('exports.reporte_concentrado_pagos_export', [
            'meses'      => $this->reporte['meses'],
            'data'       => $this->reporte['data'],
            'idStatus'   => $this->idStatus,
            'txtBuscar'  => $this->txtBuscar,
            'yearIni'    => $this->yearIni,
        ]);
    }
}
