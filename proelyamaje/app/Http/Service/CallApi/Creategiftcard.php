<?php
// recuperer des utilitaires
namespace App\Http\Service\CallApi;

use App\Models\Tier;
use Illuminate\Support\Facades\Http;
use Automattique\WooCommerce\HttpClient\HttpClientException;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use DateTime;
use DateTimeZone;

class Creategiftcard
{
    
     private $api;
     private $data =[];
    
       public function __construct(Apicall $api
      )
       {
         $this->api=$api;
        
       }

       public function str_generator()
       {
           // générer une chaine de caractère aléatoire de 16 
           $x = 0;
           $y = 10;
           $Strings = '0123456789abcdefghijklmnopqrstuvwxyz';
           $a = 0;
            $b = 5;
           $Strings='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
           $xa = substr(str_shuffle($Strings), $a, $b);
         
           return $xa;
     }
    
       // créer des cards kado
        public function Creategift($date,$email,$amount,$card)
        {
                // créer un gift card 
                 // gérer un prefixe pour les bon d'acahts..
                $card_prefix="kdo-elya";
                 // la personne connecté
                  $user_connect = Auth()->user()->name;
                  $note ="$user_connect a crée un bon d'achat $card avec un depot de $amount";
                // verifier si le bon d'acchat existe ou pas 
                     $nums =[];
                    if($card=="no"){
                    
                      $card = $card_prefix.'-'.$this->str_generator();
                      $datas = [
                      "number" => $card,
                      "active" => "1",
                      "amount"=>$amount,
                      "note" =>$note,
                      "expiration_date" => null,
                      "pimwick_gift_card_parent" => null,
                      "recipient_email" => $email,
                     ];
            
                      // Mise dans l'api woocommerce
                      $urls = "https://www.staging.elyamaje.fr/wp-json/wc-pimwick/v1/pw-gift-cards";
                      // post 
                      $this->api->InsertPost($urls,$datas);
                      // insert dans bdd.
                      // ajouter une ligne dans dolibar sur le compte des carte cadeaux.
                  }
                    else{


                       dd('zapo');
                      $urss ="https://www.staging.elyamaje.com/wp-json/wc-pimwick/v1/pw-gift-cards?number=$card";
                      $result_number = $this->api->getDataApiWoocommerce($urss);
                       // $infos_cards= $this->getcard->getCodecards($codecards);
                       // recupérer les infos.
                       if(count($result_number)!=0){
                        $montant_api = $result_number[0]['balance'];
                         // faire des update dans l'api 
                         // Mise dans l'api woocommerce.
                         $uri = "https://www.staging.elyamaje.com/wp-json/wc-pimwick/v1/pw-gift-cards/$id_api";
                         $data = [
                         'amount'=> $amount,
                       ];
                        
                         $this->api->InsertPost($uri,$data);
                      }
                      // mettre a jour dans l'api
                     // post 
                  
                   }

                // ecrire l'ecriture dans daolibar dans la banque carte cadeaux_internet
                 $method = "GET";
                 $apiKey = "f2HAnva64Zf9MzY081Xw8y18rsVVMXaQ"; 
                 $apiUrl = "https://www.transfertx.elyamaje.com/api/index.php/";
 
                 $datetime = date('d-m-Y H:i:s');
                 $d = DateTime::createFromFormat(
                'd-m-Y H:i:s',
                 $datetime,
                 new DateTimeZone('UTC')
                );
   
                if($d === false) {
                   die("Incorrect date string");
                 } else {
                  $date_finale =  $d->getTimestamp(); // conversion de date.
                 }
                // ecrire dans la banque card kdo. id 13
                $label ="$name à transmis un bon cardeaux N° $card";
                $array_data =[
                  "date"=> $date_finale,
                  "type"=>"CADO",
                  "label"=>$label,
                  "amount"=>$amount,
                  "datev" => $date_finale,
                  ];
 
               // ecrire la ligne dans la bank 
                  $this->api->CallAPI("POST", $apiKey, $apiUrl."bankaccounts/13/lines/",json_encode($array_data));
                
                  // et envoyé lacarte cadeaux via email chez la cliente......
                dd('les données sont bien transmise....');
                // insert dans une base de sauvergarde.
             
     }

}

