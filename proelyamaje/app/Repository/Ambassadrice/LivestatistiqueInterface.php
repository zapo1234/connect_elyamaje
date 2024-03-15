<?php
namespace App\Repository\Ambassadrice;
use App\Models\Ambassadrice\Livestatistique;

interface LivestatistiqueInterface
{
   public function getAllcodelive(); // recupére tous les dates de la bdd

   public function insert($id_ambassadrice,$id_live,$name,$email,$date); // insert des codes live
   
   public function getdatacodelive($id);// recupére les ligne apparteant à l'ambassadrice

   public function getCount();// nombre de live réalisé

}
   
   
?>