<?php

namespace App\Repository\Category;

use App\Models\Categorie;
use App\Models\Product;
use App\Models\Productdol;
use App\Models\EntrepotStock;
 use App\Http\Service\FilePdf\CreateCsv;
use Illuminate\Support\Facades\DB;
use App\Http\Service\CallApi\Apicall;
use Carbon\Carbon;
use Hash;

class CategorieRepository implements CategorieInterface
{
     
     private $model;
      private $api;
      private $stock = [];
      private $label = [];
      private $donnes =[];// recupérer les données update pmp api
      private $product = [];
      private $list =[];
      
    public function __construct(Categorie $model, 
    Apicall $api,
    CreateCsv $csv)
    {
      $this->model = $model;
      $this->api = $api;
      $this->csv  = $csv;
    }


    
    /**
   * @return array
    */
   public function getDonnes(): array
   {
      return $this->donnes;
   }
   
   
   public function setDonnes(array $donnes)
   {
     $this->donnes = $donnes;
    return $this;
   }
   
   
   public function getdatas()
   {
       return $this->getDonnes();
   }


     /**
   * @return array
    */
    public function getProduct(): array
    {
       return $this->product;
    }
    
    
    public function setProduct(array $product)
    {
      $this->product = $product;
      return $this;
    }


     /**
   * @return array
    */
   public function getList(): array
   {
      return $this->list;
   }
   
   
   public function setList(array $list)
   {
     $this->list = $list;
    return $this;
   }
    

   public function geturlapi()
   {
        $urls ="https://www.poserp.elyamaje.com/api/index.php/products?sortfield=t.ref&sortorder=ASC&limit=2500";
         return $urls;
    }

    
    public function getAll()
    {
         $name_list = DB::table('categories')->select('rowid','label')->get();
         $name_lists = json_encode($name_list);
         $name_lists = json_decode($name_list,true);

         $list =[];// initialiser un array retour

         foreach($name_lists as $values){
            $chaine = $values['label'].'-'.$values['rowid'];
            $list[$chaine] = $values['rowid'];
         }
        
         $this->setList($list);
         // recupérer les product et id...
         $name_lis = DB::table('product_dolibars')->select('id_product','libelle')->get();
         $name_liss = json_encode($name_lis);
         $name_liss = json_decode($name_lis,true);

         $this->setList($list);
         $this->setProduct($name_liss);
          return $name_lists;
        
    }
    
    
   public function  getAllproduct()
   {
         $name_list = DB::table('products')->select('id_product')->get();
         $name_lists = json_encode($name_list);
         $name_lists = json_decode($name_list,true);
         return $name_lists;
   }
    
    public function getdata()
    {
         $name_list = DB::table('categorie_products')->select('fk_categorie','fk_product')->get();
         $name_lists = json_encode($name_list);
        $name_lists = json_decode($name_list,true);
        
        foreach($name_lists as $values){
            $array_list[]= [
                 $values['fk_categorie']=>$values['fk_product']
                
                ];
            
        }
        
        return $array_list;
    }

      public function datalistcat($id_cat)
      {
          // recupérer les données id_invoices deja dans la table
          $donnees_product =  DB::table('categorie_products')->select('fk_product')->where('fk_categorie','=',$id_cat)->get();
          $lists = json_encode($donnees_product);
          $lists = json_decode($donnees_product,true);

          $array_product =[];// les products dont la categoris est choisis.
               foreach($lists as $kl => $val){
                 $array_product[$val['fk_product']] = $kl;
                 $array_id[] = $val['fk_product'];
               }

           return $array_id;

      }

      public function listdatacatis(){
        
         // recupérer les données id_invoices deja dans la table
         $donnees_product =  DB::table('categorie_products')->select('fk_product')->get();
         $lists = json_encode($donnees_product);
         $lists = json_decode($donnees_product,true);
          $array_product =[];// les products dont la categoris est choisis.
              foreach($lists as $kl => $val){
                $array_product[$val['fk_product']] = $kl;
                $array_id[] = $val['fk_product'];
              }

          return $array_id;

    }
        
    
    
    public function deletedata()
    {
        DB::table('products')->delete();
    }
    
    
    
    public function deleteentrepot()
    {
        
        DB::table('entrepot_stocks')->delete();
    }
    
    
     
