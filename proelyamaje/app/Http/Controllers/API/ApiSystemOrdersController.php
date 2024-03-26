<?php

namespace App\Http\Controllers\API;

use DateTime;
use DateTimeZone;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Service\CallApi\Apicall;
use App\Http\Service\CallApi\GetgiftCards;
use App\Http\Service\CallApi\TransferOrder;
use App\Repository\Coupon\CouponRepository;
use App\Http\Service\CallApi\GetDataCoupons;
use App\Http\Service\CallApi\Distributedorders;
use App\Repository\Customer\CustomerRepository;
use App\Repository\Category\CategorieRepository;
use App\Repository\Cardsgift\CardsgiftRepository;
use App\Repository\Orders\BoutiqueorderRepository;
use App\Repository\Distributeur\DistributeurRepository;
use App\Http\Service\CallApi\TransferOrderdistributeurs;
use App\Repository\Ambassadrice\Ordercustomer\OrderrefundedRepository;
use App\Repository\Ambassadrice\Ordercustomer\OrderambassadricecustomsRepository;

class ApiSystemOrdersController extends Controller
{

       private $api;
       private $repo;
       private $coupons;
       private $refunded;
       private $category;

      public function __construct(Apicall $api, CustomerRepository $repo, 
      OrderambassadricecustomsRepository $orders,
      CouponRepository $coupons,
      GetDataCoupons $codemaster,
      GetgiftCards $gift,
      CategorieRepository $category,
      CardsgiftRepository $cards,
      OrderrefundedRepository $refunded,
      DistributeurRepository $distributed,
      TransferOrder $apiorders,
      TransferOrderdistributeurs $ordersd,
      Distributedorders $orderb,
      BoutiqueorderRepository $orderboutique)
      {
         $this->api = $api;
         $this->repo = $repo;
         $this->orders = $orders;
         $this->coupons = $coupons;
         $this->codemaster = $codemaster;
         $this->gift = $gift;
         $this->category = $category;
         $this->cards = $cards;
         $this->apiorders = $apiorders;
         $this->refunded = $refunded;
         $this->distributed = $distributed;
         $this->ordersd = $ordersd;
         $this->orderb = $orderb;
         $this->orderboutique = $orderboutique;
      }
      
      
      
      // cron
      public function woocommerce(){

        $data = $this->api->getCronRequest("origin", "connect");

        $cron = [];

        if(isset($data['Crons'])){
          foreach($data['Crons'] as $key => $value) {
            if(str_contains($value['name'], 'woocommerce')){
              $date = new DateTime($value['updated_at']);
              $date->setTimezone(new DateTimeZone('Europe/Paris'));
              $value['updated_at'] = Carbon::parse($date)->isoFormat(' D MMMM Y à HH:mm');
              $cron [$value['name']] = $value;
            }
          }
        }

        return view('api.woocommerce', ['cron'=> $cron]);

      }

      public function dolibarr(){

        // Get all category products
        $message ="";
        $messages="";
        $data_category = $this->category->getAll();
         $count = count($data_category);

        $array_all[$count] =[
           'rowid'=>'32x',
           'label'=>'Toutes les categories'

        ];

        $data_category = $this->category->getAll();

        $data_category = array_merge($data_category,$array_all);
        
        
        $list_product = $this->category->getProduct();
        $data = $this->api->getCronRequest("origin", "connect");
        $cron = [];
        if(isset($data['Crons'])){
          foreach($data['Crons'] as $key => $value) {
            if(str_contains($value['name'], 'dolibarr')){
              $value['updated_at'] = Carbon::parse($value['updated_at'])->isoFormat(' D MMMM Y à HH:mm');
              $cron [$value['name']] = $value;
            }
          }
        }

        return view('api.dolibarr', ['cron'=> $cron, 'data' => $data_category, 'list_product'=>$list_product, 'message'=>$message,'messages'=>$messages]);
      }



