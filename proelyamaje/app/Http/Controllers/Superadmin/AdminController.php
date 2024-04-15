<?php

namespace App\Http\Controllers\Superadmin;

use Mail;
use DateTime;
use Carbon\Carbon;

use Payplug\Payment;
use Illuminate\Http\Request;
use Automattic\WooCommerce\Client;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use App\Models\StatsVente;
use App\Http\Service\CallApi\Apicall;
use App\Http\Service\FilePdf\CreateCsv;
use App\Http\Service\CallApi\Importrecette;
use App\Http\Service\CallApi\PointCodepromo;
use App\Http\Service\CallApi\Notificationbilan;
use App\Http\Service\CallApi\GetgiftCards;
use App\Repository\Bilandate\BilandateRepository;
use App\Repository\Promotions\PromotionsumsRepository;
use App\Repository\Notification\NotificationRepository;
use App\Repository\Ambassadrice\LivestatistiqueRepository;
use App\Repository\Dashboardtiers\DashboardtiersRepository;
use App\Repository\Ambassadrice\AccountambassadriceRepository;
use App\Repository\Ambassadrice\AmbassadricecustomerRepository;
use App\Repository\Ambassadrice\HistoriquePanierLiveRepository;
use App\Repository\Ambassadrice\Ordercustomer\OrderambassadricecustomsRepository;
use Payplug\Payplug;

use League\Csv\Reader;

class AdminController extends Controller
{
      private $order;
      
      private $amba;
       
      public function __construct(
     Apicall $api,
     OrderambassadricecustomsRepository $order,
     BilandateRepository $bilan,
     AccountambassadriceRepository $amba,
     AmbassadricecustomerRepository $customs,
     PromotionsumsRepository $promosums,
     DashboardtiersRepository $dash,
     NotificationRepository $notifications,
     HistoriquePanierLiveRepository $historique,
     Importrecette $recette,
     LivestatistiqueRepository $live,
     CreateCsv $csv,
     GetgiftCards $gift,
     Notificationbilan $pointb,
     PointCodepromo $codeleve
     
     )
      {
         $this->api = $api;
         $this->order = $order;
         $this->bilan = $bilan;
         $this->amba = $amba;
         $this->customs = $customs;
         $this->promosums = $promosums;
         $this->dash = $dash;
         $this->notifications = $notifications;
         $this->recette = $recette;
         $this->live = $live;
         $this->api = $api;
         $this->csv =$csv;
         $this->historique = $historique;
         $this->gift = $gift;
         $this->pointb = $pointb;
         $this->codeleve = $codeleve;
         
      }

      public function getChartAmba(Request $request){


        if(Auth::user()->is_admin==1){

            $array_montant = [];
            $array_name =[];

            if($request->get('chart') == "chart_1"){
                $date_from = $request->get('date_from');
                $date_after = $request->get('date_after');
                $date_years = $request->get('date_years');

                if($date_from !="" && $date_after!="" && $date_years!=""){
                    $array_chart = $this->amba->getPeriode($date_from,$date_after,$date_years);
                } else {
                    $array_chart = $this->amba->getList();
                }

            } elseif($request->get('chart') == "chart_2"){

                $date_yearss = $request->get('date_yearss');
                $mois_cours = $request->get('mois_cours');
    
                if($date_yearss!="" && $mois_cours!=""){
                   $is_admin=2;
                    $array_chart = $this->amba->getMensuel($mois_cours, $date_yearss,$is_admin);
                    // recupérer le montant 
                    $montant_mois = $this->amba->getTotalmensuel();
                } else {
                    $array_chart = $this->amba->getList();
                    $montant_mois="";
                }
            }

            if(count($array_chart)!=0){
                 
                foreach($array_chart as $key => $values){
                     $array_name[] = $values['name'];
                     $array_montant[] = floatval($values['total_montant']);
                 }
             }
 
             echo json_encode(['array_montant' => $array_montant, 'array_name' => $array_name,'montant_mois'=>$montant_mois]);
           
        } else {
            echo json_encode(['success' => false, 'message' => 'Unauthorized !']);
        }
       
      }

      public function getChiffre(Request $request)
      {
           // retour ajax chiffre..
           $annee = $request->get('date_years');
            $recette =  $this->order->getchiffreannee($annee);
            $chiffre = $recette;
            echo json_encode(['chiffre' => $chiffre,'annee'=>$annee]);

      }

