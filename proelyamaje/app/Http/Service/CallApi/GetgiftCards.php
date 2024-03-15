<?php

namespace App\Http\Service\CallApi;

use Exception;
use Carbon\Carbon;
use App\Models\Categorie;
use App\Models\Cardsgift;
use App\Models\ProductDolibar;
use Illuminate\Support\Str;
use App\Models\VariationsId;
use App\Models\CategorieProduct;
use App\Models\Productpromotion;
use App\Models\ProductWoocommerce;
use App\Models\Productbarcodewc;
use Automattic\WooCommerce\Client;
use Illuminate\Support\Facades\DB;
use App\Models\CategorisWoocommerce;
use Illuminate\Support\Facades\Http;
use App\Repository\Giftcards\GiftcardsRepository;
use Automattique\WooCommerce\HttpClient\HttpClientException;

class GetgiftCards
{
    
     private $api;
    
       public function __construct(Apicall $api)
       {
         $this->api=$api;
       }
       
    
       public function getDataGiftCards(): array
       {
          // $customer_key = env('API_KEY_PUBLIC_WOOCOMERCE');
          // $customer_secret = env('API_KEY_PRIVATE_WOOCOMERCE');

          $customer_key = $this->api->getApikeywopublic();
          $customer_secret =$this->api->getApikeysecret();
        
           // traiter les données venant de woocomerce
             $date_after ="2023-09-30T09:01:00";
             $current = Carbon::now();
             // ajouter un intervale plus un jour !
             $current1 = $current->addDays(2);
             $current2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current1)->format('Y-m-d\TH:i:s',$current1);
             $date_before = $current2;
             // initiliaser un array
             $donnees = [];
             // boucle sur le nombre de paginations trouvées
          
               $urls="https://www.elyamaje.com/wp-json/wc-pimwick/v1/pw-gift-cards/?&orderby=date&order=desc&consumer_key=$customer_key&consumer_secret=$customer_secret&page=1&per_page=1";
              // recupérer des donnees orders de woocomerce depuis api
              $donnes = $this->api->getDataApiWoocommerce($urls);
              if($donnes){
                $donnees[] = array_merge($donnes);
              }

            
           
