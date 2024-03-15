<?php

namespace App\Repository\Bilandate;

use App\Models\Ambassadrice\Bilandate;
use App\Models\Ambassadrice\Pointbilan;
use App\Models\Ambassadrice\Ordersambassadricecustom;
use App\Repository\Ambassadrice\LivestatistiqueRepository;
use App\Repository\Pointbilan\PointbilanRepository;
use App\Models\User;
use App\Http\Service\FilePdf\CreatePdf;
use Illuminate\Support\Facades\DB;
use App\Repository\Ambassadrice\Ordercustomer\OrderambassadricecustomsRepository;
use App\Repository\Ambassadrice\AmbassadricecustomerRepository ;
use Carbon\Carbon;

class BilandateRepository implements BilandateInterface
{
     
     private $model;
     private $orders;

    public function __construct(Bilandate $model,
    OrderambassadricecustomsRepository $orders,
     LivestatistiqueRepository $live,
     PointbilanRepository $pointnote,
     Createpdf $pdf,
     AmbassadricecustomerRepository $codeleve)
    {
      $this->model = $model;
      $this->orders = $orders;
      $this->live = $live;
      $this->pdf = $pdf;
      $this->pointnote = $pointnote;
      $this->codeleve = $codeleve;
    }
    
    
    public function insert($id)
    {
        
       $x = $this->pointnote->getcummulpay($id);
       // recupérer le dernier id des facture
       $id_last = $this->pointnote->getIds();
    
       $ligne_donne = $this->pointnote->getData();
       $ligne_total = $this->pointnote->getTotal();
      
       $data_ligne =[];

       if(count($ligne_donne)==0){
          $ligne_note = "";
       }

       else{
            foreach($ligne_donne as $val) {
                 $data_ligne[]=$val;
              }

          }

            // verifier si les ligne sont vide 
            // recupère la date actuel en cours..
            $date = date('Y-m-d');
            // recupérer le mot en cours
             $date1 = explode('-',$date);
             $code_mois  = (int)$date1[1];
             $code_annee = $date1[0];
             $annee = $date1[1];
             $mois="";
             $code = $code_mois;
             $this->code_mois($code);
             // recupérer le nom de l'ambassadrice
             $data_name = User::find($id);
             $name =  $data_name->name.' '.$data_name->username;
             $is_admin = $data_name->is_admin;
             $email = $data_name->email;
             $account_societe = $data_name->account_societe;
             $code_live = $data_name->code_live;
             // recupérer si c'est un
            
            // type d'utilisateur
            if($is_admin ==2) {
              $type="Ambassadrice";
            }
         
            if($is_admin ==4) {
              $type="Partenaire";
           }
            // recupérer la tva en fonction du type de compte
            $array_list1 = array('SASU','SARL','SAS','SASS');
            $array_list2 = array('EI','');
            $tva ="";
            if(in_array($account_societe,$array_list1)){
              $tva =20;
            }
            
            if(in_array($account_societe,$array_list2)){
               $tva=0;
            }

          
             $result =  DB::table('bilandates')->where('id_ambassadrice', '=', $id)->get();
             // transformer en tableau les données
             // transformer les retour objets en tableau
             $name_list = json_encode($result);
             $name_list = json_decode($result,true);

            if(count($name_list)==0){
              $data = new Bilandate();
              $data->id_mois = $code_mois;
              $data->id_ambassadrice = $id;
              $data->date_jour = $mois;
              $data->date_annee = $code_annee;
              $data->save();
            }
        
          if(count($name_list)==1){
             foreach($name_list as $values){
                 foreach($values as  $val) {
                   $array_data[] = $val;
                 }
             }

             if($array_data[2]!=$code_mois) {
                // aller recupérer les données des chiffres pour passer en historiques de paimement
                // avec le moins précedent
                  $code_mois1 = $code_mois-1;
                  $a_mois = $code_mois-1;
                   if($code_mois == 1){
                      $a_mois =12;
                      $code_annee = $code_annee-1;
                      $code_mois1 = 12;
                   }
                 
                 else{
                     $a_mois = $code_mois-1;
                     $code_annee = $code_annee;
                 }

                // recupérer  les informations (la somme commission, le nombre de code élève et live, la somme comission pour élève +lives)
                
                   $somme = $this->orders->getChiffreambamonths($id,$code_live,$a_mois,$code_annee);
                   $somme_live = $this->orders->getSomelive(); // commission live
                   $somme_code_eleve = $this->orders->getSomeleve();// commission eleve
                  //$lives = $this->orders->getNombrelive();// nombre de vente via code elève
                  // $eleves = $this->orders->getNombreleve();// nombre de vente via code ...
                  
  
                 $data =  DB::table('ordersambassadricecustoms')->where('id_ambassadrice', '=', $id)
                ->where('code_mois', '=', $a_mois)
                ->where('annee','=',$code_annee)
                 ->get();
                   // transformer les retour objets en tableau
                   $name_lists = json_encode($data);
                   $name_lists = json_decode($data,true);
                   // recupérer les données pour un code éleve et un code live
                   $array_live = [];
                   $array_eleve = [];
                   $array_somme_code =[];// somme pour les codes élèves
                   $array_somme_live =[];// somme pour les lives du mois en cours ...
                    foreach($name_lists as $km => $values){
                      if($values['code_live']==11){
                          $array_eleve[] = $values['code_live'];
                          $array_somme_code[]=$values['somme'];
                      }
                      
                      if($values['code_live']==12){
                          $array_live[] = $values['code_live'];
                          $array_somme_live[] = $values['somme'];
                      }
                  }

                    // recupérer le nombre de code crée
                     $code_nombre = $this->codeleve->getdatacounts($id,$a_mois,$code_annee);
                      // somme 
                     //$somme_live = array_sum($array_somme_live);//.......
                     //$somme_code_eleve = array_sum($array_somme_code);//....
                  
                    // compter chaque tableau
                     $lives =  count($array_live);
                     $eleves =  count($array_eleve);
                    // recupérer le nombre de live
                    // compter le nombre de live, recupérer le tableau
                     $this->live->getdatacodelive($id);
                     $data_live = $this->live->getListdate();
                      $nbrs = count($data_live);
                      // somme de la toutes les commabdes
                      // recupére les code_promo
                      // recupérer le mois en cours
                      $code = $code_mois1;
                      $mois = $this->code_mois($code);
                      $css="im";
                      $content = "payer la facture par virement";
                       $button ="paiment";
                      $array_somme = [];
                      //cout de gain pour l'ambassadrice
                      $array_montant = [];
                     /*   foreach($name_lists as $valx){
                        $array_somme[] = $valx['somme'];
                      }
                      // renvoyer de la somme
                      $sommes = array_sum($array_somme);
                      $somme = $sommes;
                     */ // somme_true.
                      $somme_true = $somme+$somme*$tva/100;
                    // recupérer le montant $ligne_total+ somme_true
                    // ajouter la ligne
                    
                   if($code_mois1 > 9) {
                       $moiss = $code_mois1;
                   }

                   else{
                     $moiss = '0'.$code_mois1;
                   }
                     // recupérer la ligne %
                     $solde_nex_months =' solde du '.$moiss.'/'.$code_annee.' '.$somme_true.'€';
                     $data_ligne[] = $solde_nex_months;
                     // ligne a flush
                     $total_true = number_format($ligne_total + $somme_true, 2, '.', ''); // montant à afficher
                    
                      $total_ht = $ligne_total +$somme; // montant ht crédit à payer au total
                      $total_ligne = 'Total '.$total_true.'€';
                      // ajouter a array data_ligne.
                      $data_ligne[] = $total_ligne;
                      $ligne_note = implode('%',$data_ligne);
                      

                     // verifier si la somme ligne  total est vide .......
                     if($is_admin==2){
                        if($ligne_total==0 && $somme_true==0){
                          $ligne_note="";
                          $data_ligne = [];
                      }

                    if($ligne_total==0 && $somme_true > 200){
                      $ligne_note="";
                      $data_ligne = [];
                    }
                
                    if($total_true < 100){
                      $csss="inactifpay";
                   } else if($total_true >=100 && $total_true < 200){
                      $csss="giftpay";
                   } else {
                      $csss="actifpay";
                   }

                  }

                  if($is_admin==4){
                      if($ligne_total==0 && $somme_true==0){
                        $ligne_note="";
                        $data_ligne = [];
                     }

                    if($ligne_total==0 && $somme_true > 3000){
                       $ligne_note="";
                        $data_ligne = [];
                    }
              
                
                      if($total_true < 100){
                          $csss="inactifpay";
                     } else if($total_true >=100 && $total_true < 200){
                        $csss="giftpay";
                      } else {
                       $csss="actifpay";
                    }

                      // METTRE les autre ligne a zero.
                      // mettre la dernier ligne  quelque sois le status au csss inactif
                      $cssx = "inactifpay";
                       DB::table('pointbilans')->where('id', $id_last)->update([
                        'csss' => $cssx
                         ]);
              }

                
                 

                   // recupérer le dernière status paiements dans le pointbilans de l'ambassadrice....
                   //...............
                  /* $lastOne = DB::table('pointbilans')->where('id_ambassadrice','=',$id)->latest('id')->first(); // id dernier enregsitrement de facture
                   // recupérer l'id 
                   $id_last = $lastOne->id;
                   // faire un update pour faire disparaitre les boutons si sont le montants est plus de 100(cards_cadeaux) et 200(vir_bancaire).
                   $chaine_montant = $lastOne->ligne_note;
                   $details_chaine = explode(' ',$chaine_montant);// convertir la chaine en tableau.
                   $sommex = explode(',', $details_chaine[13]);
                   $montant_last = $sommex[0];

                   if(100 <= $montant_last OR $montant_last  <=199){
                      // charger les changement ici.
                   }
            
                  */ 
                      // recupéerer le type de société pour définir le montant.
                      // insert dans base de données Pointbilan........
                      $status ="non payée";
                      $status_paiement ="";

                    if($somme!=0){
               
                      $point = new Pointbilan();
                      $point->id_mois = $code_mois1;
                      $point->id_ambassadrice = $id;
                      $point->is_admin = $is_admin;
                      $point->tva = $tva;
                      $point->email = $email;
                      $point->name = $name;
                      $point->mois = $mois;
                      $point->annee = $code_annee;
                      $point->somme = $somme;
                      $point->ligne_note = $ligne_note;
                      $point->status = $status;
                      $point->type_compte = $type;
                      $point->nbrslive = $lives;
                      $point->nbrseleve = $eleves;
                      $point->code_create = $code_nombre;
                      $point->somme_live = $somme_live;
                      $point->somme_eleve = $somme_code_eleve;
                      $point->nbrsfois = $nbrs;
                      $point->content = $content;
                      $point->button = $button;
                      $point->css = $css;
                      $point->csss = $csss;
                      $point->status_paiement = $status_paiement;
                      $point->save();
                     // modifier 
                     DB::table('bilandates')->where('id_ambassadrice', $id)->update([
                   'id_mois' => $code_mois
                    ]);
                    
                    // enregsitrer la facture dans le chemin mensuel 
                 }      // et telecharger un pdf.
              }
          }
      }

