<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use App\Models\EntrepotStock;
use Maatwebsite\Excel\Concerns\FromCollection;

class EntrepotStockExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
          $data = EntrepotStock::select("id_product","entrepot","qte","ref_product")->get();
         return $data;
    }
}