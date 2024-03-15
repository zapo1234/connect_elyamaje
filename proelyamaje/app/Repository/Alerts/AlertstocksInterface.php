<?php

namespace App\Repository\Alerts;
use App\Model\Alerstock;

interface AlertstocksInterface
{
   public function getAll();// recupérer les données existant
   
   public function getarrayalertsotcks();// recupérer la liste d'article qui respecte la condition
   
   public function insert();// inseré des données 
   
   

  

}