      public function getsomlive(Request $request)
      {
          // retour ajax .
           $id = $request->get('id');
           $commission =  $this->historique->getSommelive($id);
           $totalcommande = $this->historique->getNombre();
           
           $result ="Commission $commission € , Nombre vente $totalcommande";
         // recupérer le nombre de vente réalisé sur ce live et le montant génnéré par ce dernier...
          echo json_encode(['id' => $id,'comission'=>$commission,'result'=>$result]);

      }
      
      
      public function homeadmin(Request $request)
      {

          if(Auth::check()) {
             if(Auth::user()->is_admin==1){
             
              $donnees = $this->amba->getcounnum();
              
             $array_list = [];

             foreach($donnees as $vall){
                 if($vall['vente']==1) {
                     $vente=1;
                 }
                 elseif($vall['vente']==2){
                     $vente =1;
                 }
                 else{
                     $vente = $vall['vente'];
                     // à travailler.
                 }
                 
                 $array_list[]=[
                          'name'=>$vall['nom'],
                          'vente'=>$vente,
                     ];
             }
             
             
             $data_list_code = $this->order->getcountordersyears();
             $list_array =[];
             
             foreach($data_list_code as $valc){
                 // reconstruire les valuer pour affiner les tableau
                 $list_array[] = $valc['code_promo'].'-0';
             }
             // recupérer les code live et élève souhaite dans le tableau.....
             $array_code =[];
            foreach($list_array as $vas) {
                $d  = explode('-', $vas);
                // compter le nombre d'iteration des tableau.....
                if(count($d)>2){
                    $array_code[] = $vas;
                }
            }
            
             //nombre de commande généré avec code live et élève.
             $nombre_codes = count($array_code);
             // recupérer les variable
             $date_from = $request->get('date_from');
             $date_after = $request->get('date_after');
             $date_years = $request->get('date_years');
             // recupérer les variable pour la periode menseul
             $mois_cours = $request->get('mois_cours');
             $date_yearss = $request->get('date_yearss');
             $is_admin =2;
              // insert les données pour le charjs
              $this->amba->insert();
             
             if($date_from !="" && $date_after!="" && $date_years!="") {
                 $array_chart = $this->amba->getPeriode($date_from,$date_after,$date_years);
             }
               // verifier si les variable existe
             if($date_from =="" && $date_after=="" && $date_years=="") {
                  // recupérer le tableau pour formater les données du chartjs
                $array_chart = $this->amba->getList();
             }
             
             if($date_yearss!="" && $mois_cours!=""){
                  // recupérer le tableau pour formater les données du charts js.
                  $array_chart = $this->amba->getMensuel($mois_cours, $date_yearss,$is_admin);
             }
            
             // afficher les montant de commission en cours .
             $date_cours =date('Y-m-d');
             $date_chaine = explode('-',$date_cours);
             $mois_c= (int)$date_chaine[1];
             $annee_c = (int)$date_chaine[0];
              $montant_cours  = $this->amba->getMensuel($mois_c,$annee_c,$is_admin);
             $array_montant = [];// tableau pour les montants associé au chartjs
             $array_name =[];
             if(count($array_chart)!=0) {
             
               foreach($array_chart as $key => $values){
                 $array_name[] = $values['name'];
                 $array_montant[] = $values['total_montant'];
                }
             
            }
            
               // renvoi un tableau trie de valeurs par ordres decroissant.
               // recupère la date actuel en cours
               $date = date('Y-m-d');
               // recupérer le mot en cours
               $date1 = explode('-',$date);
        
               $code_mois  = $date1[1];
               $code_annee = $date1[0];
               $code = (int)$code_mois;
              
               // recuperer les somme
               $is_admin =2;
               $data_somme = $this->order->getSommeannee($is_admin);
               // cacluler la somme de toute les valuers du tableau
               $commission = $data_somme;
               // commission du mois en cours créer
               $data_somme1 = $this->order->getSommemois($is_admin);
               // recupérer le mois en cours
               $mois = $this->bilan->code_mois($code);
               $annee = $code_annee;
               $array1_somme =[];
              
              foreach($data_somme1 as $key => $values) {
                  // exclu le status refunded
                  if($values['status']!="refunded") {
                      $array1_somme[] = $values['somme'];
                  }
              }
              
              $somme1 = array_sum($array1_somme);
              
              $commission1 = $somme1;
              // recupérer le nombre de codes promo crée dans le mois en cours..
              $nombre_code = $this->customs->getcountcodeeleve();

              return view('superadmin.home',['commission'=>$commission, 'commission1'=>$commission1, 'mois'=>$mois, 'annee'=>$annee, 'array_list'=>$array_list,'nombre_code'=>$nombre_code,
            'nombre_codes'=>$nombre_codes,'montant_cours'=>$montant_cours])
            ->with('array_name',json_encode($array_name,JSON_NUMERIC_CHECK))
            ->with('array_montant',json_encode($array_montant,JSON_NUMERIC_CHECK));
          }
      
        }
      }
      
      
      public function homedatas()
      {
          
      }
      
       public function cloturelist()
       {
         if(Auth()->user()->is_admin==1){
           $session_email = Auth()->user()->email; // email de session en cours
           $array_marseille = array('melisa@elyamaje.com','wendy@elyamaje.com');// groupe marseille
           $array_nice = array('pamela@elyamaje.com'); // groupe nice
           $marseille ="marseille";
           $nice = "nice";
           
           $result = DB::table('cloturecaisses')->select('date','lieu','description','montant')->orderBy('id','Desc')->get();
           $list = json_encode($result);
           $lists =  json_decode($result,true);
        
         return view('superadmin.cloturelist',['lists'=>$lists]);
      
     }
     
 }


