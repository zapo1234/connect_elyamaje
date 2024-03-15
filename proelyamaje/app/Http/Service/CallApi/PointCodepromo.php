<?php
namespace App\Http\Service\CallApi;

use App\Http\Service\CallApi\Apicall;
use Illuminate\Support\Facades\Http;
use Automattic\WooCommerce\Client;
use Illuminate\Support\Facades\DB;
use Automattique\WooCommerce\HttpClient\HttpClientException;
use DateTime;
use DateTimeZone;

class PointCodepromo
{
    
    
       public function __construct()
       {
           
       }


       public function downloads(array $array){
            
          $filename = "status_code_eleve.csv";
          $fp = fopen('php://output', 'w');
           // créer une entete du tableau .
           $header = array('date_creation','date_utilisation','status','ambassadrice/partenaire');
           // gérer les entete du csv 
      
           header('Content-type: application/csv');
           header('Content-Disposition: attachment; filename=' . $filename);
           fputcsv($fp, $header);
            foreach ($data as $row) {
            fputcsv($fp, $row);
          }
           exit();

       }
    
    
      public function getstatistique()
      {
             
              // crée un array
              $donnees_is =  DB::table('users')->select('name','id')->get();
              // transformer en tableau 
              $lic = json_encode($donnees_is); // tranformer les données en json
              $lic = json_decode($donnees_is,true); //

              $data_name =[];

              foreach($lic as $valus){
                $chaine = $valus['id'].','.$valus['name'];
                $data_name[$chaine] = $valus['id'];
              }
        
              // recupérer les codes élève crée 
              // recupérer les données id_invoices deja dans la table
              $donnees_ids =  DB::table('ambassadricecustomers')->select('code_promo','date','nom','prenom','email')->get();
              // transformer en tableau 
              $lis = json_encode($donnees_ids); // tranformer les données en json
              $lis = json_decode($donnees_ids,true); //

              $data_code_promo_create =[];

              foreach($lis as $val){
                  $chaine = $val['code_promo'].','.$val['date'];
                  $data_code_promo_create[] = [
                    'code_promo' => $val['code_promo'],
                    'date'=>$val['date'],
                    'nom'=>$val['nom'].' '.$val['prenom'],
                    'email'=>$val['email']
                  ];
              }
 
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
                }

                // construire l'ensemble des données .
                $data_result =[];
                $data1= [];
                foreach($data_code_promo_create as $valu){
                    $code_true = array_search($valu['code_promo'],$data_code_promo_use);
                    if($code_true ==false){
                     $name_ambassadrice="";
                     $code_promo = $valu['code_promo'];
                     $date_created = $valu['date'];
                     $date_use ="";
                     $status="";
                     $x_name="";
                     
                    
                  }
                   if($code_true!=false){
                      $code_true_x = explode(',',$code_true);
                      $name_ambassadrices =  array_search($code_true_x[2],$data_name);
                      $names =  explode(',',$name_ambassadrices);
                      $x_name = $names[1];
                      $code_promo = $valu['code_promo'];
                      $date_created= $valu['date'];
                      $date_use = $code_true_x[1];
                      $status="le code est utilisé";
                     }
                     
                     $date = explode('-',$date_created);
                     $datex = $date[2].'/'.$date[1].'/'.$date[0];

                     // le array result
                     $data_result[]= [
                      'nom_ambassadrice'=> $x_name,
                      'code_promo'=> $code_promo,
                      'date_created'=>$datex,
                      'date_utilisation' => $date_use,
                      'status'=>$status,
                      'client'=>$valu['nom'],
                      'email'=>$valu['email']


                     ];
                }


                return $data_result;

                 // tirer un csv;
                 $this->downloads($data_result);
     }
     

   // 
    
     
    
  }
     
    