      public function dolibarrs(){

        // Get all category products
        $message ="";
        $messages="";
        $data_category = $this->category->getAll();

        $count = count($data_category);

        $array_all[$count] =[
           'rowid'=>'32x',
           'label'=>'Toutes les categories'

        ];

        $data_category = $this->category->getAll();

        $data_category = array_merge($data_category,$array_all);

        $list_product = $this->category->getProduct();
        $data = $this->api->getCronRequest("origin", "connect");
        $cron = [];
        if(isset($data['Crons'])){
          foreach($data['Crons'] as $key => $value) {
            if(str_contains($value['name'], 'dolibarr')){
              $value['updated_at'] = Carbon::parse($value['updated_at'])->isoFormat(' D MMMM Y à HH:mm');
              $cron [$value['name']] = $value;
            }
          }
        }

        return view('api.dolibarrs', ['cron'=> $cron, 'data' => $data_category, 'list_product'=>$list_product, 'message'=>$message,'messages'=>$messages]);
      }


      public function synchroapi(Request $request)
      {
        
            $ids = $request->get('ids');// retour data id_product..
            
             $result_data  = $this->gift->getsynchrocatepro($ids);
             // recupérer des  données categrois_product dans la bdd existant fk_categories/fk_product.
            $ids_data =[];

            // recupérer toute les categoris liée à ce id_product.
            $result_bd =  DB::table('categorie_products')->select('fk_categorie','fk_product')->where('fk_product','=',$ids)->get();
            $list = json_encode($result_bd);
            $list_fk_cat = json_decode($list,true);

            dump($list_fk_cat);
            //
            if(count($list_fk_cat)!=0) {
                   $list_data = [];// recupérer id_product et les id_categories associé.
                   foreach($list_fk_cat as $key => $val) {
                     $list_data[] = $val['fk_categorie'];
               
                   }
             
                   $list_data[] = $ids;// fist datas
                  // recupérer les données de l'api.
                  // recupérer result_data
                  $list_datas =[];// recupérer les data venant de l'api.
                  foreach($result_data as $valc) {
                    foreach($valc as $kl => $vl){
                       if($kl=="error")
                       {
                          $list_datas= [];
                       }
                        else{
                         $list_datas[]=$vl['id'];
                      }
                    }
                }
                
                   $list_datas[] = $ids; // second datas...

                   dump($list_datas);
                   dump($list_data);
                   // recupération des datas.
                   if(count($list_datas)==0)
                   {
                     $result_true =[];
                   }
                  else{
                      $result_true = array_diff($list_data,$list_datas);
                     }
                      // renvoi $result_true;
                      dd($result_true);
             }

           else
             {
                    // mettre à jour directement la table insert data.
                    // constrcut array data
                    $insert_data = [];
                    // insert directement dans la bdd de synchro...
                  if(count($result_data)!=0){
                        foreach($result_data as $valc){
                             foreach($valc as $kl => $vl) {
                                if($kl =="error"){
                                   $list_datas = [];
                                   $insert_data =[];
                                 }
                                  else{
                                   $list_datas[]=$vl['id'];
                                    $insert_data[] =[
                                    "fk_categorie"=>$vl['id'],
                                     "fk_product"=>$ids
                                   ];
                                 }
                              }
                           }

                         // si $list_datas est vide on fais rien 
                         DB::table('categorie_products')->insert($insert_data);

                         dd('données bien recupérer');
                      
                     }
                  else{
                      dd('aucune donnée recupére !');
                  }
               }
         }
      
      
       public function categoriespost(Request $request)
      {
         
          // mise a jours des categoris woocomerce
          if($request->from_cron){
            $request->from_cron == "false" ? $from_cron = false : $from_cron = true;
          } else {
            $from_cron = true;
          }

            DB::transaction(function () use ($from_cron) {
              $response = $this->gift->getcategoriesjours();
              $data = ['name' => 'update_categories_woocommerce', 'origin' => 'connect', 'error' => is_bool($response) ? 0 : 1,
              'message' => is_bool($response) ? null : $response, 'code' => null, 'from_cron' => $from_cron == false ? 0 : 1];
              echo $this->api->insertCronRequest($data);
           });

          
        // return redirect()->route('api.giftcards')->with('success', 'Les categories sont mise à jours !');
      }
      
      
       public function list_product(Request $request)
       {
           //$this->gift->getProductbarcode();
          
           if(Auth()->user()->is_admin ==1) {

          if($request->from_cron){
            $request->from_cron == "false" ? $from_cron = false : $from_cron = true;
          } else {
            $from_cron = true;
          }
          
            DB::transaction(function () use ($from_cron) {
              $response = $this->gift->product_all();
              $data = ['name' => 'update_product_woocommerce', 'origin' => 'connect', 'error' => is_bool($response) ? 0 : 1,
              'message' => is_bool($response) ? null : $response, 'code' => null, 'from_cron' => $from_cron == false ? 0 : 1];
              echo $this->api->insertCronRequest($data);
           });
         }
      }
      
      
      