 public function dashamba(){

       $result_cado = $this->promosums->getdonsamba();
       // regrouper les arrays par le name.....
       $group =[];
       foreach($result_cado as $val){
       $group[$val['name']][] = [
        'label_product' => $val['label_product'],
        'total'=>$val['total']
        ];
      }
      // array unique......
       $result_top_dons =[];
       $result_top_dons1 =[];
       $result_top_dons2 =[];
       // recupéré les données
       foreach($group as $key => $vals){
          if(count($vals)>3){
           $result_top_dons[] =[
             'ambassadrice'=> $key,
             'product1'=> $vals[0]['label_product'],
             'total' => $vals[0]['total'],
             'product2'=> $vals[1]['label_product'],
             'total2'=> $vals[1]['total'],
             'product3'=> $vals[2]['label_product'],
             'total3'=> $vals[2]['total'],
             
             ];
           }

           if(count($vals)==2){
            $result_top_dons1[] =[
              'ambassadrice'=> $key,
              'product1'=> $vals[0]['label_product'],
              'total' => $vals[0]['total'],
              'product2'=> $vals[1]['label_product'],
              'total2'=> $vals[1]['total'],
              
              ];
           }

           if(count($vals)==1){
            $result_top_dons2[] =[
              'ambassadrice'=> $key,
              'product1'=> $vals[0]['label_product'],
              'total1' => $vals[0]['total'],
               ];
           }

        }
   
        

    $statistique = $this->dash->getallsdate(); // nombre new tiers (ville et internet)
    $last_statistique = $this->dash->selectOldDatadate();
    $nombre_marseille = 0;
    $nombre_nice= 0;
    $nombre_internet= 0;

    foreach($statistique as $kl => $valis){
    $nombre_marseille = $valis['nombre_marseille'];
    $nombre_nice = $valis['nombre_nice'];
    $nombre_internet = $valis['nombre_internet'];
   }

 if($last_statistique){
     $nombre_last_marseille = $last_statistique[0]['nombre_marseille'] ?? 0;
     $nombre_last_nice = $last_statistique[0]['nombre_nice'] ?? 0;
     $nombre_last_internet = $last_statistique[0]['nombre_internet'] ?? 0;
   } else {
     $nombre_last_marseille = 0;
     $nombre_last_nice =  0;
     $nombre_last_internet = 0;
   }

   $percent_marseille = $nombre_last_marseille > 0 ? round(abs(100 - (($nombre_marseille *100) / ($nombre_last_marseille))),2) : $nombre_marseille *100;
   $percent_nice = $nombre_last_nice > 0 ? round(abs(100 - (($nombre_nice *100) / ($nombre_last_nice))),2) : $nombre_nice *100;
   $percent_internet = $nombre_last_internet > 0 ? round(abs(100 - (($nombre_internet *100) / ($nombre_last_internet))),2) : $nombre_internet *100;
   $max_new_customer = max([$nombre_marseille, $nombre_nice, $nombre_internet]);

    
    
      // recupérer les données pour afficher le top 3 produits les plus achétés lors des lives et code élève
     $data_ventes = $this->promosums->getAll(['id_product','id_commande','label_product','sku', 'somme', 'quantite']);
     $data_vente =[];
     $data_commande = []; // recupérer le nombre de commande depuis le 16/09/2022.les id_commande
       
     foreach($data_ventes as $kl=>$vb) {
         if($vb['sku']!=""){
             $data_vente[] = $vb['label_product'].' ,'.$vb['id_product'].' ,'.$vb['somme'];
             $date_commande [] = $vb['id_commande'];
         }
     }

      // compter le nombre de commande réalisé depuis le 13septembre 2022
       $nbrs_com = array_unique($date_commande);
       $nombre_commande = count($nbrs_com);
       // le nombre de de produit achété
        $nombre_line_product = count($date_commande);// nombre de produit achétes
       // calucler le kpi souhaite pour l'activité ambassadrice & partenaire
        $kpi_product = number_format($nombre_line_product/$nombre_commande,'2',',','');

        

        if(count($data_vente)!=0) {
           // compte le nombre de fois l'index est répété
            $data_count_vente = array_count_values($data_vente);
            arsort($data_count_vente);// tire par odre decroissant via la valeur
             // recupérer les clés du tableau
            $data_top_vente = array_keys($data_count_vente);
            $top_produit1 = explode(',',$data_top_vente[0]);
            $top_produit2 =  explode(',', $data_top_vente[1]);
            $top_produit3 = explode(',',$data_top_vente[2]);
            $product1 = $top_produit1[0];
            $product1_somme = $top_produit1[array_key_last($top_produit1)] * $data_count_vente[$data_top_vente[0]];
            $product2 =$top_produit2[0];
            $product2_somme = $top_produit2[array_key_last($top_produit2)] * $data_count_vente[$data_top_vente[1]];
            $product3 = $top_produit3[0];
            $product3_somme = $top_produit3[array_key_last($top_produit3)] * $data_count_vente[$data_top_vente[2]];
            $max_product_somme = max([$product1_somme, $product2_somme, $product3_somme]);
            $css="ok";
        }
         else{
              $product1="";
              $product2="";
              $product3="";
               $css="no";
           }
          
           // le nombre de code promo crée.
           $this->customs->getcountcodeeleve();
           $nombre_eleve = $this->customs->getArrayall();

           // total de chiffre d'affaire généré
           $this->order->getDataIdcodeorders();
           $somme_general = $this->order->getTotalsum();

           // nombre de live réalisé 
           $nombre_live = $this->live->getCount();
           // traiter les données pour les notifications live en cours
          // recupérer les données pour afficher le top 3 produits les plus achétés lors des lives et code élève
          $data_live_notification = $this->notifications->getAll();
          $datas_live_notification =[];
          $x_data = [];
          // date dateime 
          $date_actuel = date('Y-m-d h:i:s');

              foreach($data_live_notification as $live) {

               $dat = date('Y-m-d');
               $datet = explode('-', $dat);
                $mois_cours = (int)$datet[1];
                $annee_cours = (int) $datet[0];
              if(strlen($live['id_ambassadrice'])>5) {
                   $chaine_date = explode(' ',$live['created_at']);
                   $chaine_date1 = explode('-',$chaine_date[0]);
                   // mois recupérer le mois
                   $mois_programme = (int)$chaine_date1[1];
                    // explode la chaine de caractère 
                   $chaine_name = explode(' ',$live['id_ambassadrice']);
                   $name_ambassadrice = $chaine_name[0]; // nom ambassadrice
                   $date_chaine = $chaine_name[6]; // date de chaine
                   $heure_chaine = $chaine_name[8];
                    // transformer la dante en anglais 
                   $x_date  =  explode('/',$date_chaine);
                    // recupérer une date en anglais Y-m-d.
                   $x_dates = $x_date[2].'-'.$x_date[1].'-'.$x_date[0];
                   $date_actuel_cours = date('Y-m-d');
                   $css="";

                 if($mois_cours == $x_date[1] && $annee_cours == $x_date[2]) {
                       // si la taille de la chaine de caractère est longue reucpére
                        $datas_live_notification[] = $live['id_ambassadrice'];
                        if($date_actuel_cours < $x_dates){
                           $libelle ="prévoit un live le";
                            $css="blue";
                        }
                       elseif($date_actuel_cours == $x_dates){
                           $libelle ="a un live ce soir le";
                           $css="actuel";
                        }
                      else{
                           $libelle=" a fait un live le";
                            $css ="vert";
                        }
                         // créer un tableau associative pour les données..
                           $x_data[] = [ $css =>  [
                              $name_ambassadrice => $libelle.' '.$date_chaine.' à  '.$heure_chaine

                                ],
                           ];
                    }

         }

      }



     $tab_live = array_unique($datas_live_notification);
     $lives = count($tab_live);
   
     return view('superadmin.ambassadricedashbord',['product1'=>$product1,'nombre_eleve'=>$nombre_eleve,'group'=>$group,
     'product1_somme' => $product1_somme,'kpi_product'=>$kpi_product ,'product2_somme' => $product2_somme,'product3_somme' => $product3_somme, 'percent_marseille' => $percent_marseille,
     'percent_nice' => $percent_nice, 'percent_internet' => $percent_internet, 'max_new_customer' => $max_new_customer, 'max_product_somme' => $max_product_somme,
     'product2'=>$product2, 'product3'=>$product3,'lives'=>$lives,'x_data'=>$x_data,'css'=>$css,'somme_general'=>$somme_general,'nombre_live'=>$nombre_live,'result_top_dons'=>$result_top_dons,'result_top_dons1'=>$result_top_dons1,'result_top_dons2'=>$result_top_dons2]);

    }