    public function export_ventes($id_categorie) // périodique;
    {
        
       // recupérer tous les id product de la categoris
       // information de la cle api
       $dolaapikey ="9W8P7vJY9nYOrE4acS982RBwvl85rlMa";
       $urls = $this->geturlapi();
        // recupération des données de l'api dolibar
       $curl = curl_init();
       $httpheader = ['DOLAPIKEY: '.$dolaapikey];
  
       curl_setopt($curl, CURLOPT_URL, $urls);
       curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
       curl_setopt($curl, CURLOPT_HTTPHEADER, $httpheader);
       $result = curl_exec($curl);
        curl_close($curl);
       // transformer en array les données
        $data =  json_decode($result,true);
       
          // alller recupérer tous id de product de la meme categoris
          // créer un tableau associatif entre le id et tableau assiation
          
          $array_product = []; // tableau association entre les id et et le label product
          $array_id_product =[];// recupérer tous les id product de la categoris 
          $array_stocks = [];// tableau associative entre id_product et stocks
       
         foreach($data as $k => $values){
           
             foreach($this->getdata() as $k => $valus){
            
              foreach($valus as $key => $val){
                
                 // relation entre la variable passés pour recupérer les produit avec le champs indiquée!
                 if($id_categorie == $key) {
                     if($values['id'] == $val){
                     
                        $array_product[$values['label']]= $values['id'];
                         $array_id_product[] = $values['id'];
                          $array_stocks[$values['id']] =$values['stock_reel'];
                            
                     }
                   }
              
                      // créer un tableau pour récupérer les données
                     // insert dans la bdd les élements
                 }
              }
               // recupérer les tableau associative
               $this->setLabel($array_product);
               $this->setStocks($array_stocks);
            
          }
          
              return $array_id_product;
          
        }

       public function getLabel(): array
       {
          return $this->label;
       }
    

       public function setLabel(array $label)
       {
          $this->label = $label;
          return $this;
       }


       public function getStocks(): array
       {
          return $this->stocks;
       }
       
       
       public function setStocks(array $stocks)
       {
         $this->stocks = $stocks;
        return $this;
       }
       
    
    
    public function getdataapiproducts($id_categorie)
    {
        
       // information de la cle api
        $dolaapikey = env('KEY_API_DOLIBAR_PROD');
        $urls = $this->geturlapi();
            
         // recupération des données de l'api dolibar
          $curl = curl_init();
          $httpheader = ['DOLAPIKEY: '.$dolaapikey];
     
          curl_setopt($curl, CURLOPT_URL, $urls);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($curl, CURLOPT_HTTPHEADER, $httpheader);
          $result = curl_exec($curl);
           curl_close($curl);
          // transformer en array les données
           $data =  json_decode($result,true);
            $array_product =[];
           // boucler sur les articles
           // créer un tableau de ligne une 1 ère ligne du tableau
           $array_line_first [] =[
            'id_product'=> 'id_product',
            'warehouse_id' =>'warehouse_id',
            'quantite'=>'quantite',
            'label' => 'description',
            'inventorycode'=>'inventorycode',
            'ref' => 'reference',
            'stock_reel' =>'stock_reel',
            "pmp" => 'pmp',
            'user' =>'utilisateur',
            
            ];
            
              
            $user=1;
            $quantite =0;
            $war ="";
            $label = "";
            $pmp  = 1.0000001;
            $inventorycode="";
            $bar_code ="bar_code";
            foreach($data as $k => $values) {
              
                foreach($this->getdata() as $k => $valus) {
               
                 foreach($valus as $key => $val) {
                   // relation entre la variable passés pour recupérer les produit avec le champs indiquée!
                    if($id_categorie == $key){
                        if($values['id'] == $val) {
                                 $array_product[]=[
                                 'id_product' =>$values['id'],
                                 'warehouse_id'=>$war,
                                 'quantite' => $quantite,
                                'label' => $values['label'],
                                'inventorycode'=>$inventorycode,
                                'ref' => $values['ref'],
                                'pmp'=> $pmp,
                                'stock_reel' => $values['stock_reel'],
                                'user'  => $user,
                                'barcode'=>$values['barcode']
                                
                                ];
                               
                          }
                      }
                 
                    // créer un tableau pour récupérer les données
                     // insert dans la bdd les élements
                    
                 }
                }
               
               // inserer les données
               
               //$productdol = new Productdol;
               //$productdol->nom_produit = $values['label'];
               //$productdol->ref = $values['ref'];
               
               //$productdol->save();
               
             }
              // renvoyer un tableau associative  unique par email
              $array_data = array_unique(array_column($array_product, 'id_product'));
              $array_data_unique = array_intersect_key($array_product, $array_data);
               // insert la ligne dans le product
            
            foreach($array_line_first as $kc => $val){
                $product = new Product();
                $product->id_product = $val['id_product'];
                $product->quantite = $val['quantite'];
                $product->warehouse_id = $val['warehouse_id'];
                $product->label = $val['label'];
                $product->inventorycode = $val['inventorycode'];
                $product->ref = $val['ref'];
                $product->pmp = $val['pmp'];
                $product->stock_reel = $val['stock_reel'];
                $product->user = $val['user'];
                $product->barcode = $bar_code;
                 $product->save();
                 
             }
            
             foreach($array_data_unique as $kl => $vals){
                 
                $product = new Product();
                $product->id_product = $vals['id_product'];
                $product->warehouse_id = $war;
                $product->quantite = $quantite;
                $product->label = $vals['label'];
                $product->inventorycode = $inventorycode;
                $product->ref = $vals['ref'];
                $product->pmp = $vals['pmp'];
                $product->stock_reel = $vals['stock_reel'];
                $product->user = $vals['user'];
                $product->barcode = $vals['barcode'];
                 $product->save();
                           
                 
             }
             
              // recupere la table
             // recupérer tous les produits et leur ref dolibar.
        }
       
       
       
