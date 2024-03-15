<?php
// recuperer des utilitaires
namespace App\Http\Service\CallApi;

use App\Models\Retainscustom;
use Illuminate\Support\Facades\Http;
use Automattique\WooCommerce\HttpClient\HttpClientException;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Retainscustomerdol
{
    
     private $api;
     private $data =[];
    
       public function __construct(Apicall $api
       
        )
       {
         $this->api=$api;
        
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
   
  
     // methode recupérer des data wooocomerce qui ont un code promo amabassadrice
       public function getDataorder()
       {
        
	          // recupérer les facture journalier pour dolibar pour construire une fidelisation
	         // recuperer les données api dolibar propers prod tous les clients.
              $method = "GET";
               $apiKey = env('KEY_API_DOLIBAR_PROD');
               $apiUrl ="https://www.poserp.elyamaje.com/api/index.php/";
               //Recuperer les ref et id product dans un tableau
	   
	             $produitParam = ["limit" => 1000, "sortfield" => "rowid","sortorder" => "DESC"];
	            $listinvoice = $this->api->CallAPI("GET", $apiKey, $apiUrl."invoices", $produitParam);
	            $lists = json_decode($listinvoice,true);
	           
	            // recupérer ici
	             $datas = [];// recupérer les commande avec le bon status
                 $data_montant =[];
                 $date = date('Y-m-d');// prendre la date actuel courante.
                 $ids_socid = []; // recupérer les socid des clients à fideliser.
              foreach($lists as $key => $val){
                      $x = date('Y-m-d', $val['date']);
                       // recupérer toute les commandes qui ont le status souhaite
                       // recupére la date courate actuel(format date) à ajouter 3h
                        $x1 = date("Y-m-d H:i:s", strtotime($x.'+ 1 days'));
    
                       if($x1==$date && $val['mode_reglement_code']!="DONS" && $val['paye']==1) {
                            $datas[] = $val['socid'].','.$val['id'];
                           
                           $data_montant[] = $val['socid'].','.$val['id'].','.$val['total_ht'].','.$x1.','.$val['code_client'];
                           
                           $ids_socid [] = $val['socid'];
                           
                        }
                      
                 }
           
            
	              // recupérer les données id_invoices deja dans la table
	              $donnees_ids =  DB::table('retainscustoms')->select('id_invoices','socid')->get();
                // transformer en tableau 
                $lis = json_encode($donnees_ids); // tranformer les données en json
                $lis = json_decode($donnees_ids,true); // tranformer le retour json en array tableau.
                
                $data_invoice = []; //recupérer les ids deja présent dans la base de données.
                $data_ids = [];// recupérer les clients socid deja fais une commande
                foreach($lis as $ky=>$valus){
                    $data_invoice[] = $valus['id_invoices'];
                    $data_ids[] = $valus['socid'];
                }
                
                  // recupérer les clients si il n'existe  le socid (retainscustoms ) pas dans la base de données des clients à fidéliser 
                // le TOP départ
                  foreach($ids_socid as $val) {
                    // si le socid n'existe pas créer le client avec le code fidel
                    if(!in_array($val,$data_ids)) {
                        // créer mon client 
                        // envoi de mail de démarrage de fidélisation avec code
                        // inssérer dans la bdd les infos des clients à fidéliser
                        // recupéere ses infos depuis l'api
                         
	                        $listproduct = $this->api->CallAPI("GET", $apiKey, $apiUrl."thirdparties/$val", $produitParam);
             
                            $lists_data[] = json_decode($listproduct,true);
                    }
                    
                    }
                    
                    
                // créer les clients à fideliser avec les infos (généré un code unique à chaque client entre 8 à 12 chifffre)
                // recupérer les informations du clients
                $info_clients =[];
                foreach($list_data as $valis){
                     if($val['email']=="")
                          {
                            $email ="xxx_email";
                          }
            
                    else{
                          $email = $valis['email'];
                        }
            
                   if($valis['phone']=="")
                   {
                      $phone="xxx_phone";
                   }
            
                  else{
                       $phone = $valis['phone'];
                     }
            
                      $infos_clients[] = $valis['name'].','.$valis['id'].','.$email.','.$phone.','.$valis['address'].','.$valis['code_client'];
                }
                
                   // gérer un n° unique de mini 7  chiffre à 12 chiffre
                  // $num_code = rand(10001,5000001);
                   // créer une code unique de chaque eléve et le haché ensuite.
                  //  $data_donnees =  [];// recupérer les données à insert
                  //for($i=0; $i <count($infos_clients); $i++)
                  //{
                  //      $code = str_shuffle($num_code.$i); // mélangé le tableau.
                         // has che ce mot de pass !
                  //      $code_hash = Hash::make($code);
           
                   //       $data_donnees[] = $tiers_info[$i].','.$code.','.$code_hash;
                 /// }
                  
                  
                  
                  
                  // créer et inserer dans la table customer_client à fideliser les données.
                  // envoyé dans une portion de 20 mail à des clients copté.
        
                
                 // inserer les données recupérer dans la bdd souhaitais.
                foreach($data_montant as $values) {
                     $data_x = explode(',',$values);
                    // verifier que l'id n'est pas deja recupérer pour l'achat
                    
                    if(!in_array($data_x[1],$data_invoice)){
                        
                         $somme = number_format($data_x[2], 2, ',', '');
                        
                        // recupérer dans les données dans la table
                        $retains = new Retainscustom();
                        $retains->id_invoices = $data_x[1];
                        $retains->socid = $data_x[0];
                        $retains->total_ht = $somme;
                        $retains->date = $data_x[3];
                        
                        // recupérer insert dans bdd
                        $retains->save();
                        
                    }
                }
                
                
                dd('les données sont bien réceptionnées');

                // requete sql 

                $totat_vente = DB::table('stats_ventes')
                ->select('fk_product','mois','annee' ,DB::raw('SUM(quantite) as total'))
                ->groupBy('id_product','mois','annee')
                ->get();
         
       }


      
    
}

