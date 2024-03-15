<?php
namespace App\Repository\Ambassadrice;
use App\Models\Ambassadrice\Accountambassadrice;

interface AccountambassadriceInterface
{
   
   public function getList():array;//lister les account price amabssadrice
   
   public function insert(); //insert des données.
   
   public function getcounnum():array;//compter le nom de ventes rélaise
   
   public function getData() : array;
   
   public function getLists($code); // recupérer groupby du $code les champs de l'ambassadrice par le code promo
   
   public function getPointdata($id);
   
   public function getAllid();// recupere les id_commande dans la table ambassadrice
   
   public function getAllids();// recupérer les id_commmande de partenaire
   
   public function getPeriode($date_from,$date_after,$date_years);// recupérer dans une période

   
}
   
   
?>