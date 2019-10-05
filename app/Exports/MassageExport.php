<?php

namespace App\Exports;

use App\Massage;
use Maatwebsite\Excel\Concerns\FromCollection;

class MassageExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return Massage::all();
    }
}
