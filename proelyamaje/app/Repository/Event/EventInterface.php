<?php

namespace App\Repository\Event;
use App\Models\Ambassadrice\Event;

interface EventInterface
{
   
   public function getAll();// insert dans base de données les coupons
   
   public function insert($title,$start,$end,$status,$id_ambassadrice);//suprimer les données dans la bdd
   
   public function  updateaction($title,$start,$end,$status,$id_ambassadrice);// faire un update

}