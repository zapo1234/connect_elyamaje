<?php
namespace App\Http\Service\CallApi;

use App\Http\Service\CallApi\Apicall;
use Illuminate\Support\Facades\Http;
use App\Models\Commandeid;
use App\Models\Productdiff;
use App\Models\Transfertrefunded;
use App\Models\Transfertsucce;
use App\Models\Distributeur\Invoicesdistributeur;
use App\Repository\Commandeids\CommandeidsRepository;
use Automattic\WooCommerce\Client;
use App\Http\Service\FilePdf\CreateCsv;
use Automattique\WooCommerce\HttpClient\HttpClientException;
use DateTime;
use DateTimeZone;

class TransferOrder
{
    
      private $api;
      
      private $commande;
      private $dataidcommande;// recupérer les ids commande existant
      private $status; // vartiable string pour statuts(customer et distributeur)
      private $countd = []; // les clients distributeur
      private $countc = [];// les clients non distributeur
    
       public function __construct(Apicall $api,
       CommandeidsRepository $commande)
       {
         $this->api=$api;
         $this->commande = $commande;
       }
    
    
      public function getOrderWoocomerce()
      {
        // recupérer les orders mise à jours en fonction des status souhaités
        //competed,processing,
     
      }
      
      
      
      /**
   * @return array
    */
   public function getDataidcommande(): array
   {
      return $this->dataidcommande;
   }
   
   
   public function setDataidcommande(array $dataidcommande)
   {
     $this->dataidcommande = $dataidcommande;
    return $this;
   }
   
   
   
        /**
   * @return array
    */
   public function getCountd(): array
   {
      return $this->countd;
   }
   
   
   public function setCountd(array $countd)
   {
     $this->setCountd = $countd;
    return $this;
   }
   
   
   
        /**
   * @return array
    */
   public function getCountc(): array
   {
      return $this->countc;
   }
   
   
   public function setCountc(array $countc)
   {
     $this->setCountc = $countc;
    return $this;
   }


   public function getApikeypublic()
   {
       $public_key = env('API_KEY_PUBLIC_WOOCOMERCE');

       return $public_key;
   }

   public function getkeysecret()
   {
      $secret_key = env('cs_a11995d7bd9cf2e95c70653f190f9feedb52e694');
      return $secret_key;
   }
   
  
     
       public function getdataorderid($id)
      {
             $urls="https://www.elyamaje.com/wp-json/wc/v3/orders/$id?&consumer_key=ck_06dc2c28faab06e6532ecee8a548d3d198410969&consumer_secret=cs_a11995d7bd9cf2e95c70653f190f9feedb52e694";
              // recupérer des donnees orders de woocomerce depuis api
              $donnes = $this->api->getDataApiWoocommerce($urls);
             $donnees[] = array_merge($donnes);
             
            return $donnees;
      }
      
