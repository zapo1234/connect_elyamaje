<?php

namespace App\Repository\Giftcards;

interface GiftcardsInterface
{
    public function getAll(); // récupérer toutes lignes

    public function getIdcards(int $id_amabssadrice); // recupérer une ligne à partir du code
    
    public function Insert($code_number,$id_ambassadrice,$montant); // insert datas articles
   
    public function getamountcard($code);// recupérer le montant de carte.

}
