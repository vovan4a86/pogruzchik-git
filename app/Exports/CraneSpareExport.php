<?php

namespace App\Exports;

use App\CraneSpare;
//use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Contracts\View\View;

class CraneSpareExport implements FromView
{
//    /**
//    * @return \Illuminate\Support\Collection
//    */
//    public function collection()
//    {
//        return CraneSpare::all();
//    }
    public function view(): View
    {
        return view('exports.crane-spares', [
            'items' => CraneSpare::all()
        ]);
    }
}
