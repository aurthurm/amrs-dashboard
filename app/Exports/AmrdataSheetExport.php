<?php

namespace App\Exports;

use App\Amrdata;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class AmrdataSheetExport implements WithMultipleSheets
{
    /**
    * @return \Illuminate\Support\Collection
    */
    use Exportable;

    protected $sheets;

    public function __construct(array $sheets,$amrdata)
    {
        $this->amrdata = $amrdata;
        $this->sheets = $sheets;
    }

    public function array(): array
    {
        return $this->sheets;
    }

    public function sheets(): array
    {
        $sheets = [
            new AmrdataExport($this->sheets['amrdata_values'],$this->amrdata),
            new AmrdataInterpretationExport($this->sheets['amrdata_interpretation'],$this->amrdata),
        ];

        return $sheets;
    }
}
