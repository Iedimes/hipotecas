<?php

namespace App\Exports;

use App\Models\Mh;
use Maatwebsite\Excel\Concerns\FromCollection;

class MhExport implements FromCollection
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
            'NOMBRE',
            'NACIMIENTO',
            'DOCUMENTO',
            'EMAIL',
            'ESTADO',
        ];
    }

    public function map($invoice): array
    {
        return [
            $invoice->code,
            $invoice->resume->names.' '.$invoice->resume->last_names,
            $invoice->resume->birthdate,
            $invoice->resume->government_id,
            $invoice->resume->email,
            $invoice->statuses->status->name,
            //Date::dateTimeToExcel($invoice->created_at),
        ];
    }
}


