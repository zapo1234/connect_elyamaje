<?php

namespace App\Repository\Cardsgift;

interface CardsgiftInterface
{
    public function getAll(); // récupérer toutes lignes

    public function Insert(); // recupérer une ligne à partir du code
    
   public function getCodecards($codecards);// recupérer l'id api et le montant correspondant

}
