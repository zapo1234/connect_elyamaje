<?php

namespace App\Repository\Promotions;
use App\Models\Ambassadrice\Promotionsum;
use Illuminate\Support\Facades\DB;

class PromotionsumsRepository implements PromotionsumsInterface
{
    public function getAll($fields = '*'){
        $promotionsums = Promotionsum::all($fields);
        return $promotionsums->toArray();
    }

    public function getdonsamba() {
         
        $sum = 0;
         $total_vente = DB::table('promotionsums')
         ->join('users', 'users.id', '=', 'promotionsums.id_ambassadrice')
         ->select('promotionsums.id_ambassadrice','promotionsums.id_product','promotionsums.label_product','users.name' ,DB::raw('SUM(quantite) as total'))
         ->where('somme','=',$sum)
         ->orderByDesc('total')
         ->groupBy('id_product','id_ambassadrice','label_product','name')
         ->get();

         $list_dons = json_encode($total_vente);
         $list_dons = json_decode($total_vente,true);

         return $list_dons;

        
    }

    public function getambadons($id)
    {
         $sum=0;
        $total_vente = DB::table('promotionsums')
        ->join('users', 'users.id', '=', 'promotionsums.id_ambassadrice')
        ->select('promotionsums.id_ambassadrice','promotionsums.id_product','promotionsums.label_product','users.name' ,DB::raw('SUM(quantite) as total'))
        ->where('somme','=',$sum)
        ->where('users.id','=',$id)
        ->orderByDesc('total')
        ->groupBy('id_product','id_ambassadrice','label_product','name')
        ->get();

        
         $is_admin =2;
         $user_data = DB::table('users')->select('id_ambassadrice','name')->where('is_admin','=',$is_admin)->get();
          $list_dons = json_encode($user_data);
          $list_dons = json_decode($user_data,true);
          $user_admin =[];

          foreach($list_dons as $val){
             $user_admin[$val['id_ambassadrice']] = $val['name'];
          }

    }
}