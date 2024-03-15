<?php

namespace App\Repository\Cardsgift;
use Exception;
use App\Models\Cardsgift;
use Illuminate\Support\Facades\DB;
use App\Http\Service\CallApi\Apicall;
use App\Http\Service\CallApi\GetgiftCards;

class CardsgiftRepository implements CardsgiftInterface
{
  private $api;
  
  private $getcards;

  public function __construct(Apicall $api,
   GetgiftCards $getcards)
  {
    $this->api = $api;
    $this->getcards = $getcards;
  }

  public function getAll()
  {
    $user_all = DB::table('cardsgifts')->select('id_api')->get();
     $array_list = json_encode($user_all);
     $array_list = json_decode($user_all,true);
     // recupérer dans unn tableau les données name
     $array_id =[];
     foreach($array_list as $value)
     {
         $array_id[] = $value['id_api'];
     }
    return $array_list;
  }
  
  public function getCodecards($codecards)
  {
      $cards_infos = DB::table('cardsgifts')->select('id_api','montant')->where('code_number','=',$codecards)->get();
      $array_list = json_encode($cards_infos);
      $array_list = json_decode($cards_infos,true);
      return $array_list;
  }
  
  

   public function insert()
   {
       
    try{

        // suprimer les anciennes données
        DB::table('cardsgifts')->delete(); 
        
        // recupérer les données à inserer.
        $data = $this->getcards->getDataGiftCards();
        
        // recupére les data
        $datalist =$this->getcards->getAllidapi();
        
        $list_array =[];
        
        foreach($datalist as $k => $valc){
            $list_array[] = $valc['gift_card'];
        }
        
        
        // initaliser le tableau.
        $array_list =[];
        foreach($list_array as $ks => $values) {
            // recupérer les valeurs 
              $array_list[] = $values;
            
          }
        
      
        // recupérer un array unique en fonction de code_number..
        // recupérer les données pour les code élève ou les codes live
            $array_lists = array_unique(array_column($array_list, 'number'));
            $cards_data_unique = array_intersect_key($array_list, $array_lists);
          
        // insert
        // suprimer les données de table et mise a jours
        
        foreach($cards_data_unique as $val) {
              
              // recupérer just les code_number commençant par A et P.
              
              if(!in_array($val['pimwick_gift_card_id'], $this->getAll())){
                  $cardsgift = new Cardsgift();
                $cardsgift->id_api = $val['pimwick_gift_card_id'];
                $cardsgift->code_number = $val['number'];
                  $cardsgift->montant = $val['balance'];
                  $cardsgift->save();
              }
        }

          return true;
      } catch (Exception $e) {
        return $e->getMessage();
      }
       
   }
      
}      