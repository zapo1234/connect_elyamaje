<?php
namespace App\Repository\Ambassadrice\Ordercustomer;

interface OrderambassadricecustomsInterface
{
   
   public function getCustomerAll();// recuperer tous les enregsitrement
   
   public function getCustomerId($id); // recupére tous les orders de l'ambassadrice courant via codepromo parainage
   
   public function getCustomerIds($id); // recupére tous les or
   
   public function getCodepromoorders(string $code);// recupérer tous les orders de son code promo

   public function create(array $attribute); // créer un array
  
   public function Insert(); // insere des customs id order ambassadrice
   
   public function getSomme();// calculer la somme du à l'amabassadrice
   
   public function getDataorder($id); // recupere le id commande order Api woocommerce
   
   public function getDataIdcodeorders():array;// recupérer dans un tableau tous les id_commande possedant un code promo
   
   public function getCountorders($id); // function qui renvoi des datas pour la facture(montant suibi par les 600euro et le nombre de vente live et élève)
   
   public function getChiffreambamonths($id,$code_live,$mois,$years);// function bilan du mois 
   
   public function getcountorderss($id);// recupérer pour le superadmin des ventes.


   public function getCountAll($id);//recupérer le nombre de code promo utilisés dans l'ensemble
   
   public function getPointdata($id);// recupérer et regrouper les id_ambassadrice et la somme regrouper pour leur activité
   
   public function getDataPdf($id,$code,$annee);// recupérer les données pour les afficher dans le pdf
   
   
   public function getSommemois($is_admin); // recuperer les commission mensuel en cours
   
   public function getAlllistorders($id);// recupérer tous les orders codepromo et live
   
   public function getSommeannee($is_admin);// recupérer le somme réalisés pour l'année
   
   public function updatecodespecifique($code,$somme,$commission);// update sur le code spécifique
   
   public function getdatacodespecifique($code);// recupérer commission et somme 
   
   public function getdataAll($id);// récupérer toute les données (Nombre de vente , Nombre de live,vente total)
   
   public function updatefacture($id,$mois,$annee);// mettre à jours les montant de facture.
   
   public function getcountcodeleve();// compte le nombre de code éléve utilisés pour un order woocomerce(achat)

   public function getrestriction();// bloquer les commande à 600 euro lors d'un live d'une ambassadrice.

   public function getchiffreannee($annee);// afficher dynamiquement les montant le chiffre d'affaire .

   public function getchiffreamba($mois,$annee);// recupérer 
   

}
   