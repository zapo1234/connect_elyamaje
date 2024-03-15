<?php
namespace App\Repository\Ambassadrice;
use App\Models\Partenaire\Accountpartenaire;

interface AccountpartenaireInterface
{
   
   public function getList():array;//lister les account price amabssadrice
   
   
   public function getcounnum():array;//compter le nom de ventes rélaise
   
   public function getData() : array;
   
   public function getLists($code); // recupérer groupby du $code les champs des partenaire par le code promo
   
   public function getPointdata($id);
   
   public function getAllids();// recupere les id_commande dans la table
}
   