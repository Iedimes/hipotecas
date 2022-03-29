<?php

namespace App\Exports;

use App\Models\User;
use Maatwebsite\Excel\Concerns\FromCollection;
use Illuminate\Support\Facades\DB as FacadesDB;
use Maatwebsite\Excel\Concerns\WithHeadings;


class UsersExport implements FromCollection,WithHeadings
{
    /**
    *return \Illuminate\Support\Collection
    *///
    public function headings(): array
    {
        return [
            'Id',
            'Nombre',
            'Email',
        ];
    }


    public function collection()
    {
       return User::all();

    }
}


