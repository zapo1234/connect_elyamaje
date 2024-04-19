<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Service\CallApi\Api;
use App\Http\Controllers\Controller;

class ApiElearningController extends Controller
{
    
    
    private $api;

    public function __construct(
        Api $api,


    ){
        $this->api = $api;

    }



    public function getAllProductwc(){
        
        $customer_key = $this->api->getApikeywopublic();
        $customer_secret =$this->api->getApikeysecret();

         for($i=1; $i<8; $i++){
          
           $urls="https://www.elyamaje.com/wp-json/wc/v3/products?consumer_key=$customer_key&consumer_secret=$customer_secret&page=$i&per_page=100";
           // recupérer des donnees orders de woocomerce depuis api
           $donnes = $this->api->getDataApiWoocommerce($urls);
           $donnees[] = array_merge($donnes);
         }
    
    }
    
    
}
