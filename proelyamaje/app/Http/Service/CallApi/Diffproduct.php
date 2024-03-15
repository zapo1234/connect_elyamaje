<?php
// recuperer des utilitaires
namespace App\Http\Service\CallApi;

use Illuminate\Support\Facades\Http;
use Automattic\WooCommerce\Client;
use Automattique\WooCommerce\HttpClient\HttpClientException;

class Diffproduct
{
    
     private $api;
    
       public function __construct(Apicall $api)
       {
         $this->api=$api;
       }
    
    
      public function getdataproduct()
      {
           // boucle sur le nombre de paginations trouvées
           //$customer_key = env('API_KEY_PUBLIC_WOOCOMERCE');
          // $customer_secret = env('API_KEY_PRIVATE_WOOCOMERCE');

           $customer_key = $this->api->getApikeywopublic();
           $customer_secret =$this->api->getApikeysecret();

          for($i=1; $i<8; $i++){
              
             $urls="https://www.elyamaje.com/wp-json/wc/v3/products?consumer_key=$customer_key&consumer_secret=$customer_secret&page=$i&per_page=100";
              // recupérer des donnees orders de woocomerce depuis api
              $donnes = $this->api->getDataApiWoocommerce($urls);
             $donnees[] = array_merge($donnes);
           }
           
           // recuperer les produit (name et les sku  de ces produits)
           $product_list = [];
           foreach($donnees as $k => $values){
               $product_list[$values['sku']]=$values['name'];
           }
              
      }
      
    
    
    
       public function getDataorder(): array
       {
        
	         // recuperer les données api dolibar copie projet tranfer x.
              $method = "GET";
              $apiKey = env('KEY_API_DOLIBAR_TEST');
               $apiUrl = "https://www.transfertx.elyamaje.com/api/index.php/";
           
              //environement test local
           
               //Recuperer les ref et id product dans un tableau
	   
	           $produitParam = ["limit" => 700, "sortfield" => "rowid"];
	            $listproduct = $this->api->CallAPI("GET", $apiKey, $apiUrl."products", $produitParam);
	            
	              $lists = json_decode($listproduct,true);
	            
	            foreach($lists as $values)
               {
                  $product_data[$values['id']]= $values['ref'];// tableau associative entre id product et reférence(product)
                  // tableau associatve entre ref et label product
                  $product_datas[$values['label']] = $values['ref'];
         
              }
      
           
            return $product_datas;
       }
        
        
       
     public function data_list (): array
     {
        // recupérer les produit et les réf qui ne sont pas dans dolibar mais sur woocommerce.
        $data1 = $this->getdataproduct(); // woocommerce product et ref
        $data2 = $this->getDataorder(); // dolibar product et ref ***///
     }
     
     
     public function getDatatiers()
     {
          
             // recuperer les données api dolibar propers prod tous les clients.
              $method = "GET";
               $apiKey = env('KEY_API_DOLIBAR_PROD');
               $apiUrl ="https://www.poserp.elyamaje.com/api/index.php/";
               //Recuperer les ref et id product dans un tableau
	             $produitParam = ["limit" => 500, "sortfield" => "rowid","sortorder" => "DESC"];
	            $listproduct = $this->api->CallAPI("GET", $apiKey, $apiUrl."thirdparties", $produitParam);
	            
	            $lists = json_decode($listproduct,true);
              return $lists;
     }
     
     
     
       public function getFacturedol()
        {
          
               // recuperer les données api dolibar propers prod tous les clients.
                  $method = "GET";
                   $apiKey = env('KEY_API_DOLIBAR_PROD');
                   $apiUrl ="https://www.poserp.elyamaje.com/api/index.php/";
                  //Recuperer les ref et id product dans un tableau
                   // recupérer les facture d'au moins 3;
                  $date_cours = date('Y-m-d');
                  // retrancher les 3 mois dernier
                  $date_new = date('Y-m-d', strtotime($date_cours. ' - 90 days'));
                 // gérer des date en dur
                 $date_debut ="2022-01-01";
                 $date_fin = "2022-06-01";
                // pagination accepté de 0 à 4.
	              for($i=0;$i<4;$i++){
	                $produitParam = ["limit" => 2600, "status"=>"paid", "page"=>$i, "sortfield" => "rowid", "sqlfilters"=>"(t.datec:>=:'$date_debut') AND (t.datec:<=:'$date_fin') "];
	                $listinvoice = $this->api->CallAPI("GET", $apiKey, $apiUrl."invoices", $produitParam);
	                $lists[] = json_decode($listinvoice,true);
	              }
	              return $lists;
          
      }
     
     // recupérer les facture dans dolibarr les 1000 première facture
      public function getFacturedol2()
      {
          
              // recuperer les données api dolibar propers prod tous les clients.
               $method = "GET";
               $apiKey = env('KEY_API_DOLIBAR_PROD');
               $apiUrl ="https://www.poserp.elyamaje.com/api/index.php/";
               //Recuperer les ref et id product dans un tableau les deux première
	   
	            $produitParam = ["limit" => 2000, "sortfield" => "rowid","sortorder" => "DESC"];
	             $listinvoice = $this->api->CallAPI("GET", $apiKey, $apiUrl."invoices", $produitParam);
	             $lists = json_decode($listinvoice,true);
	            // recupérer les 2000 autre facture 
	            $produitParams = ["limit" => 2000, "sortfield" => "rowid","sortorder" => "DESC", "page"=>1];
	            $listinvoices = $this->api->CallAPI("GET", $apiKey, $apiUrl."invoices", $produitParams);
	            $lis = json_decode($listinvoices,true);
              $array = array_merge($lis,$lists);
             
            return $array;
          
      }
      
      public function getcategories()
       {
          
           // recuperer les données api dolibar propers prod tous les clients.
              $method = "GET";
               $apiKey = env('KEY_API_DOLIBAR_PROD');
               $apiUrl ="https://www.poserp.elyamaje.com/api/index.php/";
               //Recuperer les ref et id product dans un tableau
	   
	           $produitParam = ["limit" => 800, "sortfield" => "rowid","sortorder" => "DESC"];
	            $listproduct = $this->api->CallAPI("GET", $apiKey, $apiUrl."categories", $produitParam);
	            
	            $lists = json_decode($listproduct,true);
                return $lists;
                 // supmier l'existant et enregsitrer la mise a jours
         }
        
       
}
     

