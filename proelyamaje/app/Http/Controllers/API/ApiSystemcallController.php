<?php

namespace App\Http\Controllers\API;

use File;
use Response;
use Carbon\Carbon;
use PHPUnit\Util\Exception;
use App\Imports\DatasImport;
use App\Models\Detailsvente;
use Illuminate\Http\Request;
use App\Models\Detailsresort;
use App\Exports\ProductExport;
use App\Exports\CustomerExport;
use App\Models\Historiquestock;
use Illuminate\Support\Facades\DB;
use App\Exports\EntrepotStockExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Service\CallApi\Apicall;
use App\Imports\StocksmouvementImport;
use App\Http\Service\FilePdf\CreateCsv;
use PhpOffice\PhpSpreadsheet\Writer\Csv;
use App\Http\Service\CallApi\Diffproduct;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use App\Http\Service\CallApi\GetDataOrders;
use App\Http\Service\CallApi\Misejoursstatuts;
use App\Repository\Category\CategorieRepository;
use App\Repository\Stocks\StocksmouvementRepository;
use App\Repository\Ambassadrice\AmbassadricecustomerRepository;
use App\Repository\Ambassadrice\Ordercustomer\OrderrefundedRepository;
use App\Repository\Ambassadrice\Ordercustomer\OrderambassadricecustomsRepository;

class ApiSystemcallController extends Controller
{

       private $api;
       
       private $getdataorder;
       
       private $amba;
       
       private $orders;
       
       private $category;

       private $diff;
       
       private $stocks;
       
       private $refunded;
       
       private $misejours;

       private $csv;

      public function __construct(Apicall $api, 
      GetDataOrders $getdataorder, 
      AmbassadricecustomerRepository $amba,
      OrderambassadricecustomsRepository $orders,
      CategorieRepository $category,
      StocksmouvementRepository $stocks,
       OrderrefundedRepository $refunded,
       Misejoursstatuts $misejours,
       Diffproduct $diff,
       CreateCsv $csv
      )
      {
         $this->api = $api;
         $this->getdataorder = $getdataorder;
         $this->amba = $amba;
         $this->orders = $orders;
         $this->category = $category;
         $this->stocks = $stocks;
         $this->misejours = $misejours;
         $this->diff = $diff;
         $this->csv = $csv;
      }
      
      public function data()
      {
       
       dd('zapo');
        // recupérer les dates et appel du service get data
         //$datas = $this->getdataorder->getDataorder();
         //shuffle($datas);
        // insert data
          //$this->customerRepository->insert();
          // dom afficher donnees
         // $data = $this->amba->getAllcustoms();
         
         $users = $this->orders->getCustomerAll();
          
          return view('api.orders', ['users'=>$users]);
      }

      
      
      
      // recupérer les order woocomerce avec un code promo
      public function codepromoapi()
      {
        
          $this->orders->insert();
          // redirection
          return redirect()->route('api.dataorders');
      }
      
      
      // recupérer les orders refunued ou cancelled
      
      public function codecancelled()
      {
          // recupérer les données 
          
      }
      
      
      public function statusmisejours()
      {
          
          $data = $this->misejours->getStatutscancelled();
          
      }
      
      public function datastocks()
      {
          // recupérer les données à traiter
         $message ="";
         $messages="";
          $data = $this->category->getAll();
           //Récuperer les données des users dans api dolibarr
           
      // $listproducts = json_decode($listproduct, true);
          return view('api.datastocks', ['data'=>$data, 'message'=>$message,'messages'=>$messages]);
      }
      


