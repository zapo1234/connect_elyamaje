<?php
// recuperer des utilitaires
namespace App\Http\Service\CallApi;

use App\Models\Tier;
use Illuminate\Support\Facades\Http;
use Automattique\WooCommerce\HttpClient\HttpClientException;
use Illuminate\Support\Facades\Auth;
use App\Models\Orderscommerce;
use App\Http\Service\FilePdf\CreateCsv;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class Importiers
{
    
     private $api;
     private $data =[];
    
       public function __construct(Apicall $api,
       CreateCsv $csvstat
       
        )
       {
         $this->api=$api;
         $this->csvstat = $csvstat;
        
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
   
   
   public function testing($array_x,$val)
      {
          if(isset($array_x[$val])) {
              return true;
          }
          
          else{
              return false;
          }
      }
   
  
     // methode recupérer des data wooocomerce qui ont un code promo amabassadrice
       public function getDataorder()
       {
            
               $method = "GET";
               $apiKey ="9W8P7vJY9nYOrE4acS982RBwvl85rlMa";
               $apiUrl ="https://www.poserp.elyamaje.com/api/index.php/";
            
             $produitParam = array(
                    'apikey' => '9W8P7vJY9nYOrE4acS982RBwvl85rlMa',
                    'sqlfilters' => "t.datec >= '".date("Y-m-d", strtotime("-20 days"))." 00:00:00' AND t.datec <= '".date("Y-m-d")." 23:59:59'",

                    'limit' => 0,
                    'sortfield' => 'rowid',
                    'sortorder' => 'DESC',
                );
                
                
                 $listinvoice = $this->api->CallAPI("GET", $apiKey, $apiUrl."thirdparties", $produitParam);
                 $lists = json_decode($listinvoice,true);
                 
                  // delete la table faire un delete vider la table
	            
	             $data_ids = array('3087');
	             $code_client = array('CU2306-14213','CU2306-14212','CU2308-16399');
	            // recupérer les données essentiel
	            $array_tiers = $this->getiers();
                 foreach($lists as $key=>$values) {
                    
                    if($this->testing($array_tiers,$values['id'])==false) {
                    
                      if(!in_array($values['id'],$data_ids)){
                         
                         if(!in_array($values['code_client'],$code_client)) {
                     
                           if($values['id']!= 14183 OR $values['id']!= 14182){
                             $x = date('Y-m-d H:i:s', $values['date_creation']);
                             $x1 = date("Y-m-d", strtotime($x.'+ 0 days'));
                             $x2 = date("Y-m-d H:i:s", strtotime($x.'+ 0 days'));
                             $y = date('Y-m-d H:i:s', $values['date_modification']);
                    
                             $y2 = date("Y-m-d H:i:s", strtotime($y.'+ 0 days'));
                              // Insert dasn la table
                             $tier = new Tier;
                             $tier->nom = $values['name'];
                             $tier->prenom = $values['name_alias'];
                             $tier->socid = $values['id'];
                             $tier->email = $values['email'];
                             $tier->code_client = $values['code_client'];
                             $tier->phone = $values['phone'];
                             $tier->adresse = $values['address'];
                             $tier->zip_code = $values['zip'];
                             $tier->ville = $values['town'];
                             $tier->date_created = $x2;
                             $tier->date_update= $y2;
                    
                            // save clients
                           $tier->save();
                      
                         }
                         
                    }
                     
                  }
                     
                }
                  
            }
                
            
              // recupérer les clients qui ont des doublons d'email.
                
               
             }
             
            public function getiers()
            {
                // recupérer les clients existant via le socid.
                 $data =  DB::table('tiers')->select('socid')->get();
                // transformer les retour objets en tableau
                $list = json_encode($data);
                $lists = json_decode($data,true);
                $list_code =[];
                
                foreach($lists as $key =>  $values) {
                    $list_code[$values['socid']] = $key;
                }
                
                 return $list_code;
             }
       }

