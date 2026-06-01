<?php

namespace App\Exports;

use App\Models\Gasto;
use App\Models\Pago;
use App\Models\User;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithColumnFormatting;
use Maatwebsite\Excel\Concerns\WithDrawings;
use Maatwebsite\Excel\Concerns\WithTitle;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;

class ReporteCorteCajaExport implements FromView,ShouldAutoSize,WithColumnFormatting, WithDrawings, ShouldQueue,WithTitle
{

    protected $fechaIni;
    protected $fechaFin;

    public function __construct($fechaIni, $fechaFin)
    {
        $this->fechaIni     = $fechaIni;
        $this->fechaFin     = $fechaFin;
    }

    public function columnFormats(): array
    {
        return [
            'A' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'C' => '"$"#,##0.00_-'
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
        return 'Corte Caja Alpha Venus';
    }

    public function view(): View
    {

        $pagos                      = Pago::getPagosForCorteCaja($this->fechaIni,$this->fechaFin);
        $totalPagos                 = Pago::getMontoTotalPagosForCorteCaja($this->fechaIni,$this->fechaFin);

        $totalPagoTransferencias    = Pago::getMontoTotalPagosTransferenciaForCorteCaja($this->fechaIni,$this->fechaFin);
        $totalPagoEfectivo          = Pago::getMontoTotalPagosEfectivoForCorteCaja($this->fechaIni,$this->fechaFin);
        $totalPagoDepositos         = Pago::getMontoTotalPagosDepositoForCorteCaja($this->fechaIni,$this->fechaFin);


        $gastos             = Gasto::getGastosForCorteCaja($this->fechaIni,$this->fechaFin);
        $totalGastos        = Gasto::getMontoTotalGastosForCorteCaja($this->fechaIni,$this->fechaFin);


        return view('exports.reporte_corte_caja_export', [
            'pagos'                      => $pagos,
            'totalPagoTransferencias'    => $totalPagoTransferencias,
            'totalPagoEfectivo'          => $totalPagoEfectivo,
            'totalPagoDepositos'         => $totalPagoDepositos,
            'totalPagos'                 => $totalPagos,

            'gastos'                     => $gastos,
            'totalGastos'                => $totalGastos,
            'fechaIni'                   => $this->fechaIni,
            'fechaFin'                   => $this->fechaFin,
        ]);
    }
}
