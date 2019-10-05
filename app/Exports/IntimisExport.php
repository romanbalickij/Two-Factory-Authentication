<?php

namespace App\Exports;

use App\Intims;
use Maatwebsite\Excel\Concerns\FromCollection;

class IntimisExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        return  Intims::all();
    }
}
