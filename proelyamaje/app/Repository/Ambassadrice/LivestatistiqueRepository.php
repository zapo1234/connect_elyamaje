<?php

namespace App\Repository\Ambassadrice;

use App\Models\Ambassadrice\Livestatistique;
use App\Http\Service\CallApi\GetDataCoupons;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Hash;

class LivestatistiqueRepository implements LivestatistiqueInterface
{
     
     private $model;
     
     private $data = [];
     
     private $listdate = [];
     
     
    public function __construct(Livestatistique $model)
    {
      $this->model = $model;

    }
    
    public function getAllcodelive()
    {
         $name_list = DB::table('livestatistiques')->select('id','is_admin','id_ambassadrice','code_live','date')->get();
         $name_lists = json_encode($name_list);
         $name_lists = json_decode($name_list,true);
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
    
    
    public function insert($id_ambassadrice,$id_live,$name,$email,$date)
    {
        $live =  new Livestatistique();
        $live->id_ambassadrice = $id_ambassadrice;
        $live->id_live= $id_live;
        $live->name = $name;
        $live->email = $email;
        $live->date = $date;
        $live->save();
        
    }
    
    
    public function getdatacodelive($id)
    {
        
        $result = DB::table('livestatistiques')->where('id_ambassadrice', $id)->get();
        
        $list = json_encode($result);
        $lists =  json_decode($result,true);
        
        // recupérer date du jours;
        
        // recupère la date actuel en cours
        $date = date('Y-m-d');
        // recupérer le mot en cours
        $date1 = explode('-',$date);
        
        $code_mois  = $date1[1];
        $code_annee = $date1[0];
        // recupérer le mois -1jours
        $a = (int)$code_mois;

         
        $a_mois = $a-1;
    
         if($a==1) {
            $a_mois = 12;
            $code_annee = $code_annee-1;
        }
         // si on est en décembre
         $mois="";
        
       // recupérer la date.
        $array_list = [];
        foreach($lists as $lm=> $val) {
            $jour = explode(' ',$val['date']);
            // recupérer le mois depuis la bdd
            $date2 = $val['date'];
            // recupérer la date  en cours
            $date3 = explode(' ',$date2);
             // recupérer la date au format voulu d-m-y
            $code_mois1  = $date3[0];
            
            // recupérer le mois de cette date
            $date_data = explode('-',$code_mois1);
            $mois_take = $date_data[1];
            $code_annee1 = $date_data[0];
            $mois_take_int =(int)$mois_take;
            
            // verifier la condition de l'égalie
            if($a_mois == $mois_take_int && $code_annee==$code_annee1){
              $array_list[] = $a;
            }
        }
        
        // recupérer 
    
        $this->setListdate($array_list);
        
        return $lists;
        
    }

    public function getCount(){
      
        $result = DB::table('livestatistiques')->select('id_ambassadrice')->get();
         $list = json_encode($result);
        $lists =  json_decode($result,true);

        $tab =[];

        foreach($lists as $values){

          $tab[] = $values['id_ambassadrice'];
        }

          $tabs = count($tab);
           return $tabs;
      

    }
    
    
   
}
    
    