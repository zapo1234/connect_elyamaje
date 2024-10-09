<?php
// recuperer des utilitaires
namespace App\Http\Service\CallApi;

use Exception;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Repository\Caissenice\CaisseniceRepository;
use Automattique\WooCommerce\HttpClient\HttpClientException;

class Importrecette
{
     private $api;
      public function __construct(Apicall $api,
      CaisseniceRepository $caisse
       
        )
       {
         $this->api=$api;
         $this->caisse = $caisse;// 
        
       }


    public function importrecette()
    {
        // recupere les recette journalières internet recette, internet boutique, internet nice , marseille.
            // recupérer les factures étidé sur nice !
            $method = "GET";
            $apiKey = env('KEY_API_DOLIBAR_PROD');
            $apiUrl = env('KEY_API_URL_PROD');
          //Recuperer les ref et id product dans un tablea
          //Recuperer les ref_client existant dans dolibar
          //verifié l'unicité
          $list_id_order = [];
          $produitParam = ["limit" =>350, "sortfield" => "rowid", "sortorder" => "DESC", ];
          $listorders_id = $this->api->CallAPI("GET", $apiKey, $apiUrl."invoices", $produitParam);//
          $list_id = json_decode($listorders_id,true);
         $chaine="TC4-";
         $data_nice =[];
         $data_marseille =[];
         $data_internet = [];
         $internet = [];
         $chaine1 ="TC1-";
         $chaine2 ="TC6-";
         $chaine3 = "TC2-";
         $chaine4 = "TC3-";
         $chaine5="TC5";
         $chaine6 ="FA";

          $y =[];

       if($list_id){
        foreach($list_id as $k=>$vals) {
            $y[] = $vals['ref'];
           if($vals['mode_reglement_code']=="CB" OR $vals['mode_reglement_code']=="LIQ" OR $vals['mode_reglement_code']=="PRE" OR $vals['mode_reglement_code']=="PAYP" OR $vals['mode_reglement_code']=="STRIP" OR
             $vals['mode_reglement_code']=="SCALA" OR $vals['mode_reglement_code']=="REVPAY" OR  $vals['mode_reglement_code']=="REVCC" OR $vals['mode_reglement_code']=="PayPX4") {
                  $date_actuel = date('Y-m-d');
                 $x = date('d-m-Y', $vals['datem']);
                // ajouter un jour $x
                 $x1  = date("Y-m-d", strtotime($x.'+ 0 days'));
                 if(strpos($vals['ref'],$chaine1) !==false OR strpos($vals['ref'],$chaine3) !==false OR strpos($vals['ref'],$chaine4) !==false OR strpos($vals['ref'],$chaine5) !==false){
                     $data_marseille[] = $vals['ref'].','.$vals['total_ht'].','.$x1;
                 }
                 
                  if(strpos($vals['ref'],$chaine6) !==false){
                     $data_internet[] = $vals['ref'].','.$vals['total_ht'].','.$x1;
                  }
             }

           }
            
            
       }
       // insert dans la table caisse nice.

       foreach($data_nice as $kf =>$reffacture) {
             $ref_data = explode(',',$reffacture);// exploser la chaine en tableau
              // inseré les valeurs. si le ref n'est pas dans la table caisse marseille...
              $data31 = $this->caisse->getAll();
             //$data31 = $this->caissenice->getGetref();
             if(isset($data31[$ref_data[0]])==false) {
                  // insert dans la table caisse nice
                  $this->caisse->Insert($ref_data[0],$ref_data[1],$ref_data[2]);       
                  
                  $chaine = explode('-',$ref_data[2]);
                  $data =[
                     'date_fix'=>$chaine[0].'-'.$chaine[1],
                     'montant'=>$ref_data[1]
                  ];

                  //
                  $this->caisse->insertmensuel2($data);
             }
        }

         // insert dans la table caisse nice.

        foreach($data_marseille as $kfs =>$reffactures){
            $ref_datas = explode(',',$reffactures);// exploser la chaine en tableau
            // inseré les valeurs. si le ref n'est pas dans la table caisse nice
             $data21 = $this->caisse->getAlls();
            // $data21 = $this->caissenice->getGetrefs();
  
              if(isset($data21[$ref_datas[0]])==false) {
                  // insert dans la table caisse nice
                   $this->caisse->Inserts($ref_datas[0],$ref_datas[1],$ref_datas[2]); 
                   
                   $chaine = explode('-',$ref_datas[2]);
                   $data =[
                      'date_fix'=>$chaine[0].'-'.$chaine[1],
                      'montant'=>$ref_datas[1]
                   ];

                   //
                   $this->caisse->insertmensuel1($data);
               }
         }

           //insert internet bdd
         foreach($data_internet as $kf =>$refinternet) {
               $ref_datas = explode(',',$refinternet);// exploser la chaine en tableau
               // inseré les valeurs. si le ref n'est pas dans la table caisse internet....
               $data1 = $this->caisse->getAllinternet();
               $data12 = $this->caisse->getGetsref();
              
              if(isset($data12[$ref_datas[0]])==false) {
                      // insert dans la table caisse nice
                   $this->caisse->Insertnet($ref_datas[0],$ref_datas[1],$ref_datas[2]);  
                   
                   $chaine = explode('-',$ref_datas[2]);
                   $data =[
                      'date_fix'=>$chaine[0].'-'.$chaine[1],
                      'montant'=>$ref_datas[1]
                   ];

                   //
                   $this->caisse->insertmensuel($data);
              }
         }



    }


