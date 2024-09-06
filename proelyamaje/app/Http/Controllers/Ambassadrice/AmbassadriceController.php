<?php

namespace App\Http\Controllers\Ambassadrice;

use Mail;
use DateTime;
use Carbon\Carbon;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Http\Service\CallApi\Apicall;
use App\Repository\Users\UserRepository;
use App\Http\Service\Mailer\ServiceMailer;
use App\Repository\Coupon\CouponRepository;
use App\Http\Service\CallApi\GetDataCoupons;
use App\Models\Ambassadrice\Ambassadricecustomer;
use App\Repository\Bilandate\BilandateRepository;
use App\Repository\Cardsgift\CardsgiftRepository;
use App\Repository\Giftcards\GiftcardsRepository;
use App\Repository\Ambassadrice\CodeliveRepository;
use App\Models\Ambassadrice\Ordercodepromoaffichage;
use App\Repository\Ambassadrice\LivestatistiqueRepository;
use App\Repository\Ambassadrice\AmbassadricecustomerRepository;
use App\Repository\Ambassadrice\OrdercodepromoaffichageRepository;
use App\Repository\Ambassadrice\Ordercustomer\OrderambassadricecustomsRepository;
use App\Repository\Faq\FaqRepository;

class AmbassadriceController extends Controller
{
    //
       private $api;
       private $repo;
       private $orders;
       private $mailer;
       private $data = [];
       private $coupons;
       private $coupon;
       private $ordercode;
       private $code;
       private $live;
       private $cards;
       private $gift;
       private $faq;


      public function __construct(
      AmbassadricecustomerRepository $repo,
      OrderambassadricecustomsRepository $orders,
      OrdercodepromoaffichageRepository $ordercode,
      BilandateRepository $bilan,
      Apicall $api,
      ServiceMailer $mailer,
      GetDataCoupons $coupons,
      CouponRepository $coupon,
      CodeliveRepository $code,
      LivestatistiqueRepository $live,
      CardsgiftRepository $cards,
      GiftcardsRepository $gift,
      UserRepository $user,
      FaqRepository $faq
      
      )
      {
         $this->repo = $repo;
         $this->api = $api;
         $this->orders = $orders;
         $this->mailer = $mailer;
         $this->bilan = $bilan;
         $this->coupons = $coupons;
         $this->coupon = $coupon;
         $this->ordercode = $ordercode;
         $this->code = $code;
         $this->live = $live;
         $this->cards = $cards;
         $this->gift = $gift;
         $this->user = $user;
         $this->faq = $faq; 
      }
      
