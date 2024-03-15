<?php

namespace App\Http\Service\CallApi;

use App\Http\Service\CallApi\Apicall;
use Illuminate\Support\Facades\Http;
use Automattique\WooCommerce\HttpClient\HttpClientException;
use DateTime;
use DateTimeZone;

class Miseajour
{
    
      private $api;
      
      private $commande;
      private $dataidcommande;// recupérer les ids commande existant
      
    
       public function __construct(Apicall $api,
       CommandeidsRepository $commande)
       {
         $this->api=$api;
         $this->commande = $commande;
       }
    
    
    
         
          public function getdataproduct()
          {
              //$customer_key = env('API_KEY_PUBLIC_WOOCOMERCE');
             //$customer_secret = env('API_KEY_PRIVATE_WOOCOMERCE');
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
           $product_ids = [];
           foreach($donnees as $k => $values){
               $product_list[$values['sku']]= $values['name'];
               $product_ids[$values['id']] = $values['sku'];// tableau associatif entre id produit et les sku.
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
	            
	            foreach($listproduct as $values) {
                  $product_data[$values['id']]= $values['ref'];// tableau associative entre id product et reférence(product)
                  // tableau associatve entre ref et label product
                  $product_datas[$values['label']] = $values['ref'];
         
              }
      
           
           return $product_datas;
          
        
    }
         
     

  }
     
    












?>