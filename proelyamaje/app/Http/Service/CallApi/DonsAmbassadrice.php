<?php
namespace App\Http\Service\CallApi;

use App\Http\Service\CallApi\Apicall;
use Illuminate\Support\Facades\Http;
use Automattic\WooCommerce\Client;
use Illuminate\Support\Facades\DB;
use Automattique\WooCommerce\HttpClient\HttpClientException;
use DateTime;
use DateTimeZone;

class DonsAmbassadrice
{
    
    
       public function __construct()
       {
           
       }


      
    
      public function getdatas()
      {

             // recupérer les données des facture en dons et uniquement que pour les ambassadric
             $datas_facture = DB::connection('mysql2')->select("SELECT ref,datec,total_ht,datef,fk_soc,fk_mode_reglement FROM llxyq_facture WHERE paye =1");
             $datas = json_encode($datas_facture);
             $datas = json_decode($datas,true);

             // recupérer les tiers des factures
             // recupérer les données des facture en dons et uniquement que pour les ambassadric
              $datas_tiers = DB::connection('mysql2')->select("SELECT rowid,name_alias,nom FROM llxyq_tiers");
              $data = json_encode($datas_tiers);
              $data = json_decode($data,true);
              $amabassadrice =[];
              foreach($data as $value){
                  if($value['name_alias']=="Ambassadrice"){
                      $chaine = $value['rowid'].','.$value['nom'];
                       $ambassadrice[] = $value['rowid'];
                  }
              }
              // recupérer les tiers des factures
              

            // recupérer toutes les commande des ambassadrice en dons.
            $ambassadrice =[];
            $mode_fk_regelement =8; // DONS 

            
             
      }
     

   // 
    
     
    
  }
     
    




