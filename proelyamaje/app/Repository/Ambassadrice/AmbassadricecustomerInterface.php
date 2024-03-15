<?php

namespace App\Repository\Ambassadrice;

use App\Model\Ambassadrice\Ambassadricecustomer;



interface AmbassadricecustomerInterface
{

    public function getAllcustoms(); // recupérer tous les code_prom et id_ambassadrice
    public function getCustomers($id);
    public function getCustomerId($id); // recupére tous les customer de l'ambassadrice courant
   public function create(array $attribute); // créer un array
   public function getCustomersId(int $id); // recupérer un client 
   public function update($id, array $attribute); // Modifier un user
   public function getCode_promo();// recupere les code promo dans un array
    public function getCountData($id);// compter le nombre de code promo par jour id
    public function getEmail($id); // recupérer l'email du customs pour renvoi de code promo
    public function getAmbassadricedata($id_amabassadrice); // recupérer les data de l'ambassadrice user et ordercustoms
    public function getCustomsambassadrice($id,$email,$phone);// recupéer les infos des custome créer pour compter et gestion de date
     public function getCustomseleve($id,$email,$phone);// recupérer les données pour la validation de d'autre code promo
     public function getDatacount($id);// compter les données crées customer  en cours du mois
     public function getdatacodepromo();// compte par group id_ambassadrice le nombre de code élève créer
     public function deleteByCode($code);
     public function getemaildate($email,$id);// recuperer les données de mail .
     public function getbetwen($email,$date1,$date2,$id);//
     public function doublonscreate();
     public function getidline($id);
     public function getdatacounts($id,$mois,$annee);
     
     public function getcodeleve($id,$annee);

     public function getmodelmessage($id);
     
     public function getmodelmessages($id);// recupérer les models de méssages
     



}

   

   

?>