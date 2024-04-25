<?php

namespace App\Http\Controllers\Partenaire;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repository\Users\UserRepository;
use App\Models\Ambassadrice\Pointbilan;
use App\Repository\Ambassadrice\Ordercustomer\OrderambassadricecustomsRepository;
use App\Repository\Bilandate\BilandateRepository;
use App\Repository\Ambassadrice\AccountpartenaireRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use DateTime;
use Mail;
use Illuminate\Support\Str;

class PartenaireController extends Controller
{
    //
       public function __construct(UserRepository $users, 
        OrderambassadricecustomsRepository $order,
       AccountpartenaireRepository $amba,
         BilandateRepository $bilan)
      {
          $this->users = $users;
          $this->amba = $amba;
          $this->bilan = $bilan;
          $this->order = $order;
      }
        
        public function list()
        {
           if(Auth()->user()->is_admin==1)
           {
              $id=4;
              $datas = $this->users->getambassadrice($id);
              return view('partenaire.list',['datas'=>$datas]);
          }
          
        }
        
        
        public function user()
        {
            
        }
        

        public function getChartParte(Request $request){


         if(Auth::user()->is_admin==1){
 
             $array_montant = [];
             $array_name =[];
 
             if($request->get('chart') == "chart_1"){
                 $date_from = $request->get('date_from');
                 $date_after = $request->get('date_after');
                 $date_years = $request->get('date_years');
 
                 if($date_from !="" && $date_after!="" && $date_years!=""){
                     $array_chart = $this->amba->getPeriode($date_from,$date_after,$date_years);
                 } else {
                     $array_chart = $this->amba->getList();
                 }
 
             } elseif($request->get('chart') == "chart_2"){
 
                 $date_yearss = $request->get('date_yearss');
                 $mois_cours = $request->get('mois_cours');
     
                 if($date_yearss!="" && $mois_cours!=""){
                     $array_chart = $this->amba->getMensuel($mois_cours, $date_yearss);
                 } else {
                     $array_chart = $this->amba->getList();
                 }
             }
 
             if(count($array_chart)!=0){
                  
                 foreach($array_chart as $key => $values){
                      $array_name[] = $values['name'];
                      $array_montant[] = floatval($values['total_montant']);
                  }
              }
  
              echo json_encode(['array_montant' => $array_montant, 'array_name' => $array_name]);
            
         } else {
             echo json_encode(['success' => false, 'message' => 'Unauthorized !']);
         }
        
       }
        
        public function dashboard(Request $request)
        {


          if(Auth::check())
          {
             if(Auth::user()->is_admin==1)
            {
             
              $donnees = $this->amba->getcounnum();
               $array_list = [];

               // dd($donnees);

             
             foreach($donnees as $vall) {
                 if($vall['vente']==1){
                     $vente=0;
                 }
                 
                 elseif($vall['vente']==2){
                     $vente = 1;
                 }
                 
                 else{
                     $vente = $vall['vente']-1;
                     // à travailler.
                    }
                 
                   $array_list[]=[
                          'name'=>$vall['nom'],
                          'vente'=>$vente,
                     ];
             }
             
             
               // recupérer les variable.// recupérer les variable.
               $date_from = $request->get('date_from');
               $date_after = $request->get('date_after');
               $date_years = $request->get('date_years');
               // recupérer le tableau pour formater les données du chartjs
               $array_chart = $this->amba->getList();
               if($date_from !="" && $date_after!=""){
                   $array_chart = $this->amba->getPeriode($date_from,$date_after);
               }
              else{
                  // recupérer le tableau pour formater les données du chartjs
                  $array_chart = $this->amba->getList();
             }
             $array_montant = [];// tableau pour les montants associé au chartjs
             $array_name =[];
            
            if(count($array_chart)!=0) {
               foreach($array_chart as $key => $values){
                  $arrays[$values['name']] = $values['total_montant'];
                }
             }
            
             arsort($arrays);// classer le tableau par ordre decroissant !
             foreach($arrays as $klm=>$valus){
                 $array_name[] = $klm;
                 $array_montant[] = $valus;
             }
                // recupère la date actuel en cours
                $date = date('Y-m-d');
                // recupérer le mot en cours
                $date1 = explode('-',$date);
                $code_mois  = $date1[1];
                $code_annee = $date1[0];
                $code = (int)$code_mois;
                 $this->order->getDataIdcodeorders();
                 // recuperer les somme
                 $is_admin =4;
                 $data_somme = $this->order->getSommeannee($is_admin);
                 // cacluler la somme de toute les valuers du tableau
                 $commission = $data_somme;
                 // commission du mois en cours créer
                 $data_somme1 = $this->order->getSommemois($is_admin);
                 // recupérer le mois en cours
                 $mois = $this->bilan->code_mois($code);
                 $annee = $code_annee;
                 $array1_somme =[];
              
                foreach($data_somme1 as $key => $values){
                   $array1_somme[] = $values['somme'];
                }
              
               $somme1 = array_sum($array1_somme);// recupérer la sommme des commission.
               $commission1 = $somme1;

               $date_cours =date('Y-m-d');
               $date_chaine = explode('-',$date_cours);
               $mois_c= (int)$date_chaine[1];
               $annee_c = (int)$date_chaine[0];
               $montant_cours  = $this->amba->getMensuel($mois_c,$annee_c);


              
               return view('partenaire.dashboard',['montant_cours' => $montant_cours, 'commission'=>$commission, 'commission1'=>$commission1, 'mois'=>$mois, 'annee'=>$annee, 'array_list'=>$array_list])
            ->with('array_name',json_encode($array_name,JSON_NUMERIC_CHECK))
            ->with('array_montant',json_encode($array_montant,JSON_NUMERIC_CHECK));
          
           }
            
        }
         
       }
    
    
    public function paiementpar($code_amba)
    {
           $code = $code_amba;
           $name_liss =  DB::table('partenaire_tokens')->select('tokens')->where('id_partenaire',$code_amba)->get();
           $name_listss = json_encode($name_liss);
           $listes = json_decode($name_listss,true);
           $list_token =[];
           foreach($listes as $valu){
               $list_token[] = $valu['tokens'];
           }
        
           if(count($list_token)!=0){
              $token = $list_token[0];
              return view('partenaire.paiementuser',['code_amba'=>$code_amba, 'token'=>$token]);
            }
           else{
              
              return ('une demande de paiement à deja enregistré sur ce tunnel chez elyamaje');
          }
    }


