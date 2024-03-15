<?php
// recuperer des utilitaires
namespace App\Http\Service\CallApi;

use Illuminate\Support\Facades\Http;
use Automattic\WooCommerce\Client;
use App\Models\Productpromotion;
use App\Repository\Ambassadrice\AmbassadricecustomerRepository;
use App\Repository\Ambassadrice\CodeliveRepository;
use App\Repository\Codespeciale\CodespecialeRepository;
use Automattique\WooCommerce\HttpClient\HttpClientException;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AmbassadriceCustoms
{
    
      private $api;
      private $amba;
      private $codelive;
      private $data =[];
      private $listdatacodespecifique = [];
      private $cardslist = [];
      private $promoproduct =[];
    
       public function __construct(Apicall $api,
       AmbassadricecustomerRepository $amba,
        CodeliveRepository $codelive,
         CodespecialeRepository $codespecial
        )
       {
         $this->api=$api;
         $this->amba = $amba;
         $this->codelive = $codelive;
          $this->codespecial = $codespecial;
       }
    
    
    
       /**
    * @return array
    */
   public function getPromoproduct(): array
   {
      return $this->promoproduct;
   }
   
   
   public function setPromoproduct(array $promoproduct)
   {
     $this->promoproduct = $promoproduct;
     return $this;
   }
     
      /**
    * @return array
    */
   public function getCardslist(): array
   {
      return $this->cardslist;
   }
   
   
   public function setCardslist(array $cardslist)
   {
     $this->cardslist = $cardslist;
     return $this;
   }
     
    
     /**
    * @return array
    */
   public function getListdatacodespecifique(): array
   {
      return $this->listdatacodespecifique;
   }
   
   
   public function setListdatacodespecifique(array $listdatacodespecifique)
   {
     $this->listdatacodespecifique = $listdatacodespecifique;
     return $this;
   }
    
    /**
    * @return array
    */
   public function getData(): array
   {
      return $this->data;
   }
   
   
   public function setData(array $data)
   {
     $this->data = $data;
      return $this;
   }
   
   
   // traiter les produit en promotion.
   public function getAllproductpromotion()
   {
       $list_promotion = Productpromotion::All();
       // traiter le retour sous forme de tableau 
       $list_promo = json_encode($list_promotion);
       $list_promos = json_decode($list_promo,true);// convertir la chaine json en tableau array.
       // recupérer et créer un tableau associative key product_id et values price sale
       $list_promotions = [];
       $list_promo_id = [];
       
       foreach($list_promos as $kj => $values){
           if($values['sku']!=""){
              $list_promotions[$values['sku']] = $values['sku'].' , '.$values['sale_price'];
              $list_promo_id[$values['id_product']] = $values['id_product'].' , '.$values['sale_price'];
            }
       }
       
       return $list_promo_id;
   }

   public function getdonneesall(){
            
      dd('zapo');
          // FIXER LES Période de données
	        // traiter les données venant de woocomerce..
	         //$date_after ="2024-01-01T07:01:00";
            // $date_before ="2024-01-0T0:01:00";
            // 10 janvier au 20janvier soucis site.uct
           $current = Carbon::now();

           $currents1 = $current->subDays(2);
           $currents2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$currents1)->format('Y-m-d\TH:i:s',$currents1);
           $date_after = $currents2;
             // ajouter un intervale plus un jour !
           $current1 = $current->addDays(2);
           $current2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current1)->format('Y-m-d\TH:i:s',$current1);
           $date_before = $current2;
            // initiliaser un array
             $donnees = [];
            $public_key = env('API_KEY_PUBLIC_WOOCOMERCE');
            $secret_key = env('API_KEY_PRIVATE_WOOCOMERCE');

            // recupérer les commandes du jour en cours .
             /* $today = date('Y-m-d') . 'T00:00:00';
              for($i=1; $i<4; $i++){
                 $page = $i;
                 $per_page = 100;
                 $urls = 'https://www.elyamaje.com/wp-json/wc/v3/orders?consumer_key=' . $public_key . '&consumer_secret=' . $secret_key . '&after=' . $today.'&page=' . $page . '&per_page=' . $per_page;
                  //$urls="https://www.elyamaje.com/wp-json/wc/v3/orders?orderby=date&order=desc&after=$date_after&before=$date_before&consumer_key=$public_key&consumer_secret=$secret_key&page=$i&per_page=100";
                 $donnes = $this->api->getDataApiWoocommerce($urls);
                 if($donnes){
                    $donnees[] = array_merge($donnes);
                }
              } 

                dd($donnees);

            */

             for($i=1; $i<4; $i++){
                $urls="https://www.elyamaje.com/wp-json/wc/v3/orders?orderby=date&order=desc&after=$date_after&before=$date_before&consumer_key=$public_key&consumer_secret=$secret_key&page=$i&per_page=100";
                // recupérer des donnees orders de woocomerce depuis api......
                $donnes = $this->api->getDataApiWoocommerce($urls);
              if($donnes){
                 $donnees[] = array_merge($donnes);
               }
            }
           
             return $donnees;
             // 
         
       }

         public function getorderambassadrice(){
             // commande 
             //melissa nael 136579 134591  136613 136438
             $public_key = env('API_KEY_PUBLIC_WOOCOMERCE');
             $secret_key = env('API_KEY_PRIVATE_WOOCOMERCE');
             $urlss="https://www.elyamaje.com/wp-json/wc/v3/orders/136579?&consumer_key=$public_key&consumer_secret=$secret_key";
             // recupérer des donnees orders de woocomerce depuis api......
              $donnes = $this->api->getDataApiWoocommerce($urlss);
              $donnees[][] = array_merge($donnes);

              return $donnees;

         }
        

      
   
      // methode recupérer des data wooocomerce qui ont un code promo amabassadrice..
       public function getDataorder(): array
       {
             
            // FIXER LES Période de données
	          // traiter les données venant de woocomerce..
	          //$date_after ="2023-04-01T09:01:00";
            // recupére les données qui on un code pro existant
             $coupons =[];
            // recupérer les données du customer amabddasrice
             $a = [];
             $data = $this->amba->getAllcustoms();
           // recupérer le tableau associative des codelive
            $donnescodelive = $this->codelive->getAllcodelive();
            $data_codelive = $this->codelive->getListcodelive();
             // recupérer la liste des cdoes speicifique
            $this->codespecial->getAllcode();
            // recupérer les codes specifique dans un tableau
            $array_code_specifique = $this->codespecial->datacode();
            $dataspecifique = $this->codespecial->getArrayid();
         
            foreach($donnescodelive as $kl => $donnnes) {
               $array_data[$donnnes['id_ambassadrice']] = $donnnes['code_live'];
               $array_datas[$donnnes['is_admin']]  = $donnnes['code_live'];
            }
             // traiter les données dans le cas ou on as un code live
             // traitement des données des code live
            $commission="20";
            $is_admin ="";
            $id_ambassadrice="";
            $code_live ="";
             $chaine_ar =[];
           foreach($data_codelive as $kg => $vale){
                foreach($vale as $vm => $klm) {
                     $chaine = $klm;
                      // exploser la chaine en tab
                      $chaine_ar[] = explode(',',$chaine);
                   }
             }

          // recupérer la data et créer un tableau associative pour code élève
          $chaine_arr =[];
           foreach($data as $k => $value){
                   foreach($value as $v => $kl){
                        $chaine = $kl;
                         // exploser la chaine en tab
                         $chaine_arr[] = explode(',',$chaine);
                             
                      }
                }
                     
         // recupérer la data et créer tableau associative pour les code spécifique
          $chaine_arrs = [];
            foreach($dataspecifique as $ks => $valuee){
                  foreach($valuee as $vs => $kls){
                             $chaines = $kls;
                             // exploser la chaine en tab
                             $chaine_arrs[] = explode(',',$chaines);
                             
                     }
                } 
                     
             // recupérer les données des produits passer en promotion
             $chaine_promo =[];// recupérer les données pour extraire les produits en promotion....kit prothesie
             foreach($this->getAllproductpromotion() as $v=>$valis){
                 $chaine_promo[] = explode(',',$valis);
             }

            // traitement de données pour recupérer les Api 
           $data_id_product = [];
           $somme_deduit =[];// recupérer la somme des produits mis en promotion
           $chaine ="-10";
           $chaine1 ="-amb";
           $chaine2 ="bpp-";
           $chaine3 ="fem-";

           $donnees = $this->getdonneesall();// recupérer les data venant de wooocomerce.
          // $donnees = $this->getorderambassadrice();
         
          
           foreach($donnees as $donns){
                
                foreach($donns as $donnes){
                 
                   foreach($donnes['coupon_lines'] as $key=> $val){
                     
                      foreach($donnes['line_items'] as $ks => $vals) {
                      
                        if(count($donnes['coupon_lines'])!=0) {
                             
                             if(strpos($val['code'],$chaine)==true OR strpos($val['code'],$chaine1)==true){
                                 
                                 if(strpos($val['code'],$chaine2)===false && strpos($val['code'],$chaine3)===false){
                                    // recupérer le tableau !courant des données de Api !...
                                     $donnees_orders[] = $donnes;
                                    
                                     // recupére les montant des produits qui sont en promotion à partir des id product.
                                     $n =  count($chaine_promo);
                                    for($i=0; $i<$n; $i++){
                                      if($vals['product_id']==$chaine_promo[$i][0]){
                                        if(strpos($val['code'],$chaine)==true){
                                           $somme_deduit[] = $chaine_promo[$i][1];// remplir les montants.
                                          
                                        }
                                        
                                        if(strpos($val['code'],$chaine1)==true){
                                           $somme_deduit[] = $chaine_promo[$i][1];// remplir les montants de reduction(kits du prothésie..)
                                        }
                                      
                                      }
                                    }
                               
                                    // traiter la recupération de données pour les  code élève..
                                    $c = count($chaine_arr);
                                   for($i=0;  $i< $c; $i++) {
                                        // traiter les données des code élève
                                        if($val['code']==$chaine_arr[$i][1]){
                                           $id_ambassadrice = $chaine_arr[$i][0];
                                           $code_live =11;
                                           $is_admin = $chaine_arr[$i][2];
                                           $admin = (int)$is_admin;
                                           $commission="20";
                                        }
                                    }
                                    // traiter la recupération des  données dans le cas d'un codelive
                                   $d = count($chaine_ar);
                                  for($i=0;  $i< $d; $i++){
                                        if($val['code']==$chaine_ar[$i][0]){
                                         $commission ="20";
                                         $code_live =12;
                                         $id_ambassadrice = $chaine_ar[$i][1];
                                         $is_admin = $chaine_ar[$i][2];
                                          $admin = (int)$is_admin;
                                      }
                                    }
                         
                                 // traiter la recupération des  données dans le cas d'un code spécifique
                                 $v = count($chaine_arrs);
                                  for($i=0;  $i< $v; $i++){
                                      if($val['code']==$chaine_arrs[$i][0]){
                                          $commission = $chaine_arrs[$i][3];
                                           $code_live =13;
                                          $id_ambassadrice = $chaine_arrs[$i][1];
                                         $is_admin = $chaine_arrs[$i][2];
                                         $admin = (int)$is_admin;
                                     }
                                  }
                             
                                   //formaté la date en datetime français
                                    $date = $donnes['date_created'];
                                    $replace = 'à';
                                    $t  = "T";
                                    $date1 = str_replace($t,$replace,$date);
                                    $date_express = explode('à', $date1);
                                     $datet = $date_express['0'];
                                     $datet1 = $date_express['1'];
                                     $date2 = explode('-',$datet);
                                     $date_finish = $date2['2'].'/'.$date2['1'].'/'.$date2['0'];
                                     $code_mois = $date2[1];
                                     $code_annee = $date2[0];
                                     $nombre_code = (int)$code_mois;
                                     $nombre_annee = (int)$code_annee;
            
                                    //date finish
                                    $date_finish1 = $date_finish.' à '.$datet1;
                                    // somme text pour notification
                                    $s = $donnes['total']-$donnes['total_tax'];
                                    $s1 = ($s*$commission)/100;
                                    $s2 = number_format($s1, 2, ',', '');
                                    $notification = 'commande N° '.$donnes['id']. ' . '.$s2.' €' ;
                                  // initiliser les table array
                                  $coupons_code =[];
                                  $montant_gift_card =[];// montant gift_card bon cadeaux.

                                  foreach($donnees_orders as $kl => $values){
                                      
                                      $retrait = array_sum($somme_deduit);// sommes des index du tableau.....
                                      $somme = $values['total']-$retrait-$values['total_tax']-$values['shipping_total'];
                                      if($somme > 0) {
                                    
                                        $somm = ($somme*$commission)/100;
                                        
                                        $notification = 'commande N° '.$values['id']. ' . '.$somm.' €' ;
                                       // recupérer les orders avec le code spécifique.....
                                        $statuts="code_promo";
                                      
                                         $coupons[] = [
                                        "date_created"=> $date_finish,
                                         "code_promo" => $val['code'],
                                         "id_commande"=>$values['id'],
                                         "id_ambassadrice" => $id_ambassadrice,
                                         "status"=>$values['status'],
                                          "is_admin" => $is_admin,
                                          "customer"=> $values['billing']['first_name'].' '.$values['billing']['last_name'],
                                           "username" => $donnes['billing']['first_name'],
                                          "email" => $values['billing']['email'],
                                          "telephone" => $values['billing']['phone'],
                                           "adresse" => $values['billing']['address_1'].''.$values['billing']['address_2'],
                                           "total_ht" =>$somme,
                                           "somme" => $somm,
                                          "data_line"=>$values['line_items'],
                                          "somme_tva" => $values['total_tax'],
                                          "notification" => $notification,
                                         "code_mois" => $nombre_code,
                                         "nombre_annee" => $nombre_annee,
                                          "code_live" =>$code_live,
                                          "commission"=>$commission
                
                                        ];
                               
                                   }
                                  }
                          
                                  $coupon_cards = [];
                                  $array_data = array('_payplug_metadata');
                                if($donnes['payment_method']=="payplug" OR $donnes['payment_method']=="oney_x4_with_fees"){
                                     $coupon_cards[] = $donnes;
                                 }
                             } 
                             
                             }
                        
                         }
                    
                   }
                   
              }
            }
          }
          
             
              $array_datas = array_unique(array_column($coupons, 'id_commande'));
              $array_data_uniques = array_intersect_key($coupons, $array_datas);
             
              return $array_data_uniques;
    } 
    
}

