<?php

namespace App\Repository\Stocks;

use App\Models\Stocksmouvement;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class StocksmouvementRepository implements StocksmouvementInterface
{
     
     private $model;

    public function __construct(Stocksmouvement $model)
    {
      $this->model = $model;
    
      
    }
    
    public function getAll()
    {
        $data =  DB::table('stocksmouvements')->select('id_product','wharehouse_id','quantite','pmp','label','inventorycode','ref','fk_author_user')->get();
        
        $name_list = json_encode($data);
        $name_lists = json_decode($data,true);
       return $name_lists;
        
    }
    
    
    public function deletedata()
    {
        
       return  DB::table('stocksmouvements')->delete();
    }
    
    
   
     
        
}
     
    