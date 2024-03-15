<?php



namespace App\Repository\Notification;

use App\Models\Ambassadrice\Notification;



interface NotificationInterface

{

   

   public function insert($id);// insert dans base de données les coupons

   

   public function deleteid($id);//suprimer les données dans la bdd

   

   public function livestat($id_commade,$id_ambassadrice);// recupérer des notification de demande de live

   public function getAll(); // Get all notifications



}