    public function codecreateleve(){

      $data = $this->codeleve->getstatistique();
      return view('gestion.codecreateleve',['data'=>$data]);

    }


    public function dashventes(Request $request)
    {
       $code_live = $request->get('ambassadrice');
       $mois =$request->get('mois');
       $annee = $request->get('annee');
       if($code_live!=""){
           // recupérer l'historique ..
          $this->historique->gethistoriques($code_live,$mois,$annee);

       }
        $result_data = $this->historique->gethistorique();
       $result_name = $this->historique->getData();
       return view('superadmin.ambassadricevente',['result_data'=>$result_data,'result_name'=>$result_name]);
    }
    

    public function cronchifre(Request $request,$user)
    {
       // actualiser les chiffre tous les 35minute.
        if($user=="67934854968e6ee06568847ead22132f608bf4ec1997265491df0efb") {
          $this->recette->importrecette();// Import de recette journalière...
       }
       
          /*DB::transaction(function () {
              $response =  $this->recette->importrecette();
              $data = ['name' => 'import_chiffre', 'origin' => 'connect', 'error' => is_bool($response) ? 0 : 1,
              'message' => is_bool($response) ? null : $response, 'code' => null, 'from_cron' => 1];
                $this->api->insertCronRequest($data,false);
            });

        */
    }



    public function importierswc(Request $request,$user)
    {
        if($user="67934854968e6ee06568847ead22132f608bf4ec1997265491df0efb"){
         $result = $this->gift->getcustomer();// recupérer les clients 100 premiers clients
         dd($result);
        }
     
     }

    public function cronchifres(Request $request)
    {
        if($request->from_cron){
            $request->from_cron == "false" ? $from_cron = false : $from_cron = true;
          } else {
            $from_cron = true;
          }
        
           DB::transaction(function () {
              $response =  $this->recette->importrecette();
              $data = ['name' => 'import_chiffre', 'origin' => 'connect', 'error' => is_bool($response) ? 0 : 1,
              'message' => is_bool($response) ? null : $response, 'code' => null, 'from_cron' => 1];
                $this->api->insertCronRequest($data,false);
            });
        }


        public function statsventes(Request $request,$user){
            if($user=="67934854968e6ee06568847ead22132f608bf4ec1997265491df0efb") {
               
                $this->recette->getdataventedol();
             }

        }


