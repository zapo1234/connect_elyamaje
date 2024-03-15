<?php
namespace App\Imports;
use App\Models\Data;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class DatasImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Data([
         'productid'=> $row[0],
         'nom' => $row[3],
        'images'=> $row[6],
        'image'=>$row[7],
        'video'=>$row[8],
        'videos'=>$row[9],
        ]);
    }
    
}