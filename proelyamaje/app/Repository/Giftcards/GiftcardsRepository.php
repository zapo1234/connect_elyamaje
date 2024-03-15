<?php

namespace App\Repository\Giftcards;
use App\Models\Giftcard;
use App\Http\Service\CallApi\Apicall;
use App\Http\Service\CallApi\GetgiftCards;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class GiftcardsRepository implements GiftcardsInterface
{
  private $api;

  public function __construct(Apicall $api,
  GetgiftCards $apigift)
  {
    $this->api = $api;
    $this->apigift = $apigift;
  }

  public function getAll()
  {
     $user_all = DB::table('giftcards')->select('id_ambassadrice')->get();
     $array_list = json_encode($user_all);
     $array_list = json_decode($user_all,true);
     // recupérer dans unn tableau les données name
    return $array_list;
  }

   public function getIdcards($id)
   {
       $user_list_id = DB::table('giftcards')->select('code_number','id_api','id_ambassadrice','montant')->where('id_ambassadrice','=',$id)->get();
       $array_list = json_encode($user_list_id);
       $array_list = json_decode($user_list_id,true);

       
     
     // recupérer dans unn tableau les données name
      return $array_list;
   }

   public function getamountcard($code){
     
      // recupérer le montant de la carte
      $urlss ="https://www.elyamaje.com/wp-json/wc-pimwick/v1/pw-gift-cards?number=$code";
      $dones = $this->api->getDataApiWoocommerce($urlss);

      if(isset($dones['0']['message'])){
          $message_error ="false";
      }else{
         
         $message_error =  $dones;
      }

      return $message_error;
     

   }
   
   
   public function insert($code_number,$id_ambassadrice,$montant)
   {
       // recupérer la donné id_api de l'api
       $data_api = $this->apigift->getDataGiftCards();
       // initaliser le tableau.
       $array_list =[];
       foreach($data_api as $ks => $values) {
          foreach($values as $kl => $vals){
             // recupérer les valeurs 
             $array_list[] = $vals;
           
          }
       }
       
       // recupérer un array unique en fonction de code_number
       // recupérer les données pour les code élève ou les codes live
          $array_lists = array_unique(array_column($array_list, 'number'));
          $cards_data_unique = array_intersect_key($array_list, $array_lists);
       // insert
      // suprimer les données de table et mise a jours
      
       $id_api=""; // recuperer id depuis l'api
        foreach($cards_data_unique as $val) {
           
           if($code_number == $val['number']){
               $id_api = $val['pimwick_gift_card_id'];
           }
        }
       
       $giftcards = new Giftcard;
       $giftcards->code_number = $code_number;
       $giftcards->id_api = $id_api;
       $giftcards->id_ambassadrice = $id_ambassadrice;
       $giftcards->montant = $montant;
       
       $giftcards->save();
       
   }
      
}      