      public function getdataventedol()
      {
         // recupérer la table categories product.
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

              // aller recupérer un id product cossrespondant à la categoris
               // recupérer la categoris et le libelle
               
     
          // recupérer le details des ventes des produits de dolibar sur intervalle de deux jours.
          // Mise à jours crons...
           $method = "GET";
          // key et url api
          $apiKey = env('KEY_API_DOLIBAR_PROD');
          $apiUrl ="https://www.poserp.elyamaje.com/api/index.php/";
       
          $produitParam = array(
            'apikey' => $apiKey,
            'sqlfilters' => "t.datec >= '".date("Y-m-d", strtotime("-2 days"))." 00:00:00' AND t.datec <= '".date("Y-m-d")." 23:59:59'",
             'limit' => 0,
            'sortfield' => 'rowid',
            'sortorder' => 'DESC',
        );

         // recupérer les données.
          $listinvoice = $this->api->CallAPI("GET", $apiKey, $apiUrl."invoices", $produitParam);
          $lists = json_decode($listinvoice,true);
          // traiter des données a recupérer
          $line_array =[]; // recupérer les données souhaiter.
          $ref_facture =[];
           // ne pas traiter les ref deja dans la table
          $donns = DB::table('ref_stats')->select('ref')->get();

          $lis = json_encode($donns); // tranformer les données en json
          $lis = json_decode($donns,true); // tranformer le retour json en array tableau.
          $ref_exist =[];
          $date_days = date('Y-m-d');// date actuel...

          foreach($lis as $key => $valc){
            $ref_exist[$valc['ref']] = $key;
          }
          
            foreach($lists as $key => $val) {
              $x = date('Y-m-d', $val['date']);
              $x_mois =  explode('-',$x);
               // recupérer toute les commandes qui ont le status souhaite.
              // recupére la date courate actuel(format date) à ajouter 3h.....
              $x1 = date("Y-m-d H:i:s", strtotime($x.'+ 1 days'));
               
              // recupérer la date et les details des produits vendus.
                if(isset($ref_exist[$val['ref']])==false){
                  // 
                   $ref_fact = explode('-',$val['ref']);
                   $ref = $ref_fact[0];
                   $chaine="FA";
                  if(strpos($ref,$chaine)!==false){
                    $ref ="FA";
                 }

                // $array autorise
                 $array_ref = array('TC1','TC2','TC3','TC4','TC5','TC6','FA');

                 if(in_array($ref,$array_ref)){
                     foreach($val['lines'] as $vals){

                      $id_categorie =  array_search($vals['fk_product'],$regroup_data);
                      $cats="";
                      $labs="";
                      if($id_categorie!=false){
                        $cat =  explode(',',$id_categorie);
                        $cats = $cat[1];
                     }
                        $cal = array_search($cats,$game);
                        if($cal!=false){
                          $cals = explode(',',$cal);
                          $labs = $cals[1];// recupérer ...........
                       }


                         $line_array[] =[
                          'id_product' => $vals['fk_product'],
                          'ref_facture'=> $ref,
                          'libelle' => $vals['libelle'],
                          'quantite' => $vals['qty'],
                          'mois' =>   $x_mois[1],
                          'annee' => $x_mois[0],
                          'id_cat'=> $cats,
                          'label_cat'=> $labs

                        ];
                     }
                        // recupérer les ref 
                        $ref_facture[] = [
                           'ref' => $val['ref'],
                           'created_at'=> $date_days

                        ];
                    
                   }
                }
              }


           // insert dans la bdd
           // récupérer les ref_ existant.

           // recupérer une ref unique ....
           DB::table('ref_stats')->insert($ref_facture);
           DB::table('stats_ventes')->insert($line_array);

            

      }