      public function datas()
      {
         
         //$this->orders->insert();
         return view('api.dataorders');
         
      }
      
      public function coupons()
      {
           //recupérer les code promo de la master class 30 pourcent;
          if(Auth()->user()->is_admin ==1){
           $data = $this->codemaster->getCouponsmaster();
          
           return view('api.datacoupons');
          }
      }
      
      
       public function giftcards()
      {
         if(Auth()->user()->is_admin ==1){
          return view('api.giftcards');
          
         }
      }
      
      
      public function reviewproduct(Request $request)
      {
          
          if(Auth()->user()->is_admin==1)
          {
            if($request->from_cron){
              $request->from_cron == "false" ? $from_cron = false : $from_cron = true;
            } else {
              $from_cron = true;
            }

              DB::transaction(function () use ($from_cron) {
                $response =  $this->gift->getdataproduct();
                $data = ['name' => 'import_promo_proucts_woocommerce', 'origin' => 'connect', 'error' => is_bool($response) ? 0 : 1,
                'message' => is_bool($response) ? null : $response, 'code' => null, 'from_cron' => $from_cron == false ? 0 : 1];
                echo $this->api->insertCronRequest($data);
            });
          }
          
      }
      
      
       public function addgiftcards(Request $request)
      {
          // mise ajour cartes cadeaux créer 
          if(Auth()->user()->is_admin==1)
          {
            if($request->from_cron){
              $request->from_cron == "false" ? $from_cron = false : $from_cron = true;
            } else {
              $from_cron = true;
            }

              DB::transaction(function () use ($from_cron) {
                $response =  $this->cards->insert();
                $data = ['name' => 'import_cards_woocommerce', 'origin' => 'connect', 'error' => is_bool($response) ? 0 : 1,
                'message' => is_bool($response) ? null : $response, 'code' => null, 'from_cron' => $from_cron == false ? 0 : 1];
                echo $this->api->insertCronRequest($data);
            });
          }
      }
      
      
      public function datacodepromo(Request $request)
      {
        //mise à jours des coupons dans erp
        if(Auth()->user()->is_admin==1)
        {
            if($request->from_cron){
              $request->from_cron == "false" ? $from_cron = false : $from_cron = true;
            } else {
              $from_cron = true;
            }

              DB::transaction(function () use ($from_cron) {
                $response =  $this->coupons->insert();
                $data = ['name' => 'import_code_promo_woocommerce', 'origin' => 'connect', 'error' => is_bool($response) ? 0 : 1,
                'message' => is_bool($response) ? null : $response, 'code' => null, 'from_cron' => $from_cron == false ? 0 : 1];
                echo $this->api->insertCronRequest($data);
            });
        }
      }
      
      
      // oders code promo transférer
      public function dataapicodepromo(Request $request)
      {
          if(Auth()->user()->is_admin==1)
          {

            if($request->from_cron){
              $request->from_cron == "false" ? $from_cron = false : $from_cron = true;
            } else {
              $from_cron = true;
            }
  
              DB::transaction(function () use ($from_cron) {
                $response = $this->orders->insert();
                $data = ['name' => 'import_order_ambassadrice_woocommerce', 'origin' => 'connect', 'error' => is_bool($response) ? 0 : 1,
                'message' => is_bool($response) ? null : $response, 'code' => null, 'from_cron' => $from_cron == false ? 0 : 1];
                echo $this->api->insertCronRequest($data);
             });

          }
      }
      
      
      
