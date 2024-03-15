<?php
// recuperer des utilitaires
namespace App\Http\Service\CallApi;

use Illuminate\Support\Facades\Http;
use Automattic\WooCommerce\Client;
use Automattique\WooCommerce\HttpClient\HttpClientException;

class GetDataOrders
{
    
     private $api;
    
       public function __construct(Apicall $api)
       {
         $this->api=$api;
       }
    
    
        public function getdataorderid($id)
        {
           //$customer_key = env('API_KEY_PUBLIC_WOOCOMERCE');
          //$customer_secret = env('API_KEY_PRIVATE_WOOCOMERCE');
          $customer_key = $this->api->getApikeywopublic();
          $customer_secret =$this->api->getApikeysecret();
            
              $urls="https://www.elyamaje.com/wp-json/wc/v3/orders/$id?&consumer_key=$customer_key&$customer_secret=cs_a11995d7bd9cf2e95c70653f190f9feedb52e694";
              // recupérer des donnees orders de woocomerce depuis api
              $donnes = $this->api->getDataApiWoocommerce($urls);
             $donnees[] = array_merge($donnes);
             
            return $donnees;
        }
      
    
    
    
       public function getDataorder(): array
       {
        
	       // recuperer les données api dolibar copie projet.
           $method = "GET";
           $apiKey = env('KEY_API_DOLIBAR_TEST');
           $apiUrl = "https://www.transfertx.elyamaje.com/api/index.php/";
            // recupérer les données orders depuis dolibar
            // créer un array
            $data_invoices =[];
            $id =[];
            // array infos clients
            $client =[];
            $line = [];
            
            // recupérer les 2400 dernière facture.
            for($i =1; $i<3; $i ++){
            $orderSearch = json_decode($this->api->CallApi("GET", $apiKey, $apiUrl."invoices", array(
		       "sortfield" => "t.rowid", 
		       "sortorder" => "DESC", 
		       "limit" => "100", 
		       "page" => $i,
		    )
	       ), true);
	       
	       $line[] = $orderSearch;
            
            }
            
            // recupérer et créer un tableau associatives pour  les tiers
	         $orderSearchs = json_decode($this->api->CallApi("GET", $apiKey, $apiUrl."thirdparties", array(
		       "sortfield" => "t.rowid", 
		       "sortorder" => "DESC", 
		       "limit" => "3100", 
		    )
	       ), true);
	         
	        
	        foreach($orderSearchs as $list){
	            
	             $data = $list['name'].','.$list['email'].','.$list['address'].', '.$list['phone'];
	             $client[$data] = $list['id'];
	            
	        }
	        
	        // créer un tableau multidimensionelle pour recupérer les données clients !
	        $data_invoices = [];
	        $lines = [];
	        $css="paye";
	        $origine ="Boutique de marseille";
	        $status="payé";
	        $country="";
	        foreach($line as  $key =>$values){
	            foreach($values as $vals){
	            
	             foreach($vals['lines'] as $val)
	             $fk = array_search($vals['socid'],$client);
	             if($fk) {
	                 // création du tableau en cas d'existence
	                 $valeur = explode(',', $fk);
	                 
	                 // geérer l'affichage de date au format souhaité
	                 $datet = date('d-m-y H:i', $vals['date']);
	                 
	                 // format à l'affichage 2 chiffre après la virgule
	                  $total = number_format($vals['total_ttc'], 2, '.', '');

	                 
	                  $lines[] = [
                    "product_label" =>$val['product_label'],
                   "qty" => $val['qty'],
                   'socid' =>$vals['socid'],
                      
                      ];
	               
	               $data_invoices[] = [
                         
                         "socid" =>$vals['socid'],
                         "date_created"=>$datet,
                         "Nom_client" => $valeur[0],
                         "email" => $valeur[1],
                          "adresse"  =>$valeur[2],
                          "origine"=>$origine,
                           "css"=> $css,
                           "status" =>$status,
                           "phone"=> $valeur[3],
                          "total" =>$total,
                          "country" =>$country,
                          "lines" =>$lines,
                         ];
	               
	               }
	            
	         }
	            
	   }
	       
	       // liée les données au socid (procut achéte sur dolibar)
	       
	       foreach($data_invoices as $r => $val) {
           
             foreach($val['lines'] as $q => $vak){
               if($val['socid']!=$vak['socid']) {
                 unset($data_invoices[$r]['lines'][$q]);
               }

             }
         }
	      
	     
	          // FIXER LES Période de données
	          // traiter les données venant de woocomerce
              $date1 ="2022-05-01T09:01:00";
              $date2 = "2022-06-01T09:01:00";
              // definir les horaires
              $current = Carbon::now();
              $current2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current)->format('Y-m-d\TH:i:s',$current);
              $date_before = $current2;
             // initiliaser un array
             //$customer_key = env('API_KEY_PUBLIC_WOOCOMERCE');
            // $customer_secret = env('API_KEY_PRIVATE_WOOCOMERCE');
             
