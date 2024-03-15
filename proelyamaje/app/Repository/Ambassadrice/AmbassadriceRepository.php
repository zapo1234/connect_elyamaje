<?php

namespace App\Repository\Ambassadrice;

use App\Repository\Ambassadrice\Ordercustomer\OrderambassadricecustomsRepository;
use App\Models\Ambassadrice\Ordersambassadricecustom;
use App\Models\Ambassadrice\Ambassadric;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Hash;

class AmbassadriceRepository implements AmbassadriceInterface
{
     
     private $model;
     
     private $orders;
     
    public function __construct(Ambassadric $model, OrderambassadricecustomsRepository $orders)
    {
      $this->model = $model;
      $this->orders = $orders;
    }
    
    public function getAll()
    {
         return DB::table('ambassadrics')->select('code', 'nom','status')->get();
      
    }
    
    
    public function getSomme():array
    {
        
        $data =  $this->getAll();
        $orders = Ordersambassadricecustom::All();
        // transformer en tableau 
        // transformer les retour objets en tableau
        $name_list = json_encode($data);
        $name_lists = json_decode($data,true);
       
        // transformer les retour objets en tableau
        $orders_list = json_encode($orders);
        $orders_lists = json_decode($orders,true);
        // renvoyer un tableau unique en fonction du code_promo
        // renvoyer un tableau unique par id commande
       $temp = array_unique(array_column($name_lists, 'nom'));
       $unique_arr = array_intersect_key($name_lists, $temp);
        
        // initiliser les array
        $array_list = [];// construire un tableau de données code promo =>montant
        $array_list1 = [];//lister des nom pour ambassadrice ,code pro
        $array_list2 =[]; //email et code
        $some = [];
        $b = [];
        
    
        foreach($orders_lists as $ky => $valu){
              $a = $valu['somme'];
              $b  = $valu['datet'];
              $c = $valu['id_ambassadrice'];
             // créer un array associatives code_promo montant
              $tab = array(
                  $valu['code_promo']=> $valu['somme']
                 
                 );
                       
                $array_list[] = $tab;
                $tab1 = array(
                  $valu['code_promo']=> $valu['email']
                  );
                       
                 $array_list1[] =$tab1;
                
          }
        
        
        // traiter les donnnées pour affiche un array
        
        $somme =[];// regrouper toutes les valeurs
        $array_somme_list =[]; // regrouper les codes promo et éleves
        foreach($unique_arr as $values) {
            $code = $values['code'];
            
            foreach($array_list as $keys => $donnes) {
            
                foreach($donnes as $key => $dones){
                
                   if($key == $code){
                    $somme[] = [
                       $key => $dones
                      ];
                    
                       $array_somme_list[$key] = $somme;
                }
            }
            
        }
            
      }
      
      //traiter le tableau et recupére les données
        $list = [];
       $g =[];
       $b =[];
       $a =[];
       $v =[];
       $some =0;
       
        foreach($array_somme_list as $k =>$vab){
            foreach($vab as $kys => $vaq) {
               foreach($vaq as $kes =>$vac){
                   if($k!=$kes){
                       unset($array_somme_list[$k][$kys]);
                   }
                   
               }
           }
       }
       
       return($array_somme_list);
    
  }
}
    
    