    public function paiementpars($code_amba)
    {
           $code = $code_amba;
           $name_liss =  DB::table('partenaire_tokens')->select('tokens')->where('id_partenaire',$code_amba)->get();
           $name_listss = json_encode($name_liss);
           $listes = json_decode($name_listss,true);
           $list_token =[];
           foreach($listes as $valu){
               $list_token[] = $valu['tokens'];
           }
        
           if(count($list_token)!=0){
              $token = $list_token[0];
              return view('partenaire.paiementusers',['code_amba'=>$code_amba, 'token'=>$token]);
            }
           else{
              
              return ('une demande de paiement à deja enregistré sur ce tunnel chez elyamaje');
          }
    }
    
    
    
    public function postpaiments(Request $request)
    {
           // recupérer les infos souhaités.
           $token = $request->token;
           $code_amba = $request->code_amba;
           $type = $request->paiement_type;
           $virement  ="bank_transfer";
           $bon_achat = "purchase_coupon";
           $paiement_type = "";
           // verifier si le token est dans notre base de données.
           $donnees_ids =  DB::table('partenaire_tokens')->select('tokens')->where('id_partenaire',$code_amba)->get();
           $lis = json_encode($donnees_ids); // tranformer les données en json
           $lis = json_decode($donnees_ids,true); // tranformer le retour json en array tableau..
           
           if($lis==""){
             return('partenaire.error');
           }
           
            $token_us = Str::random(60);
           $list_token =[];
         
           foreach($lis as $key =>$valc) {
              $list_token[] = $valc['tokens'];
           }
             // transformer en tableau 
             // destinaire mourad.
            $array_destinataire = array('martial@elyamaje.com','paiement-ambassadrice@elyamaje.com','comptabilite@elyamaje.com');// AMBASSADRICE..
            $array_destinataire2 =  array('martial@elyamaje.com','paiement-partenaire@elyamaje.com','comptabilite@elyamaje.com'); // PARTENAIRE....
          
            if(count($list_token)!=0){
                // recupérer le nom du partenaire et l'email de l'ambassadrice
                $id = $code_amba;
                $infos = $this->users->getUserId($id);
                $infos_mail = $infos->email;
                $infos_name = $infos->name.' '.$infos->username;
                $is_admin = $infos->is_admin;
                $id_token = $list_token[0];

               $lastOne = DB::table('pointbilans')->where('id_ambassadrice','=',$code_amba)->latest('id')->first(); // id dernier enregsitrement de facture
               $last_id =$lastOne->id;
               if($type==$virement OR $type==$bon_achat){
                    if($type == $virement) {
                       $libelle="virement bancaire";
                       $paiement_type = "Virement Bancaire";
                       $status_paiement = $type;
                    }
                 
                    if($type==$bon_achat) {
                       $libelle="un bon d'achat";
                       $paiement_type = "Bon d'achat";
                       $status_paiement= $type;
                    }
                      // envoi la confirmation de mail !
                       $subject="Demande de paiement de   $infos_name";
                      //
                      
                      if($is_admin == 2) {
                          $status=" L'Ambassadrice";
                         foreach($array_destinataire as $val) {
                             // envoi du mail mutiple au customer
                              Mail::send("email.confirmationpartenaire",['infos_name' => $infos_name, 'infos_mail' =>$infos_mail,'libelle'=>$libelle,'status'=>$status] , function($message) use ($subject, $val) {
                              $message->to($val);
                              $message->from('no-reply@elyamaje.com');
                              $message->subject($subject);
                             });
                           }
                    
                       }

                       if($is_admin == 4){
                          $status=" Le Partenaire";
                          foreach($array_destinataire2 as $vals){
                             // envoi du mail mutiple au customer
                              Mail::send("email.confirmationpartenaire",['infos_name' => $infos_name, 'infos_mail' =>$infos_mail,'libelle'=>$libelle,'status'=>$status] , function($message) use ($subject, $vals) {
                              $message->to($vals);
                              $message->from('no-reply@elyamaje.com');
                              $message->subject($subject);
          
                              });
                           }

                         }
                           // delete le token dans la bdd pour envoi unique de sécurisation de email.
                           DB::table('partenaire_tokens')->where('tokens',$id_token)->delete();
                           // renvoi une route de confirmation
                            // faire un update.
                            DB::table('pointbilans')->where('id', $last_id)->update([
                              'status_paiement' => $paiement_type
                            ]);

                        return view('partenaire.confirmpay', ['paiement_type' => $paiement_type]);
                }     
           }
          else{
             
              return view('partenaire.error');
         }
     }

     
     public function postpaimentss(Request $request)
     {
            // recupérer les infos souhaités.
            $token = $request->token;
            $code_amba = $request->code_amba;
            $type = $request->paiement_type;
            $virement  ="bank_transfer";
            $bon_achat = "purchase_coupon";
            $paiement_type = "";
            // verifier si le token est dans notre base de données.
            $donnees_ids =  DB::table('partenaire_tokens')->select('tokens')->where('id_partenaire',$code_amba)->get();
            $lis = json_encode($donnees_ids); // tranformer les données en json
            $lis = json_decode($donnees_ids,true); // tranformer le retour json en array tableau..
            
            if($lis==""){
              return('partenaire.error');
            }
            
             $token_us = Str::random(60);
            $list_token =[];
          
            foreach($lis as $key =>$valc) {
               $list_token[] = $valc['tokens'];
            }
              // transformer en tableau 
              // destinaire mourad.
             $array_destinataire = array('martial@elyamaje.com','paiement-ambassadrice@elyamaje.com');// AMBASSADRICE..
             $array_destinataire2 =  array('martial@elyamaje.com','paiement-partenaire@elyamaje.com'); // PARTENAIRE....
           
             if(count($list_token)!=0){
                 // recupérer le nom du partenaire et l'email de l'ambassadrice
                 $id = $code_amba;
                 $infos = $this->users->getUserId($id);
                 $infos_mail = $infos->email;
                 $infos_name = $infos->name.' '.$infos->username;
                 $is_admin = $infos->is_admin;
                 $id_token = $list_token[0];
 
                $lastOne = DB::table('pointbilans')->where('id_ambassadrice','=',$code_amba)->latest('id')->first(); // id dernier enregsitrement de facture
                $last_id =$lastOne->id;
                if($type==$virement OR $type==$bon_achat){
                     if($type == $virement) {
                        $libelle="virement bancaire";
                        $paiement_type = "Virement Bancaire";
                        $status_paiement = $type;
                     }
                  
                     if($type==$bon_achat) {
                        $libelle="un bon d'achat";
                        $paiement_type = "Bon d'achat";
                        $status_paiement= $type;
                     }
                       // envoi la confirmation de mail !
                        $subject="Demande de paiement de   $infos_name";
                       //
                       
                       if($is_admin == 2) {
                           $status=" L'Ambassadrice";
                          foreach($array_destinataire as $val) {
                              // envoi du mail mutiple au customer
                               Mail::send("email.confirmationpartenaire",['infos_name' => $infos_name, 'infos_mail' =>$infos_mail,'libelle'=>$libelle,'status'=>$status] , function($message) use ($subject, $val) {
                               $message->to($val);
                               $message->from('no-reply@elyamaje.com');
                               $message->subject($subject);
                              });
                            }
                     
                        }
 
                        if($is_admin == 4){
                           $status=" Le Partenaire";
                           foreach($array_destinataire2 as $vals){
                              // envoi du mail mutiple au customer
                               Mail::send("email.confirmationpartenaire",['infos_name' => $infos_name, 'infos_mail' =>$infos_mail,'libelle'=>$libelle,'status'=>$status] , function($message) use ($subject, $vals) {
                               $message->to($vals);
                               $message->from('no-reply@elyamaje.com');
                               $message->subject($subject);
           
                               });
                            }
 
                          }
                            // delete le token dans la bdd pour envoi unique de sécurisation de email.
                            DB::table('partenaire_tokens')->where('tokens',$id_token)->delete();
                            // renvoi une route de confirmation
                             // faire un update.
                             DB::table('pointbilans')->where('id', $last_id)->update([
                               'status_paiement' => $paiement_type
                             ]);
 
                         return view('partenaire.confirmpay', ['paiement_type' => $paiement_type]);
                 }     
            }
           else{
              
               return view('partenaire.error');
          }
      }


 }
    
    
