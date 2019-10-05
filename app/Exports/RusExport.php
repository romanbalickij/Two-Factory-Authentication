<?php

namespace App\Exports;

use App\Rus;
use Maatwebsite\Excel\Concerns\FromCollection;

class RusExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return  Rus::all();
    }
}
