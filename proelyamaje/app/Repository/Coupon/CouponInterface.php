<?php

namespace App\Repository\Coupon;

use App\Models\Coupon;



interface CouponInterface
{

   public function getcode_promo($code_promo); // lister tous les paimement de l'ambassadrice
   public function insert();// insert dans base de données les coupons
   public function getIdcodepromo();// recupérer id du code promo en cours
   public function getcode($code);// recuperer id_coupons 
   public function deleteByCoupon($coupon);// 
   public function getcodefem();// code fidelite
   public function getDatafemcode();
   public function getdatapromofem();
  
}