        /**
   * @return array
    */
   public function getData(): array
   {
      return $this->data;
   }
   
   
   public function setData(array $data)
   {
     $this->data = $data;
    return $this;
   }
  

    
    public function user()
    {
       
      
        if(Auth()->user()->is_admin ==2 OR Auth()->user()->is_admin ==4)
        {
          
             $id = Auth::user()->id;
             $email = Auth::user()->email;
             // lancer l'action sur historique paiement.
             $this->bilan->insert($id);
            // recupére les données du mois en cours
             $ventes =  $this->orders->getCountorders($id);
             // recupérer le montant des gaim de 20% ambassadrice;
             $gain = number_format($ventes, 2, ',', '');
            // recupérer les ventes total mensuelles en cours.
             $donnees = $this->orders->getdataAll($id);
            // recupérer le nombre de ventes mensuelle généré par les code élévés
             $vente_eleves = $this->orders->getCounteleve();
          
            $nombres =count($vente_eleves);
          
             $nombre  = count($donnees);
          if($nombre ==0){
              $css="no";
              $img="non";
          }
          
          else{
              $css="code1";
              $img='notification';
          }
          
           $dd = $this->orders->getCountlive();
          // recupérer le nombre de vente mensuel génére par le live de l'ambassadrice
          $nbrs = count($dd);
          // recupérer le nombre de customer créer en cours du mois
          $this->repo->getDatacount($id);
          $dones = $this->repo->getCountcustomer();
        
         // recupére le nombre total des customs créer
         if(count($dones)!=0){
            if(Auth()->user()->id ==3){
             $num = count($dones)-1;
            }
            
            else{
              $num = count($dones);
            }
         }
         else{
             $num =0;
         }
         $nums = (int)$num;
         // recupérer la periode du temps en cours
         $date = date('Y-m-d');
         $datet  = explode('-',$date);
         $code_mois = (int)$datet[1];
         $annee = (int)$datet[0];
         // recupérer le mois en cours
        $mois = $this->bilan->code_mois($code_mois);
        
        // recupérer le statuts pour code live
          if(Auth()->user()->is_admin ==2) {
              $data_status = $this->code->getdatacodelive($id);
               $status ="";
               $css="";
                $heure ="";
                $code="";
                $code_live_user="";
               $code_reduction="";
        
          foreach($data_status as $kj => $val) {
            
              $status = $val['status'];
              $css = $val['css'];
              $heure = $val['date_expire'];
              $code = $val['nombre_fois'];
              $code_live_user = $val['code_live'];
              $code_reduction = $val['code_reduction'];
          }
        
         }
         
         
         if(Auth()->user()->is_admin ==4){
                $status ="";
                $css="";
                $heure ="";
                $code="";
                $code_live_user="";
               $code_reduction= Auth()->user()->code_reduction;
         }
        
           
          // recupérer les dates dans la table des lives activés
          $this->live->getdatacodelive($id);
          $date_listes = $this->live->listdates();
         // recupérer l'heure courant ou le live as déclecnhé
         
         // recupérer les données pour l'affichage des cartes cadeaux gift
         $somme_cards =0;
         $cox = Auth()->user()->code_giftcards;
        
         if($cox==""){
          $somme_card =[];
           $css_action="nullcard";
          $code_number="";
          $somme_cards =0;
          $somme_api = "";
         }
         else{
            
              $somme_card =  $this->gift->getamountcard($cox);
              if($somme_card!="no"){
              $css_action="cards_bon";
              $somme_cards = $somme_card[0]['balance'];
              $code_number = $cox;
              $somme_api = number_format($somme_cards, 2, ',', '');// convertir le monant avec une virgule. somme api.

            }else{
              $css_action="cards_bon";
              $somme_cards = 0;
              $code_number = $cox;
              $somme_api = "pas disponible";
            }
             
          }

       // convertir le montant
        $somme_api = number_format($somme_cards, 2, ',', '');// convertir le monant avec une virgule. somme api.
        // recupérer l'heure actuel courante
        $date = date('Y-m-d H:i:s');
        // Mettre à jour la date courante et l'heure en php
        $date2 = date("Y-m-d H:i:s", strtotime($date.'+ 1 hours'));// l'heure a laquelle le live est programmév(+1h changeante )....
        
        // recupére la date courate actuel(format date) à ajouter 3h
        $date_jour = date("Y-m-d", strtotime($date.'+ 1 hours'));
        
        // soustraire 3h à la date programmé depuis la bdd
         $debut_live = date("Y-m-d H:i:s", strtotime($heure.'- 2 hours'));// l'heure à laquel le bouton vert doit apparaitre.(date changeante -3h)
         
         $heure_fixe ="22:59:59"; // 1 h de moins de la date d'avant 23:59:59 date changeante(saison -1h)....// sais +1h.
         $heure_fixe2 = date($heure_fixe);
         
         $debut_live_heure = date("H:i:s", strtotime($heure.'+ 0 days'));
        
         $heure_final = strtotime($heure_fixe2)-strtotime($debut_live_heure);
         
         // recupére au format souhaiter
         $hh = date("H:i:s", ($heure_final));
        
        // recupérer heure de la difference
        $hhs = explode(':',$hh);
        //
        $xx = (int)$hhs[0];
        // recupérer les minutes
        $xx1 = (int)$hhs[1];
        
        // ajouter 1 jour sur la date 
        $date_fin = date("Y-m-d:H:i:s", strtotime($heure.'+ '.$xx.'hours  '.$xx1.'minute'));
         $date5 = date("Y-m-d", strtotime($heure.'+ 0 days'));
       // si le partenaire est connecté
         $idf = Auth()->user()->is_admin;
         
        if($code == "") {
            $ss="";
            $hh="";
            $csss="noprograme";
            $ids="";
            $is_admin="";
        } 

        
        if($heure > $date2 || $css == "demandecode"){
            $ss = $status;
            $hh =$heure;
            $csss = $css;
            $ids="";
            $is_admin=$idf;
            
        } else{
            $ss="";
            $hh="";
            $csss="noprograme";
            $ids="";
            $is_admin ="";
           
        }
       
         // AFFICHER LE boutons du live à cliquer...
        
        $date = date('Y-m-d H:i:s');
        $date_day = date('Y-m-d');
        $debut_live = date("Y-m-d H:i:s", strtotime($heure.'- 3 hours'));
        $date_limit = date("Y-m-d", strtotime($debut_live.'+ 1 days'));

        if($date >= $debut_live && $date_day < $date_limit && $css == "activecode") {
            
            $ids = $id;
            $hh="";
            $csss="green";
            $ss="Déclencher le live";
            $is_admin = $idf;
        
           if($code==1){ 
                $ids ="";
                $hh="";
                $csss="livereel";
                $ss="Le live est en en cours";
                $id_admin = $idf;
            }
            
         }

         
            // Si le live peut-être démarré check si aucun panier est vide sinon bloquer l'action
            if($css == "paliervide"){
                $csss = "paliervide";
                $ss = "Un de vos palier est vide ! Veuillez éditer vos palier live";
            }


            // Supprime les status de live (live programmé...) aux dates antérieurs
            $userlives = Auth::user()->id; 
            $date_actuel = date('Y-m-d H:i:s');
            
            if(isset($val['date_after'])) {
                $date_after = Carbon::parse($val['date_after']);
                $date_after = $date_after->addHours(3);
                $date_after = $date_after->isoFormat("Y-MM-DD H:mm:s");
    
                 if($date_after < $date_actuel){
    
                    // mettre a jour le tableau de bord pur les id
                    $new_status_field ="";
                    $css_field="";
                    $nombre_fois_field=0;
    
                     DB::table('codelives')
                        ->where('id_ambassadrice', Auth::user()->id)
                        ->update(array('status' => $new_status_field,
                        'css'=> $css_field,
                        'nombre_fois'=>$nombre_fois_field
                    ));
                } 
            }
            
            if($csss == "livereel"){
                $live = $this->live->getdatacodelive($userlives);
                $last_live = $live[array_key_last($live)];  
                $date_limit = Carbon::parse($last_live['updated_at']);
                $newDate = $date_limit->addHours(24);
                $date_limit = $newDate->isoFormat(' DD/MM/YYYY à HH:mm');

            } else {
                $date_limit = false;
            }

            if($ss == "Live demandé le  10/02/2020 à 20:00"){
                $ss = "";
                $csss = "";
            }

            // Afficher le lien de modification du live une fois la demande est faire ou proframmer
             $csslien ="noaffiche";
             if($css =="activecode" OR $css =="demandecode"){
                 $csslien="yesaffichelien";
            }


           return view('ambassadrice.user',['num'=>$nums, 'nombre' => $nombre, 'gain'=>$gain, 'css'=>$css, 'img'=>$img, 'nombres'=>$nombres, 
          'nbrs'=>$nbrs,'mois'=>$mois,'annee'=>$annee, 'ss'=>$ss, 'csss'=>$csss, 'ids'=>$ids, 
         'email'=>$email,'is_admin'=>$is_admin,'code_number'=>$code_number,'css_action'=>$css_action,
         'code_live_user'=>$code_live_user,'code_reduction'=>$code_reduction,'somme_api'=>$somme_api,'csslien'=>$csslien,
         'date_limit' => $date_limit]);
    }
   }
   
   
   public function userstat()
   {
       // recupérer les données 
       $id = Auth()->user()->id;
       //: nombre de vente par code élève
        $data = $this->orders->getCountAll($id);
       // recupérer les codes live et code promo
        $nombre_live = [];
        $nombre_code = [];
        $nombre_live_montant = [];// montant total via code live
        $nombre_code_montant = [];// montant total via code élève
         foreach($data as  $values)
         {
            $x = $values['code_promo'];
            $index_tab  =  explode('-',$x);
            
            if(count($index_tab)==2)
            {
                $nombre_live[] = $values['code_promo'];
                $nombre_live_montant[] = $values['somme'];
            }
            
            else{
                $nombre_code[] = $values['code_promo'];
                $nombre_code_montant[] = $values['somme'];
            }
        }
        
        $nombr_code = count($nombre_code);
        $nombr_live = count($nombre_live);
        //array sum
        $nombr_live_montant = array_sum($nombre_live_montant);
        $nombr_code_montant = array_sum($nombre_code_montant);
        // definit le smontant
        $panier_montant_code="";
         $panier_montant_live="";
        
        $taux_conversion ="";
        
        if($nombr_code !=0 && $nombr_code_montant !=0) {
            $panier_montant_code = number_format($nombr_code_montant/$nombr_code, 2, ',', '');
									
        }
        
        if($nombr_live !=0 && $nombr_live_montant!=0){
            $panier_montant_live = number_format($nombr_live_montant/$nombr_live, 2, ',', '');
        }
        
        if($nombr_code==0) {
            $panier_montant_code =0;
            $taux =0;
        }
        
        if($nombr_live==0) {
            $panier_montant_live =0;
        }
        
          // pour l'ensemble de code promo créer
          $data1 = $this->repo->getCustomerId($id);
          $name_list = json_encode($data1);
           $name_list = json_decode($data1,true);
            $nombre_total = [];
           foreach($name_list as $val){
               $nombre_total[] = $val['code_promo'];
           }
             // nombre total de code créer
           $nombr_total = count($nombre_total);
           if($nombr_code!=0 && $nombr_total!=0){
               $taux = number_format($nombr_code*100/$nombr_total, 0, ',', '');
           }
           
           if($nombr_total==0){
               $taux=0;
           }
           
            // recupérer le nombre de live effectué au total.
             $data2 = $this->live->getdatacodelive($id);
             $nombre_total_live = count($data2);
            // recupérer le top 3 des produits les plus vendu par l'ambassadrice ou partenaire
             $data_ventes= DB::table('promotionsums')->select('id_product','label_product','sku','code_promo', 'somme')->where('id_ambassadrice','=',$id)->get();
             $list = json_encode($data_ventes);
              $lists = json_decode($data_ventes,true);
               $data_vente =[];// pour les lives
               $data_vent = [];// pour les codes promo
               // deux varibale
                $lives ="-amb";
                $code_promo = "-10";
                $code_promos ="10";
              
                $data_vente_live =[];
                $data_vente_promo =[];
              
              foreach($lists as $kl=>$vb){
                  if($vb['sku']!="") {
                      $data_vente[] = $vb['label_product'].' ,'.$vb['sku'];
                  }
                  
                  if($vb['code_promo']!=""){
                      // recupérer les données des ventes lives si le code promo contient  -amb
                      if(strpos($vb['code_promo'],$lives)!=false){
                          $data_vente_live[] = $vb['label_product'].' ,'.$vb['id_product'].' ,'.$vb['somme'];
                      }
                        // recupérer des données ventes code promo si les code promo contient -10
                      elseif(strpos($vb['code_promo'],$code_promo)!=false){
                          $data_vente_promo[] =  $vb['label_product'].' ,'.$vb['id_product'].' ,'.$vb['somme'];
                      }
                      else{
                        $data_vente_live[] = $vb['label_product'].' ,'.$vb['id_product'].' ,'.$vb['somme'];
                      }
                  }
              }
              
             
               $list_data_live =[];// recupérer le top 10 des live 
             
             if(count($data_vente_live)!=0) {
                    // compter le nombre de fois l'iteration dans les array lives et promo
                    $data_ventes_lives= array_count_values($data_vente_live);
                    // resortir un tableau decroissant via la valeur
                    arsort($data_ventes_lives);
                    // recupérer les clé du tableau qui sont des labels product 
                     $data_top_live = array_keys($data_ventes_lives);
                     // recupérer les 10 premiers produit via les lives.
                   $x_data_live = array_slice($data_top_live,0,11);
                   foreach($x_data_live as $vn){    
                       $xx = explode(',',$vn);
                       $list_data_live[] = ['name' => $xx[0], 'quantity' => $data_ventes_lives[$vn], 'price' => $data_ventes_lives[$vn] * $xx[array_key_last($xx)]];

                   }
                     // recupére les 3 premiers produits top live
                    $top_live11 = explode(',',$data_top_live[0]);
                    $top_live12 =  explode(',', $data_top_live[1]);
                    $top_live13 = explode(',',$data_top_live[2]);
                    $css="oui";
                     $top_live1 = $top_live11[0];
                     $top_live2 =  $top_live12[0];
                    $top_live3 =  $top_live13[0];
                     $css="oui";
                }
                 else{
                      $top_live1 ="";
                      $top_live2 ="";
                       $top_live3 = "";
                        $css="no";
                 }
             
                 $list_code_promo =[];
             
               if($data_vente_promo) {
               
                    $data_ventes_promo = array_count_values($data_vente_promo);
                    arsort($data_ventes_promo);
                    $data_top_promo = array_keys($data_ventes_promo);
                    // recupérer les 10 premiers produit via les codes promo élève.
                    $x_data_code = array_slice($data_top_promo,0,11);
                    $list_code_promo =[];// recupérer le top 10 des live 

                    foreach($x_data_code as $vns) {
                      $xxs = explode(',',$vns);
                      $list_code_promo[] = ['name' => $xxs[0], 'quantity' => $data_ventes_promo[$vns], 'price' => $data_ventes_promo[$vns] * $xxs[array_key_last($xxs)]];
                    //   $list_code_promo[] = $xxs[0];
                    }
                      // recupérer les 3 premiers produits top promo
                      $top_promo11 = explode(',',$data_top_promo[0]);
                      $top_promo21 =  explode(',',$data_top_promo[1]);
                      $top_promo31 = explode(',',$data_top_promo[2]);
                      $css="oui";
                      $top_promo1 = $top_promo11[0];
                      $top_promo2 =  $top_promo21[0];
                      $top_promo3 =  $top_promo31[0];
                      $css="oui";
                    }
                    else{
                     $top_promo1 = "";
                     $top_promo2 =  "";
                     $top_promo3 = "";
                     $css="no";
                 }
                // pas de live pour les partenaire
                 if(Auth()->user()->is_admin ==4) {
                    $list_data_live =[];
                }

        return view('ambassadrice.userstatistique',['nombr_code'=>$nombr_code, 'nombr_live'=>$nombr_live,'nombr_total'=>$nombr_total,'nombre_total_live'=>$nombre_total_live,'nombr_live_montant'=>$nombr_live_montant,
       'nombr_live_montant'=>$nombr_live_montant,'nombr_code_montant'=>$nombr_code_montant,'panier_montant_code'=>$panier_montant_code,'panier_montant_live'=>$panier_montant_live,'taux'=>$taux
       ,'top_live1'=>$top_live1,'top_live2'=>$top_live2, 'top_live3'=>$top_live3,'top_promo1'=>$top_promo1,'top_promo2'=>$top_promo2,'top_promo3'=>$top_promo3,'list_data_live'=>$list_data_live,'list_code_promo'=>$list_code_promo]);
   }
    
    
    public function account()
    {
        if(Auth()->user()->id == 90){
            return view('error.error');
        }

        $emailc =[];
        $emailc2  =[];
        $css="no";
        $message="";
        $messages="";
        $messages3="";
        $precision ="";
        $horaire =[];
        $array_emailc =[];
        $array_emailc1 = [];
        $array_emailc2 = [];

        return view('ambassadrice.account', ['emailc'=>$emailc, 'emailc2'=>$emailc2, 'css'=>$css, 'message'=>$message, 'messages'=>$messages, 'messages3'=>$messages3,'horaire'=>$horaire,'array_emailc'=>$array_emailc,
        'array_emailc1'=>$array_emailc1,'array_emailc2'=>$array_emailc2,'precision'=>$precision]);
    }
    
    
    public function lists()
    {
        return view('ambassadrice.lists');
    }
    
    
    
