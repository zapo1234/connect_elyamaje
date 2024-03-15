<?php
namespace App\Repository\Utilisateurs;
use App\Models\Utilisateurs\Orderutilisateur;


interface OrderutilisateurInterface
{
   
   public function getList();//afficher la liste
   
   public function insert($somme,$ref,$code_promo,$date_vente);//inserer dans la table des données
   
   public function getcustomer($codepromo);// recuperer le customer ambassadrice ayant le code promo
   
   public function orderid($id);// recuprer une ligne de orders
   
   public function editdata($code_promo,$somme,$ref_facture,$id,$date_vente,$mois,$annee);
   
   
   
}
   
   
?>