            return $donnees;
        }
        
  
        
          
       public function getcategoriesjours()
       {  
          //$customer_key = env('API_KEY_PUBLIC_WOOCOMERCE');
        //$customer_secret = env('API_KEY_PRIVATE_WOOCOMERCE');

          $customer_key = $this->api->getApikeywopublic();
          $customer_secret =$this->api->getApikeysecret();
        
            try {
              for($i=1; $i<3; $i++){
                
                $urls="https://www.elyamaje.com/wp-json/wc/v3/products/categories?consumer_key=$customer_key&consumer_secret=$customer_secret&page=$i&per_page=100";
                // recupérer des donnees orders de woocomerce depuis api
                $donnes = $this->api->getDataApiWoocommerce($urls);
                if($donnes){
                  $donnees[] = array_merge($donnes);
                }
              }
          
              
              
              // flush la table et la remplir .
                DB::table('categoris_woocommerces')->delete();
              
              // remplir la table
              
              foreach($donnees as $values){
                  foreach($values as $val) {
                    $categoris = new CategorisWoocommerce();
                    $categoris->rowid = $val['id'];
                    $categoris->label = $val['name'];
                    $categoris->save();
                  
                  }
              }

              return true;
                
            } catch (Exception $e) {
              return $e->getMessage();
            }
            
            
        }
        
        
        
         public function getcategories()
         {
            try{

                   // recuperer les données api dolibar propers prod tous les clients.
                  $method = "GET";
                  $apiKey = env('KEY_API_DOLIBAR_PROD');
                  $apiUrl ="https://www.poserp.elyamaje.com/api/index.php/";
                  //Recuperer les ref et id product dans un tableau
	                // recupérer les ids product dans dolibar .
                   $produitParam = ["limit" => 1200, "sortfield" => "rowid","sortorder" => "DESC"];
	                 $listproducts = $this->api->CallAPI("GET", $apiKey, $apiUrl."products", $produitParam);

                   
                    
	                 if($listproducts){
                    $lists_p = json_decode($listproducts,true);
                   }
                  

                   // effacer les ligne 
                   DB::table('product_dolibars')->truncate();
	                 foreach($lists_p as $val) {
                      //mettre a jour les product.
                      $product = new ProductDolibar();
                      $product->id_product = $val['id'];
                      $product->barcode = $val['barcode'];
                      $product->libelle = $val['label'];
                      $product->save(); //insert

                   }
              
                  // recupérer les ids produis et les categories associés.
	                 //$data_liste =[];
                    $produitParam = ["limit" => 150, "sortfield" => "rowid","sortorder" => "DESC"];
	                  $listproduct = $this->api->CallAPI("GET", $apiKey, $apiUrl."categories", $produitParam);
                    $lists = json_decode($listproduct,true);
                    $date ="2020-01-22  10:00:00";
                    // flush la table et la remplir ..
                    DB::table('categories')->truncate();
                   foreach($lists as $values) {
                      if($values['id']!="15"){
                          $cat = new Categorie();
                          $cat->rowid = $values['id'];
                          $cat->entity = 1;
                          $cat->fk_parent = $values['fk_parent'];
                          $cat->label = $values['label'];
                          $cat->ref_ext = $values['label'];
                          $cat->type = 0;
                          $cat->description = $values['description'];
                          $cat->color = $values['color'];
                          $cat->visible = $values['visible'];
                          $cat->import_key = $values['import_key'];
                          $cat->date_creation = $date;
                          $cat->tms = $date;
                          $cat->fk_user_creat =0;
                          $cat->fk_user_modif =0;
                          $cat->save();
                      }
                  
                  }

               return true;
            } catch (Exception $e) {
                return $e->getMessage();
            } 
              
	            
	      }


        public function getsynchrocatepro(int $id)
        {
             // faire la mise a jour de la table categoris_product à partir jointure de table
             //pour lier les produits et categoris.
             $method = "GET";
             $apiKey = env('KEY_API_DOLIBAR_PROD');
             $apiUrl ="https://www.poserp.elyamaje.com/api/index.php/";
            //Recuperer les ref et id product dans un tableau
             // recupérer les ids product dans dolibar .
             $produitParam = ["limit" => 10, "sortfield" => "rowid","sortorder" => "DESC"];

               $listproducts = $this->api->CallAPI("GET", $apiKey, $apiUrl."products/$id/categories", $produitParam);
                $data_result = json_decode($listproducts,true);
                $datas[] = $data_result;
              
                // recupérer des données pour les traiter et inserer dans categories.
                return $datas;

        }



        
          // recupérer dles id_product depuis la bdd
          public function getAllidapi()
          {
               // $customer_key = env('API_KEY_PUBLIC_WOOCOMERCE');
              // $customer_secret = env('API_KEY_PRIVATE_WOOCOMERCE');
                $customer_key = $this->api->getApikeywopublic();
                $customer_secret =$this->api->getApikeysecret();
            
                $user_all = DB::table('giftcards')->select('id_api')->get();
                $array_list = json_encode($user_all);
                $array_list = json_decode($user_all,true);
                // recupérer dans le tableau data les valeur unique
                $array_id =[];
                 $donnes = [];
                 foreach($array_list as $values){
                    $array_id[]= $values['id_api'];
                  }

                  $code_verify ="XL56-ETSQ-V2WH-9AY3";

                  $gift_card_codes = ['XL56-ETSQ-V2WH-9AY3', '8PWF-3VV4-RWUW-468S'];

                  
                  $urlss ="https://www.elyamaje.com/wp-json/wc-pimwick/v1/pw-gift-cards?number=P-23OUCX";

                   $dones = $this->api->getDataApiWoocommerce($urlss);

                  dd($dones);

                  
                  
                   foreach($dones as $val) {
                    // recupérer just les code_number commençant par A et P.
                      $cardsgift = new Cardsgift();
                      $cardsgift->id_api = $val['pimwick_gift_card_id'];
                      $cardsgift->code_number = $val['number'];
                       $cardsgift->montant = $val['balance'];
                       $cardsgift->save();
                    }
              
          
            
                return $dones;
        }
       
       
       
        public function getdataproduct()
        {
          
          //$customer_key = env('API_KEY_PUBLIC_WOOCOMERCE');
          // $customer_secret = env('API_KEY_PRIVATE_WOOCOMERCE');
           $customer_key = $this->api->getApikeywopublic();
           $customer_secret =$this->api->getApikeysecret();
       
           // boucle sur le nombre de paginations trouvées
          try{

          // recupérer tous les prduits dans la table
            $data =  DB::table('productpromotions')->select('id_product')->get();
            $name_list = json_encode($data);
            $name_list = json_decode($data,true);
            $donnees = [];
              // boucle sur le nombre de paginations trouvées
            for($i=1; $i<2; $i++) {
                
              $urls="https://www.elyamaje.com/wp-json/wc/v3/products?consumer_key=$customer_key&consumer_secret=$customer_secret&page=$i&per_page=100";
                // recupérer des donnees orders de woocomerce depuis api
                $donnes = $this->api->getDataApiWoocommerce($urls);
                if($donnes){
                  $donnees[] = array_merge($donnes);
                }
            }
            
            
            // recuperer les produit (qui sont passé en promotion sur la boutique)
            $product_list1 = []; // recupérer les ids product qui sont en promotion sans varition
            $ids_product = []; // recupérer les ids de produits en variation
            $product_list2 = [];// recupérer les ids et sales price de ces id en variations
            $result_list = [];// merge sur les resultat des deux tableau
            foreach($donnees as $k => $values){
                
                foreach($values as $vals) {
                      if($vals['on_sale']=="true"){
                     // verifier le regular price
                      if($vals['regular_price']!=""){
                        $product_list1[$vals['sku']]=$vals['sale_price'].' '.$vals['id'];
                
                      }
                      
                      if($vals['regular_price']=="") {
                          foreach($vals['variations'] as $ker => $valis){
                              $ids_product[] = $valis;
                          }
                      }
          
                  }
            }
            
            
            // recupérer les montant sale_price conrrespondant au tableau ids_product
            
            } 
            
          // appel sur l'api pour recupérer un tableau associative des key id et valeurs sale_price
              $list = [];
            foreach($ids_product as $id) {
              $urls="https://www.elyamaje.com/wp-json/wc/v3/products/$id?consumer_key=$customer_key&consumer_secret=$customer_secret";
                // recupérer des donnees orders de woocomerce depuis api de ces id de produit mise en promotio 
                $data_array = $this->api->getDataApiWoocommerce($urls);
                if($data_array){
                  $list[] = array_merge($data_array);
                }
                // recupérer le tableau associative 
              }
              
              // recupérer en boucle les données sous forme de tableau associative
               foreach($list as $result) {
                     $product_list2[$result['sku']] = $result['sale_price'].' '.$result['id'];
                  
              }
              
               // insert des table de données les produits en mis en promotion sur le site woocomerce.
                
                if(count($name_list)!=0){
                    // vider la table
                    DB::table('productpromotions')->delete();
                }
                
                foreach($product_list1 as $lm => $vals) {
                  
                    $dd =  explode(' ',$vals);
                    $product = new Productpromotion();
                    $product->id_product = $dd[1];
                    $product->sku = $lm;
                    $product->sale_price = $dd[0];
                    $product->save();
                  }
                
                foreach($product_list2 as $lk => $val)
                {
                    $dd = explode(' ',$val);
                    $products = new Productpromotion();
                    $products->id_product = $dd[1];
                    $products->sku = $lk;
                    $products->sale_price = $dd[0];
                    $products->save();
                }
              
              // insert des table de données les produits en mis en promotion sur le site woocomerce.
                
              return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
      
      
      }
      
      
      public function product_all()
      {
         
        
        try {

          $donnees = [];
          // boucle sur le nombre de paginations trouvées
          //$customer_key = env('API_KEY_PUBLIC_WOOCOMERCE');
          //$customer_secret = env('API_KEY_PRIVATE_WOOCOMERCE');

          $customer_key = $this->api->getApikeywopublic();
          $customer_secret =$this->api->getApikeysecret();

          //DB::table('product_woocommerces')->delete();
           
          for($i=8; $i<12; $i++){
             $urls="https://www.elyamaje.com/wp-json/wc/v3/products?consumer_key=$customer_key&consumer_secret=$customer_secret&page=$i&per_page=100";
              // recupérer des donnees orders de woocomerce depuis api
              $donnes = $this->api->getDataApiWoocommerce($urls);
              if($donnes){
                $donnees[] = array_merge($donnes);
              }

           }
          
              $ids_product = []; // recupérer les ids de produits en variation
             $ids_prod = [];
             $ids_product3 = [];
              // un delete 
          
               foreach($donnees as $k => $values){
                     foreach($values as $vals) {
                       $ids_product[] =[
                       "ids_product"  =>$vals['id'],
                       'libelle'=> $vals['name'],
                       'ids_variation' => implode(',',$vals['variations']),
                       'prix'=>$vals['sale_price']
                      ];
                        // pour les table ids de variation de product
                       $ids_product3[] =[
                     "ids_product"  =>$vals['id'],
                     'libelle'=> $vals['name'],
                     'ids_variation' => $vals['variations'],
                     'prix'=>$vals['sale_price']
                       
                      ];
                      
                       if(count($vals['variations'])!=""){
                           foreach($vals['attributes'] as $vd) {
                             if($vd['variation']== true) {
                              $ids_prod[] = [
                              'libelle'=> $vals['name'],
                              'prix'=>$vals['sale_price'],
                              'ids_variation'=> $vals['variations'],
                              'attribute'=>$vd
                       
                        ];
                        
                       }
                    
                      }
                    }
                 }
               }
               
              // gerer les variation à introduire dans le tableau
              $ids_pr5 = [];
              $ids_pr4 = [];
              $ids_pr3 = [];
              $ids_pr2 = [];
              $ids_pr1 = [];

              foreach($ids_prod as $vd){
                 $chaine = implode(',',$vd['ids_variation']);
                 $chaine2 = implode(',',$vd['attribute']['options']);
                 
                   if(count($vd['attribute']['options'])==5){
                        $ids_pr5[] =[
                                  'name'=> $chaine.','.$vd['libelle'].','.$chaine2,
                                 
                                 ];
                                 
                        }
                        // produit qui ont 4 variations
                         if(count($vd['attribute']['options'])==4) {
                                $ids_pr4[] =[
                                  'name'=> $chaine.','.$vd['libelle'].','.$chaine2,
                                 
                                 ];
                                 
                         }
                         
                     // les produit qui ont variations 3
                    if(count($vd['attribute']['options'])==3) {
                        $ids_pr3[] =[
                                  'name'=> $chaine.','.$vd['libelle'].','.$chaine2,
                                 
                                 ];
                                 
                    }
                    
                    
                    // les produit qui ont DEUX VARIATIONS
                   if(count($vd['attribute']['options'])==2) {
                          $ids_pr2[] =[
                                  'name'=> $chaine.','.$vd['libelle'].','.$chaine2,
                                 
                                 ];
                                 
                    }
                    
                     // les produit qui ont une variations
                     if(count($vd['attribute']['options'])==1) {
                        $ids_pr1[] =[
                                 'name'=> $chaine.','.$vd['libelle'].','.$chaine2,
                                 
                                 ];
                      }
                    }
                  // ecrire un token
                $token = Str::random(60);
                
               // insert le tatbleau dans product
               foreach($ids_product as $val){
                    $code = str_shuffle($token.$val['ids_product']);// create token unique ....
                   
                   $product = new ProductWoocommerce();
                   $product->ids_product = $val['ids_product'];
                   $product->libelle = $val['libelle'];
                   $product->id_variations = $val['ids_variation'];
                   $product->prix = $val['prix'];
                   $product->token = $code;
                   $product->save();
          
                }
                
                 // insert les varaitions dans la table 
                // les produits ayant une varitations
                
                foreach($ids_pr1 as $vals) {
                       $prix="";
                       $ids_variation="";
                       $chainex = explode(',',$vals['name']);
                       $code = str_shuffle($token.$chainex[0]);// create token unique ....
                       $product = new ProductWoocommerce();
                       $product->ids_product = $chainex[0];
                        $product->libelle = $chainex[1].' '.$chainex[2];
                        $product->id_variations = $ids_variation;
                        $product->prix = $prix;
                         $product->token = $code;
                         $product->save();
                }
                
                 // les produit ayant deux variations
                 $array1 =[];
                 $array2 =[];
                 $list =[];
                 foreach($ids_pr2 as $vlc) {
                    $chainex2 = explode(',',$vlc['name']);
                    
                    $array1[] =[
                          'ids_product'=>$chainex2[0],
                          'libelle'=>$chainex2[2].' '.$chainex2[3],
                        ];
                        
                        $array2[] =[
                          'ids_product'=>$chainex2[1],
                          'libelle'=>$chainex2[2].' '.$chainex2[4],
                        ];
                        
                    }
                
                   $list = array_merge($array1,$array2);
                  // les produits ayant 3 variations
                 foreach($list as $vcd){
                      $prix="";
                      $ids_variation="";
                      $code = str_shuffle($token.$vcd['ids_product']);// create token unique ....
                      $product = new ProductWoocommerce();
                      $product->ids_product =$vcd['ids_product'];
                      $product->libelle = $vcd['libelle'];
                      $product->id_variations = $ids_variation;
                      $product->prix = $prix;
                      $product->token = $code;
                      $product->save();
                }
                
                // les prduits ayant 3 variations
                 $array3 =[];
                 $array4 =[];
                 $array5 =[];
                  $list1 =[];
                foreach($ids_pr3 as $vl){
                     $chainex3 = explode(',',$vl['name']);
                    
                      $array3[] =[
                          'ids_product'=>$chainex3[0],
                          'libelle'=>$chainex3[3].' '.$chainex3[4],
                        ];
                        
                        $array4[] =[
                          'ids_product'=>$chainex3[1],
                          'libelle'=>$chainex3[3].' '.$chainex3[5],
                        ];
                        
                    
                     $array5[] =[
                          'ids_product'=>$chainex3[2],
                          'libelle'=>$chainex3[3].' '.$chainex3[6],
                        ];
                     
                        
                 }
             
                $list1 =  array_merge($array3,$array4,$array5);
             
                foreach($list1 as $vcd){
                     $prix="";
                    $ids_variation="";
                     
                   $code = str_shuffle($token.$vcd['ids_product']);// create token unique ....
                   
                   $product = new ProductWoocommerce();
                   $product->ids_product =$vcd['ids_product'];
                   $product->libelle = $vcd['libelle'];
                   $product->id_variations = $ids_variation;
                   $product->prix = $prix;
                   $product->token = $code;
                   $product->save();
                }
                
            
                 $array6 =[];
                 $array7 =[];
                 $array8 =[];
                 $array9 =[];
                  $list2 =[];
                
                 foreach($ids_pr4 as $vl){
                    $chainex3 = explode(',',$vl['name']);
                    
                    $array6[] =[
                          'ids_product'=>$chainex3[0],
                          'libelle'=>$chainex3[4].' '.$chainex3[5],
                        ];
                        
                        $array7[] =[
                          'ids_product'=>$chainex3[1],
                          'libelle'=>$chainex3[4].' '.$chainex3[6],
                        ];
                        
                    
                     $array8[] =[
                          'ids_product'=>$chainex3[2],
                          'libelle'=>$chainex3[4].' '.$chainex3[7],
                        ];
                     
                       
              }
              
              
                 $list2 =  array_merge($array6,$array7,$array8);
                 
                   foreach($list2 as $vcd){
                     $prix="";
                     $ids_variation="";
                     
                     $code = str_shuffle($token.$vcd['ids_product']);// create token unique ....
                   
                     $product = new ProductWoocommerce();
                     $product->ids_product =$vcd['ids_product'];
                     $product->libelle = $vcd['libelle'];
                     $product->id_variations = $ids_variation;
                     $product->prix = $prix;
                     $product->token = $code;
                     $product->save();
                   }
                
                    // pour les produits à 5 variations.
                    $array10 =[];
                    $array11 =[];
                     $array12 =[];
                     $array13 =[];
                     $array14 =[];
                     $array15 =[];
                     $list =[];
                    foreach($ids_pr5 as $vlc){
                    $chainex5 = explode(',',$vlc['name']);
                    
                    $array10[] =[
                          'ids_product'=>$chainex5[0],
                          'libelle'=>$chainex5[5].' '.$chainex5[6],
                        ];
                        
                        $array11[] =[
                          'ids_product'=>$chainex5[1],
                          'libelle'=>$chainex5[5].' '.$chainex5[7],
                        ];
                        
                         $array12[] =[
                          'ids_product'=>$chainex5[2],
                          'libelle'=>$chainex5[5].' '.$chainex5[8],
                        ];
                        
                         $array13[] =[
                          'ids_product'=>$chainex5[3],
                          'libelle'=>$chainex5[5].' '.$chainex5[9],
                        ];
                        
                         $array14[] =[
                          'ids_product'=>$chainex5[4],
                          'libelle'=>$chainex5[5].' '.$chainex5[10],
                        ];
                        
                        
                    }
                
                $list5 = array_merge($array10,$array11,$array12,$array13,$array14);
               
                foreach($list5 as $vcd){
                     $prix="";
                    $ids_variation="";
                   $code = str_shuffle($token.$vcd['ids_product']);// create token unique ....
                   $product = new ProductWoocommerce();
                   $product->ids_product =$vcd['ids_product'];
                   $product->libelle = $vcd['libelle'];
                   $product->id_variations = $ids_variation;
                   $product->prix = $prix;
                   $product->token = $code;
                   $product->save();
                }
                
                 DB::table('variations_ids')->delete();
                
                // insert dans la table variations
                foreach($ids_product3 as $vf){
                   foreach($vf['ids_variation'] as $vm){
                     $ids = new VariationsId();
                     $ids->id_product =$vf['ids_product'];
                      $ids->ids_variation = $vm;
                       $ids->save();
                   }
                    
                }

                return true;

            } catch (Exception $e) {
                return $e->getMessage();
            }
             
                
      }

      public function getProductbarcode()
      {
        for($i=1; $i<10; $i++){
            // $customer_key = env('API_KEY_PUBLIC_WOOCOMERCE');
           //$customer_secret = env('API_KEY_PRIVATE_WOOCOMERCE');
             $customer_key = $this->api->getApikeywopublic();
            $customer_secret =$this->api->getApikeysecret();
          
             $urls="https://www.elyamaje.com/wp-json/wc/v3/products?customer_key=$customer_key&customer_secret=$customer_secret&page=$i&per_page=100";
            // recupérer des donnees orders de woocomerce depuis api
             $donnes = $this->api->getDataApiWoocommerce($urls);
             $donnees[] = array_merge($donnes);
         }
         
          // dd($donnees);
          $ids_product = []; // recupérer les ids de produits en variation
          // un delete 
           DB::table('productbarcodewcs')->delete();
         
            $barcode="";
            $barcodes="";
             foreach($donnees as $k => $values) {
             
              foreach($values as $vals){
                 
                  foreach($vals['meta_data'] as $valc){
                     
                         if(count($vals['variations'])==0){
                         if($valc['key']=="barcode"){
                             $barcode =$valc['value'];
                            
                          }
                   
                       $ids_product[] =[
                  
                       "ids_product"  =>$vals['id'],
                      'libelle'=> $vals['name'],
                      'ids_variation' => '',
                      'barcode'=>$barcode,
                       'prix'=>$vals['sale_price'],
                       'status'=> 'no',
                     
                      ];
                    
                    
                    // pour les table ids de variation de product
                      $ids_product3[] =[
                  
                       "ids_product"  =>$vals['id'],
                      'libelle'=> $vals['name'],
                      'ids_variation' => $vals['variations'],
                      'barcode'=>$barcode,
                       'prix'=>$vals['sale_price'],
                       'status'=>'no',
                     
                    ];
                    
                  }
                    
                    
                     if(count($vals['variations'])!=""){
                     
                     $variation ="true";
                     foreach($vals['attributes'] as $vd) {
                         
                         if($vd['variation']== true) {
                            $ids_prod[] = [
                          'ids_product'=>$vals['id'],
                          'libelle'=> $vals['name'],
                          'barcode' =>$vals['barcodes_list'],
                          'prix'=>$vals['sale_price'],
                          'ids_variation'=> $vals['variations'],
                          'attribute'=>$vd,
                          'status'=>'true',
                     
                      ];
                      
                     }
                  
                    }
                 }
                 
                }
                
              }
             
           
          }
           
           // produit en variation
          
          $array_da = array_unique(array_column($ids_product, 'libelle'));
          $coupon_data_uniques = array_intersect_key($ids_product ,$array_da);
          
           // gerer les variation à introduire dans le tableau
           $id_product ="";
           foreach($ids_prod as $vd) {
               
                $chaine = implode(',',$vd['ids_variation']);
               $chaine2 = implode(',',$vd['attribute']['options']);
                $chaines = implode(',',$vd['barcode']);// barcode autant
                
                    if(count($vd['attribute']['options'])==5){
                      $ids_pr5[] =[
                                'id_product'=>$vd['ids_product'],
                               'name'=> $chaine.','.$vd['libelle'].','.$chaine2,
                               
                               ];
                       }
                  
                      // qui ont 5 variation ...
                 if(count($vd['attribute']['options'])==5){
                      $ids_pr5[] =[
                                 'id_product'=>$vd['ids_product'],
                                'name'=> $chaine.','.$vd['libelle'].','.$chaine2.','.$chaines,
                                
                               
                               ];
                               
                      }
                      // produit qui ont 4 variations
                       if(count($vd['attribute']['options'])==4) {
                              
                              $ids_pr4[] =[
                               'id_product'=>$vd['ids_product'],
                                'name'=> $chaine.','.$vd['libelle'].','.$chaine2.','.$chaines,
                               
                               ];
                               
                       }
                       
                   // les produit qui ont variations 3
                  if(count($vd['attribute']['options'])==3) {
                      $ids_pr3[] =[
                                 'id_product'=>$vd['ids_product'],
                                'name'=> $chaine.','.$vd['libelle'].','.$chaine2.','.$chaines,
                               
                               ];
                               
                  }
                  
                   // les produit qui ont DEUX VARIATIONS
                 if(count($vd['attribute']['options'])==2) {
                      $ids_pr2[] =[
                                
                                 'id_product'=>$vd['ids_product'],
                                'name'=> $chaine.','.$vd['libelle'].','.$chaine2.','.$chaines,
                               
                               ];
                               
                  }
                  
                  
                  // les produit qui ont une variations
                   if(count($vd['attribute']['options'])==1) {
                      $ids_pr1[] =[
                                'id_product'=>$vd['ids_product'],
                               'name'=> $chaine.','.$vd['libelle'].','.$chaine2.','.$chaines,
                               
                               ];
                    }
                  }
                  
             // ecrire un token
                $token = Str::random(60);
               // insert le tatbleau dans product
               foreach($coupon_data_uniques as $val){
                  $code = str_shuffle($token.$val['ids_product']);// create token unique ....
                 $id_parent='';
                 $product = new Productbarcodewc();
                 $product->ids_product = $val['ids_product'];
                 $product->id_parent ='';
                 $product->libelle = $val['libelle'];
                 $product->barcode = $val['barcode'];
                 $product->prix = $val['prix'];
                 $product->status = $val['status'];
                 //$product->token = $code;
                 $product->save();
        
              }
              
               // insert les varaitions dans la table 
              // les produits ayant une varitations
              $status1="true";
             /* foreach($coupon_data_uniques1 as $vals) {
                  $prix="";
                  $ids_variation="";
                  $chainex = explode(',',$vals['name']);
                  $n =1;
                  
                      $code = str_shuffle($token.$chainex[0]);// create token unique ....
                     $product = new Productbarcodewc();
                     $product->ids_product = $chainex[0];
                      $product->libelle = $chainex[1].' '.$chainex[2];
                       $product->barcode = $chainex[3];
                      $product->prix = $prix;
                      //$product->token = $code;
                      $product->status = $status1.','.$n;
                       $product->save();
              }
              
              */
              
              // les produit ayant deux variations
              $array1 =[];
              $array2 =[];
              $list =[];
              foreach($ids_pr2 as $vlc) {
                  $chainex2 = explode(',',$vlc['name']);
                  
                     $array1[] =[
                        'ids_product'=>$chainex2[0],
                        'libelle'=>$chainex2[2].' '.$chainex2[3],
                        'barcode'=>$chainex2[5],
                        'id_parent'=>$vlc['id_product']
                      ];
                      
                      $array2[] =[
                        'ids_product'=>$chainex2[1],
                        'libelle'=>$chainex2[2].' '.$chainex2[4],
                        'barcode' =>$chainex2[6],
                        'id_parent'=>$vlc['id_product']
                      ];
                      
                  }
              
             $list = array_merge($array1,$array2);
             
            $array_da = array_unique(array_column($list, 'ids_product'));
             $coupon_data_uniques2 = array_intersect_key($list ,$array_da);
          
             
              // les produits ayant 3 variations
               foreach($coupon_data_uniques2 as $vcd) {
                   $prix="";
                  $ids_variation="";
                   
                 $code = str_shuffle($token.$vcd['ids_product']);// create token unique ....
                 $n=2;
                 $status="true";
                 $product = new Productbarcodewc();
                 $product->ids_product =$vcd['ids_product'];
                 $product->id_parent = $vcd['id_parent'];
                 $product->libelle = $vcd['libelle'];
                 $product->barcode = $vcd['barcode'];
                 $product->prix = $prix;
                 $product->status = $status.','.$n;
                 //$product->token = $code;
                 $product->save();
              }
              
              // les prduits ayant 3 variations
               $array3 =[];
               $array4 =[];
               $array5 =[];
               $list1 =[];
               
               
              foreach($ids_pr3 as $vl) {
                  $chainex3 = explode(',',$vl['name']);
                  $n=3;
                   $array3[] =[
                        'ids_product'=>$chainex3[0],
                        'libelle'=>$chainex3[3].' '.$chainex3[4],
                        'barcode'=>$chainex3[7],
                         'id_parent'=>$vl['id_product']
                      ];
                      
                      $array4[] =[
                        'ids_product'=>$chainex3[1],
                        'libelle'=>$chainex3[3].' '.$chainex3[5],
                        'barcode'=>$chainex3[8],
                         'id_parent'=>$vl['id_product']
                      ];
                      
                  
                   $array5[] =[
                        'ids_product'=>$chainex3[2],
                        'libelle'=>$chainex3[3].' '.$chainex3[6],
                        'barcode'=>$chainex3[9],
                        'id_parent'=>$vl['id_product']
                      ];
                   
                   
                      
            }
           
              $list1 =  array_merge($array3,$array4,$array5);
              
               $array_da = array_unique(array_column($list1, 'ids_product'));
             $coupon_data_uniques3 = array_intersect_key($list1 ,$array_da);
             
          
           
              foreach($coupon_data_uniques3 as $vcd){
                   $prix="";
                  $ids_variation="";
                   
                 $code = str_shuffle($token.$vcd['ids_product']);// create token unique ....
                 $status="true";
                 
                 $product = new Productbarcodewc();
                 $product->ids_product =$vcd['ids_product'];
                 $product->id_parent = $vcd['id_parent'];
                 $product->libelle = $vcd['libelle'];
                 $product->barcode = $vcd['barcode'];
                 $product->prix = $prix;
                 $product->status = $status.','.$n;
                 //$product->token = $code;
                 $product->save();
              }
              
          
               $array6 =[];
              $array7 =[];
               $array8 =[];
               $array9 =[];
              $list2 =[];
              
          
              
               foreach($ids_pr4 as $vl) {
                  $chainex3 = explode(',',$vl['name']);
                  $n=4;
                      $array6[] =[
                        'ids_product'=>$chainex3[0],
                        'libelle'=>$chainex3[4].' '.$chainex3[5],
                        'barcode'=>$chainex3[8],
                         'id_parent'=>$vl['id_product']
                      ];
                      
                      $array7[] =[
                        'ids_product'=>$chainex3[1],
                        'libelle'=>$chainex3[4].' '.$chainex3[6],
                        'barcode'=>$chainex3[9],
                         'id_parent'=>$vl['id_product']
                      ];
                      
                   $array8[] =[
                        'ids_product'=>$chainex3[2],
                        'libelle'=>$chainex3[4].' '.$chainex3[7],
                        'barcode'=>$chainex3[10],
                         'id_parent'=>$vl['id_product']
                      ];
                   
                     
            }
            
            
               $list2 =  array_merge($array6,$array7,$array8);
               
               $array_dav = array_unique(array_column($list2, 'ids_product'));
              $coupon_data_uniques4 = array_intersect_key($list2 ,$array_dav);
          
               
               foreach($coupon_data_uniques4 as $vcd) {
                   $prix="";
                  $ids_variation="";
                   
                 $code = str_shuffle($token.$vcd['ids_product']);// create token unique ....
                 $status="true";
                 $product = new Productbarcodewc();
                 $product->ids_product =$vcd['ids_product'];
                 $product->id_parent = $vcd['id_parent'];
                 $product->libelle = $vcd['libelle'];
                  $product->barcode = $vcd['barcode'];
                 $product->prix = $prix;
                 $product->status = $status.','.$n;
                 //$product->token = $code;
                 $product->save();
              }
              
               // pour les produits à 5 variations.
               $array10 =[];
              $array11 =[];
              $array12 =[];
              $array13 =[];
              $array14 =[];
              $array15 =[];
              $list =[];
              foreach($ids_pr5 as $vlc){
                  $chainex5 = explode(',',$vlc['name']);
                  $n=5;
                  
                 $array10[] =[
                        'ids_product'=>$chainex5[0],
                        'libelle'=>$chainex5[5].' '.$chainex5[6],
                        'barcode'=>'',
                         'id_parent'=>$vlc['id_product']
                      ];
                      
                      $array11[] =[
                        'ids_product'=>$chainex5[1],
                        'libelle'=>$chainex5[5].' '.$chainex5[7],
                        //'barcode'=>$chainex5[12],
                         'id_parent'=>$vlc['id_product']
                      ];
                      
                       $array12[] =[
                        'ids_product'=>$chainex5[2],
                        'libelle'=>$chainex5[5].' '.$chainex5[8],
                        'id_parent'=> $vlc['id_product'],
                        //'barcode'=>$chainex5[11]
                      ];
                      
                       $array13[] =[
                        'ids_product'=>$chainex5[3],
                        'libelle'=>$chainex5[5].' '.$chainex5[9],
                         'id_parent'=> $vlc['id_product'],
                        // 'barcode'=>$chainex5[12]
                      ];
                      
                       $array14[] =[
                        'ids_product'=>$chainex5[4],
                        'libelle'=>$chainex5[5].' '.$chainex5[10],
                         'id_parent'=> $vlc['id_product'],
                        //'barcode'=>$chainex5[13]
                      ];
                      
                      
                      
                      
                  }
              
              $list5 = array_merge($array10,$array11,$array12,$array13,$array14);
             
              
               $array_dass = array_unique(array_column($list5, 'libelle'));
               $coupon_data_uniques5 = array_intersect_key($list5 ,$array_dass);
          
             
              foreach($coupon_data_uniques5 as $vcd){
                   $prix="";
                  $ids_variation="";
                   
                 $code = str_shuffle($token.$vcd['ids_product']);// create token unique ....
                 $status="true";
                 $product = new Productbarcodewc();
                 $product->ids_product =$vcd['ids_product'];
                 $product->id_parent = $vcd['id_parent'];
                 $product->libelle = $vcd['libelle'];
                 $product->barcode = $vcd['barcode'];
                 $product->prix = $prix;
                 $product->status = $status.','.$n;
                 //$product->token = $code;
                 $product->save();
              }
              
              
              
                DB::table('variations_ids')->delete();
              
              // insert dans la table variations
              foreach($ids_product3 as $vf){
                 foreach($vf['ids_variation'] as $vm){
                   $ids = new VariationsId();
                   $ids->id_product =$vf['ids_product'];
                    $ids->ids_variation = $vm;
                    
                    $ids->save();
                 }
                  
              }
           



      }


      public function getdescid()
      {
         // recupérer le dernier id du customer chez
          // boucle sur le nombre de paginations trouvées..
          $customer_key = env('API_KEY_PUBLIC_WOOCOMERCE');
          $customer_secret = env('API_KEY_PRIVATE_WOOCOMERCE');

          $urls="https://www.elyamaje.com/wp-json/wc/v3/customers?orderby=id&order=desc&&consumer_key=$customer_key&customer_secret=$customer_secret&page=1&per_page=1";
          // recupérer des donnees orders de woocomerce depuis api
          $donnes = $this->api->getDataApiWoocommerce($urls);
          if($donnes){
            $donnees = array_merge($donnes);
          }
      
      return $donnees;

    }


     public function getcustomer()
     { 
            // recupérer le dernier id du customer chez
          // boucle sur le nombre de paginations trouvées..
          $customer_key = env('API_KEY_PUBLIC_WOOCOMERCE');
          $customer_secret = env('API_KEY_PRIVATE_WOOCOMERCE');

          $urls="https://www.elyamaje.com/wp-json/wc/v3/customers?orderby=id&order=desc&&consumer_key=$customer_key&customer_secret=$customer_secret&page=1&per_page=100";
          // recupérer des donnees orders de woocomerce depuis api
          $donnes = $this->api->getDataApiWoocommerce($urls);
          if($donnes){
            $donnees[] = array_merge($donnes);
          }

          // traiter les et mettre a jours la table
           // traiter les clients existant 
           $data =  DB::table('tiers_woocommerce')->select('email','customer_id')->get();
           $name_list = json_encode($data);
           $name_lists = json_decode($data,true);
           $result_data = [];
           foreach($name_lists as $key => $val){
             $result_data[$val['email']] = $key;
           }

            $resultat_data =[];
            foreach($donnees as $val){
               
              foreach($val as $values){
              
              if($values['role']=="customer"){

                if(isset($result_data[$values['email']])!=false){
                 $resultat_data[] =[
                  'name'=> $values['first_name'],
                  'prenom'=> $values['last_name'],
                  'customer_id'=>$values['id'],
                  'email'=> $values['email'],
                  'adresse'=> $values['billing']['address_1'],
                  'ville'=> $values['billing']['city'],
                  'pays'=> $values['billing']['country'],
                  'code'=> $values['billing']['postcode'],
                  'created_at'=> $values['date_created']
                  
                  ];
              }
             }
          }
       }
       
          $array_da = array_unique(array_column($resultat_data, 'email'));
          $coupons_data_uniques = array_intersect_key($resultat_data, $array_da);
          DB::table('tiers_woocommerce')->insert($coupons_data_uniques); 

          dd('succees');

    }

  }
      
   
     
