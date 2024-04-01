<?php
// recuperer des utilitaires
namespace App\Http\Service\CallApi;

use Illuminate\Support\Facades\Http;
use Automattic\WooCommerce\Client;
use Automattique\WooCommerce\HttpClient\HttpClientException;
use Illuminate\Support\Facades\DB;

use DateTime;

class Colliship
{
    
      private $api;
    
       public function __construct(Apicall $api)
       {
         $this->api=$api;
        }
    
    
      public function getcolliship()
      {
            // recupérer les commande  en colliship dolibar et cocher dynamiquement.
          try{
                $date = new DateTime();
                // Soustrait un jour à la date actuelle
                $date->modify('-5 day');
                $date_true = $date->format('Y-m-d');
                $array_montant =  array('59.60','55.62','55.60');
                $array_montants = implode(',',$array_montant);
                $datas_facture = DB::connection('mysql2')->select("SELECT rowid ,datec FROM llxyq_facture WHERE total_ttc IN (".$array_montants.") AND  datef > '$date_true' AND fk_mode_reglement=54  AND paye=1");
                $datas = json_encode($datas_facture);
                $data = json_decode($datas,true);
                $ids_fact =[];

                dump($data);

                foreach($data as $valu){
                  $ids_fact[] = $valu['rowid'];
                }
                // recupérer les fk_facture
                // faire un update dans la table llxyq_facture_extrafields
                // recupérer ...
                 $ids_f = implode(',',$ids_fact);
                 $response = DB::connection('mysql2')->select("UPDATE llxyq_facture_extrafields SET col=1 WHERE fk_object IN ('.$ids_f.')");
               //$reponse = DB::connection('mysql2')->update("UPDATE llxyq_facture_extrafields SET col=1 WHERE fk_object IN ('.$ids_f.')");
                var_dump($response);
             }  catch (\Illuminate\Database\QueryException $e) {
              // Capture de l'erreur et affichage du message
               dd($e->getMessage());
              echo "Une erreur s'est produite : " . $e->getMessage();
       }
      
    }
}
     

