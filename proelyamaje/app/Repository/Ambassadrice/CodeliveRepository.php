<?php

namespace App\Repository\Ambassadrice;

use App\Models\Ambassadrice\Codelive;
use App\Http\Service\CallApi\GetDataCoupons;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Hash;

class CodeliveRepository implements CodeliveInterface
{
     
     private $model;
     
     private $data = [];
     
     private $listdate = [];
     
     private $listcodelive = [];
     
     
    public function __construct(Codelive $model)
    {
      $this->model = $model;

    }
    
    
    
      /* @return array
    */
   public function getListcodelive(): array
   {
      return $this->listcodelive;
   }
   
   
   public function setListcodelive($listcodelive)
   {
     $this->listcodelive = $listcodelive;
      return $this;
   }
   
   
      /**
   * @return array
   */
    public function datacodelive(): array
    {
     //recupérer les données sous forme de tableau de la liste des code live avec leur donné
       return $this->getListcodelive();
    }
    
    
    public function getAllcodelive()
    {
         $name_list = DB::table('codelives')->select('id','is_admin','id_ambassadrice','code_live','date_expire')->get();
         $name_lists = json_encode($name_list);
        $name_lists = json_decode($name_list,true);
        
    
        $array_code_live = [];
        $array_date_expire = [];
        
        $array_codelive  =[];// créer un tableau associative entre le code live et leur données
        foreach($name_lists as $k=>$values){
            $array_code_live[] = $values['code_live'];
            $array_date_expire[] = $values['date_expire'];
            
             $array_codelive[] = [
                                 $values['code_live'] =>$values['code_live'].','.$values['id_ambassadrice'].','.$values['is_admin']
                                 
                            ];
        }
         // recupérer les donnnées dans l'array tab
         $this->setData($array_code_live);
         $this->setListdate($array_date_expire);
         
         // recupérer les données 
         $this->setListcodelive($array_codelive);
         
        //renvoi un tableau 
         // renvoi un tableau associative
        return $name_lists;
        
    }
    
    
     
     
     /* @return array
    */
   public function getListdate(): array
   {
      return $this->listdate;
   }
   
   
   public function setListdate($listdate)
   {
     $this->listdate = $listdate;
    return $this;
   }
   
   
    /**
   * @return array
   */
    public function listdates(): array
    {
     //recupérer les données sous forme de tableau dans la vairable array data les codes promos
       return $this->getListdate();
    }
    
    
    
       /**
   * @return array
    */
   public function getData(): array
   {
      return $this->data;
   }
   
   
   public function setData(array $data)
   {
     $this->data = $data;
    return $this;
   }
  
    
    /**
   * @return array
   */
    public function donnees(): array
    {
     //recupérer les données sous forme de tableau dans la vairable array data les codes promos
       return $this->getData();
    }
    
    
    public function insert($code_live, $id_ambassadrice,$is_admin)
    {
        $a=0;
        $codelive =  new Codelive();
        $codelive->code_live = $code_live;
        $codelive->id_ambassadrice = $id_ambassadrice;
        $codelive->is_admin = $is_admin;
        $codelive->nbres_live = $a;
        $codelive->save();
        
    }
    
    
    public function getdatacodelive($id)
    {
        
        $result = DB::table('codelives')->where('id_ambassadrice', $id)->get();
        
        $list = json_encode($result);
        $lists =  json_decode($result,true);
        
        return $lists;
        
    }

    public function getNextLives($fields = '*'){
      return Codelive::where(['css' => 'activecode', 'nombre_fois' => 0])->orWhere('css', 'demandecode')->select($fields)->get()->toArray();
    }

    public function updateByCodeLive($data, $code_live){
      return Codelive::where('code_live', $code_live)->update($data);
    }

    public function updateByIdCoupon($data, $coupon){
      return Codelive::where('id_coupons', $coupon)->update($data);
    }

}
    
    