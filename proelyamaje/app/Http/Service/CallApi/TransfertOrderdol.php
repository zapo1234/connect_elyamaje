<?php
namespace App\Http\Service\CallApi;

use App\Repository\Distributeur\DistributeurRepository;
use Illuminate\Support\Facades\Http;
use Automattic\WooCommerce\Client;
use Automattique\WooCommerce\HttpClient\HttpClientException;
use Illuminate\Support\Facades\DB;

use DateTime;
use DateTimeZone;

class TransfertOrderdol
{
    
      private $api;
      
      private $commande;
      private $status; // vartiable string pour statuts(customer et distributeur)
     
    
       public function __construct(Apicall $api,
       DistributeurRepository $distributeur
       )
       {
         $this->api=$api;
         $this->distributeur =$distributeur;
         
       }
    
    
     /** 
     *@return array
     */
      public function getordersdol()
      {
           // recuperer les commandes dans dolibar
           // Api dolibar.
           
             $method = "GET";
             $apiKey = env('KEY_API_DOLIBAR_PROD');
             $apiUrl = env('KEY_API_URL_PROD');
            
            // $apiKey = env('KEY_API_DOLIBAR_TEST');
            // $apiUrl = env('KEY_API_URL');
             
             $produitParam = ["limit" => 1, "sortfield" => "rowid","sortorder" => "DESC"];
             $listorders = $this->api->CallAPI("GET", $apiKey, $apiUrl."orders", $produitParam);
             $lists = json_decode($listorders,true);

             //dd($lists);
         // recupérter le dernier customer id venant de woocomerce....
                // recupérer les orders depuis la prod
               //construire les données à flush dans les tables orders_dol et order_product_dol.
                $data_ids =[];// recupérer les ids socid et recupérer l'utilisateur ensuite depuis la table tiers.
                $data_orders_dol =[];
                $data_orders_product =[];

                // reupérer les distributeurs existant .
                $distributeur = $this->distributeur->getDistributeur();
                $data_info_tiers = $this->distributeur->getDatalist();
                $data_ids_order =$this->distributeur->getorderiddistributeur();
                // recupérer la liste des users deja crée
                $list_email_user = $this->distributeur->getEmailgroup();// les client deja reupérer(existant)
                $data_tiers_orders =[];// les informations de l'utilisateur à la creation.
                $data_info_order =[];// lié un statut a la commande de l'utilisateur
                $data_product_ilne =[];
                $text="not_attribute";// a la creation du distributeur quand il existe pas .
                $status="untreated";// non traité la commande.
                $user="En attente";// attribué à la personne qui as transféré la commande 

                $data =  DB::table('tiers_woocommerce')->select('email','customer_id')->get();
                $name_list = json_encode($data);
                $name_lists = json_decode($data,true);
                $result_data = [];
                foreach($name_lists as $key => $val){
                  $result_data[$val['email']] = $key;
                  $result_id_custom[$val['customer_id']] = $val['email'];
                }
              
                if($lists!=""){
                 
                   
                        foreach($lists as $value){
                        if(isset($data_ids_order[$value['id']])!=false){
                            $data_tiers_orders =[];
                            $data_info_order =[];
                            $data_product = [];
                        }

                        else{

                            // recupérer le systeme.
                           if($value['status']==1){
                           // voir si le client n'existe pas.
                              $date_fr = date('d-m-Y', $value['date_creation']);
                              $id = $value['socid'];
                             // recupérer l'email du client
                               $listproduct = $this->api->CallAPI("GET", $apiKey, $apiUrl."thirdparties/$id", $produitParam);
                               $lists_data[] = json_decode($listproduct,true);
                              

                           foreach($lists_data as $values){
                             
                            if(isset($list_email_user[$values['email']])==false){
                               
                              $data_tiers_orders[] =[
                              'socid'=>$values['id'],
                              'customer_id_wc'=>$text,
                              'nom'=>$values['name'],
                              'prenom'=>$values['name'],
                              'email'=>$values['email'],
                              'adresse'=>$values['address'],
                              'phone'=>$values['phone'],
                              'code_postal'=>$values['zip'],
                              'phone'=>$values['phone'],
                              'city'=>$values['town']
                               ];
                                
                              }

                           }

                               $data_info_order[] = [
                                'date_create'=> $date_fr,
                                'ref_commande'=>$value['ref'],
                                'order_id' => $value['id'],
                                'socid'=>$id,
                                'status'=> $status,
                                'total_ht'=>$value['total_ht'],
                                'total_ttc'=>$value['total_ttc'],
                                 'user'=> $user
                              ];
     
                             foreach($value['lines'] as $val) {
                                 $data_product[] = [
                                "order_id"=> $val['commande_id'],
                                 "ref" => $val['ref'],
                                "libelle" =>$val['libelle'],
                                "quantite" => $val['qty'],
                                "barcode"=> $val['product_barcode'],
                                "subprice"=> floatval($val['multicurrency_subprice']),
                                "total_ht" => floatval($val['multicurrency_total_ht']),
                                "total_ttc" => floatval($val['multicurrency_total_ttc']),
                               
                                ];

                             }
                            }
                         }
                       }
                   }
                   
                  
               // filtrer les tiers uniques à partir de la colonne socid unique.
                 $tiers = array_unique(array_column($data_tiers_orders, 'socid'));
                 $unique_tiers = array_intersect_key($data_tiers_orders, $tiers);
                // insert dans la table distributeur et order
                DB::table('distributeurs')->insert($unique_tiers);
                DB::table('order_distributeur_status')->insert($data_info_order);
                DB::table('orders_distributeurs_line_products')->insert($data_product);
                
              
        }
      }   
        
       

