<?php
namespace App\Repository\Stocks;
use App\Models\Stocksmouvement;

interface StocksmouvementInterface
{
   
   public function getAll(); // recupérer toutes les categories
   
   public function  deletedata(); // suprimer les ligne de la table
   

}
   
   
?>