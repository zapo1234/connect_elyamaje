<?php

namespace App\Http\Service\CallApi;

use Illuminate\Support\Facades\Http;
use App\Models\Couponmasterclas;
use Automattic\WooCommerce\Client;
use App\Models\FemFidelite;
use Automattique\WooCommerce\HttpClient\HttpClientException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class GetDataCoupons
{
    
     private $api;
    
       public function __construct(Apicall $api)
       {
         $this->api=$api;
       }
       
       
       public function getCouponsmaster()
       {
           $data = DB::table('couponmasterclass')->select('id_coupons')->get();
            $list = json_encode($data);
            $lists = json_decode($data,true);
      
	        
	        return $lists;
       }
    
       public function getDatacoupons(): array
       {
        
	         // traiter les données venant de woocomerce
            // $customer_key = env('API_KEY_PUBLIC_WOOCOMERCE');
            //$customer_secret = env('API_KEY_PRIVATE_WOOCOMERCE');

            $customer_key = $this->api->getApikeywopublic();
            $customer_secret =$this->api->getApikeysecret();

             $date_after ="2023-05-30T09:01:00";
              $current = Carbon::now();
             // ajouter un intervale plus un jour !
             $current1 = $current->addDays(2);
            $current2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current1)->format('Y-m-d\TH:i:s',$current1);
            $date_before = $current2;
           
          // initiliaser un array
           $donnees = [];
           // boucle sur le nombre de paginations trouvées
          for($i=1; $i<3; $i++){
               $urls="https://www.elyamaje.com/wp-json/wc/v3/coupons?orderby=date&order=desc&after=$date_after&before=$date_before&consumer_key=$customer_key&consumer_secret=$customer_secret&page=$i&per_page=100";
              // recupérer des donnees orders de woocomerce depuis api
              $donnes = $this->api->getDataApiWoocommerce($urls);
              if($donnes){
                $donnees[] = array_merge($donnes);
              }
           }
          
        
             return $donnees;
        }

        public function getAlldatacodefem()
        {
              // recupérer les code fem existant.
            $data = DB::table('fem_fidelites')->select('code_fem')->get();
            $list = json_encode($data);
            $lists = json_decode($data,true);
             $data_code =[];

            foreach($lists as $key => $val){
                  $data_code[$val['code_fem']]= $key;
            }

            return $data_code;
      

        }


        public function getDatafemcode(): array
        {
         
            //$customer_key = env('API_KEY_PUBLIC_WOOCOMERCE');
            //$customer_secret = env('API_KEY_PRIVATE_WOOCOMERCE');

            $customer_key = $this->api->getApikeywopublic();
            $customer_secret =$this->api->getApikeysecret();
          
             // traiter les données venant de woocomerce
              $date_after ="2022-08-30T09:01:00";
               $current = Carbon::now();
              // ajouter un intervale plus un jour de 10jours.
              $current1 = $current->addDays(7);
              $currents1 = $current->subDays(2);
           
              $current2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current1)->format('Y-m-d\TH:i:s',$current1);
              $current21 =  \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current2)->format('Y-m-d\TH:i:s',$current2);
               
               $date_after = $current21;
               $date_before = $current2;
               // initiliaser un array
               $donnees = [];
               // boucle sur le nombre de paginations trouvées
              for($i=1; $i<4; $i++) {
                $urls="https://www.elyamaje.com/wp-json/wc/v3/coupons?orderby=date&order=desc&after=$date_after&before=$date_before&consumer_key=$customer_key&consumer_secret=$customer_secret&page=$i&per_page=100";
               // recupérer des donnees orders de woocomerce depuis api
               $donnes = $this->api->getDataApiWoocommerce($urls);
               if($donnes){
                 $donnees[] = array_merge($donnes);
               }
            }

            // recupérer tous les codes du programme de fidélité crée.....
            $data_code_fem =[];
            $chaine ="fem-";
            $date =date('Y-m-d');
            foreach($donnees as $val){
                   foreach($val as $values){
                    
                    if(strpos($values['coupons'],$chaine) !==false) {
                           if(isset($data_code[$values['coupons']])==false){
                            $data_code_fem[] = $values['coupons'];

                            // insert dans la bdd
                            $codefem = FemFidelite();
                            $codefem->code_fem = $values['coupons'];
                            $codefem->id_coupons = $values['id'];
                            $codefem->date = $date;
                            $codefem->save();
                        }  
                    }

                 }

            }

         }


         public function getdatacodefem($id)
         {
            //$customer_key = env('API_KEY_PUBLIC_WOOCOMERCE');
           // $customer_secret = env('API_KEY_PRIVATE_WOOCOMERCE');

            $customer_key = $this->api->getApikeywopublic();
            $customer_secret =$this->api->getApikeysecret();
          
            $urls="https://www.elyamaje.com/wp-json/wc/v3/coupons/$id/?&consumer_key=$customer_key&consumer_secret=$customer_secret&page=$i&per_page=100";
             // recupérer des donnees orders de woocomerce depuis api
            $donnes = $this->api->getDataApiWoocommerce($urls);
          if($donnes){
            $donnees[] = array_merge($donnes);
          }
                 
         }

         public function getdatacustomers()
         {
            
          $customer_key = $this->api->getApikeywopublic();
          $customer_secret =$this->api->getApikeysecret();
        
            $donnees = [];
          // boucle sur le nombre de paginations trouvées
           for($i=1; $i<9; $i++) {
              $urls="https://www.elyamaje.com/wp-json/wc/v3/customers?consumer_key=$customer_key&consumer_secret=$customer_secret&page=$i&per_page=100";
              // recupérer des donnees orders de woocomerce depuis api
              $donnes = $this->api->getDataApiWoocommerce($urls);
                if($donnes){
                 $donnees[] = array_merge($donnes);
             }
           }
        }
 

}
     