    public function listeleve(Request $request)
    
    {
         if(Auth()->user()->is_admin ==2 OR Auth()->user()->is_admin ==4){
            // ceation des data amabassadrice
            $id_ambassadrice = Auth::user()->id;
            $id = $id_ambassadrice;
            // recupérer la liste des utilisateurs
            // recupérer la variable search
            $search = $request->get('search_name');
            
             $users_mobile = $this->ordercode->getallidmobile($id);
          
            if($search!=""){
                 $users_mobile = $this->ordercode->getsearch($search,$id);
            }
            
           else {
                // mobile
                $this->repo->getCsutomsambassadrice($id);
              $users = $this->ordercode->getallidmobile($id);
               $users_mobile = $this->ordercode->getallidmobile($id);
            }
            
               // recupérer la liste actualisé
              $this->repo->getCsutomsambassadrice($id);
              $users = $this->ordercode->getallid($id);
             if($search=="tous" OR $search==""){
                // recupérer la liste actualisé
               $this->repo->getCsutomsambassadrice($id);
              $users = $this->ordercode->getallid($id);
              $users_mobile = $this->ordercode->getallidmobile($id);
            }
             
             if($users ==false) {
                 return view('ambassadrice.lists');
             }

             $message="";
             $css ="nocss";

              /// recupérer id passer dans le formulaire
              $id = $request->get('line-id');
              // aller recupérer l'email de léléve.
             if($id!=""){
                 $user = $this->repo->getidline($id);
                 $email="";
                 $code_promo="";
                 $nom_eleve ="";
        
                foreach($user as $vad) {
                    $email=$vad['email'];
                    $code_promo =$vad['code_promo'];
                    $nom_eleve = $vad['nom'];
                }
        
                  $libelle="renvoi de code promo ";
                  $nom_ambassadrice= Auth()->user()->name;
                  // ceation des data amabassadrice
                   $id_ambassadrice = Auth::user()->id;
                   $id = $id_ambassadrice;

                   $message="code promo envoyé avec succès";
                   $css="yescss";
      
                   Mail::send('ambassadrice.emails2', ['code_promo' => $code_promo, 'libelle'=>$libelle,'email' =>$email,'nom_eleve'=>$nom_eleve,'nom_ambassadrice'=>$nom_ambassadrice], function($message) use($email){
                      $message->to($email);
                       $message->from('no-reply@elyamaje.com');
                       $message->subject('Renvoi de votre code promo !');
                      });
                      
             }
             
             return view('ambassadrice.listeleve',['users'=>$users, 'users_mobile'=>$users_mobile,'message'=>$message,'css'=>$css]);
        }
    
    }


     public function list(Request $request)
     {
        
        if(Auth()->user()->is_admin ==2 OR Auth()->user()->is_admin ==4){
        
          // recupérer la variable
           $code = $request->get('id_code_add');
           if($code!=""){
               //id_code renvoi de code promo
           }
        
        // ceation des data amabassadrice
            $id_ambassadrice = Auth::user()->id;
            $id = $id_ambassadrice;
            // recupérer la liste des utilisateurs
            // recupérer la variable search
            $search_name = $request->get('search_name');
             $search = $request->get('search_name');
             $users_mobile = $this->ordercode->getallidmobile($id);
          
            if($search!="") {
                 $users_mobile = $this->ordercode->getsearch($search,$id);
                 
            }
            
           else {
                // mobile
                $this->repo->getCsutomsambassadrice($id);
              $users = $this->ordercode->getallidmobile($id);
               $users_mobile = $this->ordercode->getallidmobile($id);
            }
            
               // recupérer la liste actualisé
              $this->repo->getCsutomsambassadrice($id);
              $users = $this->ordercode->getallid($id);
              if($search=="tous" OR $search=="") {
                // recupérer la liste actualisé
                $this->repo->getCsutomsambassadrice($id);
                $users = $this->ordercode->getallid($id);
                $users_mobile = $this->ordercode->getallidmobile($id);
            }
             
             if($users ==false) {
                 return view('ambassadrice.lists');
             }
             $message="";
             $css="nocss";

                 /// recupérer id passer dans le formulaire
                 $id = $request->get('line-id');
                 // aller recupérer l'email de léléve.
                if($id!=""){
                    $user = $this->repo->getidline($id);
                    $email="";
                    $code_promo="";
                    $nom_eleve ="";
           
                   foreach($user as $vad) {
                       $email=$vad['email'];
                       $code_promo =$vad['code_promo'];
                       $nom_eleve = $vad['nom'];
                   }
           
                     $libelle="renvoi de code promo ";
                     $nom_ambassadrice= Auth()->user()->name;
                     // ceation des data amabassadrice
                      $id_ambassadrice = Auth::user()->id;
                      $id = $id_ambassadrice;
   
                      $message="code promo envoyé avec succès";
                      $css="yescss";
                      
                      // recupérer id du model de message
         
                      Mail::send('ambassadrice.emails2', ['code_promo' => $code_promo, 'libelle'=>$libelle,'email' =>$email,'nom_eleve'=>$nom_eleve,'nom_ambassadrice'=>$nom_ambassadrice], function($message) use($email){
                         $message->to($email);
                          $message->from('no-reply@elyamaje.com');
                          $message->subject('Renvoi de votre code promo !');
                         });
                         
                }


                // recupérer l'id du modèlé
                // recupérer la liste des messages
                $id=Auth()->user()->id;
                $data_messages = $this->repo->getmodelmessage($id);
                 $amba = Auth()->user()->name;

             
              return view('ambassadrice.list',['users'=>$users, 'users_mobile'=>$users_mobile,'css'=>$css,'message'=>$message,'data_messages'=>$data_messages,'amba'=>$amba]);
        }
    }
    
    
     public function editaction($id)
     {
           if(Auth()->user()->is_admin==2 OR Auth()->user()->is_admin ==4)
           {
              $message="";
              $user = $this->repo->getCustomersId($id);
           
             return view('ambassadrice.edit',['user'=>$user, 'id' => $id, 'message'=>$message]);
           
           }
            
     }
     
