<?php

namespace App\Exports;

use App\Models\Cartera;
use App\Models\Mh;
use App\Models\DetalleMh;
use App\Models\Juridico;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;


class MhExport implements FromCollection, WithHeadings, WithMapping, ShouldAutoSize, WithStyles
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Mh::paginate(100);

    }

    public function headings(): array
    {
        return [
            'CODIGO',
            'PROYECTO',
            'DOCUMENTO',
            'ADJUDICATARIO',
            'FECHA INSCRIPCION',
            'INSTITUCION ACREEDORA',
            'OBSERVACION',
            'FECHA RE INSCRIPCION',
            'DEPARTAMENTO',
            'LOCALIDAD',
            'SUPERFICIE',
            'NRO CUOTA',
            'ULTIMO VENCIMIENTO',
            'ULTIMO MOVIMIENTO',
            'ULTIMA ACTUACION',
            'OBSERVACION DETALLE',
        ];
    }

    public function map($invoice): array
    {

        $det = DetalleMh::where('VivPer', $invoice->documento)->first();
        $car = Cartera::where('PerCod', $invoice->documento)->first();
        $jur = Juridico::where('PerCod', $invoice->documento)->first();
        //dd($detalle);
        return [
            $invoice->codigo,
            $invoice->proyecto,
            $invoice->documento,
            $invoice->adjudicatario,
            $invoice->fecha_ins,
            $invoice->institucion_acreedora,
            $invoice->obs,
            $invoice->fecha_reins,
            $det ? ($det->dpto ? $det->dpto->DptoNom:'Sin Datos Departamento') : 'Sin Detalle',
            $det ? ($det->localidad ? $det->localidad->CiuNom:'Sin Datos Ciudad') : 'Sin Detalle',
            $det ? $det->VivSupTer : 'Sin Datos',
            $car ? $car->CLIUCP : 'Sin Datos',
            $car ? \Carbon\Carbon::parse($car->CliFuv)->format('d/m/Y') : 'Sin Datos',
            $car ? ($car->Clifum != '1753-01-01 00:00:00.000' ? \Carbon\Carbon::parse($car->Clifum)->format('d/m/Y') : '-') : 'Sin Datos',
            $jur ? ($jur->CliOFObs != '1753-01-01 00:00:00.000' ? \Carbon\Carbon::parse($jur->CliOFObs)->format('d/m/Y') : '-') : 'Sin Datos',
            $jur ? $jur->CliOObs : 'Sin Datos',

        ];
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->getStyle('A1:P1')->getFont()->setBold(true)->getColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_WHITE);
        $sheet->getStyle('A1:P1')->getFill()
        ->setFillType(\PhpOffice\PhpSpreadsheet\Style\Fill::FILL_SOLID)
        ->getStartColor()->setARGB(\PhpOffice\PhpSpreadsheet\Style\Color::COLOR_BLUE);
    }
}