      // 
      public function getDataorder($date_after,$date_before)
      {
             $donnees = [];
           // boucle sur le nombre de paginations trouvées
          for($i=1; $i<3; $i++)
          {
              $urls="https://www.elyamaje.com/wp-json/wc/v3/orders?orderby=date&order=desc&after=$date_after&before=$date_before&consumer_key=ck_06dc2c28faab06e6532ecee8a548d3d198410969&consumer_secret=cs_a11995d7bd9cf2e95c70653f190f9feedb52e694&page=$i&per_page=100";
              // recupérer des donnees orders de woocomerce depuis api
              $donnes = $this->api->getDataApiWoocommerce($urls);
             $donnees[] = array_merge($donnes);
           }
           
           return $donnees;
      }
      
      
      public function getdataproduct()
      {
          
        // boucle sur le nombre de paginations trouvées
          for($i=1; $i<9; $i++)
          {
              
             $urls="https://www.elyamaje.com/wp-json/wc/v3/products?consumer_key=ck_06dc2c28faab06e6532ecee8a548d3d198410969&consumer_secret=cs_a11995d7bd9cf2e95c70653f190f9feedb52e694&page=$i&per_page=100";
              // recupérer des donnees orders de woocomerce depuis api
              $donnes = $this->api->getDataApiWoocommerce($urls);
             $donnees[] = array_merge($donnes);
           }
           
           // recuperer les produit (name et les sku  de ces produits)
           $product_list = [];
           foreach($donnees as $k => $values)
           {
               foreach($values as $val)
               {
                 $product_list[$val['sku']]=$val['name'];
               
               }
           }
           
           
           return $product_list;
              
      }
      
      
       public function getDataorders()
       {
        
	         // recuperer les données api dolibar copie projet tranfer x.
              $method = "GET";
              $apiKey = env('KEY_API_DOLIBAR_TEST');
               $apiUrl = "https://www.transfertx.elyamaje.com/api/index.php/";
           
              //environement test local
           
               //Recuperer les ref et id product dans un tableau
	   
	           $produitParam = ["limit" => 700, "sortfield" => "rowid"];
	            $listproduct = $this->api->CallAPI("GET", $apiKey, $apiUrl."products", $produitParam);
	            
	             $lists = json_decode($listproduct,true);
	            
	            foreach($lists as $values) {
                  // tableau associatve entre ref et label product
                  $product_datas[$values['ref']] = $values['label'];
         
              }
      
           
            return $product_datas;
       }
        
      

     
     /** 
     *@return array
     */
      public function Transferorder($date_after,$date_before)
     {
        // excercer un get et post et put en fonction des status .
        
        
          // recuperer les données api dolibar copie projet tranfer x.
              $method = "GET";
               $apiKey = env('KEY_API_DOLIBAR_TEST');
               $apiUrl = "https://www.transfertx.elyamaje.com/api/index.php/";
           
              //environement test local
           
               //Recuperer les ref et id product dans un tableau
	   
	           $produitParam = ["limit" => 1000, "sortfield" => "rowid"];
	            $listproduct = $this->api->CallAPI("GET", $apiKey, $apiUrl."products", $produitParam);

      
               // reference ref_client dans dolibar
               //Recuperer les ref_client existant dans dolibar
	            $tiers_ref = "";
               $produitParam = ["limit" => 4000, "sortfield" => "rowid"];
               $list_tiers = $this->api->CallAPI("GET", $apiKey, $apiUrl."thirdparties", $produitParam);
               // recupérer dans un array les valeurs

               // verifier attribue ref_client dans dolibar comme id commande woocomerce!
               //Recuperer les ref_client existant dans dolibar
               //verifié l'unicité
               $list_id_order = [];
               $produitParam = ["limit" => 10, "sortfield" => "rowid"];
               $listorders_id = $this->api->CallAPI("GET", $apiKey, $apiUrl."invoices", $produitParam);
               //
               $list_id = json_decode($listorders_id,true);
             
             // recupérer les status prise en compte sur order woocommce
              $data_status = array('processing','completed','lpc_ready_to_ship','lpc_delivered', 'pret-en-magasin','lpc_transit','lpc_anomaly');
              
             
             // recuperer les ids commandes
             $ids_commande = $this->commande->getAll(); // tableau pour recupérer les id_commande 
             
             // recupérer le tableau de ids
             $ids_commandes =[];
             $id_commande_isset =[];
             foreach($ids_commande as $key => $valis){
                 $ids_commandes[] = $valis['id_commande'];
                 $id_commande_isset[$val['id_commande']]=$key;
             }
            
            
              // recupérer dans un array les valeurs
            foreach($list_id as $val1){ 
      
               $list_id_order[] = $val1['ref_client'];// recupérer les id commandes  oders de woocomerce =>muté sur les ref client de facture
            }

              $array_donnees = array_unique($list_id_order);// recupérer les ref client qui devient id commande de dolibar
              $list_tier = json_decode($list_tiers,true);
              
               // recupérer les email existant dans tiers
             $data_email = [];
             $data_list = []; //tableau associative de id et email
             $data_code =[];// tableau associative entre id(socid et le code client )
     
     
            foreach($list_tier as $val) {
               $data_email[$val['code_client']] = $val['email'];
               
               if($val['email']!=""){
                  $data_list[$val['id']] = $val['email'];// synchroniser socid et email de l'utilisateur
               
               }
         
                // recuperer id customer du client et créer un tableau associative.
                $code_cl = explode('-',$val['code_client']);
                if(count($code_cl)>2){
                  $code_cls = $code_cl[2];
                  $data_code[$val['id']] = $code_cls;
                }
        
             }
             
                // recuperer dans un tableau les ref_client existant der nier socid.
                 $clientSearch = json_decode($this->api->CallAPI("GET", $apiKey, $apiUrl."thirdparties", array(
		        "sortfield" => "t.rowid", 
	    	     "sortorder" => "DESC", 
		          "limit" => "1", 
		          "mode" => "1",
		       )
         	), true);

               
   
              foreach($clientSearch as $data){
                  $tiers_ref = $data['id'];
               }
                 // convertir en entier la valeur.
                 $id_cl = (int)$tiers_ref;
                 $id_cl = $id_cl+1;
                  $socid ="";
                  // recupérer  les données dans un tableau associative(id et ref_article) dans dolibar
	              $listproduct = json_decode($listproduct, true);// la liste des produits dans dolibar
      
                 foreach($listproduct as $values) {
                    $product_data[$values['id']]= $values['ref'];// tableau associative entre id product et reférence(product)
                   // tableau associatve entre ref et label product
                 }
                // recupére les customer des données provenant de  woocomerce
               // appel du service via api
                $id=23080;
                $customers = $this->getdataorderid($id);// recupérer les clients et details produit des id commande correspondant.
                $customer =  $this->getDataorder($date_after,$date_before);// recupérer les orders journaliers pour recupérer les clients  !
                
               // $x = $this->getDataorders();// dolibar
               // $d = $this->getdataproduct();// woocomerce
                
                //$result = array_diff_key($x,$d);
                
                //$results = array_intersect_key($x,$d);
                
                
                
               // insert base de donnée
               //foreach($result as $kl =>$vs)
               //{
               //   $results = new Productdiff();
               //   $results->name_product = $vs;
               //   $results->ref_ugs = $kl;
                  //
               //    $results->save();
               
               //}
               
                // test produit !
                //initialiser un array
                
                $data_tiers = [];//data tiers dans dolibar
                $data_lines  = [];// data article liée à commande du tiers en cours
                $data_product =[]; // data article details sur commande facture
                $data = [];
                $lines =[]; // le details des articles produit achétés par le client
                $id_commande_existe =[];// recupérer les id_commande existant deja récupérer dans les facture...
                $orders_d = [];// le nombre de orders non distributeur....
                $orders_distributeur = [];// le nombre de orders des distributeurs.....
               
                foreach($customer as $k => $dones){
                 
                   foreach($dones as $donnees){
                        // recupérer les données pour les tiers pour dolibar post tiers dans l'array
                        // recupérer les données article liée à la comande 
                        // recupérer les status souhaités de orders 
                
                
                         if(in_array($donnees['status'],$data_status))
                         {
                             $ref_client = rand(4,10);
                             //verifié et recupérer id keys existant de l'article
                             $fk_tiers = array_search($donnees['billing']['email'],$data_list);
                             // recupérer id en fonction du customer id
                             $fk_tier = array_search($donnees['customer_id'],$data_code);
                             // recupérer le code customer client
                             //$fk_tier = array_search($donnees['customer_id'],$data_code)
                             if($fk_tiers!=""){
                               $socid = $fk_tiers;
                             }
        
                             if($fk_tier!="" && $fk_tiers==""){
                               $socid = $fk_tier;
                             }
        
                             if($fk_tiers=="" && $fk_tier=="") {
                                   
                                   $date = date('Y-m-d');
                                   $dat = explode('-', $date);
                                   $a1 = $dat[0];
                                   // recupérer les deux deniers chiffre;
                                   $a11= substr($a1,-2);
                                   $a2 = $dat[1];
                                 
                                   $socid = $id_cl++;
                                   $woo ="woocommerce";
                                    $name="";
                                   $code = $donnees['customer_id'];//customer_id dans woocomerce
                                   $code_client ="WC-$a2$a11-$code";// recupérer le customer id dans wocoomerce
                                    $data_tiers[] =[ 
                                    'entity' =>'1',
                                    'name'=> $donnees['billing']['first_name'].' '.$donnees['billing']['last_name'],
                                   'name_alias' => $woo,
                                   'address' => $donnees['billing']['address_1'],
                                   'zip' => $donnees['billing']['postcode'],
                                   'email' => $donnees['billing']['email'],
                                   'phone' => $donnees['billing']['phone'],
                                    'client' 	=> '1',
                                    'code_client'	=> $code_client,
                                    'country_code'=> $donnees['billing']['country']
                               ];
           
   
                            }
       
                                // recupére les lines d'artilce liée achété du client 
                                $list_refs =[];
                               // recupérer tous les id product et leur quantité
                                $list_product_stocks =[];
             
                               foreach($donnees['line_items'] as $key => $values) {
                                     //verifié et recupérer id keys existant de l'article
                                     $fk_product = array_search($values['sku'],$product_data); // fournir le sku de woocommerce  =  à la reference product de dolibar.
                                     if($fk_product!="") {
                                        // details  array article libéllé(product sur la commande) pour dolibar
                                         $data_product[] = [
                                           "multicurrency_subprice"=> floatval($values['subtotal']),
                                            "multicurrency_total_ht" => floatval($values['subtotal']),
                                            "multicurrency_total_tva" => floatval($values['total_tax']),
                                            "multicurrency_total_ttc" => floatval($values['total']),
                                            "product_ref" => $values['sku'], // reference du produit.(sku wwocommerce/ref produit dans facture invoice)
                                            "product_label" =>$values['name'],
                                            "qty" => $values['quantity'],
                                            "fk_product" => $fk_product,// id product dans dolibar.
                                            "ref_ext" => $socid, // simuler un champ pour socid pour identifié les produit du tiers dans la boucle /****** tres bon
                                       ];
               
                                     }
                      
                                     if($fk_product==""){
                                        $list = new Transfertrefunded();
                                        $list->id_commande = $donnees['id'];
                                        $list->ref_sku = $values['sku'];
                                        $list->name_product = $values['name'];
                                        $list->quantite = $values['quantity'];
                                         $list->save();
                                     }
                     
                 
                                }      
                          
                                  // recupérer les champs dolibar utile pour les articles liée dans la facture
                                  // si la commande existe deja avec un id 
                                  // recupérer les socid en fonction de leur article lié
              
                                 if(!in_array($donnees['id'], $ids_commandes)) {
                                      // pour les facture non distributeur
                                      $d=1;
                                      $data_lines[] = [
                                      'socid'=> $socid,
                                      'ref_int' =>$d,
                                     'ref_client' =>$donnees['id'],// fournir un id orders wocommerce dans dolibar.
                                      "email" => $donnees['billing']['email'],
                                      "total_ht"  =>floatval($donnees['total']),
                                      'total_tva' =>floatval($donnees['total_tax']),
                                      "total_ttc" =>floatval($donnees['total']),
                                      "paye"=>"1",
                                      'lines' =>$data_product,
                                    ];
                           
                          
                                     // insert dans base de donnees historiquesidcommandes
                                     $date = date('Y-m-d');
                                     $historique = new Commandeid();
                                     $historique->id_commande = $donnees['id'];
                                     $historique->date = $date;
                                    // insert to
                                     $historique->save();
            
                                 }
                   
                                 // recupérer les id_commande deja pris
                                if(in_array($donnees['id'],$ids_commandes))
                                {
                                  $id_commande_existe[] = $donnees['id'];
                                }
                
                       }
         
                   }
         
             }
     
           
                // recupérer les deux variable dans les seter
                 $this->setCountd($orders_distributeur);// recupérer le tableau distributeur la variale.
           
                  $this->setCountc($orders_d);// recupérer le tableau des id commande non distributeur
                   // filtrer les doublons du tableau
                  $id_commande_exist = array_unique($id_commande_existe);
                  // recupérer le tableau
                  $this->setDataidcommande($id_commande_exist);
                  // renvoyer un tableau unique par id commande
                  // données des non distributeurs
                  $temp = array_unique(array_column($data_lines, 'socid'));
                  $unique_arr = array_intersect_key($data_lines, $temp);
                 // Filtrer les produits associés au tiers (socid = ref_ext simulé) suprimer en cas d'inégalité du tableau.
                 // clients invoices non distributeur 
          
               foreach($unique_arr as $r => $val) {
                   foreach($val['lines'] as $q => $vak){
                      if($val['socid']!=$vak['ref_ext']) {
                        unset($unique_arr[$r]['lines'][$q]);
                       }
                   }
               }
                
                 // insérer data tiers/client dans dolibar.
                 foreach($data_tiers as $data) {
                      // insérer les données tiers dans dolibar
                     $this->api->CallAPI("POST", $apiKey, $apiUrl."thirdparties", json_encode($data));
                 }
                  // créer des factures dans dolibar sous status brouillons
                  // traiter les facture dont les clients sont pas distributeurs.
                foreach($unique_arr as $donnes){
                   // insérer les données invoices dans dolibar en brouillon
                   // valider les facture en boucle
                     $this->api->CallAPI("POST", $apiKey, $apiUrl."invoices", json_encode($donnes));
                }
                
                  // activer le statut payé et lié les paiments  sur les factures
                   $this->invoicespay($date_after,$date_before);
                   dd('succes of opération');
                   // initialiser un array recuperer les ref client.
        
               return view('apidolibar');
   }




