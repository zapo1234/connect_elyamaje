<?php
namespace App\Repository\Ambassadrice;
use App\Models\Ambassadrice\Ambassadric;

interface CodeliveInterface
{
   public function getAllcodelive(); // recupére tous les codelives des ambassadrice

   public function insert($code_live,$id_ambassadrice,$is_admin); // insert des codes live
   
   public function getdatacodelive($id);// recupére le code live et les date soumis 

   public function getNextLives($fields = '*');

}
   
   
?>