        public function statvente(Request $request)
        {
                
             // recupérer les produits dans l'api
             // recuperer les données api dolibar copie projet tranfer x.
             $method = "GET";
              $apiKey = "305ZB714CPxxYqHgk5w7Ah1i1aTtOHFe";
              $apiUrl = "https://www.poserp.elyamaje.com/api/index.php/";
                //environement test local
                //Recuperer les ref et id product dans un tableau
               $produitParam = ["limit" => 1200, "sortfield" => "rowid"];
               $listproduct = $this->api->CallAPI("GET", $apiKey, $apiUrl."products", $produitParam);
               $lists = json_decode($listproduct,true);
               $libelle_id =[];
          
               foreach($lists as $val){
                $chaine = $val['id'].','.$val['label'];
                $libelle_id[$chaine] = $val['id'];
               }

             // aller cherche la liasons des product et avec une categoris dans la table categoris_product...
               $id_cat = $request->get('id_cate');
               if($id_cat!="32x"){
               // recupérer les données id_invoices deja dans la table
                $donnees_product =  DB::table('categorie_products')->select('fk_product')->where('fk_categorie','=',$id_cat)->get();
                $lists = json_encode($donnees_product);
                $lists = json_decode($donnees_product,true);

               }
               
              $array_product =[];// les products dont la categoris est choisis.
               foreach($lists as $val){
                 $array_product[] = $val;
               }

               // aller cherche des correspondance entre le nom produits et son id.
               $id_cat = $request->get('id_cate');
               $mois1 = (int)$request->get('search_dates');// mois start
               $mois2 = (int)$request->get('search_date'); // mois end 

               // recupérer le mois et l'annee
               // date start
               /*$date_x_s = explode(' ',$date_start);
               $date_x_s1 = explode('-',$date_x_s[0]);
               $mois1 = (int)$date_x_s1[1];
                $annee1 = $date_x_s1[0];

              // date fend
              $date_x_ss1 = explode(' ',$date_end);
              $date_x_s2 = explode('-',$date_x_ss1[0]);
              $mois2 =  (int)$date_x_s2[1];
              $annee2 = $date_x_s2[0];
              */
              // créer un array d'intervalle de recherche pour le mois .
               $array_mois =[];// recupérer les mois desiré...
               $array_mois1 =[];
               $array_annees =[];
               $array_annees1 =[];
                $anee = $request->get('date_year');//année debut
               $anneee = $request->get('date_years'); //année fin.
               if($anee=="" OR $anneee=="" OR  $mois1=="" OR $mois2==""){
                 $array_annees =[];
                 $array_mois =[];
               }
              
               if($anee == $anneee){
                  for($i=$mois1; $i<$mois2+1; $i++){
                  $array_mois[] = $i;
                }
                 $array_annees[] = $anee;
                 $array_mois1 = [];
                 $array_annees1 = [];
            }

             if($anee!=$anneee){
              
                 // lorsque l'année est differente.
                 $max =12;
                 // construire des bornes de recupération
                 if($mois1 !=12 && $mois2!=1){
                    $borne_inf = 12 - $mois1;
                    $borne_sup =  $mois2 -1;
                    
                    for($i=$mois1; $i<13; $i++){
                        $array_mois[] = $i;
                      }

                      for($i=1; $i<$mois2+1; $i++){
                        $array_mois1[] = $i;
                      }
                    
                    }

                    if($mois1==1 && $mois2==1){
                       for($i=1; $i<13; $i++){
                        $array_mois[] = $i;
                        }
                         
                    }

                   $array_annees[] = $anee;
                   $array_annees1[]= $anneee;

            }
             
                //dump($array_mois);
               // dump($array_annees);
               // pour l'annee
               // Anné fin...
               // recupérer la provenance souhaite 
               $choix = $request->get('poste');// pour internet, boutique,nice..

               

               if($choix!=1 OR $choix!=2 OR $choix!=3 OR $choix!="none"){
                if($id_cat!="32x"){
                 // traiter la sortie du aller chercher les bonne donnés souhaités....
                 $sum_vente = DB::table('stats_ventes')
                ->select('id_product','mois','annee' ,DB::raw('SUM(quantite) as total'))
                ->whereIn('id_product',$array_product)
                ->whereIn('mois',$array_mois)
                ->whereIn('annee',$array_annees)
                ->groupBy('id_product','mois','annee')
                 ->get();

                 // SORTIR 
                 $sum_vente1 = DB::table('stats_ventes')
                 ->select('id_product','mois','annee' ,DB::raw('SUM(quantite) as total'))
                 ->whereIn('id_product',$array_product)
                 ->whereIn('mois',$array_mois1)
                 ->whereIn('annee',$array_annees1)
                 ->groupBy('id_product','mois','annee')
                  ->get();
                }
               }

               if($choix==1 OR $choix==2 OR $choix==3){
                   if($id_cat!="32x"){
                    if($choix==1){
                      $array_ref= array('TC2','TC3','TC6','TC5','FA');// internet
                     }
                      if($choix==2){
                       $array_ref[] ="TC1";// boutique marseille
                    }
                     if($choix==3){
                       $array_ref[] ="TC4";// boutique nice.
                   }

                  $sum_vente = DB::table('stats_ventes')
                 ->select('id_product','mois','annee','ref_facture' ,DB::raw('SUM(quantite) as total'))
                 ->whereIn('id_product',$array_product)
                 ->whereIn('ref_facture',$array_ref)
                 ->whereIn('mois',$array_mois)
                 ->whereIn('annee',$array_annees)
                 ->groupBy('id_product','mois','annee','ref_facture')
                  ->get();
 
                   // SORTIR 
                   $sum_vente1 = DB::table('stats_ventes')
                  ->select('id_product','mois','annee','ref_facture' ,DB::raw('SUM(quantite) as total'))
                  ->whereIn('id_product',$array_product)
                  ->whereIn('mois',$array_mois1)
                  ->whereIn('annee',$array_annees1)
                  ->groupBy('id_product','mois','annee','ref_facture')
                   ->get();
                }
            }

            if($choix==1 OR $choix==2 OR $choix==3){
                // traiter le csv pour les toutes les categoris en fonction du choix .
               if($id_cat=="32x"){
                   if($choix==1){
                    $array_ref= array('TC2','TC3','TC6','TC5','FA');// internet
                    }
                    if($choix==2){
                      $array_ref[] ="TC1";// boutique marseille
                   }
                    if($choix==3){
                     $array_ref[] ="TC4";// boutique nice.
                 }


               }


               $sum_vente_all = StatsVente::select('id_product','mois','annee','ref_facture','id_cat','label_cat', DB::raw('COUNT(quantite) as counts'))
               ->whereIn('mois',$array_mois)
               ->whereIn('annee',$array_annees)
               ->whereIn('ref_facture',$array_ref)
               ->groupBy('mois','annee','id_cat','id_product','label_cat','ref_facture')
               ->get();

                 $sum_vente_all1 = StatsVente::select('id_product','mois','annee','id_cat','ref_facture','label_cat', DB::raw('COUNT(quantite) as counts'))
                ->whereIn('mois',$array_mois1)
                ->whereIn('annee',$array_annees1)
                ->whereIn('ref_facture',$array_ref)
                ->groupBy('mois','annee','id_cat','id_product','label_cat','ref_facture')
                ->get();

                // pour toutes les categoris
                    $list2 = json_encode($sum_vente_all);
                    $list2 = json_decode($sum_vente_all,true);

                    // lister les 
                    $list3 = json_encode($sum_vente_all1);
                    $list3 = json_decode($sum_vente_all1,true);
                   
                    $list_def1 = array_merge($list2,$list3);
                  
                    foreach($list_def1 as $vals){

                      // recupérer le libelle
                      $libelle_f="";
                      if($vals['id_product']!=""){
                       $libelle_x =  array_search($vals['id_product'],$libelle_id);
                      if($libelle_x!=false){
                          $libelle_final = explode(',',$libelle_x);
                          $libelle_f = $libelle_final[1];
                      }

                      }
    
                      $array_csv[] =[
                        'id_produit' => $vals['id_product'],
                        'nom_produit'=> $libelle_f,
                        'mois_de_vente' => $this->getNummois($vals['mois']),
                        'annee' => $vals['annee'],
                        'total_vente' => $vals['counts'],
                        'categorie_name'=>$vals['label_cat']
                         ];
    
                    }

                   // tirer un csv speciifique 
                   $this->csv->statsventess($array_csv);


            }


            // pour le troisiemme cas je veux toute la categories..
              if($choix!=1 OR $choix!=2 OR $choix!=3 OR $choix!="none"){
                if($id_cat=="32x"){
                  $sum_vente_all = StatsVente::select('id_product','mois','annee','id_cat','label_cat', DB::raw('COUNT(quantite) as counts'))
                 ->whereIn('mois',$array_mois)
                 ->whereIn('annee',$array_annees)
                 ->groupBy('mois','annee','id_cat','id_product','label_cat')
                 ->get();

                   $sum_vente_all1 = StatsVente::select('id_product','mois','annee','id_cat','label_cat', DB::raw('COUNT(quantite) as counts'))
                  ->whereIn('mois',$array_mois1)
                  ->whereIn('annee',$array_annees1)
                  ->groupBy('mois','annee','id_cat','id_product','label_cat')
                  ->get();

                

                   // pour toutes les categoris
                    $list2 = json_encode($sum_vente_all);
                    $list2 = json_decode($sum_vente_all,true);

                    // lister les 
                    $list3 = json_encode($sum_vente_all1);
                    $list3 = json_decode($sum_vente_all1,true);
                   
                    $list_def1 = array_merge($list2,$list3);
                  
                    foreach($list_def1 as $vals){

                      // recupérer le libelle
                      $libelle_f="";
                      if($vals['id_product']!=""){
                       $libelle_x =  array_search($vals['id_product'],$libelle_id);
                      if($libelle_x!=false){
                          $libelle_final = explode(',',$libelle_x);
                          $libelle_f = $libelle_final[1];
                      }

                      }
    
                      $array_csv[] =[
                        'id_produit' => $vals['id_product'],
                        'nom_produit'=> $libelle_f,
                        'mois_de_vente' => $this->getNummois($vals['mois']),
                        'annee' => $vals['annee'],
                        'total_vente' => $vals['counts'],
                        'categorie_name'=>$vals['label_cat']
                         ];
    
                    }

                   // tirer un csv speciifique 
                   $this->csv->statsventess($array_csv);

                }
               }
          
            
                // table
                
                $list = json_encode($sum_vente);
                $list = json_decode($sum_vente,true);
                 
                // pour differentes boutique 
                $list1 = json_encode($sum_vente1);
                $list1 = json_decode($sum_vente1,true);

               

                $list_def = array_merge($list,$list1);
                 
                $array_csv =[];// construire mon tableau

                foreach($list_def as $vals){

                  // recupérer le libelle
                  $libelle_x =  array_search($vals['id_product'],$libelle_id);
                  if($libelle_x!=false){
                      $libelle_final = explode(',',$libelle_x);
                      $libelle_f = $libelle_final[1];
                  }

                  $array_csv[] =[
                    'id_produit' => $vals['id_product'],
                    'nom_produit'=> $libelle_f,
                    'mois_de_vente' => $this->getNummois($vals['mois']),
                    'annee' => $vals['annee'],
                    'total_vente' => $vals['total']
                     ];

                }
                
            $this->csv->statsventes($array_csv);
          // tire un excel 
        /*  echo'
	        <table class="tb" border="1">
           <tr>
	         <th>Id-product</th>
           <th>Nom du produit</th>
	         <th>Mois de vente</th>
	         <th>Annee</th>
	          <th>total_ventes</th>
           </tr>';
        $outpout="";
       foreach($list_def as $kl=> $vals) {
           $outpout.='
	        	<tr>
	         <td>'.$vals['id_product'].'</td>
		       <td>'.$vals['libelle'].'</td>
		       <td>'.$this->getNummois($vals['mois']).'</td>
		       <td>'.$vals['annee'].'</td>
		      <td>'.$vals['total'].'</td>
		       </tr>';
           
         }
       
           $outpout.='</table>';
         
           header("Content-Type: application/xls; charset=utf-8");
	         header("Content-Disposition: attachement; filename=ventes_periodique.xls");
         
         return $outpout;

        */
           // tirer le csv souhaités. d
          

        }