     public function addaction($id)
     {
          if(Auth()->user()->is_admin==2 OR Auth()->user()->is_admin ==4)
          {
              //dump($id);
              $user = $this->repo->getCustomersId($id);
               $data = json_encode($user);
               $data =  json_decode($user, true);
               // 
                $id = Auth()->user()->id;
               //dump($data['email']);
               $date_x  =  $this->repo->getemaildate($data['email'],$id);
               
               foreach($date_x as $vl){
                $date_group[] = $vl['date'];
               }
            
              // dump($date_group);
              $date_max = max($date_group);
             // dump($date_max);
               // soustraire 1 ans à cette date
              $date_soustraire = date('Y-m-d', strtotime($date_max. ' -1 years'));
              // verifier combien de code que l'ambassadrice ou partenaire à générée  dans ce intervalle.
                $nombre_create =  $this->repo->getbetwen($data['email'],$date_soustraire,$date_max,$id);
                $datas = json_encode($nombre_create);
                $datas =  json_decode($nombre_create,true);
                $nombre_user = count($datas);
                 // Afficher des message
                  $message_lecture ="";
             
                 if($nombre_user > 1) {
                $message_lecture ="Vous ne pouvez pas créer de code promo supplémentaire pour cet élève car vous avez atteint le
                quota sur l'année (2 par an et dans un intervalle de 2 mois)";
                $message_lectures="";
                $message_type="danger";
             }

             if($nombre_user ==1 OR $nombre_user ==0){
                   // recupérer la dernier date et ajouter 2 mois .
                   $date_news = date('Y-m-d', strtotime($date_max. ' + 60 days'));
                     // transformer la date en francais
                     $date_fr =  explode('-',$date_news);
                    $date_fr1 = $date_fr[2].'/'.$date_fr[1].'/'.$date_fr[0];
                   // date aujourdhuit
                     $date_actuel = date('Y-m-d');
                      if($date_news > $date_actuel){
                          $message_lecture = "Vous pouvez ajouter un code seulement après le $date_fr1";
                          $message_lectures="";
                          $message_type="warning";
                     }
                     else{
                         $message_lecture="Vous pouvez ajouter un code à l'élève";
                         $message_lectures="";
                          $message_type="success";

                }
            }
              
                return view('ambassadrice.addcode',['user'=>$user,'message_lecture'=>$message_lecture,'message_lectures'=>$message_lectures, 'message_type' => $message_type]);
       }
     
     }
        
        
     public function editpost(Request $request,$id) 
     {
         if(Auth()->user()->is_admin == 2 OR Auth()->user()->is_admin == 4) {
            // recupérer les données correspondant email et codepromo
	        $array_email = $this->repo->getEmail($id);
	        
	        // recupérer l'ensemble des mails
	        foreach($array_email as $values) {
	            foreach($values as $val)
	            {
	               $data[] = $val;
	            }
	        }
	        
	        
	          $email = $request->get('account_email');
	         
	         if($data[0]!=$email){
	             // envoi de mail pour le nouveau code promo
	             $email = $request->get('account_email');
	             $nom_eleve = $request->get('account_name');
	             // recupérer l'adresse et le code postal
	             $adresse = $request->get('account_adresse');
	             $codepostal = $request->get('account_codep');
	             $code_promo = $data[1];
	             // nom Ambassadrice
	             $nom_ambassadrice = Auth()->user()->name;
	             
	             if(Auth()->user()->is_admin ==2){
	                 $libelle ="ambassadrice";
	              }
	             
	             if(Auth()->user()->is_admin ==4){
	                 $libelle ="partenaire";
	             }
	              // envoi de mail via php mailer
	              $subject = "Création code promo Elyamaje";
                  $from = 'no-reply@elyamaje.com';
                  $message="zapo";
                  
                  //envoi de mail via phpmailer
                 // $this->mailer->sendMailedit($email,$form,$message,$nom_ambassadrice,$code_promo,$libelle)
                 
                 // envoi de mail XXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX
                  // send email
                   Mail::send('ambassadrice.emails2', ['code_promo' => $code_promo, 'libelle'=>$libelle,'email' =>$email,'nom_eleve'=>$nom_eleve,'nom_ambassadrice'=>$nom_ambassadrice], function($message) use($request){
                    $message->to($request->get('account_email'));
                     $message->from('no-reply@elyamaje.com');
                     $message->subject('Confirmation de création de code promo !');
                    });
                    
                    
                    
                     $accounts = Ambassadricecustomer::findOrFail($id);
	       	         $accounts->nom = $request->input('account_name');
	     	        $accounts->prenom = $request->input('account_username');
		            $accounts->email = $request->input('account_email');
		             $accounts->adresse = $request->input('account_address');
		              $accounts->code_postal = $request->input('account_codep');
		              $accounts->telephone = $request->input('account_phone');
		             //insert
	                $accounts->save($request->all());
	                 $message="email modifié, renvoyer du code élève avec succès !";
                  
             }
	        
	        else{
	               $accounts = Ambassadricecustomer::findOrFail($id);
	       	       $accounts->nom = $request->input('account_name');
	     	       $accounts->prenom = $request->input('account_username');
	     	       $accounts->email = $request->input('account_email');
		           $accounts->adresse = $request->input('account_address');
		           $accounts->code_postal = $request->input('account_codep');
		           $accounts->telephone = $request->input('account_phone');
		            //insert
	               $accounts->save($request->all());
	                // renvoi sur la liste
	               $message ="vos données sont bien modifiées";
	        }
	        
	          $user = $this->repo->getCustomersId($id);
             return view('ambassadrice.edit',['user'=>$user, 'id' => $id, 'message'=>$message]);
       }
     
     }
        
