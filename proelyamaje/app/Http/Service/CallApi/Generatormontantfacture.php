<?php
namespace App\Http\Service\CallApi;

use App\Http\Service\CallApi\Apicall;
use Illuminate\Support\Facades\Http;
use Automattic\WooCommerce\Client;
use Illuminate\Support\Facades\DB;
use App\Models\Ambassadrice\Pointbilan;
use App\Models\Ambassadrice\Ambassadricecustomer;
use App\Models\Ambassadrice\Ordersambassadricecustom;
use Automattique\WooCommerce\HttpClient\HttpClientException;
use DateTime;
use DateTimeZone;

class Generatormontantfacture
{
    
    
       public function __construct()
       {
           
       }


      
    
      public function  updatecode_use()
      {
         // générer une facture menseul Partenaire ou Ambassadrice classique en fonction du status de la sociéte
             // recupérer les codes élève crée 
              // recupérer les données id_invoices deja dans la table
              $donnees_ids =  DB::table('ambassadricecustomers')->select('code_promo','date')->get();
              // transformer en tableau 
              $lis = json_encode($donnees_ids); // tranformer les données en json
              $lis = json_decode($donnees_ids,true); //

              $data_code_promo_create =[];

              foreach($lis as $val){
                  $chaine = $val['code_promo'].','.$val['date'];
                  $data_code_promo_create[] = [
                    'code_promo' => $val['code_promo'],
                    'date'=>$val['date']
                  ];

                  $code_create[] = $val['code_promo'];
              }

              //dd($data_code_promo_create);
 
                // recupérer les données id_invoices deja dans la table
                $code_live =11;
                $donnees_id =  DB::table('ordersambassadricecustoms')->select('code_promo','datet','id_ambassadrice','customer','email','telephone')->where('code_live','=',$code_live)->get();
                 // transformer en tableau 
                 $liss = json_encode($donnees_id); // tranformer les données en json
                  $liss = json_decode($donnees_id,true); //
               
                  $data_code_promo_use =[];
                foreach($liss as $values){
                     $chaine = $val['code_promo'].','.$values['datet'].','.$values['id_ambassadrice'].','.$values['customer'].','.$values['telephone'];
                     $data_code_promo_use[$chaine] = $values['code_promo'];
                     $code_use[] = $values['code_promo'];
                }

                    // update le champs ajouté le champs status à 1;
                    $status_id=1;
                    DB::table('ambassadricecustomers')->whereIn('code_promo', $code_use)->update([
                     'status' => $status_id
                   ]);

                   dd('success');

               

            }

      public function  updategeneratorfacture($id_ambassadrice,$annee)
      {
          // changer les montants et ajuster les facture si le Amba ou le Part change de status pour la TVA
          // EI => SAS,SASU,SARL => Crée un satus SASS.
          // modifier le status pour la tva dans la table users.
          // recupérer les données des montant 
          //obtenir le nombre de ventes réalisées par une amabadrice
            $tva =20;
            // faire un group by  sur les montant et les mois via l'année....
            $points = DB::table('pointbilans')
            ->select('id','id_mois','somme')
            ->where('id_ambassadrice','=',$id_ambassadrice)
            ->where('annee','=',$annee)
            ->orderBy('id_mois','asc')
            ->get();
  
             $name_list = json_encode($points);
             $name_list = json_decode($points,true);


             $data_mois_id=[];// recupérer les id a update...
             $data_id_mois =[];// recupérer les id_mois mensuel

             foreach($name_list as $values){
               $chaine_x = $values['id_mois'].','.$values['id'];
                $data_mois_id[] =  $values['id'];
                $data_id_mois[] = $values['id_mois'];
             }
             
            //general....
             $array_mois = array('1','2','3','4','5','6','7','8','9','10','11','12');
             $list_diff = array_diff($array_mois,$data_id_mois);
             $n = count($list_diff);
             for($i=0; $i <$n+1;$i++){
                 unset($array_mois[11-$i]);// retirer du tableau.
                 unset($data_mois_id[11-$i]);
             }

            
             // faire un group by  sur les montant et les mois via l'année.
             $orders = DB::table('ordersambassadricecustoms')
            ->select('code_mois',DB::raw('SUM(somme) as total'))
            ->where('id_ambassadrice','=',$id_ambassadrice)
            ->where('annee','=',$annee)
            ->groupBy('code_mois')
            ->orderBy('code_mois','asc')
            ->get();

             $name_lists = json_encode($orders);
             $name_lists = json_decode($orders,true);

             $data_montant = [];
             $data_montant_change =[];
            foreach($name_lists as $value){
               if(in_array($value['code_mois'],$array_mois)){
                 $chaine = $value['code_mois'].','.$value['total'];
                 $data_montant[$chaine] = $value['code_mois'];
                 $data_montant_change[] = $value['total']+$value['total']*20/100;// prendre le montant +la tva.
               }
          }
            
           // recap des données pour mettre à jours les le montant_ttc des facture
            $nombre_fois = count($data_mois_id)-1;
           // Modification mutiple des montants nickel recupération des datas .
            DB:: transaction (function() use($data_mois_id, $data_montant_change,$nombre_fois) { 
            for ($i = 0; $i <= $nombre_fois; $i++) { 
                 Pointbilan:: where (['id' => $data_mois_id[$i]]) 
                  ->update(['somme' => $data_montant_change[$i]]); 
            } 
        });

        dd('succes');//......
         
            return $datas;

      }
     

   // 
    
     
    
  }
     
    




