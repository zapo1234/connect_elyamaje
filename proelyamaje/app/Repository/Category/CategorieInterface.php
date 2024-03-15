<?php
namespace App\Repository\Category;
use App\Models\Categorie;

interface CategorieInterface
{
   
   public function getAll(); // recupérer toutes les categories
   
   public function getAllproduct(); // recupérer tous les produits;
   
    public function getdata();// recupérer getada
    
   public function getdataapiproducts($id_categorie);// recuperer et insert les product
   
   public function deletedata(); // suprimer les dans la table 

   public function geturlapi();// url de api solicite.
   

}
   
   
?>