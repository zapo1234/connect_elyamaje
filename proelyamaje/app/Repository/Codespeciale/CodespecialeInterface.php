<?php

namespace App\Repository\Codespeciale;
use App\Models\Codespeciale;

interface CodespecialeInterface
{
   
   public function getAllcode();
   
   public function getAllcodes();
    public function insert();// insert dans base de données les coupons
   
   public function getIdcodepromo($id);// recupérer id du code promo en cours
   
   public function updatecodespecifique($code,$commission,$reduction,$nom_eleve,$email);// faire un update sur données
  

}