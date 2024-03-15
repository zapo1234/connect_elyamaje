<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Maatwebsite\Excel\Concerns\FromCollection;

class ProductExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
          $data = Product::select("id_product","quantite","warehouse_id", "label","inventorycode","ref","pmp","stock_reel","user","barcode")->get();
         return $data;
    }

    
    
}