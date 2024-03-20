<?php

namespace App\Http\Service\CallApi;

use App\Models\ChoixPanierLive;
use App\Models\PanierLive;
use App\Models\PanierApiLive;
use App\Models\ProductWoocommerce;
use App\Models\HistoriquePanierLive;
use App\Models\Ambassadrice\Ordersambassadricecustom;
use Illuminate\Support\Facades\Http;
use Automattic\WooCommerce\Client;
use Automattique\WooCommerce\HttpClient\HttpClientException;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class PalierLive
{
    
     private $api;
    
       public function __construct(Apicall $api)
       {
         $this->api=$api;
       }
       
    
       public function Actionlive()
       {
          // delenché l'envoi de l'api via click bouton vert avec les paliers
              $code_live = Auth()->user()->code_live;
             // recupérer les données souhaités pour declencher api panier.
             // Modifier le champs actif à 1.
             // recupérer le id_coupons si existe
              // suprimer des ligne existante de l'amabassadrice existante
            DB::table('panier_api_lives')->delete();
             // modifier le actif en 1 
            $actif=1;
             DB::table('choix_panier_lives')
             ->where('code_live', $code_live)
             ->update(array('actif' => $actif
            ));
            
         $data = DB::table('choix_panier_lives')->select('id_live','date_live','code_live','id_coupons','token_datas','actif')->where('code_live','=',$code_live)->get();
        $lis = json_encode($data);
        $list = json_decode($data,true);

        // recupérer la date et voir si c'est le mardi le live est declenché .
          // traiter les données quand le champ actif est égale a 1;
        $donnes_recoive =[];
        
        $donnes_token =[]; // recupérer le champs token dans un array de données.
        $date_x ="";
        $pseudo_id_live="";
        $date_days = date('Y-m-d H:i:s');
        foreach($list as $val)  {
            if($val['actif']==1){
                $donnes_recoive[] = $val;
                
                 $donnes_token[] = [
                               'id_live'=>$val['id_live'],
                               'code_live'=>$val['code_live'],
                               'id_coupons'=>$val['id_coupons'],
                               'date_live'=>$val['date_live'],
                              'token_data' => explode(',',$val['token_datas'])
                                
                            ];
                    // insert des données dans historique live 
                    $panier = new HistoriquePanierLive();
                    $panier->id_live = $val['id_live'];
                    $panier->code_live = $val['code_live'];
                    $panier->date_live = $val['date_live'];
                    $panier->token_datas = $val['token_datas'];
                    // insert....... !-----
                   $panier->save(); 
                            
            }


            // recupérer la date du live 
            $the_date  = $val['date_live'];
            // trouve le jour de la date
            $name_of_the_day = date('l', strtotime($the_date));
            $date_x = $name_of_the_day;
            if($date_x =="Tuesday"){
                  $pseudo_id_live= $val['id_live'].','.$val['code_live'].','.$val['date_live'];
            }else{
               $pseudo_id_live = "";
            }
            
        }
        
         // recupérer les données des paniers choisir par les emabassadrice
        $datas = DB::table('panier_lives')->select('id_product','ids_variations','pseudo','token','mont_max','mont_mini','nature','libelle')->get();
        $lis = json_encode($datas);
        $lists = json_decode($datas,true);
         // recupérer les données des product
         // créer un jeu de tableau pour les ids_product parent et les variations contenu
         // recupérer les données des paniers choisir par les emabassadrice
         $donns = DB::table('variations_ids')->select('id_product','ids_variation')->get();
         $lis = json_encode($donns);
         $lister = json_decode($donns,true);
        
        $list_data =[];
        
        foreach($lister as $vk){
            $chaine = $vk['id_product'].','.$vk['ids_variation'];
            
            $list_data[$chaine] = $vk['ids_variation'];
        }
        
         $ids_list_donnees =[];// créer un index de tableau associative pour recupérer des données.
         $donnees =[];
         $donnes = [];
        foreach($lists as $key => $valc){
            $chaine1 = $valc['id_product'].'%A'.$valc['token'].'%A'.$valc['nature'].'%A'.$valc['libelle'];
            $chaine11 = $valc['ids_variations'].'%A'.$valc['token'];
            $chaine2 = $valc['pseudo'].'%A'.$valc['token'];
            $chaine3 = $valc['mont_max'].'%A'.$valc['mont_mini'].'%A'.$valc['token'];

            $donnees[$chaine1] = $valc['token'];
            $donnes[$chaine2] = $valc['token'];
            $dac[$chaine3] = $valc['token'];
            $var[$chaine11] = $valc['token'];
            
        }
        
        // 
        
        foreach($donnes_token as $vl){
            //
            foreach($vl['token_data'] as $km) {
                 $panier = array_search($km,$donnes);
                 $panierx = explode('%A',$panier);// envoi..
                 // $chaine token pour ids product
                $id_products = array_search($km,$donnees);
                $ids_var_ps = explode('%A',$id_products);
                 // defini le champ souhaité
                $nature="";
                if($ids_var_ps[2]=="categorie") {
                    $nature="id_categoris";
                }
                
                if($ids_var_ps[2]=="produit") {
                    $nature="id_product";
                }
                
                // recupérer le parent id 
                if(array_search($ids_var_ps[0],$list_data)!=false) {
                    $parent_id =array_search($ids_var_ps[0],$list_data);
                }
                 else{
                    
                    $parent_id ="no,no";
                }
                
                $parent_ids = explode(',',$parent_id);
                  // chaine des monts
                $data_mont = array_search($km,$dac);
                $id_var_p = explode('%A',$data_mont);
                 //variation
                $id_var = array_search($km,$var);
                $ids_var = explode('%A',$id_var);
                
                $donnes_api[] =[
                    
                         'id_live'=>$vl['id_live'],
                         'code_live'=>$vl['code_live'],
                          'nature'=>$nature,
                         'id_coupons'=>$vl['id_coupons'],
                         'date_live'=>$vl['date_live'],
                         'panier'=>$panierx[0],
                         'data_api' =>[
                            
                               'id_product'=>$ids_var_ps[0],
                               'libelle'=>$ids_var_ps[3],
                               'parent_id'=>$parent_ids[0],
                               'id_variation'=>$ids_var[0],
                               'mont_mini'=>$id_var_p[1],
                               'mont_max'=>$id_var_p[0],
                             
                             ]
                    ];
               }
        }
        
         foreach($donnes_api as $valu){
              $xy ="1";
               $panierapi =new PanierApiLive();
               $panierapi->id_live = $valu['id_live'];
               $panierapi->code_live= $valu['code_live'];
               $panierapi->nature = $valu['nature'];
               $panierapi->id_coupons = $valu['id_coupons'];
               $panierapi->date_live = $valu['date_live'];
               $panierapi->panier = $valu['panier'];
               $panierapi->ids_product = $valu['data_api']['id_product'];
               $panierapi->libelle = $valu['data_api']['libelle'];
               $panierapi->parent_id  = $valu['data_api']['parent_id'];
               $panierapi->ids_variations = $valu['data_api']['id_variation'];
               $panierapi->mont_mini = $valu['data_api']['mont_mini'];
               $panierapi->mont_max =$valu['data_api']['mont_max'];
               $panierapi->xy = $xy;
               
               $panierapi->save();
            
            }
           // gouper les donne en fonction du panier et code_live de l'amabassadrice
           $array = PanierApiLive::all()->groupBy('code_live','panier')->toArray();
             foreach($array as $keys => $values) {
                  
                  foreach($values as $valu) {
                      $id_live = $valu['id_live'];
                      $code_live= $valu['code_live'];
                      $id_coupons = $valu['id_coupons'];
                      $nature = $valu['nature'];
            
                           $datas_panier[] =[
                          'id_live' => $id_live,
                            'code_live'=> $code_live,
                            'id_coupons'=>$id_coupons,
                            'nature'=>$nature,
                            'order_amonts' => $values
                          
                          
                          ];
                      }
                  
              }
              
             $array_da = array_unique(array_column($datas_panier, 'code_live'));
              $data_panier_uniques = array_intersect_key($datas_panier, $array_da);// recupérer des panier unique avec leur données.
             
              // envoi un post sur wordpress api module Adrien !
               $urls ="https://www.elyamaje.com/wp-json/wc/v3/postGift";
        
               foreach($data_panier_uniques as $tabs){
                 $this->api->InsertPost($urls, $tabs);
                 
              }
              
               // modifier le actif en pendant le live
               // au montant du click 
               $date_true = date('Y-m-d H:i:s');
               $actif=2;
              DB::table('choix_panier_lives')
             ->where('code_live', $code_live)
             ->update(array('actif' => $actif,
                            'date_fix_live'=>$date_true,
                            'ext'=>$pseudo_id_live
                          

            ));
            
       
         }
     
     
     public function forcerlive($id_ambassadrice)
     {
         // forcer le live super admin.
         // recupere le code live du coupons.
         $donnees = DB::table('codelives')->select('code_live')->where('id_ambassadrice','=',$id_ambassadrice)->get();
          $x = json_encode($donnees);
         $lists = json_decode($x,true);
         
         $code_live="";
         foreach($lists as $key => $vc){
             foreach($vc as $l) {
               $code_live = $vc['code_live'];
             }
         }
           // Modifier le champs actif à 1.
          // recupérer le id_coupons si existe
          // suprimer des ligne existante de l'amabassadrice existante
           DB::table('panier_api_lives')->delete();
            // modifier le actif en 1 
           $actif=1;
             DB::table('choix_panier_lives')
             ->where('code_live', $code_live)
             ->update(array('actif' => $actif
            ));
            
        $data = DB::table('choix_panier_lives')->select('id_live','date_live','code_live','id_coupons','token_datas','actif')->where('code_live','=',$code_live)->get();
        $lis = json_encode($data);
        $list = json_decode($data,true);
         // traiter les données quand le champ actif est égale a 1...........
         $donnes_recoive =[];
         $donnes_token =[]; // recupérer le champs token dans un array de données......
        $date_days = date('Y-m-d H:i:s');
        foreach($list as $val){
            if($val['actif']==1) {
                $donnes_recoive[] = $val;
                  $donnes_token[] = [
                               'id_live'=>$val['id_live'],
                               'code_live'=>$val['code_live'],
                               'id_coupons'=>$val['id_coupons'],
                               'date_live'=>$val['date_live'],
                              'token_data' => explode(',',$val['token_datas'])
                                
                            ];

                               // insert des données dans historique live 
                                $panier = new HistoriquePanierLive();
                                $panier->id_live = $val['id_live'];
                                $panier->code_live = $val['code_live'];
                                $panier->date_live = $date_days;
                                 $panier->token_datas = $val['token_datas'];
                                 // insert....... !-----
                                 $panier->save(); 
                            
            }

            $the_date  = $val['date_live'];
            // trouve le jour de la date
            $name_of_the_day = date('l', strtotime($the_date));
            
            $date_x = $name_of_the_day;
            if($date_x =="Tuesday"){

              $pseudo_id_live= $val['id_live'].','.$val['code_live'].','.$val['date_live'];
            }else{
               $pseudo_id_live="";
            }
            
            
        }
        
      
        // recupérer les données des paniers choisir par les emabassadrice
         $datas = DB::table('panier_lives')->select('id_product','ids_variations','pseudo','token','mont_max','mont_mini','nature','libelle')->get();
         $lis = json_encode($datas);
         $lists = json_decode($datas,true);
         // recupérer les données des product
         // créer un jeu de tableau pour les ids_product parent et les variations contenu
         // recupérer les données des paniers choisir par les emabassadrice
         $donns = DB::table('variations_ids')->select('id_product','ids_variation')->get();
         $lis = json_encode($donns);
         $lister = json_decode($donns,true);
        
        $list_data =[];
        
        foreach($lister as $vk){
            $chaine = $vk['id_product'].','.$vk['ids_variation'];
             $list_data[$chaine] = $vk['ids_variation'];
        }
        
        $ids_list_donnees =[];// créer un index de tableau associative pour recupérer des données.
        $donnees =[];
        $donnes = [];
        foreach($lists as $key => $valc) {
            $chaine1 = $valc['id_product'].'%A'.$valc['token'].'%A'.$valc['nature'].'%A'.$valc['libelle'];
            $chaine11 = $valc['ids_variations'].'%A'.$valc['token'];
            $chaine2 = $valc['pseudo'].'%A'.$valc['token'];
            $chaine3 = $valc['mont_max'].'%A'.$valc['mont_mini'].'%A'.$valc['token'];
           //chaine par rapport au token !
            $donnees[$chaine1] = $valc['token'];
            $donnes[$chaine2] = $valc['token'];
            $dac[$chaine3] = $valc['token'];
            $var[$chaine11] = $valc['token'];
            
        }
        
        // 
         foreach($donnes_token as $vl){
            //
            foreach($vl['token_data'] as $km) {
                 $panier = array_search($km,$donnes);
                 $panierx = explode('%A',$panier);// envoi..
                 // $chaine token pour ids product
                  $id_products = array_search($km,$donnees);
                  $ids_var_ps = explode('%A',$id_products);
                  // defini le champ souhaité
                   $nature="";
                 if($ids_var_ps[2]=="categorie") {
                    $nature="id_categoris";
                 }
                
                if($ids_var_ps[2]=="produit") {
                    $nature="id_product";
                }
                 // recupérer le parent id 
                if(array_search($ids_var_ps[0],$list_data)!=false){
                    $parent_id =array_search($ids_var_ps[0],$list_data);
                }
                else{
                    
                    $parent_id ="no,no";
                }
                
                  $parent_ids = explode(',',$parent_id);
                  // chaine des monts.....
                  $data_mont = array_search($km,$dac);
                  $id_var_p = explode('%A',$data_mont);
                  //variation....
                  $id_var = array_search($km,$var);
                  $ids_var = explode('%A',$id_var);
                   $donnes_api[] =[
                    
                         'id_live'=>$vl['id_live'],
                         'code_live'=>$vl['code_live'],
                          'nature'=>$nature,
                         'id_coupons'=>$vl['id_coupons'],
                         'date_live'=>$vl['date_live'],
                         'panier'=>$panierx[0],
                         'data_api' =>[
                            
                               'id_product'=>$ids_var_ps[0],
                               'libelle'=>$ids_var_ps[3],
                               'parent_id'=>$parent_ids[0],
                               'id_variation'=>$ids_var[0],
                               'mont_mini'=>$id_var_p[1],
                               'mont_max'=>$id_var_p[0],
                             
                             ]
                      ];
            }
        }
        
        
        
        foreach($donnes_api as $valu){
              $xy ="1";
               $panierapi =new PanierApiLive();
               $panierapi->id_live = $valu['id_live'];
               $panierapi->code_live= $valu['code_live'];
               $panierapi->nature = $valu['nature'];
               $panierapi->id_coupons = $valu['id_coupons'];
               $panierapi->date_live = $valu['date_live'];
               $panierapi->panier = $valu['panier'];
               $panierapi->ids_product = $valu['data_api']['id_product'];
               $panierapi->libelle = $valu['data_api']['libelle'];
               $panierapi->parent_id  = $valu['data_api']['parent_id'];
               $panierapi->ids_variations = $valu['data_api']['id_variation'];
               $panierapi->mont_mini = $valu['data_api']['mont_mini'];
               $panierapi->mont_max =$valu['data_api']['mont_max'];
               $panierapi->xy = $xy;
               
               $panierapi->save();
            
            }
           
          // gouper les donne en fonction du panier et code_live de l'amabassadrice
           $array = PanierApiLive::all()->groupBy('code_live','panier')->toArray();
           
         
           foreach($array as $keys => $values){
                  
                  foreach($values as $valu) {
                      $id_live = $valu['id_live'];
                      $code_live= $valu['code_live'];
                      $id_coupons = $valu['id_coupons'];
                      $nature = $valu['nature'];
            
                      $datas_panier[] =[
                            'id_live' => $id_live,
                            'code_live'=> $code_live,
                            'id_coupons'=>$id_coupons,
                            'nature'=>$nature,
                            'order_amonts' => $values
                          
                          
                          ];
                      }
                  
              }
              
              
               $array_da = array_unique(array_column($datas_panier, 'code_live'));
              $data_panier_uniques = array_intersect_key($datas_panier, $array_da);// recupérer des panier unique avec leur données.
              // envoi un post sur wordpress api module Adrien !
               $urls ="https://www.elyamaje.com/wp-json/wc/v3/postGift";
        
               foreach($data_panier_uniques as $tabs){
                 $this->api->InsertPost($urls, $tabs);
                 
              }
              
              $date_true = date('Y-m-d H:i:s');
              $actif=2;
             DB::table('choix_panier_lives')
            ->where('code_live', $code_live)
            ->update(array('actif' => $actif,
                           'date_fix_live'=>$date_true,
                           'date_live'=>$date_true,
                           'ext'=>$pseudo_id_live
                         
             ));
           
        }
       
 }
     
