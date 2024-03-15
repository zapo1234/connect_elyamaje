<?php
// recuperer des utilitaires
namespace App\Http\Service\CallApi;

use Exception;
use Carbon\Carbon;
use App\Models\Orderscommerce;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Automattique\WooCommerce\HttpClient\HttpClientException;

class NombreOrders
{
    
     private $api;
     private $data =[];
    
       public function __construct(Apicall $api
       
        )
       {
         $this->api=$api;
        
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
   
  
     // methode recupérer des data wooocomerce qui ont un code promo amabassadrice
       public function getDataorder()
       {
          try{
	            // FIXER LES Période de données
	            // traiter les données venant de woocomerce
               $current = Carbon::now();
              // ajouter un intervale plus un jour !
              $current1 = $current->addDays(2);
              $curren = Carbon::now()->subDays(4);
              $current2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current1)->format('Y-m-d\TH:i:s',$current1);
              $current_sub =  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$curren)->format('Y-m-d\TH:i:s',$curren);

              $customer_key = $this->api->getApikeywopublic();
              $customer_secret =$this->api->getApikeysecret();
            
              $date_after = $current_sub;
              $date_before = $current2;
          
                 // initiliaser un array
               $donnees = [];
               // boucle sur le nombre de paginations trouvées..
                for($i=1; $i<7; $i++) {
                   $urls="https://www.elyamaje.com/wp-json/wc/v3/orders?orderby=date&order=desc&after=$date_after&before=$date_before&$customer_key=ck_06dc2c28faab06e6532ecee8a548d3d198410969&$customer_secret=cs_a11995d7bd9cf2e95c70653f190f9feedb52e694&page=$i&per_page=100";
                  // recupérer des donnees orders de woocomerce depuis api
                   $donnes = $this->api->getDataApiWoocommerce($urls);
                if($donnes){
                $donnees[] = array_merge($donnes);
              }
             
           }
          
           // recupérer les commande de la date courante
           $current_days = Carbon::now();
           $date_now = date('Y-m-d');
           // convertir la date au format api woocomerce
            $current_true = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current_days)->format('Y-m-d\TH:i:s',$current_days);
           $donnees_array = [];// commande actuel en cours
           $donnees_statuts = [];// le nombre de commande avec le status processing // enc cours
           $status_array = array('processing');
           
           
           // recuperer id commande existant
           // $donnees_ids =  DB::table('orderscommerces')->select('id_commande')->get();
           // transformer en tableau 
           //$list = json_encode($donnees_ids);
           //$lists = json_decode($donnees_ids,true);
           
           //$donnes_array_ids =[];// recupérer id dans une table
           
          // foreach($lists as $vl)
          // {
          //     $donnes_array_ids[] = $vl['id_commande'];
          // }
           
           
           // vider la table pour actualiser les nouvelle
           DB::table('orderscommerces')->delete();
           
           foreach($donnees as $keys =>$values){
               foreach($values as $val) {
                  // recupérer la date au format souhaite Y-m-d
                   $date_now_api = explode('T', $val['date_created']);
                   $date_true = $date_now_api[0];
                   
                   if($date_true == $date_now){
                       // recupérer les commande à la date courrante actuel
                       $donnees_array[] = $val['id'];
                   }
                   
                   if(in_array($val['status'],$status_array)){
                       $donnees_status[] = $val['id'];
                       // insert les commande avec ce status dans la bdd
                       $orders = new Orderscommerce();
                       $orders->date = $date_true;
                       $orders->id_commande = $val['id'];
                       // insert dans bdd
                       $orders->save();
                       
                   }
                   
                   
               }
           }
           
            // faire un delete sur la table
            return $donnees_status;

        } catch (Exception $e) {
          return $e->getMessage();
        } 
           
    } 
    
}

