<?php

namespace App\Repository\Customer;

interface CustomerInterface
{
    public function getCustomers(); // récupérer tous les articles
    
    public function Insert(); // insert datas customer
    
    public function getEmail(); // recupérer les données email dans un tableau.


}