        public function reporting()
        {
           // faire les statistique  de répresentation des clients par département et region.
            $data = $this->dash->getcustomerall();
            // recupérer les regions
            $regions = $this->dash->getDatas();
            return view('gestion.usercustomer',['data'=>$data,'regions'=>$regions]);

        }


        public function  cloturepoint()
        {
            // recupérer des données.
             $this->pointb->getBilan();
        }


        public function getNummois($moi)
        {
       
          if($moi==1) {
             $mo ="Janvier";
            }
         
          if($moi==2){
             $mo="Février";
         }
         
         if($moi==3) {
             $mo = "Mars";
         }
         
         if($moi==4) {
             $mo="Avril";
         }
         
         if($moi==5) {
             $mo ="Mai";
         }
         
         if($moi==6){
             $mo="Juin";
         }
         
         if($moi==7){
             $mo="Juillet";
         }
         
         if($moi==8) {
             $mo="Août";
         }
         
         
         if($moi==9){
             $mo="Septembre";
         }
         
         if($moi==10){
             $mo="Octobre";
         }
         
         if($moi==11){
             $mo="Novembre";
         }
         
         if($moi==12){
             $mo="Décembre";
         }
         
         
         return $mo;
     }


     function checkingCommandes(){
      try {

/*

      
      $data_export_payp = array();
      $filename = dirname(dirname(dirname(dirname(dirname(__DIR__))))).'/payments/History_Export_Payplug.csv';
      $csv = Reader::createFromPath($filename, 'r');
      $csv->setDelimiter(',');


      foreach ($csv as $key => $row) {

        if ($key == 0) {
          $tabCle = [
            "ID" =>array_search("ID", $row),
            "Date" =>array_search("Date", $row),
            "Heure" =>array_search("Heure", $row),
            "Statut" =>array_search("Statut", $row),
            "Destinataire" =>array_search("Destinataire", $row),
            "Montant" =>array_search("Montant", $row),
            "Prénom" =>array_search("Prénom", $row),
            "Nom" =>array_search("Nom", $row),
            "Commentaire" =>array_search("Commentaire", $row),
            "Nombre de tentatives" =>array_search("Nombre de tentatives", $row),
            "Raison d'échec" =>array_search("Raison d'échec", $row),
            "metadata_customer_id" =>array_search("metadata_customer_id", $row),
            "metadata_order_id" =>array_search("metadata_order_id", $row),
          ];

        }

        if ($key != 0) {
          if ($row[$tabCle["metadata_order_id"]]) {

            if (!isset($data_export_payp[$row[$tabCle["metadata_order_id"]]])) {
              $data_export_payp[$row[$tabCle["metadata_order_id"]]] = [];
              array_push($data_export_payp[$row[$tabCle["metadata_order_id"]]],[
                "ID" =>$row[$tabCle["ID"]],
                "Date" =>$row[$tabCle["Date"]],
                "Heure" =>$row[$tabCle["Heure"]],
                "Statut" =>$row[$tabCle["Statut"]],
                "Destinataire" =>$row[$tabCle["Destinataire"]],
                "Montant" =>$row[$tabCle["Montant"]],
                "Prénom" =>$row[$tabCle["Prénom"]],
                "Nom" =>$row[$tabCle["Nom"]],
                "Commentaire" =>$row[$tabCle["Commentaire"]],
                "Nombre de tentatives" =>$row[$tabCle["Nombre de tentatives"]],
                "Raison d'échec" =>$row[$tabCle["Raison d'échec"]],
                "metadata_customer_id" =>$row[$tabCle["metadata_customer_id"]],
                "metadata_order_id" =>$row[$tabCle["metadata_order_id"]],
              ]);
            }else{
              array_push($data_export_payp[$row[$tabCle["metadata_order_id"]]],[
                "ID" =>$row[$tabCle["ID"]],
                "Date" =>$row[$tabCle["Date"]],
                "Heure" =>$row[$tabCle["Heure"]],
                "Statut" =>$row[$tabCle["Statut"]],
                "Destinataire" =>$row[$tabCle["Destinataire"]],
                "Montant" =>$row[$tabCle["Montant"]],
                "Prénom" =>$row[$tabCle["Prénom"]],
                "Nom" =>$row[$tabCle["Nom"]],
                "Commentaire" =>$row[$tabCle["Commentaire"]],
                "Nombre de tentatives" =>$row[$tabCle["Nombre de tentatives"]],
                "Raison d'échec" =>$row[$tabCle["Raison d'échec"]],
                "metadata_customer_id" =>$row[$tabCle["metadata_customer_id"]],
                "metadata_order_id" =>$row[$tabCle["metadata_order_id"]],
              ]);
            }
          }
        }
      }

*/


      $url = "https://www.elyamaje.com/wp-json/wc/v3/orders";
      $url2 = "https://www.elyamaje.com/wp-json/wc/v3/orders";
      $apikey = 'ck_06dc2c28faab06e6532ecee8a548d3d198410969';
      $apikeys ='cs_a11995d7bd9cf2e95c70653f190f9feedb52e694';

      $status1 = "failed";
      $status2 = "cancelled";
      $per_page = 100;
      $page = 1;

      $date_j_3 = date('Y-m-d\TH:i:sP', strtotime('-0 days'));
      $date_j_1 = date('Y-m-d\TH:i:sP', strtotime('-0 days'));

      $data_final = array();



      $response = Http::withBasicAuth($apikey, $apikeys)
      ->get($url2, [
          'status' => $status1.','.$status2,
          'per_page' => $per_page,
          'page' => $page,
      ]);

      $data = $response->json();

      dd($data);

      do {
        $response = Http::withBasicAuth($apikey, $apikeys)
        ->get($url2, [
            'status' => $status1.','.$status2,
            'per_page' => $per_page,
            'page' => $page,
            'after' => $date_j_3, // Commandes après j-3
        //  'before' => $date_j_1, // Commandes avant j-1
        ]);

        $data = $response->json();
        // array_push($data_final,$data);
        $data_final = array_merge($data_final, $data);
        $page++;
        $taille = count($data);

      } while ($taille == 100);


      

      foreach ($data_final as $key => $value) {
        if($value["id"] == "92801"){
          dd($value);
        }
      }

    //  dd($data_final);

     foreach ($data_final as $key => $value) {
      dump($value["id"]);
     }


     dd('fin');
      $pay_trouve = array();
      $pay_non_trouve = array();

     
      foreach ($data_final as $key => $value) {
        $order_id = $value["id"];

        if (isset($data_export_payp[$order_id])) {
          array_push($pay_trouve,$data_export_payp[$order_id]);
        }else {
          array_push($pay_non_trouve,$value);
        }

        
      }

      foreach ($pay_trouve as $key => $pay_tr) {

        foreach ($pay_tr as $k => $va) {
          if ($va["Statut"] == "Terminé") {
            dd($key);
          }
        }
       
      }


      dump($pay_trouve);
      dd($pay_non_trouve);

      // 93273    * 4





      dd("xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx");


      
        $auj = new DateTime();
        $j_3 = clone $auj;
        $j_3->modify('-3 days');

        $j_1 = clone $auj;
        $j_1->modify('-1 days');

        $startTimeStamp = $j_3->getTimestamp();
        $endTimeStamp = $j_1->getTimestamp();
        require_once(dirname(dirname(dirname(dirname(__DIR__)))) . '/vendor/payplug/payplug-php/lib/init.php');
        \Payplug\Payplug::setSecretKey('sk_live_6mHRVt8DVX4nFoRyRIJ7pb');

        $perPage = 100;
        $page = 1;
        $condition = true;
        $data_final_payment = array();


        do {
         $payments = \Payplug\Payment::listPayments($perPage,$page);

          foreach ($payments as $key => $payment) {
            if ($payment->created_at < $startTimeStamp) {
              $condition = false;
            }else {
              if ($payment->metadata) {
                if (!isset($data_final_payment[$payment->metadata["order_id"]])) {
                  $data_final_payment[$payment->metadata["order_id"]] = $payment;
                }else{
                  array_push($data_final_payment[$payment->metadata["order_id"]], $payment);
                }
                
              }
              
            }
          }
          
          $page++;

        } while ($condition);

    

      dd($data_final_payment);

      //****************************************************************************** */

        $url = "https://www.elyamaje.com/wp-json/wc/v3/orders";
        $url2 = "https://www.elyamaje.com/wp-json/wc/v3/orders";
        $apikey = 'ck_06dc2c28faab06e6532ecee8a548d3d198410969';
        $apikeys ='cs_a11995d7bd9cf2e95c70653f190f9feedb52e694';

        $status1 = "failed";
        $status2 = "cancelled";
        $per_page = 100;
        $page = 1;

        $date_j_3 = date('Y-m-d\TH:i:sP', strtotime('-3 days'));
        $date_j_1 = date('Y-m-d\TH:i:sP', strtotime('-1 days'));

        $data_final = array();

        do {
          $response = Http::withBasicAuth($apikey, $apikeys)
          ->get($url2, [
              'status' => $status1.','.$status2,
              'per_page' => $per_page,
              'page' => $page,
            'after' => $date_j_3, // Commandes après j-3
            'before' => $date_j_1, // Commandes avant j-1
          ]);

          $data = $response->json();
          // array_push($data_final,$data);
          $data_final = array_merge($data_final, $data);
          $page++;
          $taille = count($data);

        } while ($taille == 100);

        


        dd($data_final);

       $payement_filed_or_cancelled = array();
       $no_data = array();
       $a_traiter = array();

       foreach ($data_final as $key => $value) {

        if (isset($data_final_payment[$value["id"]])) {
          array_push($a_traiter, $value);
        }else {
          array_push($no_data,$value);
        }

        dump($a_traiter);
        dd($no_data);


       }

       dd("fin");
      


        return view('api.checkPayments', ['message'=>$message]);

      } catch (\Throwable $th) {
        dd($th);
      }
     }

      
      
}