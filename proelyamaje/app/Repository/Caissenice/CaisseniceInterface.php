<?php

namespace App\Repository\Caissenice;

interface CaisseniceInterface
{
    public function getAll(); // récupérer tous les articles

    public function Insert($ref_facture,$montant,$date); // insert datas lines invoices caisse nice
     
     public function getAlldata();// recuperer les données 

     public function getinternetmensuel();

     public function getnicemensuel();

     public function getmarseillemenseul();

     public  function insertmensuel($data); // internet caisse ..
     public function insertmensuel1($data); //marseille caisse
     public function insertmensuel2($data);// nice

    
     
    

}

