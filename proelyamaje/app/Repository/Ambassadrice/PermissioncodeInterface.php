<?php
namespace App\Repository\Ambassadrice;
use App\Models\Permissioncode;

interface PermissioncodeInterface
{
   public function getAll(); // recupére tous les codelives des ambassadrice

   public function insert($id,$email,$date,$total); // insert des codes live
   
   public function getIdambassadrice($id,$email);// insert des codes live

}
   
   
?>