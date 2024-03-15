<?php

namespace App\Repository\Pointbilan;
use App\Model\Ambassadrice\Pointbilan;

interface PointbilanInterface
{
   public function getAllpay($i); // lister tous les paimement de l'ambassadrice
   
   public function getAllfacture();
   
   public function getDatainvoices($id,$code,$annne);// recupérer id , periode moi et montant de la facture
   
   public function getsearchamabassadrice($mois,$id);// recupérer les nom par like search ambassadrice
   
  public function  getfactureambassadrice($id); // recupérer les facture d'une amabassadrice

  public function getfactureambassadriceim($id);// recupérer les ligne des facture impayés.
  
  public function getnameambassadrice($name);// recupérer ou selectionner une ambassadrice la liste.
  
  public function alertpaypartenaire();

  public function getfacturepay();// recupérer les facture non payé et qui ont plus de 200 euro.

  // NOUVELLE METHODE pour filltre.
  public function getusermoispay($id_ambassadrice,$mois,$annee); // recupérer les user en fonction du mois ou l'année.

  public function getusermoisim($id_ambassadrice,$mois,$annee); // recupérer les user 

  public function getfacturesolde($id_ambassadrice,$mois,$annee); // recupérer les user 

  //..............
  public function getcummulpay($id);// le cumul des facture impayé pour l'utilisateur

  public function getidsim($id);// recupérer tous les id de facture impayés.

  public function getidpay($id_facture);
  
  public function userisadmin($id);
  public function getlastid($id);

  public function insertpoint($id_ambassadrice,$is_admin,$account_societe,$tva,$email,$name,$type_compte);


}