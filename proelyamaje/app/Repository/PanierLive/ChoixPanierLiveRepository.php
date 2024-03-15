<?php

namespace App\Repository\PanierLive;
use App\Models\ChoixPanierLive;
use Illuminate\Support\Facades\DB;

class ChoixPanierLiveRepository implements ChoixPanierLiveInterface
{

   public function getLikeToken($tokens, $field = '*'){

      $results = ChoixPanierLive::query(); 
      foreach ($tokens as $token) {
         $results->orWhere('token_datas', 'LIKE', '%' . $token['token'] . '%');
      }
      return $results->get()->toArray();

   }

   public function updatebyTokens($tokens){

      // construire la requête de mise à jour avec une clause 'case'
      $query = ChoixPanierLive::query();
      $ids = [];
      $cases = '';
      foreach ($tokens as $token) {
         $id = $token['id'];
         $ids [] = $token['id'];
         $token_datas = implode(',', $token['token_datas']);
         $cases .= "when id = $id  then '$token_datas' ";
          
      }

      return $query->whereIn('id', $ids)->update(['token_datas' => DB::raw("(case $cases end)")]);
   }

   public function getByIdLive($id_live){

      return ChoixPanierLive::select('*')->where('id_live', $id_live)->get()->toArray();

   }

   public function getidlive($code_live)
   {
      $lastOne = ChoixPanierLive::select('id_live')->where('code_live','=',$code_live)->first(); // id dernier enregsitrement de facture
      $id_live =$lastOne->id_live;
       return $id_live;

   }

   public function getOrderByIdLive($field = '*'){
      return ChoixPanierLive::select($field)->orderBy('id_live', 'DESC')->get()->toArray();
   }
}

   