      // distributeur orders
      public function distributed()
      {
         if(Auth()->user()->is_admin==1)
         {
           return view('api.distributeur');
         }
      }
      
     
      
      // post distributeur commande
      
      public function postdistributeur(Request $request)
      {
          
          if(Auth()->user()->is_admin ==1)
          {
            if($request->from_cron){
              $request->from_cron == "false" ? $from_cron = false : $from_cron = true;
            } else {
              $from_cron = true;
            }
  
              DB::transaction(function () use ($from_cron) {
                $response = $this->distributed->insert();
                $data = ['name' => 'import_order_distributeur_woocommerce', 'origin' => 'connect', 'error' => is_bool($response) ? 0 : 1,
                'message' => is_bool($response) ? null : $response, 'code' => null, 'from_cron' => $from_cron == false ? 0 : 1];
                echo $this->api->insertCronRequest($data);
             });
          }
      }
      
      
      // post prepare en boutique
       public function apidordersboutique()
      {
          if(Auth()->user()->is_admin ==1)
          {
              DB::transaction(function () {
                $response =  $this->orderboutique->insert();
                $data = ['name' => 'import_order_boutique_woocommerce', 'origin' => 'connect', 'error' => is_bool($response) ? 0 : 1,
                'message' => is_bool($response) ? null : $response, 'code' => null, 'from_cron' => 0];
                $this->api->insertCronRequest($data);
              });
          }
      }
      
      
      
      public function categorisall(Request $request)
      {
          // mise à jour de categoris dolibar
          if($request->from_cron){
            $request->from_cron == "false" ? $from_cron = false : $from_cron = true;
          } else {
            $from_cron = true;
          }

            DB::transaction(function () use ($from_cron) {
              $response = $this->gift->getcategories();
              $data = ['name' => 'update_categories_dolibarr', 'origin' => 'connect', 'error' => is_bool($response) ? 0 : 1,
              'message' => is_bool($response) ? null : $response, 'code' => null, 'from_cron' => $from_cron == false ? 0 : 1];
              echo $this->api->insertCronRequest($data);
           });
          // dd($this->gift->getcategories());
      }
      
      
      
      public function apidistributeur(Request $request)
      {
          
          if(Auth()->user()->is_admin ==1) {
              
              // recupérer les dates passés en paramètre
              $date1 = $request->get('search_date');
              $date2 = $request->get('search_dates');
            
          // fixer des dates par défaut lorsque les dates sont vides
           if($date1==""){
                $date1 ="2022-08-15T09:01";
           }
        
            if($date2==""){
               $date2 ="2022-08-01T09:01";
           }
         
            $hh =":00";
            $date11 = $date1.$hh;
            $date12 = $date2.$hh;
              
              $this->ordersd->Transferorder($date11,$date12);
          }
          
      }
      
      
      public function orderrefunded()
      {
          
          $this->refunded->insert();
          return redirect()->route('api.dataorders')->with('success', 'Le transfert  des commandes annulées ou remboursés transferés !');
      }
      
      public function action1()
      {
          return view('api.nullorders');
      }
      
       public function action2()
      {
          return view('api.confirmtransferorder');
      }
      