      public function insertdata($id_ambassadrice,$id_mois,$date_jour,$date_annee){

           $array_data[] = [
               'id_ambassadrice'=>$id_ambassadrice,
               'id_mois'=>$id_mois,
               'date_jour'=>'',
               'date_annee'=>date('Y'),
               'updated_at'=>'2022-07-11 10:54:30',
               'created_at'=>'2022-07-11 10:54:30',
               ];

               // insert datas
               DB::table('bilandates')->insert($array_data);
      }
      
      
      public function code_mois($code)
      {
          // defini les mois
          
         if($code ==1){
             $mois = "Janvier";
         }
         elseif($code==2){
             $mois = "Février";
         }
         
         elseif($code ==3){
             $mois = "Mars";
         }
         
         elseif($code==4){
             $mois ="Avril";
         }
         
         elseif($code==5){
             $mois ="Mai";
         }
         
         elseif($code==6){
             $mois ="Juin";
         }
         
         elseif($code==7) {
             $mois ="Juillet";
         }
         
         elseif($code==8)
         {
             $mois ="Août";
         }
         
         elseif($code==9)
         {
             $mois ="Septembre";
         }
         
         elseif($code==10)
         {
             $mois ="Octobre";
         }
         
         elseif($code==11)
         {
             $mois ="Novembre";
         }
         
         else
         {
             $mois ="Décembre";
         }
         
         
         return $mois;
      }
      
     
        
    }
     
    











