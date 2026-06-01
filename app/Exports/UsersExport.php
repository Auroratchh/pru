<?php

namespace App\Exports;

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

class UsersExport implements FromView,ShouldAutoSize,WithColumnFormatting, WithDrawings, ShouldQueue,WithTitle
{

    protected $idStatusUsuario;
    protected $txtBuscar;

    public function __construct($idStatusUsuario, $txtBuscar)
    {
        $this->idStatusUsuario  = $idStatusUsuario;
        $this->txtBuscar        = $txtBuscar;
    }

    public function columnFormats(): array
    {
        return [
            'E' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'I' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'K' => NumberFormat::FORMAT_DATE_DDMMYYYY,
            'L' => '"$"#,##0.00_-',
            'M' => NumberFormat::FORMAT_DATE_DDMMYYYY,
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
        return 'Usuarios Alpha Venus';
    }

    public function view(): View
    {

        $usuarios       = User::getAllAUsuariosLikeExport($this->txtBuscar, $this->idStatusUsuario);
        $status         = User::getStatusUsuario($this->idStatusUsuario);


        return view('exports.users_export', [
            'usuarios'      => $usuarios,
            'status'        => $status
        ]);
    }

}