       public function invoicespay($date_after,$date_before)
       {
           // recuperer les données api dolibar.
          // recuperer les données api dolibar copie projet tranfer x.
            $method = "GET";
           $apiKey = env('KEY_API_DOLIBAR_TEST');
            $apiUrl = "https://www.transfertx.elyamaje.com/api/index.php/";
           
           //appelle de la fonction  Api
           // $data = $this->api->getDatadolibar($apikey,$url);
           // domp affichage test

            // recupérer le dernière id des facture 
            // recuperer dans un tableau les ref_client existant id.
            $invoices_id = json_decode($this->api->CallAPI("GET", $apiKey, $apiUrl."invoices", array(
	    	"sortfield" => "t.rowid", 
	    	"sortorder" => "DESC", 
		    "limit" => "1", 
		    "mode" => "1",
	    	)
      	), true);
      	


                // recupérer le premier id de la facture
               // recuperer dans un tableau les ref_client existant id.
               $invoices_asc = json_decode($this->api->CallAPI("GET", $apiKey, $apiUrl."invoices", array(
		      "sortfield" => "t.rowid", 
		      "sortorder" => "ASC", 
		      "limit" => "1", 
	        	"mode" => "1",
	        	)
    	      ), true);
    
            // recuperer dans un tableau les ref_client existant id.
            $clientSearch = json_decode($this->api->CallAPI("GET", $apiKey, $apiUrl."thirdparties", array(
		   "sortfield" => "t.rowid", 
		   "sortorder" => "DESC", 
		   "limit" => "1", 
		   "mode" => "1",
		   )
        	), true);


            // recupération du dernier id invoices dolibar
            foreach($invoices_id as $vk){
              $inv = $vk['id'];
           }

            // recupérer le premier id de la facture
           foreach($invoices_asc as $vks){
              $inc = $vks['id'];
           }
   

           foreach($clientSearch as $data){
             $tiers_ref = $data['id'];
           }
        
        
             // le nombre recupérer 
           $count_datas = $this->getDataorder($date_after,$date_before);
           $ids_orders =[];// recupérer les id commande venant de woocomerce
           
           $data_ids=[];// recupérer les nouveaux ids de commande jamais utilisés
           
           // recupérer les status prise en compte sur order woocommce
              $data_status = array('processing','completed','lpc_ready_to_ship','lpc_delivered', 'pret-en-magasin','lpc_transit','lpc_anomaly');
             
           
           foreach($count_datas as $k =>$valis){
              foreach($valis as $val){
                  if(in_array($val['status'],$data_status)){
                      $ids_orders[] = $val['id'];
                  
                      if(!in_array($val['id'],$this->getDataidcommande()))
                      {
                        $data_ids[]= $val['id'];
                      }
               
                  }
               
              }
           }
           
           
          // le nombre de facture à traiter en payé
           $count_data = count($ids_orders);
         
         // les nouveau order à traiter
         
         
          // recupérer le nombre de commande recupérer 
          $nombre1 = $count_data;
          $nombre2= count($this->getDataidcommande());// compter les anciennes ids 
         
           // nombre des nouveaux order recupérer journaliier.
           $nombre_orders = count($data_ids);
           
           // tranformer le tableau en chaine de caractère
           $list_id_commande = implode(',',$data_ids);
           
             $nombre_count = $inv - $nombre_orders+1;
           
           $datetime = date('d-m-Y H:i:s');
           $dat = date('Y-m-d H:i:s');
         
         // insert infos dans bdd ...
         if($nombre_orders == 0) {
             $label = "Aucune commande transférée";
         }
         
         elseif($nombre_orders ==1) {
             $label ="Une commande transférée dans dolibars le $datetime";
         }
         
         else{
             
             $label = "$nombre_orders commandes transférées dans dolibars le $datetime";
         }
         
         
         // insert dans la table 
         
         $sucess = new Transfertsucce();
         $sucess->date = $dat;
         $sucess->id_commande = $list_id_commande;
         $sucess->label = $label;
         $sucess->save();
     
          // convertir en entier la valeur.
          $id_cl = (int)$tiers_ref;
          $id_cl = $id_cl+1;
          $socid ="";
          // id  du dernier invoices(facture)
         
      
          // valider invoice
          $newCommandeValider = [
          "idwarehouse"	=> "6",
          "notrigger" => "0",
          ];
    
          
          $newCommandepaye = [
          "paye"	=> 1,
          "statut"	=> 2,
          "mode_reglement_id"=>4,
          "idwarehouse"=>6,
          "notrigger"=>0,
      
         ];
        
   
         // recupérer la datetime et la convertir timestamp
         // liée la facture à un mode de rélgement
         // convertir la date en datetime en timestamp.
            $datetime = date('d-m-Y H:i:s');
            $d = DateTime::createFromFormat(
           'd-m-Y H:i:s',
           $datetime,
           new DateTimeZone('UTC')
           );
     
        if ($d === false) {
         die("Incorrect date string");
      } else {
           $date_finale =  $d->getTimestamp(); // conversion de date.
        }
      
            $newbank = [
           "datepaye"=>$date_finale,
           "paymentid"=>6,
           "closepaidinvoices"=> "yes",
           "accountid"=> 6, // id du compte bancaire.
        ];

           // valider les facture dans dolibar
           for($i=$nombre_count; $i<$inv+2; $i++){
              $this->api->CallAPI("POST", $apiKey, $apiUrl."invoices/".$i."/validate", json_encode($newCommandeValider));
           }
      
             // Lier les factures dolibar  à un moyen de paiement et bank.
           for($i=$nombre_count; $i<$inv+2; $i++){
               $this->api->CallAPI("POST", $apiKey, $apiUrl."invoices/".$i."/payments", json_encode($newbank));
           }

              // mettre le statut en payé dans la facture  dolibar
           for($i=$nombre_count; $i<$inv+2; $i++) {
             $this->api->CallAPI("PUT", $apiKey, $apiUrl."invoices/".$i, json_encode($newCommandepaye));
           }

     }
     
     
     public function invoicesdistributeur($date_after,$date_before)
     {
	       // recuperer les données api dolibar.
	      // recuperer les données api dolibar copie projet tranfer x.
		  $method = "GET";
	      $apiKey = env('KEY_API_DOLIBAR_TEST');
	    	$apiUrl = "https://www.transfertx.elyamaje.com/api/index.php/";
	   
	      //appelle de la fonction  Api
	      // $data = $this->api->getDatadolibar($apikey,$url);
	      // domp affichage test

		    // recupérer le dernière id des facture 
		   // recuperer dans un tableau les ref_client existant id.
		    $invoices_id = json_decode($this->api->CallAPI("GET", $apiKey, $apiUrl."invoices", array(
		    "sortfield" => "t.rowid", 
		     "sortorder" => "DESC", 
		      "limit" => "1", 
		     "mode" => "1",
		   )
     	  ), true);
	



		// recupération du dernier id invoices dolibar
		foreach($invoices_id as $vk)
	   {
		  $inv = $vk['id'];
	   }

	
       // le nombre recupérer  sur woocommerce.
	   $count_datas = $this->getDataorder($date_after,$date_before);
	   $ids_orders =[];// recupérer les id commande venant de woocomerce
	   
	   $data_ids=[];// recupérer les nouveaux ids de commande jamais utilisés
	   
	   foreach($count_datas as $k =>$valis)
	   {
		  foreach($valis as $val)
		  {
			  if(in_array($val['status'],$data_status))
			  {
				$ids_orders[] = $val['id'];// recupérer les bon id en fonction de la commande.
			  
			  }
		  }
		  
		  
		   if(!in_array($val['id'],$this->getDataidcommande()))
		   {
			   $data_ids[]= $val['id'];// recupérer les nouveaux id de commande.
		   }
	   }
	   
	   
	  // le nombre de facture à traiter en payé
	   $count_data = count($ids_orders);
	 
	 // recupérer le nombre de commande recupérer 
	  $nombre1 = $count_data;
	  $nombre2= count($this->getDataidcommande());// compter les anciennes ids 
	 
	   // nombre des nouveaux order recupérer journaliier.
	   $nombre_orders = count($data_ids);
	   
	   // tranformer le tableau en chaine de caractère
	   $list_id_commande = implode(',',$data_ids);
	   
		 $nombre_count = $inv - count($nombre_orders)+1;
	   
	   $datetime = date('d-m-Y H:i:s');
	   $dat = date('Y-m-d H:i:s');
	 
	 // insert infos dans bdd ...
	 if($nombre_orders == 0)
	 { 
       $label = "Aucune commande distribiteur transférée";
	 }
	 
	 elseif($nombre_orders ==1)
	 {
		 $label ='Une commande distributeur transférée dans dolibars le '.$datetime.'';
	 }
	 
	 else{
		 
		 $label = $nombre_orders.' commandes distributeurs transférées dans dolibars le $datetime';
	 }
	 
	 
	 // insert dans la table 
	 
	 $sucess = new Transfertsucce();
	 $sucess->date = $dat;
	 $sucess->id_commande = $list_id_commande;
	 $sucess->label = $label;
	 $sucess->save();
 
	  // convertir en entier la valeur.
	  $id_cl = (int)$tiers_ref;
	  $id_cl = $id_cl+1;
	  $socid ="";
	  // id  du dernier invoices(facture)
	 
  
	  // valider invoice
	  $newCommandeValider = [
	  "idwarehouse"	=> "6",
	  "notrigger" => "0",
	  ];

	  // status impayés pour distributeur
	  $newCommandepaye = [
	  "paye"	=> 1,
	  "statut"	=> 1,
	  "mode_reglement_id"=>4,
	  "idwarehouse"=>6,
	  "notrigger"=>0,
  
	 ];
	

	 // recupérer la datetime et la convertir timestamp
	 // liée la facture à un mode de rélgement
	 // convertir la date en datetime en timestamp.
		$datetime = date('d-m-Y H:i:s');
		$d = DateTime::createFromFormat(
	   'd-m-Y H:i:s',
	   $datetime,
	   new DateTimeZone('UTC')
	   );
 
	if ($d === false) {
	 die("Incorrect date string");
  } else {
	   $date_finale =  $d->getTimestamp(); // conversion de date.
	}


	   // valider les fact dans dolibar
	   for($i=$nombre_count; $i<$inv+2; $i++)
	   {
		  $this->api->CallAPI("POST", $apiKey, $apiUrl."invoices/".$i."/validate", json_encode($newCommandeValider));
	   }

		  // mettre le statut impayé chez dolibar pour les distributeur
	   for($i=$nombre_count; $i<$inv+2; $i++)
	   {
		 $this->api->CallAPI("PUT", $apiKey, $apiUrl."invoices/".$i, json_encode($newCommandepaye));
	   }
	   
	   
	   // inserrer dans ma bb les id de commande distributeur.
	   // recupérer les id de facture dsitributeur.
	   for($i=$nombre_cout; $i< $inv+2; $i++)
	   {
	       $invoice =  new Invoicesdistributeur();
	       $invoice->invoice_id = $i;
	       $invoice->date = $date('d-m-Y H:i:s');
	       $invoice->status = "facture impayée";
	   }

 }