    public function customers(Request $request)
    {
        
      if(Auth()->user()->is_admin ==2 OR Auth()->user()->is_admin == 4)
      {
          if(Auth::check()){
             // ceation des data amabassadrice
             $id_ambassadrice = Auth::user()->id;
             $nom = Auth::user()->name;
             $is_admin = Auth()->user()->is_admin;
          }
            // appelle de la fonction recupereation
            $id =$id_ambassadrice;
            // renvoi le nombre total de customer créer à la date du jour actuel now
            $donnes = $this->repo->getCountData($id);
            // recupérer le tableau des emails customer deja créer par l'ambassadrice
            $dones = $this->repo->donnees();
            // ajouter un email facultatif dans le tableau.
            //  $email_x ="xxxx@xx.xx";
            //  $doness = array($dones,$email_x);
             // recupérer le tableau des numéro de phone créer par l'ambassadrice
             $donees = $this->repo->donees();
             // recupérer les emails et la date
             $list_datas = $this->repo->listdatas();
            // recupérer les codes promo existant
             $data = $this->repo->getCode_promo();
            // créer compte client amabassadrice
             $current = Carbon::now();
             $dateToday = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current)->format('Y-m-d',$current);
          
             $percent = 10;
             $name = $request->get('nom');
             $prenom = $request->get('prenom');
             $email = $request->get('email');
             $tel = $request->get('phone');
             $adresse = $request->get('adresse');
              // filtrer les doublons dans le tableau.
              $emails = array_unique($email);
             /// NEW script //
            // recupérer les données pour insert
             $email_array =[];// recupérer la liste des email pour envoi mail
             $xs=[];// renvoyer les arrays via api si y'a création.
             
           if($id==37){
               $limit_create_code = 81;// exception charlen Amba 80 code par mois......
            }else{
               $limit_create_code= 50;
            }

            if($donnes < $limit_create_code) {
               foreach($emails as $keys => $insert) {
                    // création d'un tableau associatives......
                    $code_nom = substr($nom,0,7);
                    // creation de code promo
                    $number = rand(100,20000);
                    $name_ajoute = substr($name[$keys],0,7);
                    $num=10;

                    // filtrer le code promo
                     $res_name = str_replace( array( '%', '@', '\'', ';', '<', '>' ), ' ', $name_ajoute);// filtre sur les caractère spéciaux
                     $name_true = preg_replace("/\s+/", "", $res_name);// suprime les espace dans la chaine.
                    
                     $code_promo_test = $code_nom.'-'.$name_true.'-'.$number.'-'.$num;
                    //convertir un miniscule la chaine
                    $code_promof = strtolower($code_promo_test);
                   // recuperer id_admin (amabassadrice ou patenaire connecte)......
                    if(Auth()->user()->is_admin==2){
                       $libelle ="Ambassadrice";
                     }
                    if(Auth()->user()->is_admin ==4){
                      $libelle = "Partenaire";
                   }
                    // recupérer les emails et code promo créer dans un array associative..
                   if(!in_array($email[$keys], $dones)){
                        if($email[$keys]!="" && $name!=""){
                          $email_array[] = ['code_promo' =>$code_promof,
                                 'email' => $emails[$keys],
                                 'libelle'=>$libelle,
                                 'nom_ambassadrice'=>$nom,
                                 'nom_eleve' =>$name[$keys]
                                 
                               ];
                        }
                    }
            
                      // verifier l'existence du code promo en base
                       $code_p[] = $code_promof;
                      // definir les tableau à recupérer pour les different cas
                       $array_email =[];
                       $array_email1 = [];
                       $array_email2 =[];
                      $horaire = [];
                       $messages3="";
                       $code=0;
                       $status=0;
            
                   if(!in_array($email[$keys], $dones)){
                     
                      if($email[$keys]!="") {
                          // verifier l'unicité du code promo
                          $data=[
                         'id_ambassadrice'=> $id_ambassadrice,
                         'is_admin' => $is_admin,
                         'nom'=> $name[$keys],
                         'prenom'=>$prenom[$keys],
                         'email'=>$email[$keys],
                         'telephone' => $tel[$keys],
                         'adresse'=> $adresse[$keys],
                         'code_promo' => $code_promof,
                         'date' =>$dateToday,
                         'status'=>$status,
                          ];
                          
                           // création de variable ambassadrice ou paternaire.
                           if(Auth()->user()->is_admin==2){
                              $libelle ="ambassadrice";
                           }
                  
                           if(Auth()->user()->is_admin ==4){
                              $libelle = "partenaire";
                           }
                            // envoi de mail
                            $suject = "Création code promo Elyamaje";
                            $datas = $email_array;
                     
                            // insere POST dans Api woocomerce 
                            // créer les données datas 
                            $data_donnes =[];
                            $som =10;
                            $currents = Carbon::now();
                            $current = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$currents)->format('Y-m-d\TH:i:s',$currents);
                            // description
                            // le code expirer dans 1 ans.
                            $date_expire = $currents->addDays(365);
                            // recupère la date actuel en cours
                            $date = date('Y-m-d');
                           // recupérer le mot en cours
                            $date1 = explode('-',$date);
                            $code_mois  = $date1[1];
                            $code_annee = $date1[0];
                            // recupérer le mois en francais
                            $mois = $this->bilan->code_mois($code_mois);
                            $description = " Code promo  élève $libelle $code_nom $mois"; 
              
                          foreach($datas as $val){
                                $data_donnes [] = [
                               'code' => $val['code_promo'],
                               'amount' => $som,
                               'date_created' => $current,
                               'date_created_gmt'=> $current,
                               'date_modified' => $current,
                               'date_modified_gmt' => $current,
                               'date_expires'=>$date_expire,
                               'description'=>$description,
                                'discount_type' => 'percent',
                               'usage_limit' => '1',
                                'exclude_sale_items' =>true,
                               'individual_use' => true,
                               'excluded_product_ids' => [160265],
                             ];
                          } 
                       
                             // insert des données en post dans Api woocomerce Post.
                            $urls="https://www.elyamaje.com/wp-json/wc/v3/coupons";
                        
                             for($i=0; $i<count($data_donnes); $i++) {
                               $x =  $this->api->InsertPost($urls, $data_donnes[$i]);// retour create post.
                               $xs[] = json_decode($x,true);
                            
                             }
                             
                               if(isset($xs[0]['message'])){
                                 // renvoi une page d'erreur..probable soucis avec api..
                                 return redirect()->route('ambassadrice.account')->with('errors', 'Notre service est  momentanément indisponible ,réessayer plus tard!');
                              }
                              
                              // api créer.
                              // insert les données dans la table....
                            
                                 DB::table('ambassadricecustomers')->insert($data);
                            
                            // insert 
                           // recupération données api et insert dans bdd !...
                            $data_coupons = $this->coupons->getDatacoupons();
                            $array_id_coupon = $this->coupon->getIdcodepromo();
                            $array_codes = $this->coupon->getCodes();
                             $name_code = $this->coupon->getArraycode();
                          
                            foreach($data_coupons as $keys => $values) {
                               foreach($values as $k => $val) {
                                 if(isset($array_codes[$val['id']])==false){
                                  if(isset($name_code[$val['code']])==false){
                                  
                                       // recupérer LES CODES PROMO pas encore utilisé et inser dans la table
                                         $coupons = new Coupon();
                                         $coupons->id_coupons = $val['id'];
                                         $coupons->code_promos = $val['code'];
                                         $coupons->date_created = $val['date_created'];
                                         $coupons->save();
                                    }
                                    
                                 }

                               }
                
                             }
                         }
            
                    else{
                       // traiter les cas ou l'email devrais etre ajouter une second fois en fonction de l'interval de date.
                           foreach($list_datas as $k => $vales){
                    
                               foreach($vales as $ks => $vl) {
                                  foreach($request->get('email') as $vald) {
                                    if($vald == $vl) {
                                          // recupérer la date courante
                                         $date = $ks;
                                         // recupérer les emails dans un tableau
                                          $a[]=$vald;
                                         // compter le nombre de fois l'email as créer un code promo
                                           $b = count($a);
                                          // recupérer l'anné en cours
                                          $date2 = explode('-',$ks);
                                           $datet2 = $date2[0];
                                           // rajouter 30 jour a la date recuperer
                                          // rajouter un customer pas avant un  mois à la date
                                          $date_new = date('Y-m-d', strtotime($ks. ' + 30 days'));
                                         // Afficher le format
                                           $daded1 =  explode('-',$date_new);
                                           // recupérer la date courante
                                            $date_time = date('Y-m-d');
                                          // recupérer l'annnée 
                                             $date1 = explode('-',$date_time);
                                            $datet1 = $date1[0];
                             
                             
                                        if($datet1 == $datet2){
                                           if($b == 1) {
                                            if($date_time > $date_new) {
                                              // recupérer les email à valider le code promo après un mois
                                               $array_email[] = $vald;
                                              $messages3 ="";
                                                $horaire = [];
                                                 // enregistrer action ajouter code promo.
                                            }
                                          else{
                                     
                                           // recupérer les email à invalider le code promo avant 1 mois pour une seconde tentatives
                                          $array_email1[] = $vald;
                                          $messages3 ="";
                                           $horaire[] = $date_new;
                                    }
                                 
                                 }
                                
                                 
                             }
                     
                          }
                         
                    }
                     
                 }
                 
                }
                 
              }
                
            }
           
           }
             
                // recupérer le tableau et envoyé les emails au élèves contenant les codes promo
                  $lists = $email_array;
                 // envoi de mailXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXXX via phpmailer
                    $subject = "Création code promo Elyamaje";
                    $from = 'no-reply@elyamaje.com';
                    $message="connect";
                   $data = $lists;
                    $this->mailer->SendMails($data,$from,$subject,$message);//envoyer.
                  // traiter le retour de réponse des codes validés ou nom
                  // renvoyer des tableau unique
                   $array_emailc = array_unique($array_email);// email à valider pour un second compte promo.
                   $array_emailc1 = array_unique($array_email1);// email  non accepté  de code promo pas avant un mois
                    $array_emailc2 = array_unique($array_email2);// liste des email ne pouvant pas généré des code promo pendant la meme année plus de 2 fois.
                    $emails =[];
                    $emails1 = [];
              
              
                 foreach($request->get('email') as $val) {
    
                  if(in_array($val, $dones)) {
                      // Si $val est trouvé dans $dones, ajoutez-le à $emails
                      $val != null ? $emails[] = $val : '';
                  } else {
                      // Sinon, ajoutez-le à $emails1, en supposant qu'il ne devrait pas être dupliqué entre $emails et $emails1
                      $val != null ? $emails1[] = $val : '';
                  }
              }
                 
                  
                  $emailc = array_unique($emails);// email non valide pour code promo
                  $emailc1 = array_unique($emails1);// email accepté code promo
                  $emailc2 = array_unique(array_diff($emails1,$emails));
                  
                   // lister les tableau
                   // compter le nombre element dans le tableau
                   // tranformer en chaine de caractère
                   $list_mail = implode(',',$emailc);
                   $list_mail1 = implode(',',$emailc2);
                 
                   // remplacer 
                   $message="";
                   $messages="";
                   $message3="";
                   $precision="";
                   
                   if (count($emailc)>0 && count($emailc2)>0){
                      $nombre = count($emailc);
                      $message="Échec de création pour les e-mails suivants :";
                      $list = $list_mail;
                      $precision ="NB : Cette interface sert uniquement pour les élèves que vous n'avez pas encore créés. L'élève est existant ? Rendez vous sur la page Vos élèves, recherchez l'élève et attribuez lui un code.";
                      $css ="oui";
                      $messages ="Création validé pour les e-mails suivants :";
                      $list1 = $list_mail1;
                   }
                   else if (count($emailc2)>0 && count($emailc)==0){
                      $messages ="Création validé pour les e-mails suivants :";
                      $list1 = $list_mail1;
                      $list ="";
                      $css ="oui";
                      $emailc =[];
                   }

                   else if (count($emailc)>0 && count($emailc2)==0){
                    $nombre = count($emailc);
                    $message="Échec de création pour les e-mails suivants :";
                    $list = $list_mail;
                    $list1="";
                    $css ="oui";
                    $emailc = $emailc;
                    $emailc2 =[];
                    $precision ="NB : Cette interface sert uniquement pour les élèves que vous n'avez pas encore créés. L'élève est existant ? Rendez vous sur la page Vos élèves, recherchez l'élève et attribuez lui un code.";
                   }

                
                  // if(count($emailc)==0) {
                  //     $message="";
                  //     $css ="no";
                  //     $emailc =[];
                  //     $nombre  = count($emailc);
                  // }
                  
                  // else{
                  //     $nombre = count($emailc);
                  //     $message="Échec de création de code promo pour les mails existant suivants";
                  //     $list = $list_mail;
                  //     $css ="oui";
                  //     $emailc = $emailc;
                  //     $precision ="NB : Cette interface sert uniquement pour les élèves que vous n'avez pas encore créés. L'élève est existant ? Rendez vous sur la page Vos élèves, recherchez l'élève et attribuez lui un code.";
                      
                  // }
                  
                  // if(count($emailc1)==1){
                  //     $messages="";
                  //     $list1="";
                  //     $list ="";
                    
                  // }
                  // else {
                  //     $messages ="Création de  code promo validé pour les mails suivants";
                  //     $list1 = $list_mail1;
                  //     $list="";
                      
                  // }
                  
                   $email_array[] = ['code_promo' =>'',
                                 'email' => '',
                             ];
                 // id de l'ambassadrice
                $id = Auth()->user()->id;
                             
                 return view('ambassadrice.account',['message'=>$message, 'messages'=>$messages,'messages3'=>$messages3,'list'=>$list,'list1'=>$list1,'emailc'=>$emailc,'emailc2'=>$emailc2,'css'=>$css,
                 'horaire'=>$horaire,'array_emailc'=>$array_emailc, 'array_emailc1'=>$array_emailc1,'array_emailc2'=>$array_emailc2,'precision'=>$precision]);
            }
                