      public function importcsv()
      {
          // recupération des données directement de dolibarr pour ventes  facture....
             // $data =  DB::table('detail_facture')->select('fk_product','label','quantity','ref_facture','date')->get();
          // $coun = json_encode($data);
          // $coun = json_decode($data,true);
         
          // denier ref 2023-04-31.
          // creer des jeu intervals depuis 1 er janvier 2022 recupération des ventes effectués.

          // recupérer la table categories product.
          $cats = DB::table('categorie_products')->select('fk_product','fk_categorie')->get();
          $data_cat = json_encode($cats);
          $data_cat = json_decode($cats,true);
          // aller recupérer les produits.
          $datas_facture = DB::connection('mysql2')->select("SELECT llxyq_facture.rowid, llxyq_facture.ref, 
           llxyq_facture.datec,llxyq_facture.paye, llxyq_facturedet.fk_product,llxyq_facturedet.description,llxyq_facturedet.qty  FROM llxyq_facture
           INNER JOIN llxyq_facturedet ON llxyq_facture.rowid=llxyq_facturedet.fk_facture 
           WHERE  llxyq_facture.datec BETWEEN '2023-07-01'AND '2023-08-31' AND llxyq_facture.paye=1");
            $datas = json_encode($datas_facture);
            $datas = json_decode($datas,true);
            
            // recupérer le label product
              $products = DB::connection('mysql2')->select("SELECT rowid,label  FROM llxyq_product");
              
              $data = json_encode($products);
              $data = json_decode($data,true);
              
              $assoc_product =[];
              
              foreach($data as $val){
                  
                  $chaine = $val['label'].','.$val['rowid'];
                  $assoc_product[$chaine] = $val['rowid'];
              }
              
            $refs= [];
            $ref_vente =[];
            
            foreach($datas as $val){
                
                $ref_facture = explode('-',$val['ref']);
                 $ref = $ref_facture[0];
                 
                 $mois  = explode(' ',$val['datec']);
                 $mois_add = explode('-',$mois[0]);
                
                $refs[]= [
                    
                    'ref' =>$val['ref']
                   ];
                
                 $label = array_search($val['fk_product'],$assoc_product);
                 $labels = explode(',',$label);
                 $array_line[] =[
                   
                   'id_product'=>$val['fk_product'],
                   'ref_facture'=> $ref,
                   'libelle'=> $labels[0],
                   'quantite'=> $val['qty'],
                   'mois'=> $mois_add[1],
                   'annee'=>$mois_add[0]
                  
                  ];
                  
                 
            }
            
            
                 $array_da = array_unique(array_column($refs, 'ref'));
               $coupons_data_uniques = array_intersect_key($refs, $array_da);
               // recupérer le tableau avec id commande unique
             
          
            
         /*  foreach (array_chunk($coupons_data_uniques,1000) as $rer)  
           {
              
              DB::table('ref_stats')->insert($rer); 
           }
          */ 
          
           
         /*   foreach (array_chunk($array_line,1000) as $rers)  
           {
              
              DB::table('stats_ventes')->insert($rers); 
           }
         */ 
         
            dd('succees');
          
          $date_cours = date('Y-m-d');


      }
      
    
}