  public function statscoliship()
  {
          // recuperer les données api dolibar propers prod tous les clients.
          $method = "GET";
          $apiKey ="305ZB714CPxxYqHgk5w7Ah1i1aTtOHFe";
          $apiUrl ="https://www.poserp.elyamaje.com/api/index.php/";
          //Recuperer les ref et id product dans un tableau
          
          
          // recupérer les facture d'au moins 3;
          $date_cours = date('Y-m-d');
          
         // retrancher les 3 mois dernier
         $date_new = date('Y-m-d', strtotime($date_cours. ' - 90 days'));
        // gérer des date en dur
        $date_debut ="2023-09-01";
        $date_fin = "2023-10-01";
        
        // pagination accepté de 0 à 2.

        for($i=0;$i<2;$i++)
        {
          $produitParam = ["limit" => 2600, "status"=>"paid", "page"=>$i, "sortfield" => "rowid", "sqlfilters"=>"(t.datec:>=:'$date_debut') AND (t.datec:<=:'$date_fin') "];
          $listinvoice = $this->api->CallAPI("GET", $apiKey, $apiUrl."invoices", $produitParam);
         
           $lists[] = json_decode($listinvoice,true);

    
        }
        
         $ids_socid =[];
          $info_user =[];
    /*     foreach($lists as $key => $val)
           {
                
                foreach($val as $vals){
                
                 $x = date('Y-m-d H:i:s', $vals['date']);
                
                 // recupérer toute les commandes qui ont le status souhaite
                  // recupére la date courate actuel(format date) à ajouter 3h
                   $x1 = date("Y-m-d", strtotime($x.'+ 1 days'));
                   
                     if($vals['mode_reglement_code']!="DONS" && $vals['paye']=="1")
                     {
                           
                           $chaine_unique_key = $vals['socid'].','.$x;
                           
                           $data[] =  $vals['socid'].','.$x;
                         
                           $ids_socid[$chaine_unique_key] = $vals['socid'];
                      
                    }
               }
           
           }
           
       
       */
           
             $data =  DB::table('customercolliships')->select('name','email','socid','adresse','phone','date_dons')->get();
             $name_list = json_encode($data);
             $name_list = json_decode($data,true);
             $tiers_ids =[];
             $key_ids =[];
             
             $info_user =[];
            
            foreach($name_list as $keys => $values){
                
                $chaine_info = $values['name'].','.$values['email'].','.$values['date_dons'].','.$values['phone'];
                
                 $info_user[$chaine_info]= $values['socid'];
               
                $key_ids[$values['socid']] = $keys;
                
               // $chaine_id = array_search($values['socid'],$ids_socid);
                
               // if($chaine_id!=""){
                    
               //     $data_result[] = $chaine_id;
               // }
            }
            
            
            // aller chercher les clients qui sont suspecptible d'avoir payée donc devenu client au mois 4
           
   
          /*foreach($data_result as $vac){
              
              $chaine_d = explode(',',$vac);
              
              $results[] = [
                  
                  'socid'=>$chaine_d[0],
                  'date_paye'=>$chaine_d[1]
                  
                  ];
          }
          
          */
          
          // DB::table('payecustomercolliship')->insert($results);
           // recupérer les données pour les traiter.
           // recupérer le nombre de clients qui sont devenu client.
            
             $datac =  DB::table('payecustomercolliship')->select('socid','date_paye')->get();
             $name_lists= json_encode($datac);
             $name_lists = json_decode($datac,true);
             
             // le nombre de fois que les client on achéte.
              $info_socid =[];
             $result_data =[];
             
             foreach($name_lists as $key => $val){
                 
                 $info_socid[$val['socid']] = $key;
                 
                 $result_data[$val['socid']][] =$val['date_paye'];// date à laquel il as recupérer.
                       
             }
             $data_result =[];
             foreach($result_data as $key => $vald){
                 
                 $date_min = min($vald);
                 
                 $chaine = $key.'.'.$date_min;
                 
                 $data_result[$chaine] = $key;
             }
             
              // compter le nombre de fois que le client  a fait un achat
             // recupeére dans l'autre tableau de restriction 
             $orders = DB::table('payecustomercolliship')
            ->select('socid',DB::raw('COUNT(socid) as nombres'))
            ->groupBy('socid')
            ->get();
            
              $name_li = json_encode($orders);
              $name_li = json_decode($orders,true);
              
              $count_vente =[];
              
              foreach($name_li as $vl){
                  $ch = $vl['socid'].','.$vl['nombres'];
                  $count_vente[$ch] = $vl['socid'];
              }
              
              
              
              // construire mon cvs
              $data_result_tiers =[];
              
              foreach($name_list as $vab){
                  
                  if(isset($info_socid[$vab['socid']])!=false){
                  
                  // recupérer la dernier date 
                   $chaine_date =  array_search($vab['socid'],$data_result);
                   $date_first =  explode('.',$chaine_date);
                   
                    $date_first = $date_first[1];
                    $status="est devenue cliente";
                    // nombre à reucpérer
                    $count_rep = array_search($vab['socid'],$count_vente);
                     $count_achat  = explode(',',$count_rep);
                     $count_v_achat = $count_achat[1];
                      $status="est dvenue cliente";
                    // les infos du clients
                  
                    $info_data = array_search($vab['socid'],$info_user);
                    $chaine_info =  explode(',',$info_data);
                  
                  $data_result_tiers[] =[
                      
                      'name'=>$chaine_info[0],
                      'email'=>$chaine_info[1],
                      'télephone'=> $chaine_info[3],
                      'date_de_dons'=> $chaine_info[2],
                      'date_premier_achat_client'=>$date_first,
                      'nombre_Achat_realisé' => $count_v_achat,
                      'status'=> $status
                      
                      ];
                  
                  
                  
              }
              else{
                  
                  $infos_no[] = $vab['socid'];
              }
              
              }
              
             
              
              foreach($infos_no as $vac){
                  
                 $info_data = array_search($vac,$info_user);
                  $chaine_infos =  explode(',',$info_data);
                  
                  $date_first="";
                  $count_v_achat="";
                  $status="";
                   $data_result_tier[] =[
                      
                      'name'=>$chaine_infos[0],
                      'email'=>$chaine_infos[1],
                      'télephone'=> $chaine_infos[3],
                      'date_de_dons'=> $chaine_infos[2],
                      'date_premier_achat_client'=>$date_first,
                      'nombre_Achat_realisé' => $count_v_achat,
                      'status'=> $status
                      
                      ];  
                  
                  
                  
                }
              
              
              
              $data_finale = array_merge($data_result_tiers,$data_result_tier);
              
              // tirée le csv
              
              $this->csv->csvcolliship($data_finale);
              
              dd($data_finale);
              
              // tirer un csv  pour les datas.
             
            
             $unique_tier =array_unique($info_socid);
             
             $count_tiers = count($unique_tier);
             
             dd($count_tiers);
             
             
             // pourcentage de convertion sur la période de Nov 2022 à aujourd'huit.
             // nombre de client 64  taux de conversion 33,50 %.
          
          
         




  }
	

  }
     
    