            // afficher les reponses
             else{
                 return redirect()->route('ambassadrice.account')->with('errors', 'Désolé vous avez atteint le qouata de  codes promo ce mois!');
            }
             dd('zapo elyamaje');
             // new script//
             return view('ambassadrice.confirm');
      }    
    }


    public function addpost(Request $request,$id)
    {
        if(Auth()->user()->is_admin ==2 OR Auth()->user()->is_admin == 4){ 
            $user = $this->repo->getCustomersId($id);
            $data = json_encode($user);
            $data =  json_decode($user, true);

            $id = Auth()->user()->id;
             // 
            $date_x  =  $this->repo->getemaildate($data['email'],$id);
             foreach($date_x as $vl){
                $date_group[] = $vl['date'];
             }

              $date_max = max($date_group);
              // soustraire 1 ans à cette date
                $date_soustraire = date('Y-m-d', strtotime($date_max. ' -1 years'));
                // verifier combien de code que l'ambassadrice ou partenaire à générée  dans ce intervalle.
                $nombre_create =  $this->repo->getbetwen($data['email'],$date_soustraire,$date_max,$id);
                $datas = json_encode($nombre_create);
                $datas =  json_decode($nombre_create,true);
                  $nombre_user = count($datas);
                  // Afficher des message
                   $message_lectures ="";
                 if($nombre_user > 1) {
                    $message_lecture ="";
                    $message_lectures="Vous ne pouvez pas créer de code promo supplémentaire pour cet élève car vous avez atteint le quota sur l'année (2 par an et dans un intervalle de 2 mois)";
                    $message_type="danger";
                      return view('ambassadrice.addcode', ['user'=>$user,'message_lecture'=>$message_lecture, 'message_lectures'=>$message_lectures, 'message_type'=>$message_type]);
               }

              
                   
               if($nombre_user==1 OR $nombre_user==0){
                   // recupérer la dernier date et ajouter 2 mois .
                   $date_news = date('Y-m-d', strtotime($date_max. ' + 60 days'));
                    // transformer la date en francais
                     $date_fr =  explode('-',$date_news);
                    $date_fr1 = $date_fr[2].'/'.$date_fr[1].'/'.$date_fr[0];
                   // date aujourdhuit
                     $date_actuel = date('Y-m-d');
                     if($date_news > $date_actuel){
                       $message_lecture = "";
                       $message_lectures = "Vous pouvez ajouter un code après le $date_fr1";
                       $message_type="warning";
                        return view('ambassadrice.addcode', ['user'=>$user,'message_lecture'=>$message_lecture, 'message_lectures'=>$message_lectures, 'message_type'=>$message_type]);
                   }
                   else{
                       
                           $message_lecture="";
                           $message_lectures="L'envoi du code promo a bien été effectué";
                            $message_type="success";
                       
                            if(Auth::check()){
                                   // ceation des data amabassadrice
                                     $id_ambassadrice = Auth::user()->id;
                                      $nom = Auth::user()->name;
                                       $is_admin = Auth()->user()->is_admin;
                                 }
                                    // declarer les vairables
                                    // créer compte client amabassadrice
                                      $current = Carbon::now();
                                       $dateToday = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current)->format('Y-m-d',$current);
          
                                          $percent = 10;
                                          $name = $request->get('account_name');
                                         $prenom = $request->get('account_username');
                                          $email = $request->get('email');
                                          $tel = $request->get('account_phone');
                                         $adresse = $request->get('adresse');
                                         
                                        // création d'un tableau associatives
                                         $code_nom = substr($nom,0,7);
                                         // creation de code promo
                                         $number = rand(20000,80000);
                                         $name_ajoute = substr($prenom,0,5);
                                         $num=10;

                                          // filtrer le code promo
                                          $res_name = str_replace( array( '%', '@', '\'', ';', '<', '>' ), ' ', $name_ajoute);// filtre sur les caractère spéciaux
                                          $name_true = preg_replace("/\s+/", "", $res_name);// suprime les espace dans la chaine.
                                           $code_promo_test = $code_nom.'-'.$name_true.'-'.$number.'-'.$num;

                                          $code_promo = $code_nom.'-'.$name_ajoute.'-'.$number.'-'.$num;
                                          //convertir un miniscule la chaine
                                          $code_promof = strtolower($code_promo);
                                          // recupérer les emails et code promo créer dans un array associative
                                         $datas=['code_promo' =>$code_promof,
                                       'email' => $email,
                                       ];
                                          // insert et envoi de mail
                                          // verifier l'unicité du code promo
                                          $status=0;
                                             $data=[
                                                'id_ambassadrice'=> $id_ambassadrice,
                                                'is_admin' => $is_admin,
                                                'nom'=> $name,
                                                 'prenom'=>$prenom,
                                                  'email'=>$email,
                                                    'telephone' => $tel,
                                                    'adresse'=> $adresse,
                                                    'code_postal'=>$adresse,
                                                       'code_promo' => $code_promof,
                                                        'date' =>$dateToday,
                                                        'status' =>$status,
                 
                                                      ];
             
                                                   // insert les données dans la table
                                                   DB::table('ambassadricecustomers')->insert($data);
                   
                                                  // insert 
                                                   // envoi de mail
                                                    $suject = "Création code promo Elyamaje";
                                                   $email = $request->get('email');
                                                   $code_promo = $code_promof;
                                                   
                                                   if(Auth()->user()->is_admin==2){
                                                       $libelle="Ambassadrice";
                                                   }
                                                   
                                                   if(Auth()->user()->is_admin ==4) {
                                                       $libelle="Partenaire";
                                                   }
                                                   
                                                  //xxxxxxxxxxxxxxxxx
                                                  //$this->mailer->SendMailadd($email,$from,$subject,$message,$nom,$code_promof,$libelle)
                                                   // envoi du mail via php mailer xxxxxx.
                                                 // send email xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx
                                                  Mail::send('ambassadrice.emails1', ['code_promof' => $code_promof, 'libelle'=>$libelle,'email' =>$email,'nom'=>$nom,'name'=>$name], function($message) use($request){
                                                  $message->to($request->get('email'));
                                                   $message->from('no-reply@elyamaje.com');
                                                   $message->subject('Confirmation de création de code promo !');
                                               });
                                                
                                                // insert dans Api wooocomerce
                                               // insere POST dans Api woocomerce 
                                                // créer les données datas 
                                                 $data_donnes =[];
                                                 $som =10;
                                                 $currents = Carbon::now();
                                                  $current = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$currents)->format('Y-m-d\TH:i:s',$currents);
                                                  
                                                   // recupère la date actuel en cours...
                                                  $date = date('Y-m-d');
                                                 // recupérer le mot en cours
                                                  $date1 = explode('-',$date);
                                                   $code_mois  = $date1[1];
                                                     $code_annee = $date1[0];
              
                                                       // recupérer le mois en francais
                                                    $mois = $this->bilan->code_mois($code_mois);
              
                                                      $description = " Code promo  élève $libelle $nom $mois"; 
                                                  
                 
                                                     $data_donnes  = [
                                                    'code' => $datas['code_promo'],
                                                    'amount' => $som,
                                                    'date_created' => $current,
                                                    'date_created_gmt'=> $current,
                                                     'date_modified' => $current,
                                                    'date_modified_gmt' => $current,
                                                     'description'=>$description,
                                                     'discount_type' => 'percent',
                                                      'usage_limit' => '1',
                                                       'exclude_sale_items' =>true,
                                                       'individual_use' => true,
                                                       'exclude_product_ids' => [160265],
                
                                                ];
              
                                                    // insert des données en post dans Api woocomerce Post
                                                   $urls="https://www.elyamaje.com/wp-json/wc/v3/coupons";   
                                                    $this->api->InsertPost($urls, $data_donnes);        
                                                
                       
                                          // recupération données api et insert dans bdd !...
                                          $data_coupons = $this->coupons->getDatacoupons();
                                          $array_id_coupon = $this->coupon->getIdcodepromo();
                                          $array_codes = $this->coupon->getCodes();
                                          $name_code = $this->coupon->getArraycode();
                          
                                        foreach($data_coupons as $keys => $values) {
                                           foreach($values as $k => $val) {
                                             if(isset($array_codes[$val['id']])==false){
                                                 if(isset($name_code[$val['code']])==false){
                                  
                                             // recupérer LES CODES PROMO pas encore utilisé et inser dans la table
                                             $coupons = new Coupon();
                                             $coupons->id_coupons = $val['id'];
                                             $coupons->code_promos = $val['code'];
                                            $coupons->date_created = $val['date_created'];
                                             $coupons->save();
                                     }
                                    
                                  }

                               }
                
                             }
                       
                       return view('ambassadrice.addcode', ['user'=>$user, 'message_lecture'=>$message_lecture, 'message_lectures'=>$message_lectures, 'message_type'=>$message_type]);
                       
                   }
                 
             }
             
      }
      
    }

    /**
   * @return array
   */
    public function donnees(): array
    {
     //recupérer les données sous forme de tableau dans la vairable array data
       return $this->getData();
       
    }
    
    public function createexistant(Request $request)
    {
        
        // recupérer les variable
        $email = $request->get('emails');
        $phone = $request->get('phones');
        
        // recupérer tous les email et phone existant dans la table 
        $this->repo->getAllcustoms();
        $emails = $this->repo->donnsemail();
        $phones = $this->repo->donsphone();
        
        // recupérer la requete de verification
        
        // traiter les données verifier l'existance de l'email et password
        if(!in_array($email, $emails))
        {
            return view('ambassadrice.account');
        }
        
        if(!in_array($phone,$phone))
        {
            return view('ambassadrice.account');
        }
        
        
    }
    
    public function renvoie()
    {
        
        
        
    }


    public function profil(){

        if(Auth()){ 
            $user = $this->user->getUserId(Auth()->user()->id);
            $live = $this->code->getdatacodelive(Auth()->user()->id);
            return view('ambassadrice.profil', ['user' => $user, 'live' => $live ? $live[0] : 0]);
        }
        
    
    }

    public function updateProfil(Request $request){

        if(Auth()){ 

            $request->validate([
                'nom' => 'required',
                'prénom' => 'required',
                'email' => [
                    'required',
                    Rule::unique('users')->ignore(Auth()->user()->id),
                    'max:255',
                ],
                'status_juridique' => 'nullable',
                'siret' => 'numeric|nullable',
                'rib' => 'nullable',
                'code_postal' => 'required'
            ]);

            // UPDATE RIB IF FILE IS UPLOADED
            $rib = Auth()->user()->rib ?? null;
            if($request->hasFile('rib')) {
                $file = $request->file('rib');
                $name = "rib_user_".Auth::user()->id.'.'.$file->getClientOriginalExtension();
                $data = $this->api->store($file, $name, $rib = true);
                if($data == "succes" OR $data == ""){
                    $rib = $name;
                } else {
                    return redirect()->back()->with('error', 'Fichier non valide !'); 
                }
            } 


            //Update user
            $update = $this->user->update(Auth()->user()->id, ['name' => $request->post('nom'), 'username' => $request->post('prénom'), 'email' => $request->post('email'),
            'account_societe' => $request->post('status_juridique'), 'telephone' => $request->post('telephone'), 'addresse' => $request->post('addresse'), 
            'siret' => $request->post('siret'), 'code_postal' => $request->post('code_postal'), 'ville' => $request->post('ville'), 'rib' => $rib, 'swift' => $request->post('swift') ?? null,
            'iban' => $request->post('iban') ?? null]);

            if($update){

                   // envoi de message à samir ou compte si l'ambassadrice change le rib.
                   $id_ambassadrice  = Auth()->user()->id;
                   $iban = Auth()->user()->iban;
                   $swift = Auth()->user()->swift;
                   // nettoyer les espace dans les chaine
                   $ibans = str_replace(' ', '', $iban);
                   $input_iban = str_replace(' ', '', $request->post('iban'));
                   $name_ambassadrice = $request->post('nom');
                   $date = date('d/m/Y');
                   $array_destinataire = array('comptabilite@elyamaje.com','melisa@elyamaje.com');//....
                 
                    if($ibans!=$input_iban OR $swift!=$request->post('swift')){
                     // envoi de mail.
                      foreach($array_destinataire as $val){
                         Mail::send('email.alerterib', ['name_ambassadrice' => $name_ambassadrice,'val'=>$val, 'date'=>$date], function($message) use($request,$val){
                         $message->to($val);
                         $message->from('no-reply@elyamaje.com');
                         $message->subject('Modification de coordonnées bancaires !');
                      });

                    }
                    
                 }

                   return redirect()->back()->with('success', 'Profil modifié avec succès');   
            } else { 
                return redirect()->back()->with('error', 'Veuillez rééssayer plus tard');   
            }
        }
    }


    public function faq(){
        $dataQuestions = $this->faq->getAllFaqs();
        return view('ambassadrice.faq', ['dataQuestions'=>$dataQuestions]);
    }

    public function aideforms(Request $request)
    {
        
         $message="";
         $css="noaffiche";
         $messages = $request->get('repons');
         $choix = $request->get('choix');
        
         if($choix!="" && $messages!=""){
             if($choix==1){
                $demande ="Problème de Demande de live";
            }elseif($choix==2){
                $demande ="Problème de code live amb pas activé";
            }elseif($choix==3){
                $demande=" Problème Commission";
            }

            elseif($choix==4){
                $demande=" Problème facture à regler";
            }

            else{
                $demande=" Problème Divers demande";
            }

             // envoyer l'email aux utilisateur.
                $destinaire= array('zapomartial@yahoo.fr','martial@elyamaje.com');
              $subject = $demande;
              $ambassadrice = Auth()->user()->name;
              $phone = Auth()->user()->telephone;
              $email = Auth()->user()->email;
             // envoi de mail.
              // envoi du mail mutiple au customer
              foreach($destinaire as $val){
               Mail::send("email.aideforms",['choix' => $choix, 'val'=>$val, 'ambassadrice'=>$ambassadrice,'messages'=>$messages,'phone'=>$phone] , function($message) use ($subject, $val) {
                $message->to($val);
                $message->from('no-reply@elyamaje.com');
                $message->subject($subject);

              });

            }

            $message="votre demande à été bien envoyé, nous revenons vers vous le plus vite possible";
            $css ="yesaffiche";
            return view('ambassadrice.aideforms',['message'=>$message,'css'=>$css]);
         }
    
         return view('ambassadrice.aideforms',['message'=>$message,'css'=>$css]);
    // }

    }

    public function models()
    {
        
         // recupérer la liste des messages..
         $id_ambassadrice = Auth()->user()->id;
         $data = $this->repo->getmodelmessage($id_ambassadrice);
         $result =[];
         foreach($data as $values){
            $date_s = explode('-',$values['date']);
            $result[] =[
             'id'=>$values['id'],
             'titre'=>$values['titre'],
             'sujet'=>$values['sujet'],
             'message'=>$values['message'],
             'date' => $date_s[2].'/'.$date_s[1].'/'.$date_s[0]

            ];
         }
         $messages="";
         $messa="";
         $css="nows";
         $csss="nows";
         $libelle ="Bonjour chère élève";
         return view('ambassadrice.models',['messages'=>$messages,'messa'=>$messa,'css'=>$css,'csss'=>$csss,'result'=>$result,'libelle'=>$libelle]);

    }

    public function model(Request $request)
    {
         
          // traiter le formulaire ..
          $subject = $request->get('sujet');
          $type =  $request->get('title');
          $mess = $request->get('messages');
          $id_ambassadrice = Auth()->user()->id;
          //
          
            // recupérer et les flush dans la base 
          $messages ="le modèle de message à été bien crée";
          
          $messa="";
          $date= date('Y-m-d');
          $css="yesm";
          $csss="noyes";
            $datas =[
             'id_ambassadrice'=>$id_ambassadrice,
             'titre'=>$type,
             'sujet'=>$subject,
             'message'=>$mess,
             'date'=>$date

          ];


          $result =[];
          $data =[];
          $data = $this->repo->getmodelmessage($id_ambassadrice);
         if(count($data) <5){
            // insert dans la bdd..
             DB::table('models_message')->insert($datas);
          }else{
                $messages="";
                $messa="Vous avez atteint votre limite de 5 modèles";
                $css="noyes";
                $csss="yesm";
          }

          $datas = $this->repo->getmodelmessage($id_ambassadrice);

           foreach($datas as $values){
             $date_s = explode('-',$values['date']);
             $result[] =[
             'id'=>$values['id'],
              'titre'=>$values['titre'],
              'sujet'=>$values['sujet'],
              'message'=>$values['message'],
              'date' => $date_s[2].'/'.$date_s[1].'/'.$date_s[0]
 
             ];
          }

           $libelle ="Bonjour chère élève";
        
          return view('ambassadrice.models',['messages'=>$messages,'messa'=>$messa,'css'=>$css,'csss'=>$csss,'result'=>$result,'libelle'=>$libelle]);


    }

    public function modeledit(Request $request){
     // recupérer 
            $id= $request->get('id');
            // recupérer les message et nom
            $data = $this->repo->getmodelmessages($id);
        
            // recupérer le titre le message et la date et le suje
            
            $titre = $data[0]['titre'];
            $messages = $data[0]['message'];
            $sujet =$data[0]['sujet'];
            
            
            $zap="message";
           echo json_encode(['zap' => $zap,'titre'=>$titre,'messages'=>$messages,'sujet'=>$sujet,'id'=>$id]);
    }
    
    
    public function modelaffich(Request $request){
        
        $id = $request->get('id');
        $name_amba = $request->get('name');
        $codeline = $request->get('codeline');
        
        // recupérer les informations essentiel.
        // afficher le message Bonjour chère éléve {{ $name eleve   }}
        // contenu du message et nom de l'emabassadrice
        
        $name_customer = $this->repo->getEmail($codeline);
        $name_customers = $name_customer[0]['nom'].'  '.$name_customer[0]['prenom'].' ,';
        $email = $name_customer[0]['email'];
        
    
        // le message
         $message = $this->repo->getmodelmessages($id);
         
         $message_model = nl2br($message[0]['message']);

         $titre = $message[0]['titre'];

         $sujet = $message[0]['sujet'];
        
        $libelle ="Bonjour chère élève";
        
         $id_info =  Auth()->user()->is_admin;
         
         if($id_info ==2){
             
             $styles="Amabssadrice Elyamaje";
         }else{
             
             $styles="Partenaire Angels Elyamaje";
         }
        
         echo json_encode(['libelle' => $libelle,'name_customers'=>$name_customers,'name_amba'=>$name_amba,'message_model'=>$message_model,'styles'=>$styles,'sujet'=>$sujet,'email'=>$email,'titre'=>$titre]);
        
    }
    
    
    public function modeledits(Request $request)
    {
        
        
        $titre = $request->get('titless');
        $sujet = $request->get('sujets');
        $messages = $request->get('messagess');
        
        //  recupérer id
        $id = $request->get('line-id');
        $id_ambassadrice =Auth()->user()->id;
        // faire un update
        // faire un update sur les champs
         // faire un update.
             DB::table('models_message')->where('id', $id)->update([
            'titre'=>$titre,
             'sujet'=>$sujet,
             'message' => $messages
            ]);

        // recuperer la data
        
         // recupérer la liste des messages
         $data = $this->repo->getmodelmessage($id_ambassadrice);
         $result =[];
         foreach($data as $values){
            $date_s = explode('-',$values['date']);
            $result[] =[
             'id'=>$values['id'],
             'titre'=>$values['titre'],
             'sujet'=>$values['sujet'],
             'message'=>$values['message'],
             'date' => $date_s[2].'/'.$date_s[1].'/'.$date_s[0]

            ];
         }
         $messages="";
         $messa="";
         $css="nows";
         $csss="nows";
         $libelle="Bonjour chère élève";
         
           return view('ambassadrice.models',['messages'=>$messages,'messa'=>$messa,'css'=>$css,'csss'=>$csss,'result'=>$result,'libelle'=>$libelle]);
        
    }

    public function confirmodels()
    {

        return view('ambassadrice.confirmodels');
    }

    public function modelenvois(Request $request)
    {
        $libelle = "Bonjour chère élève";
        $eleve = $request->get('line-customs');
        $messags = $request->get('line-message');
        $messages  = str_replace('<br />','<br>',$messags);
        $footer = $request->get('line-style');
        $name_ambassadrice = $request->get('line-amba');
        $sujet = $request->get('line-sujet');
        $email = $request->get('line-email');
        $titre = $request->get('line-titre');

          // recupérer 
         // gérer l'envoi du message

          Mail::send("email.models", ['titre'=>$titre,'sujet'=>$sujet,'messages' => $messages, 'name_ambassadrice'=>$name_ambassadrice,'eleve' =>$eleve,'footer'=>$footer,'libelle'=>$libelle], function($message) use($email,$sujet){
             $message->to($email);
             $message->from('no-reply@elyamaje.com');
             $message->subject($sujet);
            });

            // renvoyer sur la liste.
            return view('ambassadrice.confirmodels');
    }

    public function envoimailnot()
    {
          return view('ambassadrice.envoimaillot');
    }

    public function bongift(){
 
        // recupérer le resutat de gift_card bon cadeau.
        $code = Auth()->user()->code_giftcards;
        $resultat = $this->gift->getamountcard($code);
        
         if($resultat=="false"){
              $message_retour ="Votre demande est en cours";
         }else{
              $montant = number_format($resultat[0]['balance'], 2, ',', '');
              $message_retour ='<div class="code-bon p-3 card"><span class="montant-disponible">Montant disponible : <strong>'.$montant.'€</strong></span> <span class="numero-bon" >N° du bon : <span class="copyable"><strong id="code_id_text">'.$code.'</strong>  <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none" class="icon-to-replace">
              <g clip-path="url(#clip0_45_2625)">
              <path d="M7.5 10H2.5C1.8372 9.99921 1.20178 9.73556 0.73311 9.26689C0.264441 8.79822 0.000793929 8.1628 0 7.5L0 2.5C0.000793929 1.8372 0.264441 1.20178 0.73311 0.73311C1.20178 0.264441 1.8372 0.000793929 2.5 0L7.5 0C8.1628 0.000793929 8.79822 0.264441 9.26689 0.73311C9.73556 1.20178 9.99921 1.8372 10 2.5V7.5C9.99921 8.1628 9.73556 8.79822 9.26689 9.26689C8.79822 9.73556 8.1628 9.99921 7.5 10ZM2.5 1C2.10218 1 1.72064 1.15804 1.43934 1.43934C1.15804 1.72064 1 2.10218 1 2.5V7.5C1 7.89782 1.15804 8.27936 1.43934 8.56066C1.72064 8.84196 2.10218 9 2.5 9H7.5C7.89782 9 8.27936 8.84196 8.56066 8.56066C8.84196 8.27936 9 7.89782 9 7.5V2.5C9 2.10218 8.84196 1.72064 8.56066 1.43934C8.27936 1.15804 7.89782 1 7.5 1H2.5ZM12 9.5V3C12 2.86739 11.9473 2.74021 11.8536 2.64645C11.7598 2.55268 11.6326 2.5 11.5 2.5C11.3674 2.5 11.2402 2.55268 11.1464 2.64645C11.0527 2.74021 11 2.86739 11 3V9.5C11 9.89782 10.842 10.2794 10.5607 10.5607C10.2794 10.842 9.89782 11 9.5 11H3C2.86739 11 2.74021 11.0527 2.64645 11.1464C2.55268 11.2402 2.5 11.3674 2.5 11.5C2.5 11.6326 2.55268 11.7598 2.64645 11.8536C2.74021 11.9473 2.86739 12 3 12H9.5C10.1628 11.9992 10.7982 11.7356 11.2669 11.2669C11.7356 10.7982 11.9992 10.1628 12 9.5Z" fill="black"/>
              </g>
              <defs>
              <clipPath id="clip0_45_2625">
              <rect width="12" height="12" fill="white"/>
              </clipPath>
              </defs>
              </svg></span><span></div>';
          }
           // message 
           echo json_encode(['message_retour' => $message_retour]);
        
     }

}