      public function actionapi(Request $request)
      {
         
           // get the current time
           // gerer un intervalle de date de 6 jours à partir de la date actuel
           $current = Carbon::now();
           $current1 = $current->subDays(6);
           $current2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current)->format('Y-m-d\TH:i:s',$current);
           $current3 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s', $current1)->format('Y-m-d\TH:i:s',$current1);
           // recupérer les dates passés en paramètre
           $date1 = $request->get('search_date');
           $date2 = $request->get('search_dates');
         
            // fixer des dates par défaut lorsque les dates sont vides
           if($date1=="") {
            $date1 ="2022-02-15T09:01";
           }
        
          if($date2=="") {
             $date2 ="2022-06-01T09:01";
          }
         
          $hh =":00";
          $date11 = $date1.$hh;
          $date12 = $date2.$hh;
            // Appel de la foction api transfer des données woocomerce vers dolibar !
          $action = $this->apiorders->Transferorder($date11,$date12);
          if($action=="success") {
             // action RESPONSE en cas de données dans l'intervalle de date 
             return redirect()->route('api.confirmtransferorder');
          }
         
           elseif($action=="Aucune") {
              //action RESPONSE en cas d'aucune données dans l'intervalle de date 
              return redirect()->route('api.nullorders');
          }
             else{
                 // recupérer les données get de date 
                 // action tranferer des orders via woocomerce vers dolibars 
                 redirect()->route('api.dataorders')->with('error', 'le transfert des données à echoué !');
         }
          
     }
     
     
     public function datacronorder($user)
     {
         
         if($user=="67934854968e6ee06568847ead22132f608bf4ec1997265491df0efb")
         {
            DB::transaction(function () {
              $response =  $this->orderboutique->insert();
              $data = ['name' => 'import_order_boutique_woocommerce', 'origin' => 'connect', 'error' => is_bool($response) ? 0 : 1,
              'message' => is_bool($response) ? null : $response, 'code' => null, 'from_cron' => 1];
                $this->api->insertCronRequest($data,false);
            });
         } else{
            dd('echec du script');
         }
     }
     
     
      public function datactioncron($user)
      {
         
         if($user =="67934854968e6ee06568847ead22132f608bf4ec1997265491df0efb"){
            DB::transaction(function () {
              $response =  $this->orders->insert();
              $data = ['name' => 'import_order_ambassadrice_woocommerce', 'origin' => 'connect', 'error' => is_bool($response) ? 0 : 1,
              'message' => is_bool($response) ? null : $response, 'code' => null, 'from_cron' => 1];
                $this->api->insertCronRequest($data,false);
            });
          } else{
              dd('echec de la requete');
          }
          
      }
      
      
      public function datactioncron1($user)
      {
          if($user =="67934854968e6ee06568847ead22132f608bf4ec1997265491df0efb") {
            DB::transaction(function () {
              $response =  $this->orders->insert();
              $data = ['name' => 'import_order_ambassadrice_woocommerce', 'origin' => 'connect', 'error' => is_bool($response) ? 0 : 1,
              'message' => is_bool($response) ? null : $response, 'code' => null, 'from_cron' => 1];
                $this->api->insertCronRequest($data,false);
            });
          } else{ 
            dd('echec de la requete');
          }
          
      }


      public function datactioncron3($token,Request $request)
      {
           if($token=="67934854968e6ee06568847ead22132f608bf4ec1997265491df0efb") {
              DB::transaction(function () {
                $response =  $this->cards->insert();
                $data = ['name' => 'import_cards_woocommerce', 'origin' => 'connect', 'error' => is_bool($response) ? 0 : 1,
                'message' => is_bool($response) ? null : $response, 'code' => null, 'from_cron' => 1];
                  $this->api->insertCronRequest($data,false);
              });
           } else {
              dd('echec de la requete');
           }
      
      }


      public function datadistributeur($user)
      {
          if($user == "67934854968e6ee06568847ead22132f608bf4ec1997265491df0efb"){
             $this->distributed->insert();
          }

      }
      
      
      
 }
   
   
