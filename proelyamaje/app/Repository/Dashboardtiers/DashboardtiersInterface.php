<?php

namespace App\Repository\Dashboardtiers;

interface DashboardtiersInterface
{
    public function Insert($date,$mois,$annee,$number,$nombre_marseille,$nombre_nice,$nombre_internet,$jour); // insert des données api dans la table

    public function getjour(): array;// recupérer les données en fonction du jours
    
    public function getallsdate() ;// recupérer en fonction des dates les données
    
    public function getalldate($date);
    
    public function updatenumber($date,$nombre,$number_marseille,$number_nice,$number_internet);

    public function getcountiers();

    public function getcustomerall();// recupérer les clients tiers
    
        


}