      public function exportventes(Request $request)
      {
          
        
          if($request->from_cron){
          $request->from_cron == "false" ? $from_cron = false : $from_cron = true;
        } else {
            $from_cron = true;
        }

        try{
          // recupérer les ventes dans un export de ventes.
          // recupérer les données de vente de dolibar
          $id_categorie = $request->get('id_categoris') ?? $request->post('id_categoris');
         
          $ids = $this->category->export_ventes($id_categorie);

          // recupérer les données de dolibar via les factures
          $donnes_data =  $this->diff->getFacturedol();
      
          $date_debut ="2022-07-01";
           $date_fin = "2022-10-01";
           
           // recupérer les mois souhaité
         $data_ventes =[];// recupérer les données des ventes souhaités.
        

         foreach($donnes_data as $valc){
              if($valc!=""){
             
              foreach($valc as  $vl) {

                  // convertir la date recupérer en format Y-m-d
                    $x = date('d-m-Y', $vl['date']);
                    // ajouter un jour $x
                    $x1  = date("Y-m-d", strtotime($x.'+ 1 days'));
                    // recupérer le mois 
                    $datet = explode('-',$x1);
                    $datx = $datet[1];

                    foreach($vl['lines'] as $valu){

                    if($vl['paye']==1) {
                      // recupérer les données respectant les id dans l'array et les date souhaité
                      if(in_array($valu['fk_product'], $ids)) {
                          $data_ventes []= $valu['fk_product'].','.$valu['qty'].','.$datx;
                          // recupére dans la bdd details vente;
                      }

                    }
                  }
           }
         
        }
        
         }
         
         
        // faire un delete 
         DB::table('detailsventes')->delete();  
         // un delete
         DB::table('detailsresorts')->delete();  
         // enregsitré les données dans la bdd
         foreach($data_ventes as $va){
             $valeur = explode(',',$va);
             
             $details = new Detailsvente();
             $details->id_product = $valeur[0];
             $details->mois = $valeur[2];
             $details->qty = $valeur[1];
             $details->number = $valeur[0].''.$valeur[2];// créer un nombre avec id et le mois 
             // recupérer les données souhaité.
             $details->save();
         }
         
          // aller chercher toutes les ventes lines des factures dont le fk_facture est dans le tableau.
          
         // travailler les données à importer
         // faire une requete scalaire sur la table
         $data =  Detailsvente::selectRaw("number,SUM(qty) as quantite")
          ->groupBy('number')
          ->orderBy("mois", "asc")
          ->get();
          
          // transformer les retour objets en tableau
          $name_list = json_encode($data);
          $name_lists = json_decode($data,true);// retour sous forme de tableau des ventes du mois.
          
         
          // recupérer le tableau associative entre label et id_product 
          // recupérer tableau associative entre id_product et stocks reel.
          $data_label = $this->category->getLabel();
          $data_stocks = $this->category->getStocks();
          
          // recupérer un tableau mois
          $array_mois =[];
          $donnees_final =[];
          $data_array = [];
          
          $stock_courant ="";
          
          // construire le tableau à renvoyés
         foreach($name_lists as $view) {
             $mois_cible = substr($view['number'],-2); // recupérer 
             
             $id_product_cible =  substr($view['number'],0,-2);// recupérer l'id du product
             
             // recupérer le mois à construire
             $mois =  $this->category->getMois($mois_cible);
             
             $array_mois[] = $mois;// recupérer les mois
             
             $label_product = array_search($id_product_cible,$data_label);// recupérer le product
             
             foreach($data_stocks as $ki => $valeur) {
                 if($ki == $id_product_cible) {
                     $stock_courant = $valeur;
                 }
             }
             
             $donnees_final[] = $mois.','.$label_product.','.$view['quantite'].','.$stock_courant;
             $data_array[] = [
                 
                    $label_product=>$view['quantite']
                 
                 ];
         }
         
         
        
        foreach($donnees_final as $vj){
            $dax = explode(',', $vj);
            
            $detail = new Detailsresort();
            $detail->libelle = $dax[1];
            $detail->mois = $dax[0];
            $detail->qty = $dax[2];
            $detail->stock_unique = $dax[3];
            
            $detail->save();
        }
         
    
         
         // afficher le tableau par famille produit
          $datas =  Detailsresort::all()->groupBy('libelle');
          // transformer les retour objets en tableau
          $name_li = json_encode($datas);
          $name_lis = json_decode($datas,true);
          
         // renvoyé un tableau
          $data_table=[];
          foreach($name_lis as $keys => $vas) {
              foreach($vas as  $vi) {
                  if($keys == $vi['libelle'])  {
                      $data_table[]= implode(',',$vi);
                          
                          
                  }
              }
          }
          
              // return le tableau 
              // construire les colones du csv à generé
         $array_csv = [];
         foreach($data_table as $donnes){
             $x1 =  explode(',', $donnes);
             $array_csv[] = array($x1[1],$x1[2],$x1[3],$x1[4]);
         }
         
          

          $data = ['name' => 'update_stocks_warehouse_dolibarr', 'origin' => 'connect', 'error' => 0,
          'message' => null, 'code' => null, 'from_cron' => $from_cron == false ? 0 : 1];
          $this->api->insertCronRequest($data, false);

          // télécharger le csv
          $this->csv->csvcreate($array_csv);

           
        } catch (Exception $e) {

              $data = ['name' => 'update_stocks_warehouse_dolibarr', 'origin' => 'connect', 'error' => 1,
              'message' => $e->getMessage(), 'code' => null, 'from_cron' => $from_cron == false ? 0 : 1];
              $this->api->insertCronRequest($data, false);
          }
        
      }
      
