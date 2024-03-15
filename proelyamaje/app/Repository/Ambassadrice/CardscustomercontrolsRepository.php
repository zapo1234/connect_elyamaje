<?php

namespace App\Repository\Ambassadrice;

use App\Models\Ambassadrice\Cardscustomercontrol;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CardscustomercontrolsRepository implements CardscustomercontrolsInterface
{
     
     private $data =[];

    public function __construct()
    {
     
      
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
  
    
    
   public function getAll()
   {
       
   }
    
    
   public function getAllidcommande()
   {
      // recuperer un id_commande de la table
      $data =  DB::table('cardscustomercontrols')->select('id_commande','code_promo','mois_expire','numero_card','annee_expire','numero_forms')->get();
        
        
        // recupérer les données dans un tableau
        $array_id_commande =[];
        // recupérer les données de la card bancaire sous forme de numero
        $array_cards =[];
        // transformer les retour objets en tableau
        $list = json_encode($data);
        $lists = json_decode($data,true);
        
        foreach($lists as $values) {
            
               $array_id_commande[] = $values['id_commande'];
             
             $chaine="-";
            if(preg_match("/{$chaine}/i", $values['code_promo']) && $values['numero_forms']!="") {
                $array_cards [] = $values['numero_forms'];
            }
        }
        
        // recupérer le tableau
        $this->setData($array_cards);
        
       
       return $array_id_commande;
      
   }
   
   
  
    
}
     