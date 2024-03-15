<?php

namespace App\Exports;

use Illuminate\Support\Facades\DB;
use App\Models\Customer;
use Maatwebsite\Excel\Concerns\FromCollection;

class CustomerExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
         $data = Customer::select("name","phone","email","code_postal")->get();
         return $data;
    }
}
