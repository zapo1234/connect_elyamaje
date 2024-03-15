<?php
namespace App\Repository\Ambassadrice;
use App\Models\HistoriquePanierLive;

interface HistoriquePanierLiveInterface
{
   public function getall(); // recupérer les données des hitoriques live.

   public function getalls($id_ambassadrice);// recupérer les données de l'ambassadrice. des lives

   public function gethistorique();// recupérer les données historique des live effectué

   public function gethistoriques($id,$mois,$annee);// recupérer les données historique de live d'une ambassadrice

   public function gethistoriquesommelive();// fixer la methode
   
   public function gethistoriquevente($annee);// recupérer le rapoport de ventesen %

   public function gethistoriqueventes($id,$annee);// recupérer le rapoport de ventesen menseul par ambassadrice %


   public function getSommelive($id);// recupérer le montant génére par live...

   public function getdatelivecode($code_live);// recupérer le code live et la date via le code id de l'ambassadrice

   public function getorderlist($code_live);// recupérer la liste des commande de l'ambassadrice 

    public function getdatelivesomme();// recupérer et groupe les somme des dates live 

    public function getdatechecklive($date);// recuperer des infos des live par date click

    public function getdatecheckcode($date);// recupérer des infos code eleve par date click

    public function getcustomers($id,$code);// recupérer les customers ambassadrice

    public function  getpointeleve();

    public function getId();

    

}
   
   
?>