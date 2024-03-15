<?php
namespace App\Repository\Ambassadrice;
use App\Models\Ambassadrice\Ordercodepromoaffichage;

interface OrdercodepromoaffichageInterface
{
   public function getAll(); // recupére tous la list à afficher

    public function insert(array $datas); // insert des données dans la table
   
    public function getsearch($search,$id_ambassadrice); // recherche par nom de l'eleve
    
    public function getsearchs($search);// recherche par le nom de l'elève;
    
    public function getdatapromo();// recupérer les code èlve créer pour les actions.
    
    public function getdatapromos($id);// recupérer les code élève avec l'id courant
    
    public function getallidmobile($id_ambassadrice);
}
   
  ?>