       public function getproductpmp($id_categorie)
       {
            // information de la cle api
           $dolaapikey = env('KEY_API_DOLIBAR_PROD');
           $urls = $this->api->geturlapi();
            
         // recupération des données de l'api dolibar
          $curl = curl_init();
          $httpheader = ['DOLAPIKEY: '.$dolaapikey];
     
          curl_setopt($curl, CURLOPT_URL, $urls);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($curl, CURLOPT_HTTPHEADER, $httpheader);
          $result = curl_exec($curl);
           curl_close($curl);
            // transformer en array les données
             $data =  json_decode($result,true);
             $array_product =[];
             // boucler sur les articles
             // créer un tableau de ligne une 1 ère ligne du tableau
             $array_line_first [] =[
                    'id_product'=> 'id_product',
                    'quantite'=> 'quantite',
                   'warehouse_id' =>'warehouse_id',
                  'label' => 'nom_produit',
                  'inventorycode'=>'inventorycode',
                  'ref' => 'reference',
                  'stock_reel' =>'stock_reel',
                  "pmp" => 'pmp',
                  'user' =>'utilisateur',
                  'libelle'=>'libelle',
                  'barcode'=>'barcode'
              
              ];
              
              
                $user =1;
                $quantite ='';
                $war ='';
                // recupérer les données 
                
          
             foreach($data as $k => $values) {
              
                foreach($this->getdata() as $k => $valus) {
               
                 foreach($valus as $key => $val){
                    // relation entre la variable passés pour recupérer les produit avec le champs indiquée!
                    if($id_categorie == $key){
                        if($values['id'] == $val) {
                         $array_product[]=[
                               
                               'id_product' =>$values['id'],
                               'quantite' => $quantite,
                                'warehouse_id'=>$war,
                               'label' => $values['label'],
                               'inventorycode'=>$values['inventorycode'],
                               'ref' => $values['ref'],
                               'pmp'=> $values['pmp'],
                               'stock_reel' => $values['stock_reel'],
                               'user'  => $user,
                               'libelle'=>$values['label'],
                               'barcode'=>$values['barcode']
                               
                               ];
                               
                          }
                     
                 }
                 
                   // créer un tableau pour récupérer les données
                     // insert dans la bdd les élements
                     }
                 }
               }
             
             // renvoyer un tableau associative  unique par email
              $array_data = array_unique(array_column($array_product, 'id_product'));
              $array_data_unique = array_intersect_key($array_product, $array_data);
              
             return $array_data_unique;
           
       }
       
       
       
       
       public function getsotckentrepot($id_categoris)
       {
           $dolaapikey = env('KEY_API_DOLIBAR_PROD'); // clé Api.
          // recupérer les wharehouse de l'activité
           $url = "https://www.poserp.elyamaje.com/api/index.php/warehouses?sortfield=t.rowid&sortorder=ASC&limit=20";
         
          $curls = curl_init();
          $httpheader = ['DOLAPIKEY: '.$dolaapikey];
     
          curl_setopt($curls, CURLOPT_URL, $url);
          curl_setopt($curls, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($curls, CURLOPT_HTTPHEADER, $httpheader);
          $results = curl_exec($curls);
           curl_close($curls);
          // transformer en array les données
           $data_wharehouse =  json_decode($results,true);
            $list_wharehouse = [];
            $libelle = [];// regrouper les entrepot.
          foreach($data_wharehouse as $ky => $vals){
              
              $id = $vals['id'].','.$vals['libelle'];
              $list_wharehouse[$id] = $vals['id'];
              $list[$vals['libelle']] = $vals['id'];
              $libelle[] = $vals['libelle'];
          }
           
          arsort($list_wharehouse);

          $urls = $this->geturlapi();
           // recupération des données de l'api dolibar
          $curl = curl_init();
          $httpheader = ['DOLAPIKEY: '.$dolaapikey];
     
          curl_setopt($curl, CURLOPT_URL, $urls);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($curl, CURLOPT_HTTPHEADER, $httpheader);
          $result = curl_exec($curl);
           curl_close($curl);
          // transformer en array les données
           $data =  json_decode($result,true);
           // recupére rles ids product
           $id_product_api =[];
            // créer un tableau de ligne une 1 ère ligne du tableau
             $array_line [] =[
               'id_product'=> 'id_product',
               'quantite'=> 'quantite',
               'entrepot' =>'entrepot',
               'ref_product'=>'ref_product',
               'details'=>'details'
              
             ];
              
            $data_ref = []; // reference 
           foreach($data as $kl=>$vli) {
               $id_product_api[] = $vli['id'];
               
               $chaine = $vli['ref'].'-'.$vli['id'];
               $data_ref[$chaine] = $vli['id'];
           }


           // cibler id de la categoris et le libelle.
          $cats = DB::table('categorie_products')->select('fk_product','fk_categorie')->get();
           $data_cat = json_encode($cats);
           $data_cat = json_decode($cats,true);
            // recupérer
            $regroup_data =[] ; 
            $game =[];
            foreach($data_cat as $values){
                         
             $chaine = $values['fk_product'].','.$values['fk_categorie'];
              $regroup_data[$chaine] = $values['fk_product'];
            
            }
   
              // categories 
             $categoris = DB::table('categories')->select('rowid','label')->get();
             $f_cat = json_encode($categoris);
             $f_cat = json_decode($categoris,true);
             $game =[];
              foreach($f_cat as $valus){
                 $chaine = $valus['rowid'].','.$valus['label'];
                 $game[$chaine] = $valus['rowid'];
                
            }
   

        // recupérer les ..
          if($id_categoris!="32x") {
            $list_details = $this->datalistcat($id_categoris);
            $chaine_id_product = implode(',',$list_details);
            $products = DB::connection('mysql2')->select('SELECT * FROM llxyq_product_stock WHERE fk_product IN ('.$chaine_id_product.') ORDER BY fk_entrepot ASC');
          }else{
             
            $list_details = $this->listdatacatis();
            $products = DB::connection('mysql2')->select('SELECT * FROM llxyq_product_stock');
          }

        
           $datas = json_encode($products);
           $datas = json_decode($datas,true);

           $table_product =[];

           foreach($datas as $vac){
              $table_product[$vac['fk_entrepot']][] = $vac['fk_product'];
           }

           $fk_entrepot1 = 6; //malpasse
          $entrepot_malpasse =[];
          $entrepot_autre =[];
          $entrepot_malpasses =[];
           foreach($table_product as $key => $vm){
              if($key==6){
                  $entrepot_malpasse = $vm;
                }else{

                    $entrepot_autre =[];
                }
           }
          //fk_entrepot 
          
           $array_data_csv = [];
           // tableau $libelle
           $data_x =[];

           foreach($datas as $vals) {
             foreach($libelle as $vl){
              $data_x[$vals['fk_product']][] =[
                'id_product'=>$vals['fk_product'],
                'entrepot' => $vl,
                'reel' => 0
                ];

              }
           }

        
        // recupérer les ids qui ont ont au moins un chiffre en stocks
            $array_data_product_exist =[];
            $id_c = "";
            $libelles ="";
           foreach($datas as $val){
            $array_data_product_exist[] = $val['fk_product'];
            // recupérer la categoris
            $id_cat = array_search($val['fk_product'],$regroup_data);
            if($id_cat!=false){
              $ids_cat = explode(',',$id_cat);
              $id_c = $ids_cat[1];

            }
             
             $label =  array_search($id_c,$game);
             if($label!=false){
                  $labels = explode(',',$label);
                  $libelles = $labels[1];
             }

             $array_data[] =[
                'id_product' =>$val['fk_product'],
               'entrepot' => array_search($val['fk_entrepot'],$list),
                'quantite' => $val['reel'],
                'ref_product'=> array_search($val['fk_product'],$data_ref),
                'categorie_name'=>$libelles
             ];

               
           }

            $data_ids =  array_unique($array_data_product_exist);
            // recupérer tous les produits qui sont à zero
            $product_diff = array_diff($list_details,$entrepot_malpasse);


              $array_product_null =[];

              foreach($product_diff as $valc){

                $id_cats = array_search($valc,$regroup_data);
                if($id_cats!=false){
                  $ids_cats = explode(',',$id_cats);
                  $id_cs = $ids_cats[1];
                }
             
                 $labels =  array_search($id_cs,$game);
                 if($labels!=false){
                   $labelss = explode(',',$labels);
                   $libelless = $labelss[1];
                }

                   $array_product_null[] =[
                   'id_product' =>$valc,
                   'entrepot' => 'Entrepôt Malpassé',
                   'quantite' => 0,
                   'ref_product'=> array_search($valc,$data_ref),
                   'categorie_name'=>$libelless
                ];
   

              }

        
            
          
           $x = array_merge($data_x,$array_data);
          
            $data_result = array_merge($array_data,$array_product_null);

           $this->csv->csvcreateentrepot($data_result);

           
      
           // créer un tableau associative entre le libelle et leur id......
           // recupérer les different stocks dans les entrepot
            // recupérer les stocks souhaite
           // information de la cle api recupérer les produits
        
           $urls = $this->geturlapi();
            
           // recupération des données de l'api dolibar
          $curl = curl_init();
          $httpheader = ['DOLAPIKEY: '.$dolaapikey];
     
          curl_setopt($curl, CURLOPT_URL, $urls);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($curl, CURLOPT_HTTPHEADER, $httpheader);
          $result = curl_exec($curl);
           curl_close($curl);
          // transformer en array les données
           $data =  json_decode($result,true);
           // recupére rles ids product
           $id_product_api =[];
            // créer un tableau de ligne une 1 ère ligne du tableau
             $array_line [] =[
              
              'id_product'=> 'id_product',
              'quantite'=> 'quantite',
              'entrepot' =>'entrepot',
              'ref_product'=>'ref_product',
              'details'=>'details'
              
              
              ];
              
            $data_ref = []; // reference 
           foreach($data as $kl=>$vli) {
               $id_product_api[] = $vli['id'];
               
               $chaine = $vli['ref'].'-'.$vli['id'];
               $data_ref[$chaine] = $vli['id'];
           }
            
           foreach($id_product_api as $valc){
                
                  $geturl ="https://www.poserp.elyamaje.com/api/index.php/products/$valc/stock";
                 $cur = curl_init();
                  $httpheader = ['DOLAPIKEY: '.$dolaapikey];
                  curl_setopt($cur, CURLOPT_URL, $geturl);
                 curl_setopt($cur, CURLOPT_RETURNTRANSFER, 1);
                 curl_setopt($cur, CURLOPT_HTTPHEADER, $httpheader);
                 $resuls = curl_exec($cur);
                 curl_close($cur);
              
                 // transformer en array les données
                $data_list[$valc] =  json_decode($resuls,true);
              
             }

         // filter l'array.
              foreach($data_list as $lm => $values_array) {
                 if(count($values_array)==1){
                     foreach($values_array as $kj =>$vla){
                         
                         foreach($vla as $kn => $vlue) {
                              // recupérer le libéllé de l'entrepot
                             $libelle_l = array_search($kn,$list_wharehouse);
                             $l =  explode(',',$libelle_l);
                             
                             $x = $l[1].','. $lm.','.$vlue['real'];
                              $data_list1[$x]=$lm;
                             
                         }
                    }
                }
             }
             
           // dd($data_list1);
           $list_details = $this->datalistcat($id_categoris);

             $data_result_entrepot =[];
             foreach($data_list1 as $kyes => $valo) {
                  // recupérer les relation avec id categories
                   if(isset($list_details[$valo])==true){
                     $ref = array_search($valo,$data_ref);
                         $data_result_entrepot[] = $kyes.','.$ref;
               }
            }
            
        
            // faire un jeu de données avec entrepot
            $array_donnes = array('Entrepôt Homebox Marseille','Entrepôt Préparation','Boutique Nice','Elyamaje boutique');
            
             foreach($data_result_entrepot as $value){
                     $chaine = explode(',',$value);

                $array_data_csv[]=[
                   'id_product' => $chaine[1],
                   'entrepot' => $chaine[0],
                   'quantite' => $chaine[2],
                   'ref_product'=> $chaine[3]

                ];
                
                 
                 //$details[] = $chaine[0].','.$chaine[2].','.$chaine[1].','.$chaine[3];
             }
             

             $this->csv->csvcreateentrepot($array_data_csv);
             dd('succees');
             $details =[];
                     // tirer le csv 
                    // recupérer les données et les flush dans les bdd.
             /*
                     foreach($array_line as  $valis){
                              $entrepot = new EntrepotStock();
                              $entrepot->id_product = $valis['id_product'];
                              $entrepot->entrepot = $valis['entrepot'];
                              $entrepot->qte = $valis['quantite'];
                              $entrepot->ref_product = $valis['ref_product'];
                              $entrepot->details = $valis['details'];
                              $entrepot->save();
                     }
                     
                      // recupérer les données dans la bdd
                       foreach($data_result_entrepot as $data_chaine){
                         $va = explode(',',$data_chaine);
                         // recupérer les données.
                          $entrepot =  new EntrepotStock();
                          $entrepot->id_product = $va[1];
                          $entrepot->entrepot = $va[0];
                          $entrepot->qte = $va[2];
                          $entrepot->ref_product = $va[3];
                          $entrepot->details = $va[0].' '.$va[2];
                         
                           $entrepot->save();
                         
                     }
                   
                     dd('succes');
                

                     
                    // requete agreagt sql
                 /* $data_details = DB::table('entrepot_stocks')
                  ->select(DB::raw("id_product,GROUP_CONCAT(details) as `details_entrepot`"))
                  ->groupBy('id_product')
                  ->get();
                
                   $list_details =json_encode($data_details);
                   $list_detail = json_decode($data_details,true);
                   dd($list_detail);

                   $list_datas =[];
                  
                  foreach($list_detail as $valeur){
                      $id_product = $valeur['id_product'].','.$valeur['details_entrepot'];
                      $list_datas[$id_product] = $valeur['id_product'];
                  }
                  
                   unset($list_datas['id_product,details']);
                   return $list_datas;
              */

                 // créer un jeu de données d'affichage csv
                

                 

            }


            public function getMois($moi)
            {
             
               if($moi=="01") {
                   $mo ="Janvier";
               }
               
               if($moi=="02"){
                   $mo="février";
               }
               
               if($moi=="03"){
                   $mo ="Mars";
               }
               
               if($moi=="04"){
                   $mo="Avril";
               }
               
               if($moi=="05"){
                   $mo ="Mai";
               }
               
               if($moi=="06"){
                   $mo="Juin";
               }
               
               if($moi=="07"){
                   $mo="Juillet";
               }
               
               if($moi=="08"){
                   $mo="Aout";
               }
               
                if($moi=="09"){
                   $mo="Septembre";
               }
               
               if($moi=="10"){
                   $mo="Octobre";
               }
               
               if($moi=="11"){
                   $mo="Novembre";
               }
               
               if($moi=="12")
               {
                   $mo="Decembre";
               }
               
               
               return $mo;
           }
                 
                 
    }
    
    