<?php
namespace App\Imports;
use App\Models\Stocksmouvement;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
class StocksmouvementImport implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $fk_author_user=1;
        $label="";
        $wharehouse_id ="";
        $quantite ="3";
        return new Stocksmouvement([
          
         'id_product'=> $row[0],
         'wharehouse_id' => $row[2],
          'quantite'=> $row[1],
          'pmp'=>$row[6],
          'label'=>$label,
          'inventorycode'=>$row[4],
         'ref'=>$row[3],
        'fk_author_user'=>$fk_author_user,
         
        ]);
    }
    
}