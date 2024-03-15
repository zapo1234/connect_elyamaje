<?php
// recuperer des utilitaires
namespace App\Http\Service\CallApi;

use Illuminate\Support\Facades\Http;
use Automattic\WooCommerce\Client;
use Automattique\WooCommerce\HttpClient\HttpClientException;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class Distributedorders
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
       public function getDataorder(): array
       {
           
             // créer un tableau des id_customer des distributeur
             // recupérer des distributeurs dynamiquement 
              $datas_distributeur = DB::connection('mysql3')->select("SELECT customer_id  FROM prepa_distributors");
              $datas = json_encode($datas_distributeur);
              $datas = json_decode($datas,true);
              
              $result_data =[];
              foreach($datas as $val){
                $result_data [] = $val['customer_id'];// result_data.
              }
              // FIXER LES Période de données
	            // traiter les données venant de woocomerce
              // FIXER LES Période de données
	            // traiter les données venant de woocomerce
               $current = Carbon::now();

               $date_last = $current->subDays(2);
               $curr = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$date_last)->format('Y-m-d\TH:i:s',$date_last);
               $date_after = $curr;
               // ajouter un intervale plus un jour !
               $current1 = $current->addDays(2);
               $current2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current1)->format('Y-m-d\TH:i:s',$current1);
               $date_before = $current2;

               //$customer_key = env('API_KEY_PUBLIC_WOOCOMERCE');
               //$customer_secret = env('API_KEY_PRIVATE_WOOCOMERCE');
               $customer_key = $this->api->getApikeywopublic();
               $customer_secret =$this->api->getApikeysecret();
              // initiliaser un array
                $donnees = [];
              // boucle sur le nombre de paginations trouvées
             for($i=1; $i<4; $i++) {
                $urls="https://www.elyamaje.com/wp-json/wc/v3/orders?orderby=date&order=desc&after=$date_after&before=$date_before&consumer_key=$customer_key&consumer_secret=$customer_secret&page=$i&per_page=100";
                // recupérer des donnees orders de woocomerce depuis api
                $donnes = $this->api->getDataApiWoocommerce($urls);
               if($donnes){
                  $donnees[] = array_merge($donnes);
                }
           }
           
             $distributeur_id = $result_data;
            // choix du status de commande à recupérer
            $data_status =  array('on-hold'); // en-attente-de-pai
           $coupons_distributeur= [];
            $order_id =[];// recupérer les id de comande.
           foreach($donnees as $donns){
                
                foreach($donns as $values){
                 
                        //formaté la date en datetime français
                           $date = $values['date_created'];
                           $replace = 'à';
                           $t  = "T";
                            $date1 = str_replace($t,$replace,$date);
             
                            $date_express = explode('à', $date1);
                            $datet = $date_express['0'];
                            $datet1 = $date_express['1'];
             
                             $date2 = explode('-',$datet);
             
                             $date_finish = $date2['2'].'/'.$date2['1'].'/'.$date2['0'];
                             
                             $code_mois = $date2[1];
                             $code_annee = $date2[0];
                             
                             $nombre_code = (int)$code_mois;
                             $nombre_annee = (int)$code_annee;
            
                              //date finish
                             $date_finish1 = $date_finish.' à '.$datet1;
                             
                        
                               $somme = $values['total'];
                                // recupérer les orders avec le code spécifique..km
                                // si le customer id est dans le tableau..
                    
                                if(in_array($values['customer_id'],$distributeur_id)){
                                    if(in_array($values['status'],$data_status)){
                                        $coupons_distributeur[] = [
                                         "date_created"=> $date_finish,
                                          "id_commande"=>$values['id'],
                                          "status"=>$values['status'],
                                         "customer"=> $values['billing']['first_name'].' '.$values['billing']['last_name'],
                                         "email" => $values['billing']['email'],
                                         "telephone" => $values['billing']['phone'],
                                         "adresse" => $values['billing']['address_1'].''.$values['billing']['address_2'],
                                           "somme" => $somme,
                                          "data_line"=>$values['line_items'],
                                         "somme_tva" => $values['total_tax']
                
                                      ];

                                       // recupérer les order_id 
                                       $order_id[] = $values['id'];
                               
                                     }
                                    
                                   }
                                
                                }
                        
                         }

                
                         if(count($order_id)!=0){
                            // mettre le status de la commande en attente pai.
                              foreach($order_id as $valc){
                               // change directement via api le statuts
                                // modifier le status en pret magasin
                               $status="en-attente-de-pai";
                                $datas  = [
                                    'status'=>$status,
                                 ] ;
                                   $id = $valc;
        
                                  $urls="https://www.elyamaje.com/wp-json/wc/v3/orders/$id";
                                 $this->api->InsertPost($urls,$datas);
                               }

                         }
          
              // renvoyer un  tableau associative unique
               $array_datas = array_unique(array_column($coupons_distributeur, 'id_commande'));
               $array_data_uniques = array_intersect_key($coupons_distributeur, $array_datas);
               return $array_data_uniques;
    } 
    
    
    public function getDataorderboutique():array
    {
            
           // $urls="https://www.elyamaje.com/wp-json/wc/v3/orders/132737";
           //  $donnes = $this->api->getDataApiWoocommerce($urls);
          //  dd($donnes);
            $current = Carbon::now();

             $date_last = $current->subDays(1);
              $curr = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$date_last)->format('Y-m-d\TH:i:s',$date_last);
              $date_after = $curr;
             // ajouter un intervale plus un jour !
             $current1 = $current->addDays(2);
             $current2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current1)->format('Y-m-d\TH:i:s',$current1);
             $date_before = $current2;
             // initiliaser un array
             $donnees = [];
             
              //$customer_key = env('API_KEY_PUBLIC_WOOCOMERCE');
              //$customer_secret = env('API_KEY_PRIVATE_WOOCOMERCE');
               $customer_key = $this->api->getApikeywopublic();
               $customer_secret =$this->api->getApikeysecret();
               // boucle sur le nombre de paginations trouvées
             for($i=1; $i<3; $i++){
                $urls="https://www.elyamaje.com/wp-json/wc/v3/orders?orderby=date&order=desc&after=$date_after&before=$date_before&consumer_key=$customer_key&consumer_secret=$customer_secret&page=$i&per_page=100";
                // recupérer des donnees orders de woocomerce depuis api
                $donnes = $this->api->getDataApiWoocommerce($urls);
                if($donnes){
                  $donnees[] = array_merge($donnes);
                }
              }

              
             // choix du status de commande à recupérer
              $data_status =  array('processing');
              $coupons_boutique= [];// coupons boutique marseille
              $coupons_boutique_nice = [];//order boutique nice !
              $ids_orders_boutique = [];// recuperer les ids commande marseille
               $ids_orders_boutique_nice =[]; // recuperer les dis commande marseille  .
             foreach($donnees as $donns){
                foreach($donns as $values) {
                 
                           //formaté la date en datetime français
                             $date = $values['date_created'];
                             $replace = 'à';
                             $t  = "T";
                             $date1 = str_replace($t,$replace,$date);
             
                             $date_express = explode('à', $date1);
                             $datet = $date_express['0'];
                             $datet1 = $date_express['1'];
             
                             $date2 = explode('-',$datet);
                             $date_finish = $date2['2'].'/'.$date2['1'].'/'.$date2['0'];
                             $code_mois = $date2[1];
                             $code_annee = $date2[0];
                             $nombre_code = (int)$code_mois;
                             $nombre_annee = (int)$code_annee;
                              //date finish
                             $date_finish1 = $date_finish.' à '.$datet1;
                             $somme = $values['total'];
                             // precision que la commmande est en cours et qu'il doit etre retiré au magasin.  
                              if(in_array($values['status'],$data_status)) {
                                    // recupérer toute les commandes prete en boutique 
                                     // recupérer les ids de ces commande et un tableau 
                                     // Si Le retraire est à marseille.
                                       foreach($values['shipping_lines'] as $vals){
                                      
                                            if($vals['instance_id']=="40"){
                                                // recupérer les ids commande de la conditions 
                                                    $ids_orders_boutique[] = $values['id'];
                                                    $coupons_boutique[] = [
                                                   "date_created"=> $date_finish,
                                                   "id_commande"=>$values['id'],
                                                   "status"=>$values['status'],
                                                   "customer"=> $values['billing']['first_name'].' '.$values['billing']['last_name'],
                                                   "email" => $values['billing']['email'],
                                                   "telephone" => $values['billing']['phone'],
                                                  "adresse" => $values['billing']['address_1'].''.$values['billing']['address_2'],
                                                    "somme" => $somme,
                                                   "data_line"=>$values['line_items'],
                                                   "somme_tva" => $values['total_tax']
                
                                             ];
                               
                                          }
                                    
                                   
                                          if($vals['instance_id']=="39") {
                                                // recupérer les ids commande de la conditions
                                              // recupérer les ids commande de la conditions 
                                               $ids_orders_boutique_nice[] = $values['id'];
                                              $coupons_boutique_nice[] = [
                                                "date_created"=> $date_finish,
                                                "id_commande"=>$values['id'],
                                               "status"=>$values['status'],
                                                "customer"=> $values['billing']['first_name'].' '.$values['billing']['last_name'],
                                               "email" => $values['billing']['email'],
                                               "telephone" => $values['billing']['phone'],
                                               "adresse" => $values['billing']['address_1'].''.$values['billing']['address_2'],
                                               "somme" => $somme,
                                               "data_line"=>$values['line_items'],
                                               "somme_tva" => $values['total_tax']
                
                                           ];
                                        
                                        }
                                    
                                    }
                                 } 
                                    
                             }
                                    
                          }
          
                          // renvoyer un  tableau associative unique pour marseille
                        $array_datas = array_unique(array_column($coupons_boutique, 'id_commande'));
                        $array_data_uniques = array_intersect_key($coupons_boutique, $array_datas);
                        // renvoyer un tableau associatives pour nice
                        $array_datas_nice = array_unique(array_column($coupons_boutique_nice, 'id_commande'));
                        $array_data_uniques_nice = array_intersect_key($coupons_boutique_nice, $array_datas_nice);
                        // recupérer le tableau nice
                         $this->setData($array_data_uniques_nice);
         
                        return $array_data_uniques;
        
        }
    
    
    }