             $customer_key = $this->api->getApikeywopublic();
             $customer_secret =$this->api->getApikeysecret();

             $donnees = [];
             // boucle sur le nombre de paginations trouvées
          for($i=1; $i<3; $i++){
              $urls="https://www.elyamaje.com/wp-json/wc/v3/orders?&orderby=date&order=desc&consumer_key=$customer_key&consumer_secret=$customer_secret&page=$i&per_page=100";
              // recupérer des donnees orders de woocomerce depuis api
              $donnes = $this->api->getDataApiWoocommerce($urls);
             $donnees[] = array_merge($donnes);
           }
          
         
            // recuperer les données de woocomerce 
             $datas =[];
            foreach($donnees as $donns) {
                
                foreach($donns as $donnes){
             
                foreach($donnes['line_items'] as $key => $values){
                    
                 // recupérer les commande declenché
                 $array_succes = array('processing');
                 if(in_array($donnes['status'],$array_succes)){
                 // product comments
                 $line = $values['name'];
                 //formaté la date en datetime français
                 $date = $donnes['date_created'];
                 $replace = 'à';
                 $t  = "T";
                 $date1 = str_replace($t,$replace,$date);
             
                 $date_express = explode('à', $date1);
             
                $datet = $date_express['0'];
                $datet1 = $date_express['1'];
             
                 $date2 = explode('-',$datet);
             
                $date_finish = $date2['2'].'/'.$date2['1'].'/'.$date2['0'];
            
               //date finish
                $date_finish1 = $date_finish.' à '.$datet1;
            
                if($donnes['status']=="processing"){
                   $statuss ="en cours";
                   $css="processing";
                }
            
                elseif($donnes['status']=="failed") {
                   $statuss ="echouée";
                   $css="failed";
                }
            
               else{
                  $statuss = $donnes['status'];
                  $css="";
               }
            
                $origines ="woocommerce";
                 $datas[] = [
                "socid" =>'',
               "date_created"=> $date_finish1,
               "Nom_client"=> $donnes['billing']['first_name'].' '.$donnes['billing']['last_name'],
                  "adresse" => $donnes['billing']['address_1'].''.$donnes['billing']['address_2'],
                  "email"=> $donnes['billing']['email'],
                 "status"=>$statuss,
                 "origine"=>$origines,
                  "css"=> $css,
                 "phone" => $donnes['billing']['phone'],
                 "total" => $donnes['total'],
                "country" => $donnes['billing']['country'],
                 "lines" => $line
                  
            ];
          
          }
          
          }
        
       }
        
    }
        
        // afficher un tableau avec email unique lié au client
        // renvoyer un tableau unique par email des données de woocomerce
        // merge les deux tableau en un seul
          $array_sync = array_merge($data_invoices, $datas);
       
          return $array_sync;
        
        
       }
}
     

