<?php

namespace App\Repository\PanierLive;
use App\Models\PanierLive;
use Illuminate\Support\Facades\DB;

class PanierLiveRepository implements PanierLiveInterface
{

   public function getByIds($ids, $field = '*'){
      $paniersLive =  PanierLive::whereIn('id_product', $ids)->select($field)->get()->toArray();
      return $paniersLive;
   }

   public function getByTokens($tokens, $field = '*'){
      $productsLive =  PanierLive::whereIn('token', $tokens)->select($field)->orderBy('pseudo', 'ASC')->get()->toArray();
      return $productsLive;
   }

   public function getPanierByTokens($tokens){

      $palier = [];

      foreach ($tokens as $token) {

         $listPalier = PanierLive::whereIn('token', $token['token_datas'])->select('panier_title')->groupBy('panier_title')->get()->toArray();
         $palier[] = ['id_coupons' => $token['id_coupons'], 'id' => $token['id'], 'palier' => array_column($listPalier,'panier_title')];
      }

      return $palier;
   }

   public function getAllPanier(){
      return PanierLive::select('panier_title')->groupBy('panier_title')->get()->toArray();
   }
}

   