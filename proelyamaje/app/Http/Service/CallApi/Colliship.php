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
          
                $date = new DateTime();
                $date1 = new DateTime();
                // Soustrait un jour à la date actuelle.....
                $date->modify('-10 day');
                 $date1->modify('-180');
                
                $date_true = $date->format('Y-m-d');
                $date_trues = $date->format('Y-m-d H:i:s');
                $date_tru = $date1->format('Y-m-d H:i:s');
                $array_montant =  array('59.60','55.62','55.60','67.60','54.60');
                $array_montants = implode(',',$array_montant);
                $datas_facture = DB::connection('mysql2')->select("SELECT rowid ,datec FROM llxyq_facture WHERE total_ttc IN (".$array_montants.") AND  datef > '$date_true' AND fk_mode_reglement=54  AND paye=1");
                $datas = json_encode($datas_facture);
                $data = json_decode($datas,true);
                $ids_fact =[];

                // recupérer des données de la table facture_extrafiels pour un tri
                $datas_factures = DB::connection('mysql2')->select("SELECT  fk_object FROM llxyq_facture_extrafields WHERE  tms > '$date_trues'");
                $json = json_encode($datas_factures);
                $json_true = json_decode($json,true);


                // aller cherche dans la base 

                 // recupérer des données de la table facture_extrafiels pour un tri
                /* $datas_factutet = DB::connection('mysql2')->select("SELECT  fk_object,col FROM llxyq_facture_extrafields WHERE  tms < '$date_tru'");
                 $jsons = json_encode($datas_factutet);
                 $json_trues = json_decode($jsons,true);
 
                 dd($json_trues);

                */
                
                $result_data =[];

                foreach($json_true as $val){
                    $result_data[] = $val['fk_object'];
                }
                

                    foreach($data as $valu){
                    $ids_fact[] = $valu['rowid'];
                 }
                // recupérer les fk_facture
                // faire un update dans la table llxyq_facture_extrafields
                // recupérer ...
                 // recupérer la difference des 
                 $result_data_diff = array_diff($ids_fact,$result_data);
                
                 
                // faire des insert ici pour .
                // faire un insert d'ecriture de paiement facture du montant en espéce.
                $col =1;
                $point_fidelite= 0.00;

               foreach($result_data_diff as $vl){
                   DB::connection('mysql2')->table('llxyq_facture_extrafields')->insert([
                    'tms' => date('Y-m-d H:i:s'),
                    'fk_object' =>$vl,
                    'fid' => $col,
                     'point_fidelite'=>0.00,
                     'col' => 1,
                    // Ajoutez d'autres colonnes et valeurs selon votre besoin
                  ]);

              }
             
              dd('succees_true_true');

             $ids_f = implode(',',$ids_fact);

             // $reponse = DB::connection('mysql2')->select("UPDATE llxyq_facture_extrafields SET col=1 WHERE fk_object IN ('.$ids_f.')");

             DB::connection('mysql2')
              ->table('llxyq_facture_extrafields')
              ->whereIn('fk_object', $ids_fact)
              ->update(['col' => $col,
                       ]);
          
              dd('reponse_true');
     
      
    }
}
     

