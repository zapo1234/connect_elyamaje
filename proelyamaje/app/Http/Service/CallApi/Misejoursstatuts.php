<?php
// recuperer des utilitaires
namespace App\Http\Service\CallApi;

use Illuminate\Support\Facades\Http;
use Automattic\WooCommerce\Client;
use Automattique\WooCommerce\HttpClient\HttpClientException;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class Misejoursstatuts
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
        
          $customer_key = env('API_KEY_PUBLIC_WOOCOMERCE');
          $customer_secret = env('API_KEY_PRIVATE_WOOCOMERCE');
	        // traiter les données venant de woocomerce
	          $date_after ="2021-02-30T09:01:00";
             $current = Carbon::now();
             // ajouter un intervale plus un jour !
             $current1 = $current->addDays(2);
             $current2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current1)->format('Y-m-d\TH:i:s',$current1);
            $date_before = "2021-04-30T09:01:00";
          
             // initiliaser un array
           $donnees = [];
           // boucle sur le nombre de paginations trouvées
          for($i=20; $i<40; $i++)
          {
              
             $urls="https://www.elyamaje.com/wp-json/wc/v3/orders?orderby=date&order=desc&after=$date_after&before=$date_before&consumer_key=$customer_key&consumer_secret=$customer_secret&page=$i&per_page=100";
              // recupérer des donnees orders de woocomerce depuis api
              $donnes = $this->api->getDataApiWoocommerce($urls);
             $donnees[] = array_merge($donnes);
           }
           
          // choix du status de commande à recupérer
          $data_status =  array('on-hold');
          $datas_ids =[];// recupérer les ids des commande en status de virement en attente.
        
           foreach($donnees as $donns) {
                
                foreach($donns as $values){
                    if(in_array($values['status'],$data_status)){
                            // recupérer les ids de ces commandes.
                            $datas_ids[] = $values['id'];
                        }
                                    
                }
                                
            }
                    
                // Modifier le status de toutes les commandes avec ce ids
                  $status_annule ="cancelled";
               
                  foreach($datas_ids as $values) {
                      // modifier le status des commandes récupérer.
                       // insert des données en post dans Api woocomerce Put sur les status
                       $id = $values;
                       $datas  = [
                       'status'=>$status_annule,
                
                          ] ;
            
                       $urls="https://www.elyamaje.com/wp-json/wc/v3/orders/$id";
                       $this->api->InsertPost($urls,$datas);
                 }
               
               dd('mise à jour des status');
    } 
    
    
    
    
    
     public function getStatutscancelled():array
     {
             $date_after ="2022-12-15T09:01:00";
             $current = Carbon::now();
             // ajouter un intervale plus un jour !
             $current1 = $current->addDays(2);
             $current2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current1)->format('Y-m-d\TH:i:s',$current1);
             $date_before = $current2;
            // Api key ....
             $customer_key = $this->api->getApikeywopublic();
             $customer_secret =$this->api->getApikeysecret();
             $donnees = [];
            // boucle sur le nombre de paginations trouvées
             for($i=1; $i<10; $i++) {
              
             $urls="https://www.elyamaje.com/wp-json/wc/v3/orders?orderby=date&order=desc&after=$date_after&before=$date_before&consumer_key=$customer_key&consumer_secret=$customer_secret&page=$i&per_page=100";
              // recupérer des donnees orders de woocomerce depuis api
              $donnes = $this->api->getDataApiWoocommerce($urls);
             $donnees[] = array_merge($donnes);
           }
           
        
         
         // choix du status de commande à recupérer
        $data_status =  array('on-hold');
        
        $datas_ids =[];// recupérer les ids des commande en status de virement en attente.
        $donnes_data =[];// recupérer les données ids commande dates et status;
        
           foreach($donnees as $donns) {
                
                foreach($donns as $values) {
                    if(in_array($values['status'],$data_status)) {
                            
                            // recupérer la date et modifier le format en Y-m-d;
                             $date = $values['date_created'];
                             $replace = 'à';
                              $t  = "T";
                          // recupérer la date et la transformer 
                              $date1 = str_replace($t,$replace,$date);
                              $date_express = explode('à', $date1);
                              $datet = $date_express['0']; // date au format y-m-d création de la commande
                              
                              // ajouter plus 5 sur la date 
                              $date_active = date('Y-m-d', strtotime($datet. '+5 days'));
                              
                              $date = date('Y-m-d');// recupére les données !
                              
                              if($date_active < $date && $values['status']=="on-hold"){
                                  // recupérer les ids de commande et changer la status en annulé
                                  $datas_ids[] = $values['id'];
                              }
                        
                            
                            $donnes_data[] =[
                                
                                'ids'=> $values['id'],
                                'date_create'=>  $datet,
                                'date_expire'=> $date_active,
                                'status'=> $values['status']
                                
                                ];
                        }
                                    
                }
                                
            }
            
            dd($datas_ids);
            
               // modifier les status 
              $status_annule = "cancelled";
                  foreach($datas_ids as $values)
                  {
                      // modifier le status des commandes récupérer.
                       // insert des données en post dans Api woocomerce Put sur les status
                       $id = $values;
                       $datas  = [
                       'status'=>$status_annule,
                
                          ] ;
            
                       $urls="https://www.elyamaje.com/wp-json/wc/v3/orders/$id";
                       $this->api->InsertPost($urls,$datas);
             
                   
                   
               }
                    
               dd('des mises bien effectuées');
               dd($donnes_data);
                
    } 
        
        
        
 }

