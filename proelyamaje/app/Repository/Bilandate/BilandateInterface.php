<?php

namespace App\Repository\Bilandate;
use App\Model\Ambassadrice\Bilandate;

interface BilandateInterface
{
   public function insert($id); // insert les dates bilan

   public function insertdata($id_ambassadrice,$id_mois,$date_jour,$date_annee);

  

}