       // traiter la mise à jour du stocks via le fichier csv
       public function misejoursstocks(Request $request)
       {

          try{
              // recupérer les catégoris
            $file = $request->file('file');
            $data_category = $this->category->getAll();
             $list_product = $this->category->getProduct();
             $data_cron = $this->api->getCronRequest("origin", "connect");
              $cron = [];
              if(isset($data_cron['Crons'])){
                 foreach($data_cron['Crons'] as $key => $value) {
                    if(str_contains($value['name'], 'dolibarr')){
                      $value['updated_at'] = Carbon::parse($value['updated_at'])->isoFormat(' D MMMM Y à HH:mm');
                        $cron [$value['name']] = $value;
                }
              }
            }
            
              if(isset($file)){
           
                $datas = $this->api->uploadstock($file);
           
                if($datas == "denied"){
                   
                    //Récuperer les données des users dans api dolibarr
                    $message=" le fichier séléctionné n'est pas un csv, recommencer!";
                    $messages="";
                     return view('api.dolibarr', ['cron'=> $cron, 'data' => $data_category, 'list_product'=>$list_product, 'message'=>$message,'messages'=>$messages]);
                 }
           
               if($datas =="deni"){
                 $message="la taille du fichier est lourd moins de 1Mo acceptable !";
                 $messages="";
                 return view('api.dolibarr', ['cron'=> $cron, 'data' => $data_category, 'list_product'=>$list_product, 'message'=>$message,'messages'=>$messages]);
               }
               
                  // verifier que la table stocksmouvements est vide ou as des données
                  $donnees =$this->stocks->getAll();
             
                    if(count($donnees)!=0) {
                       // suprimer les ligne de la table pour les nouvelle données
                     $this->stocks->deletedata();
                   }
                  
                 // inserére les nouvelle données dans ma la table stocks mouvemnt
                 Excel::import(new StocksmouvementImport, $request->file('file'));
                // recupération des données dans l'api
                 $datas = $this->stocks->getAll();
                // insert les mouvement de stock de l'api
                 $data_donnees =[];
                 
                   // paramètre api
                   // parametre api 
                   //  $apikey = 'f2HAnva64Zf9MzY081Xw8y18rsVVMXaQ';
                    // $url = 'https://www.transfertx.elyamaje.com/api/index.php/stockmovements';

                     $apikey ='VA05eq187SAKUm4h4I4x8sofCQ7jsHQd';
                     $url = "https://www.poserp.elyamaje.com/api/index.php/stockmovements";
                     $label="";
                 
                 // ecrire le regex utilie pour va lider le csv
                 $id_product_regex ='/[0-9]{1,10000}/';
                 $wharehouse_id_regex = '/[0-9]{1,4}/';
                 $quantite_regex = '/[0-9]{1,5}/';
                 $mouvement_libelle ="Correction stocks Martial";
                 foreach($datas as  $values) {
                      if($values['id_product']!="id_product"){
                     
                        if($values['quantite']!=0 && $values['wharehouse_id']!=""){
                            $data_donnees[] =[
                           "product_id"=>$values['id_product'],
                           "warehouse_id"=> $values['wharehouse_id'],
                            "qty"=>$values['quantite'],
                            "price"=>$values['pmp'],
                            "inventorycode"=>$values['inventorycode'],
                            "movementlabel"=>$mouvement_libelle,
                            "fk_user_author"=>1,
                         
                         ];
                      }  
                    
                   }
                 
                 }
                
                 
                 foreach($data_donnees as $key => $val){
                    // insert de stocks mouvement dans api stockmouvement dolibar
                      $this->api->insertDatadolibarr($url,$apikey,$val);
                 }
                  
                  // garder les historiques de moouvemnts dans une table mysql...
                    $date = date('Y-m-d');
                    $details = "l'importation du  fichier $file-$date à crée un mouvements de stocks  dans dolibar";
                   $historique =  new Historiquestock();
                   $historique->details = $details;
                   $historique->date = $date;
                   $historique ->save();
                 
                   //Récuperer les données des users dans api dolibarr
                      $message="";
                      if(count($data_donnees)!=0) {
                         $line = count($data_donnees);
                         if($line ==1) {
                           $messages=" $line Produit a été bien affecté sur le stocks dolibarr !";
                         }
                         
                         if($line > 2 OR $line==2) {
                             $messages ="$line Produits ont étés affectés sur le stocks dolibarr !";
                         }
                      
                      }
                      
                      else{
                          
                          $messages ="Aucun mouvement de stocks à été effectué";
                      }
                     return view('api.dolibarr', ['cron'=> $cron, 'data' => $data_category, 'list_product'=>$list_product,'message'=>$message,'messages'=>$messages]);
           
           }
           else{
                 $message="Choisir un fichier csv pour impoter vos données !";
                 $messages="";
                 return view('api.dolibarr', ['cron'=> $cron, 'data' => $data_category, 'list_product'=>$list_product,'message'=>$message,'messages'=>$messages]);
               }

               $data = ['name' => 'import_stock_with_file_dolibarr', 'origin' => 'connect', 'error' => 0,
              'message' => null, 'code' => null, 'from_cron' => 0];
              $this->api->insertCronRequest($data, false);
           
          } catch (Exception $e) {

            $data = ['name' => 'import_stock_with_file_dolibarr', 'origin' => 'connect', 'error' => 1,
            'message' => $e->getMessage(), 'code' => null, 'from_cron' => 0];
            $this->api->insertCronRequest($data, false);
          }
           
       }
      

      
      public function misejourpmp(Request $request)
      {
          // recupérer les catégoris
          // Rcupérer id_categorie
          $id_categorie = $request->get('id_categoris');
          
          // valuer optinelle pmp
          $pmp = $request->get('pmp');
          
          if(!empty($pmp)) {
             // recupérer les données
             $array = $this->category->getproductpmp($id_categorie);
             // parametre api 
             $apikey = "9W8P7vJY9nYOrE4acS982RBwvl85rlMa";
             $url = "https://www.poserp.elyamaje.com/api/index.php/stockmovements";
             //données à update
              $data =[
                    
                    "product_id"=>4660,
                   "warehouse_id"=> 1,
                    "qty"=>25,
                   "movementlabel"=>"correction des vsp de elyamaje par Martial",
                   "fk_user_author"=>1,
                 
                  ];
               
             
                $this->api->insertDatadolibarr($url,$apikey,$data);
                // faire un update sur les articles
               
             }
           $data = $this->category->getAll();
           $message="";
           $messages="La mise à jours du stocks à bien réussi";
            return view('api.datastocks', ['data'=>$data,'message'=>$message,'messages'=>$messages]);
      }
      
      
      public function exportstocks(Request $request)
      {
            if($request->from_cron){
            $request->from_cron == "false" ? $from_cron = false : $from_cron = true;
        } else {
            $from_cron = true;
        }

          // traiter des données et tiré le csv
          $donnees = $this->category->getAllproduct();
          
          // Rcupérer id_categorie
          $id_categorie = $request->get('id_categoris') ?? $request->post('id_categoris');

          try{

              // recupérer les données du tableau pour update api
              if(count($donnees)!=0) { // suprime les données dans bdd
                  $this->category->deletedata();
                  // insert des données 
                  $this->category->getdataapiproducts($id_categorie);
              } else{
                  // inset des données et tiré le csv
                  $this->category->getdataapiproducts($id_categorie);
              }

              $data = ['name' => 'update_stocks_dolibarr', 'origin' => 'connect', 'error' => 0,
              'message' =>  null, 'code' => null, 'from_cron' => $from_cron == false ? 0 : 1];
              $this->api->insertCronRequest($data, false);

              return Excel::download(new ProductExport, 'Product_categorie.csv');

          } catch (Exception $e) {

              $data = ['name' => 'update_stocks_dolibarr', 'origin' => 'connect', 'error' => 1,
              'message' => $e->getMessage(), 'code' => null, 'from_cron' => $from_cron == false ? 0 : 1];
              echo $this->api->insertCronRequest($data);
          }




        
      }
      
      
      
      public function entrepotstock(Request $request)
      {
           $id_categoris = $request->get('id_categoris');
            $this->category->deleteentrepot();
              // insert nouvelle data
               $data = $this->category->getsotckentrepot($id_categoris);
              //
         
         return Excel::download(new EntrepotStockExport, 'entrepot_stocks_product.csv');
        
      }
      
      
      public function filecsv()
      {
         // recupérer un téléchargement de csv file. 
          return Excel::download(new CustomerExport, 'customerdata.csv');
      }
      
      public function importscsv(Request $request)
      {
         // recupérer un téléchargement de csv file. 
           Excel::import(new DatasImport, $request->file('file'));
        return back();
      }
      
   
}
   
   
