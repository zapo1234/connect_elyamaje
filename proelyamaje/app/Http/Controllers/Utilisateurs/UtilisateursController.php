<?php



namespace App\Http\Controllers\Utilisateurs;



use Mail;

use DateTime;

use Exception;

use Carbon\Carbon;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\DB;

use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Auth;

use App\Http\Service\CallApi\Apicall;

use App\Repository\Faq\FaqRepository;

use App\Repository\Users\UserRepository;
use App\Models\Utilisateurs\Cloturecaisse;
use App\Repository\Coupon\CouponRepository;
use App\Http\Service\CallApi\GetDataCoupons;
use App\Http\Service\CallApi\Creategiftcard;
use App\Http\Service\CallApi\PointCodepromo;
use App\Repository\Ambassadrice\CodeliveRepository;
use App\Repository\Utilisateurs\OrderutilisateurRepository;
use App\Repository\Ambassadrice\AccountambassadriceRepository;
use App\Repository\Ambassadrice\HistoriquePanierLiveRepository;
use App\Repository\Ambassadrice\OrdercodepromoaffichageRepository;
use App\Repository\Ambassadrice\Ordercustomer\OrderambassadricecustomsRepository;
use App\Repository\PanierLive\ChoixPanierLiveRepository;



class UtilisateursController extends Controller
{
      private $choixpanierlive;
      private $coupons;
      private $orders;
      private $order;
      private $code;
      private $amba;
      private $api;
      private $faq;
      private $donnees =[];

       public function __construct(

       CouponRepository $coupons, 

       OrderutilisateurRepository $orders,

       OrderambassadricecustomsRepository $order,

       OrdercodepromoaffichageRepository $ordercode,

       CodeliveRepository $code,

       AccountambassadriceRepository $amba,

       UserRepository $users,

        Apicall $api,

         FaqRepository $faq,
         HistoriquePanierLiveRepository $historique,
         PointCodepromo $codeleve,
         Creategiftcard $creategift,
         ChoixPanierLiveRepository $choixpanierlive

     )

      {

            $this->coupons = $coupons;
            $this->orders = $orders;
            $this->order = $order;
            $this->code = $code;
            $this->amba = $amba;
            $this->ordercode = $ordercode;
             $this->users = $users;
             $this->api = $api;
             $this->faq = $faq;
             $this->historique = $historique;
             $this->codeleve = $codeleve;
             $this->creategift = $creategift;
             $this->choixpanierlive = $choixpanierlive;
      }

     public function getDonnees(): array
     {
         return $this->donnees;
     }
    
     public function setDonnees(array $donnees)
     {
         $this->donnees = $donnees;
         return $this;
     }


     public function views()
     {
       return view('livewire.calendars');
     }

      public function list()
      {
          if(Auth::check()) {

             if(Auth::user()->is_admin!=3){

               return view('login');
              }

          }

          $users = $this->orders->getList() ?? [];
           return view('utilisateurs.list', ['users'=>$users]);

      }

      

      public function activelive(Request $request)
      {

          if(Auth()->user()->is_admin==3) {

           // recupérer les ambassadrice
           // recupérer les varibale
            $date_expire = $request->get('search_dates');
            $id_code = $request->get('id_code');
            $email_destinataire = $request->get('name_email');
             // date actuel
             $current = Carbon::now();
             $current1 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current)->format('Y-m-d\TH:i:s',$current);
             // recupére la date
              $date_t = $date_expire.':00';
              $id=$id_code;
              // recupérer les dates existante des code lives
             $this->code->getAllcodelive();
             $list_date = $this->code->listdates();
             $error="";
             $message="";
             $essage_error="";
              $css="";

          if($date_expire=="") {
             $error ="choisir des dates pour activer le code live";
             $message_error="";
             $css="";
             $message_error="";

          }

          if($date_t < $current1){
               $error ="la date choisie est passée";
               $message_error="la date choisir est passée";
                $css="";
               $message_error="";

               }

           if($date_expire!="") {
           if($current1 < $date_t){
            //  recupérer le code live existant
                $error="";
                $data = $this->code->getdatacodelive($id);
                $retour_expiration="";
                 $email_destinataire ="";
                 $code_live="";
                  $nombre =""; // nombre de fois que le code live est activé
                 $nbres_live ="";

               foreach($data as $kj => $values) {
                  $retour_expiration = $values['date_expire'];
                  $nombre = $values['nombre_fois'];
                   $code_live = $values['code_live'];
                     $nbres_live = $values['nbres_live'];

              }

                   // recupérer la date d'expiration. depuis la bdd du code live
                   // mettre au format la date
                  $dates = $date_expire.':00';
                  // transformer la date au format chaine de caractère bd
                   $date = $date_expire;
                   $replaces =' ';
                   $ts ="T";

                   $date_expiration1 = str_replace($ts,$replaces,$dates);
                    // affichage de la date au format francais.
                    $replace = 'à';
                     $t  = "T";
                     $date1 = str_replace($t,$replace,$date);
                     $date_express = explode('à', $date1);
                     $datet = $date_express['0'];
                      $datet1 = $date_express['1'];
                      $date2 = explode('-',$datet);
                       $date_finish = $date2['2'].'/'.$date2['1'].'/'.$date2['0'];
                        //date finish
                       $date_finish1 = $date_finish.' à '.$datet1;
                      // programmé une date 
                     $date_finish2 = $date2['2'].'/'.$date2['1'].' à '.$datet1;

                 if(!in_array($date_expiration1,$list_date)) {
                    // faire les action ici 
                    // modifier le status de la table et les differentes dates
                     $status="Live programmé  le $date_finish2 ";
                     $css="activecode";
                      $message_error="";
                       $message="le live à été programmé avec succès";
                     // modifier le code promo dans la table
                       DB::table('codelives')->where('id_ambassadrice', $id)->update([
                       'date_after' => $date_expiration1,
                        'date_expire' => $date_expiration1,
                        'status'=>$status,
                        'css'=>$css

                   ]);

                 
         Mail::send('email.codelive', ['id_code' => $id_code, 'email_destinataire' =>$email_destinataire,'code_live'=>$code_live,'date_finish1'=>$date_finish1], function($message) use($request){

                     $message->to($request->get('name_email'));

                     $message->from('no-reply@elyamaje.com');

                     $message->subject('Traitement de votre demande ,Elyamaje !');

                  });

                }

              else{

                  $css="";
                  $error="";
                  $message_error="Attention ,un live à été deja programmé à cette date";
                  $message="";

               }

          }
           else{

                   $css="";
                  $error="";
                  $message_error="Attention la date n'est pas correcte, vide ou est passé, réssayer";
                  $message="";

          }

        }

        // recupérer les données

          $this->users->getUser();
          $userlives = $this->users->getdatausercodelive();
          // recupérer le nombre de live
          // créer une date actuel
          $date_actuel = date('Y-m-d H:i:s');
         // recupérer les id_ambassadrice
           $array_id = [];
           // actualiser le tableau bord

          foreach($userlives as $km =>$val){

              if($val['date_expire'] < $date_actuel) {
                $array_id[] = $val['id_ambassadrice'];

              }

          }

           // mettre a jour le tableau de bord pur les id
          /*  $new_status ="";
            $csss="";
            $nombre_fois=0;
            DB::table('codelives')
            ->whereIn('id_ambassadrice', $array_id)
            ->update(array('status' => $new_status,
               'css'=> $csss,
                'nombre_fois'=>$nombre_fois
                ));
            */

           return view('utilisateurs.codelive', ['userlives'=>$userlives,'error'=>$error, 'message'=>$message,'message_error'=>$message_error,'css'=>$css]);

       }

         

     }

     
     public function historiquelive()
      {

         

           // traiter les données pour les notifications live en cours

              // recupérer les données pour afficher le top 3 produits les plus achétés lors des lives et code élève

              $data_live_notification = DB::table('notifications')->select('id_ambassadrice','created_at')->orderBy('created_at', 'desc')->get();

              $lis = json_encode($data_live_notification);

              $list = json_decode($data_live_notification,true);

               $datas_live_notifications =[];

              $x_data = [];

              // date dateime 

              $date_actuel = date('Y-m-d h:i:s');

              foreach($list as $live){

                 $dat = date('Y-m-d');
                 $datet = explode('-', $dat);

                 $mois_cours = (int)$datet[1];

                 $mois_cours1 = $mois_cours-1;

                     if(strlen($live['id_ambassadrice'])>5) {

                      $chaine_date = explode(' ',$live['created_at']);
                       $chaine_date1 = explode('-',$chaine_date[0]);

                      // mois recupérer le mois

                      $mois_programme = (int)$chaine_date1[1];
                       // explode la chaine de caractère 
                      $chaine_name = explode(' ',$live['id_ambassadrice']);

                      $name_ambassadrice = $chaine_name[0]; // nom ambassadrice
                      $date_chaine = $chaine_name[6]; // date de chaine
                      $heure_chaine = $chaine_name[8];
                      // transformer la dante en anglais 
                      $x_date  =  explode('/',$date_chaine);
                        // recupérer une date en anglais Y-m-d.
                     $x_dates = $x_date[2].'-'.$x_date[1].'-'.$x_date[0];
                      $date_actuel_cours = date('Y-m-d');

                       if($mois_cours == $x_date[1] OR $mois_cours1 == $x_date[1]){

                        $data_live_notifications[] = [
                           'nom_ambassadrice'=>$name_ambassadrice,
                            'date_chaine' => $date_chaine,
                               'heure_chaine' => $heure_chaine,
                              'unique' => $name_ambassadrice.'.'.$date_chaine

                            ];

                      

                      }

                  }

              }

              // transformer sous forme de tableaux le retour
               // transformer en tableau 
             // trier par date unique live les filles
              // recupérer les données pour les code élève ou les codes live
              $array_da = array_unique(array_column($data_live_notifications, 'unique'));
             $data_uniques = array_intersect_key($data_live_notifications, $array_da);

          return view('utilisateurs.historiquelive',['data_uniques'=>$data_uniques]);

     }

      

      

      public function userscode(Request $request)
       {

       //dd($this->amba->getList());

          if(Auth::check()){

             if(Auth::user()->is_admin==3){
               $this->order->getDataIdcodeorders();
               // recupérer tous les code promo utilisés dans une commande deja 
               $array_data = $this->order->donnees();
               $code_promo = strtolower($request->get('account_promo'));
               // recupérer les données parès la jointue
                $data = $this->coupons->getcode_promo($code_promo);
                 // recupérer les codes promo et lives créer
                 $this->coupons->getIdcodepromo();
                 $datas = $this->coupons->donnes();

             // faire un merge des tableau

          

          if(!in_array($code_promo,$datas)){
            return redirect()->route('utilisateurs.utilisateur')->with('error', 'Ce code promo n\'existe pas dans nos archives !');

          }
          elseif(in_array($code_promo, $array_data)){

            return redirect()->route('utilisateurs.utilisateur')->with('error', 'Ce code promo à été deja utilisé pour une commande !');

          }else{

                // insert ..
                 $sommes = $request->get('account_montant');
                 $ref = $request->get('ref_facture');
                 $code_promo = $request->get('account_promo');
                 $date_v = $request->get('date_vente');
                 // ecrire les montant 
                 $point='.';
                 $virgule=',';
                 $somme = str_replace($virgule,$point,$sommes);
               if($date_v ==""){
                     $date_vent = date('Y-m-d');
                     $date1 = explode('-',$date_vent);
                     $date_vente =  $date1[2].'/'.$date1[1].'/'.$date1[0];
                 }else{
                       $date_vent = $date_v;
                        $date1 = explode('-',$date_vent);
                        $date_vente =  $date1[2].'/'.$date1[1].'/'.$date1[0];

              }

              

              // insérer les données et mis a jour de l'api coupons

              $this->orders->insert($code_promo,$somme,$ref,$date_vente);

              

               $users = $this->orders->getList();

              

              return redirect()->route('utilisateurs.list');

              

          }

          

        }

            

      }

      

      else{

          return view('login');

      }

          

      }

    

          

          public function editaction($id)

          {

              // insérer les données 

               if(Auth::check())

              {

                  if(Auth::user()->is_admin==3)

                  {

                     $data = $this->orders->orderid($id);

                     return view('utilisateurs.edit',['data'=>$data]);

                 }

              }

         

          

        }

        

        

        public function editcaisse(Request $request)

        {

           // recuperer les variable

           $id = $request->get('id_order');

           $somme = $request->get('account_montant');

           $code_promo = $request->get('account_promo');

           $ref_facture = $request->get('ref_facture');

           $date_v = $request->get('date_vente');

            // ecrire les montant 

              $point='.';
               $virgule=',';

            if($date_v!="") {

             $date1 = explode('-',$date_v);
             $dats = $date1[2].'/'.$date1[1].'/'.$date1[0];
             $date_vente = $dats;
              $mois = $date1[1];
              $annee = $date1[0];

           }

           else{

               // recupérer la date coorespondant à l'id

               $date_t = $this->orders->orderid($id);

               $date_v = $date_t->datet;

                $date1 = explode('/',$date_v);

                 $dats = $date1[2].'/'.$date1[1].'/'.$date1[0];

                 $date_vente = $dats;

                 $mois = (int)$date1[1];

                  $annee = $date1[2];

                  $date_vente = $date_v;

               }

           // modifier les données

            $this->orders->editdata($code_promo,$somme,$ref_facture,$id,$date_vente,$mois,$annee);

            // redirigé ves la liste des données

             return redirect()->route('utilisateurs.list');

            

        }

        

        

        public function codeverify(Request $request)
          {

            if(Auth()->user()->is_admin ==3) {

             // recupération de la vérification du code élève

              if($request->get('code_verify')!=""){

                   $code_promo = $request->get('code_verify');

                  $this->order->getDataIdcodeorders();

                 // recupérer tous les code promo utilisés dans une commande deja 

                 $array_data = $this->order->donnees();

                // recupérer les données parès la jointue

                 $data = $this->coupons->getcode_promo($code_promo);
                 // recupérer les codes promo et lives créer

                  $this->coupons->getIdcodepromo();

                  $datas = $this->coupons->donnes();
                  // faire un merge des tableau

                
                if(isset($datas[$code_promo])==false){
                   return redirect()->route('utilisateurs.verifypromo')->with('error', 'Ce code promo n\'existe pas dans nos archives !');

                 }
                    elseif(in_array($code_promo, $array_data)) {
                    return redirect()->route('utilisateurs.verifypromo')->with('error', 'Ce code promo à été deja utilisé pour une commande !');

                 }

                 else{

                      return redirect()->route('utilisateurs.verifypromo')->with('success', 'Ce code promo est valide, vous pouvez l\'utiliser !');

                 }

              }

             // ceation des data amabassadrice

            $id_ambassadrice = Auth::user()->id;
            $id = $id_ambassadrice;
            // recupérer la liste des utilisateurs
            // recupérer la variable search
             $search_name = $request->get('search_name');

              if($search_name!=""){

                $users = $this->ordercode->getsearchs($search_name);

            }

           else{
                  // recupérer la liste actualisé
                   $users = $this->ordercode->getAll();

            }

             

            

            return view('utilisateurs.verifypromo',['users'=>$users]);

        }

            

    }

    

    public function cloturecaisse()

    {

        // recupérer la clé api dolibar

               $method = "GET";
               $apiKey = "9W8P7vJY9nYOrE4acS982RBwvl85rlMa";
                $apiUrl = "https://www.poserp.elyamaje.com/api/index.php/";
                $produitParam = ["limit" => 30, "sortfield" => "rowid","sortorder" => "DESC"];
                 $listproduct = $this->api->CallAPI("GET", $apiKey, $apiUrl."bankaccounts", $produitParam);

	             $lists = json_decode($listproduct,true);
               $data = []; // afficher le label des bankaccounts sur dolibar avec les id de compte;

               foreach($lists as $values){

                   $data[] = [
                                 $values['id'] => $values['label']
                            ];

               }

               
               if(Auth()->user()->is_admin==3) {

                    // créer des des array 
                    // data merseille
                    // recupérer l'email de session Auth
                    $array_list_marseille = array('melisa@elyamaje.com','anissa@elyamaje.com','deborah@elyamaje.com','sarah@elyamaje.com','ryma@elyamaje.com');
                    $array_list_nice =  array('pamela@elyamaje.com');
                    $session_email = Auth()->user()->email;

                  if(in_array($session_email,$array_list_marseille)) {
                      $libelle1 ="Marseille_liquide_caisse"; // $id_marseille1
                      $libelle2 ="Marseille_fonds_liquides";// $id_marseille2
                     //
                      $id1 =2;
                      $id2 =11;
                  }

                  if(in_array($session_email,$array_list_nice)) {
                      // data nice.
                      $libelle1 ="Nice_liquide"; // $id_nice3
                      $libelle2 ="Nice_fonds_liquide";// $id_niece4
                      $id1 =14;
                      $id2 =18;
                   }

                   if(isset($libelle1)){
                    return view('utilisateurs.cloturecaisse',['libelle1'=>$libelle1,'libelle2'=>$libelle2,'id1'=>$id1, 'id2'=>$id2]);

                   } else {
                    abort(403);
                   }


         }

    }

     public function postcaisse(Request $request)
     {
         // traiter le transfert de montant
           if(Auth()->user()->is_admin ==3){
               if(Auth()->user()->is_admin==3){
                   // créer des des array 
                   // data merseille
                   // recupérer l'email de session Auth
                   // recupérer la clé api dolibar

                     $method = "GET";
                     $apiKey ="9W8P7vJY9nYOrE4acS982RBwvl85rlMa";
                     $apiUrl ="https://www.poserp.elyamaje.com/api/index.php/";

                        //Recuperer les ref et id product dans un tableau
                       // recupérer les date 
                       $array_list_marseille = array('melisa@elyamaje.com','marina@elyamaje.com','anissa@elyamaje.com','deborah@elyamaje.com','sarah@elyamaje.com','ryma@elyamaje.com');
                       $array_list_nice =  array('pamela@elyamaje.com');
                       $session_email = Auth()->user()->email;
                  
                       if(in_array($session_email,$array_list_marseille)){
                            //
                           $id1 =2;
                           $id2 =11;
                            $lieu ="marseille";
                              $description_api="cloture de caisse marseille";
                       }
                     
                       if(in_array($session_email,$array_list_nice)) {
                         $id1 =14;
                         $id2 =18;
                          $lieu ="nice";
                          $description_api ="cloture de caisse nice";

                        }

                        // recupérer depuis dans les données depuis la bdd les dates en fonction du lieu
                        $donnees_ids =  DB::table('cloturecaisses')->select('date')->where('lieu','=',$lieu)->get();
                        // transformer en tableau 
                        $list = json_encode($donnees_ids);
                         $lists = json_decode($donnees_ids,true);

                          $date_lieu =[];// recupérer les dates dans pour un lieu en fonction

                     foreach($lists as $values) {
                         $date_lieu[] = $values['date'];
                      }

                       // recupérer les variable utiles
                        $name = Auth()->user()->name;
                        // variable 
                        $montant = $request->get('montant_transfer');
                        // recupérer deux chiffrent après le virgule.
                        // modifier le , par .
                        $montants = str_replace(',','.',$montant);
                       // deux chiffre après la virgule.
                        $montant_requis =  number_format($montants, 2, '.', '');
                        // $description_api = $request->get('description_api');
                        $date_transfert = $request->get('date_transfer');
                        // convertir la date en timesamp
                        $date_transfer_timesamp = strtotime($date_transfert);
                        // fixer la date en francais.
                        $date_fr = explode('-',$date_transfert);
                        $date_frs = $date_fr[2].'/'.$date_fr[1].'/'.$date_fr[0];
                        // description erp
                        $description_bd = $name.' a transferé le montant journalier des fonds liquides le '.$date_frs.'';
                        // convertir la date en français .
                          // mise à jours dans l'api
                          $data_donnes = [
                           "bankaccount_from_id"=> $id1,
                           "bankaccount_to_id"=>$id2,
                           "description"=>$description_api,
                            "date" => $date_transfer_timesamp,
                             "amount"=>$montant_requis,
                           ];

                
                        // insert dans l'api .
                        $date_limit =date('Y-m-d');
                        // ajouter un jour à la date
                        $x1  = date("Y-m-d", strtotime($date_limit.'+ 1 days'));

                      if($date_transfert > $x1){
                          return redirect()->route('utilisateurs.cloturecaisse')->with('error', 'Ecehc,la date de cloture de caisse n\'est pas logique trop grande !');
                       }
                      elseif(!preg_match("#^[0-9.,]{1,10}$#",$montant)){
                          return redirect()->route('utilisateurs.cloturecaisse')->with('error', 'Echec le montant doit etre un nombre ou un nombre avec 2 chiffre après le virgule !');
                       }
                      elseif(in_array($date_transfert,$date_lieu)){
                          return redirect()->route('utilisateurs.cloturecaisse')->with('error', ' Echec,Contacter l\'equipe informatique cette date à été deja enregistrée pour un transfert !');
                       }
                       else{
                           // transmettre dans l'api.
                           // insérer les données tiers dans dolibar dans les accounts
                            $this->api->CallAPI("POST", $apiKey, $apiUrl."bankaccounts/transfer", json_encode($data_donnes));
                            $transfer = new Cloturecaisse();
                            $transfer->lieu = $lieu;
                            $transfer->description = $description_bd;
                            $transfer->montant = $montant_requis;
                            $transfer->date = $date_transfert;
                            $transfer->now = $date_limit;
                           // insert into
                            $transfer->save();
                          return redirect()->route('utilisateurs.cloturecaisse')->with('succes', ' le transfert de '.$montant_requis.' € à bien été effectué merci  !');

                       }
               }
         }
    }


public function caisselist()
{

     if(Auth()->user()->is_admin==3 OR Auth()->user()->is_admin==1)
      {
           $session_email = Auth()->user()->email; // email de session en cours
           $array_marseille = array('melisa@elyamaje.com','marina@elyamaje.com','anissa@elyamaje.com','deborah@elyamaje.com','sarah@elyamaje.com','ryma@elyamaje.com');// groupe marseille
           $array_nice = array('pamela@elyamaje.com'); // groupe nice
            $marseille ="marseille";
           $nice = "nice";
        
           if(in_array($session_email,$array_marseille)) {
              $result = DB::table('cloturecaisses')->select('date','lieu','description','montant')->where('lieu','=',$marseille)->orderBy('id','Desc')->get();
           }
           elseif(in_array($session_email,$array_nice)) {
              $result = DB::table('cloturecaisses')->select('date','lieu','description','montant')->where('lieu','=',$nice)->orderBy('id','Desc')->get();
           }
           else{
                $result = DB::table('cloturecaisses')->select('date','lieu','description','montant')->orderBy('id','Desc')->get();
           }
           
            $list = json_encode($result);
            $lists =  json_decode($result,true);
             return view('utilisateurs.cloturelist',['lists'=>$lists]);
        }

    }

 
    public function paniercount()
    {
          // lister et compter le nombre de panier à incremente
            $data = DB::table('configuration_panier_lives')->select('id','panier_title','mont_mini','mont_max','libelle','libelle_categories')->get();
            $lis = json_encode($data);
            $list = json_decode($data,true);
             $data_donnees =[];
            foreach($list as $val){
                 $data_donnees[] =[
                     'id'=>$val['id'],
                     'panier_title'=> $val['panier_title'],
                      'mont_mini'=> $val['mont_mini'],
                      'mont_max'=>$val['mont_max'],
                     'libelle'=> explode(',',$val['libelle']),
                      'libelle_categories'=> explode(',',$val['libelle_categories'])
                    ];

            }

             // recupérer les données
             $this->setDonnees($data_donnees);
             $nombre = count($list);
            return $nombre;
     }

      

       public function palier()
       {

           if(Auth()->user()->is_admin==3)
           {
               $this->paniercount();
               $datas = $this->getDonnees();
              return view('utilisateurs.paliercadeaux',['datas'=>$datas]);
           }
       }


      public function faq(){
        $dataQuestions = $this->faq->getAllFaqs();
        return view('utilisateurs.faq',['dataQuestions'=>$dataQuestions]);
      }

      public function faqAdminPost(Request $request){
        try {
          $input = $request->all();
          unset($input["_token"]);
          $tab_update = array();
          $tab_insert = array();

          if (isset($input["question"])) {
              array_push($tab_insert, ["question" => $input["question"], "reponse" => $input["reponse"]]);
          }
          unset($input["question"]);
          unset($input["reponse"]);

          // voir si au moins un champ existant a été modifié
          if ($input) {

              foreach ($input as $key => $value) {
                  $valueTab = explode("_",$key);
                  if ($valueTab[0] == "question") {
                      array_push($tab_update, ["id" => $valueTab[1], "type" => $valueTab[0], "contenu" => $value]);
                  }else {
                      array_push($tab_update, ["id" => $valueTab[1], "type" => $valueTab[0], "contenu" => $value]);
                  }
              }
              $questions_update = $this->faq->updateFaqs($tab_update);
          }
          if ($tab_insert) {
              // inserer la nouvel question
              $questions_insert = $this->faq->insertQuestion($tab_insert); 
          }
            return redirect()->back()->with('success', 'L\'insertion a été faite avec succée');
        } catch (Exception $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
      }

      public function faqAdminDelete(Request $request){
        $id = $request->post('id');
        return $this->faq->deleteQuestion($id);
      }


      public function codefide()
      {
        $message="";
        $messages ="";
        $css="noaffiche";
        $csss="noaffiche";
        return view('utilisateurs.codefidelite',['css'=>$css,'message'=>$message, 'messages'=>$messages,'csss'=>$csss]);

      }

      public function postcodefide(Request $request)
      {
          
         $code_verify = $request->get('codefemverify');
         $type= $request->get('type_choix');


         if($code_verify!=""){
           
            // appel via api pw git cards.
            $url ="https://www.elyamaje.com/wp-json/wc-pimwick/v1/pw-gift-cards?number=$code_verify"; // bon cadeaux
            //$uurl = "https://staging.elyamaje.com/wp-json/wc-pimwick/v1/pw-gift-cards";
            $result_number = $this->api->getDataApiWoocommerce($url);
            
            $urlss ="https://www.elyamaje.com/wp-json/wc/v3/coupons/?code=$code_verify";// code promo

            $results_numbers = $this->api->getDataApiWoocommerce($urlss);
            $date_t = date('Y-m-d');

           $id_c ="";
            $montant="";
            $num =count($result_number);

            $nums = count($results_numbers);

              // APPEL CODE promo.....
              $coupons_all = $this->coupons->getdatapromofem();
              $id_coupons_all = $this->coupons->getCodes();
              $data_status = $this->coupons->getStatus();
               

             if($num==0 &&  $nums==0) {
                  $message=" Le code fidélité n'existe pas";
                  $messages="";
                  $css="writeaffiche";
                  $csss="noaffiche";

               }

               if($num!=0 && $nums==0) {
            
                foreach($result_number as $valu){
                   $id_c = $valu['pimwick_gift_card_id'];
                   $montant = $valu['balance'];
                  }
                 
                  $somme_t = number_format($montant, 2, ',', '');
                    $messages="Le bon carte cadeaux existe ,la cagnonte est de $somme_t €";
                    $message ="";
                    $css="noaffiche";
                    $csss="writeaffiches";
              }

              if($num==0 && $nums!=0) {

                // voir si le code est utilisé ou pas
                $usage_count ="";
                $usage_limit ="";
                $date_expiration ="";
                $date="";
                 foreach($results_numbers as $val){
                     $usage_count = $val['usage_count'];
                     $usage_limit = $val['usage_limit'];
                     $date_expiration = explode('T',$val['date_expires']);
                     $date = $date_expiration[0];
                 }

                
                  if($usage_count==1 && $usage_limit==1){
                    $message ="Le code à été deja utilisé sur le site";
                    $messages="";
                    $css="writeaffiche";
                    $csss="noaffiche";
                  }

                if($date < $date_t) {
                     $message ="Le code a été deja desactivé";
                     $messages="";
                     $css="writeaffiche";
                     $csss="noaffiche";
                  }


                  $messages="Le code promo fidélité existe bien !";
                    $message ="";
                    $css="noaffiche";
                    $csss="writeaffiches";
              

          }
      }
        
          if($type==1){

                $code = $request->get('account_promo');
               // appel via api pw git cards.
               $url ="https://www.elyamaje.com/wp-json/wc-pimwick/v1/pw-gift-cards?number=$code";
               $result_number = $this->api->getDataApiWoocommerce($url);
               $id_c ="";
               $montant="";
               $num =count($result_number);
               if($num==0) {
                     $message="ce code fidélité n'existe pas";
                     $messages="";
                     $css="writeaffiche";
                     $csss="noaffiche";

                  }

             else{

                    // recupérer les données souhaite.
                    $id_c ="";
                    $mmontant="";
                    $mont = $request->get('account_montant');
                    foreach($result_number as $valu){
                       $id_c = $valu['pimwick_gift_card_id'];
                       $montant = $valu['balance'];
                    }
                     
                    $true_montant = number_format($montant, 2, ',', '');
                    // verifier le montant
                    if($montant <  $mont) {
                        $message="Le montant est insuffisant ,la cagnonte est de $true_montant €";
                        $messages="";
                         $css="writeaffiche";
                         $csss="noaffiche";
                   
                    }else{
                        
                        // flush dans l'api la mise a jours
                         $id_api = $id_c;
                         $montant_true = $montant - $mont;
                         $somme_t = number_format($montant_true, 2, ',', '');
                      
                          $urls = "https://www.elyamaje.com/wp-json/wc-pimwick/v1/pw-gift-cards/$id_api";
                          $datas = [
                            'balance'=> $somme_t,
                          ];
                          
                           // mettre a jour dans l'api
                           // post 
                            $this->api->InsertPost($urls,$datas);
                             $messages="Votre cagnonte à été bien débité,l'achat est réalisé!";
                             $message ="";
                             $css="noaffiche";
                             $csss="writeaffiches";

                    }
               }

              
           }
           if($type==2){

                 // recupérer le code ..
                   $x =$this->coupons->getDatafemcode();
                   // recupérer le code promo transmis.
                  $code_fem = $request->get('account_promo');
                  $ref = $request->get('ref_facture');
                  // verifier sur le code n'existe
                  $urlss ="https://www.elyamaje.com/wp-json/wc/v3/coupons/?code=$code_fem";// code promo
                  $results_numbers = $this->api->getDataApiWoocommerce($urlss);
                  $nums = count($results_numbers);
                  // voir si le code est utilisé ou pa
                  // $coupons_all = $this->coupons->getdatapromofem();
                  // $id_coupons_all = $this->coupons->getCodes();
                  // $data_status = $this->coupons->getStatus();
                   $date_invalite ="2023-01-30T09:01:00";
                   $date_t = date('Y-m-d');

                   if($nums==0) {
                     $message="ce code fidélité n'existe pas.";
                     $messages="";
                     $css="writeaffiche";
                     $csss="noaffiche";
               } else{

                      // if le code existe
                      $usage_count ="";
                      $usage_limit ="";
                      $id_coupons ="";
                      $date ="";
                       foreach($results_numbers as $val){
                         $usage_count = $val['usage_count'];
                         $usage_limit = $val['usage_limit'];
                          $id_coupons = $val['id'];
                          $date_expiration = explode('T',$val['date_expires']);
                            $date = $date_expiration[0];
                    }
                     // verifier si il est deja ut
                   if($usage_count==1 && $usage_limit==1){
                       $message =" Ce Code à été deja utilisé sur le site !";
                       $messages="";
                       $css="writeaffiche";
                       $csss="noaffiche";
                       
                     }elseif($date < $date_t){
                       
                        $message ="Le code a été deja desactivé";
                        $messages="";
                        $css="writeaffiche";
                        $csss="noaffiche";
                     }
                      else{
                           
                           // modifier le usage limit dans dans l'api...
                            $description ="Code fidélité  utilisé en boutique -$ref";
                            $data = [
                                
                                'usage_count'=>1,
                                'usage_limit'=>1,
                                'usage_limit_per_user'=>1,
                                'date_expires'=>$date_invalite,
                                'description'=>$description,
                                'individual_use' => true,
                            ] ;
                        
                            // insert des données en post dans Api woocomerce Post
                            $urls="https://www.elyamaje.com/wp-json/wc/v3/coupons/$id_coupons" ;
                            $this->api->InsertPost($urls,$data);

                            // modifier le status en 1 dans la bdd..
                            $int_status = 1;
                             
                            //DB::table('fem_fidelites')->where('id_coupons', $id_coupons)->update([
                            //  'status' => $int_status
                            //]);

                             $messages="le code promo fidelité à eté bien desactivé !";
                             $message ="";
                             $css="noaffiche";
                             $csss="writeaffiches";
                    }
                }
          }

          if($type=="" && $code_verify==""){
                
            $message="Choississez obligatoirement le type de code";
            $messages="";
            $css="writeaffiche";
            $csss="noaffiche";
              
          }

          return view('utilisateurs.codefidelite',['css'=>$css,'message'=>$message,'messages'=>$messages,'csss'=>$csss]);

          // flush.
      }

      public function verifycodefem(Request $request)
      {
          // recupérer le code fem
          $code_fem = $request->get('codefemverify');
        
          $message="ce code fidélité n'existe pas.";
          $messages="";
          $css="writeaffiche";
           $csss="noaffiche";
          return view('utilisateurs.codefidelite',['css'=>$css,'message'=>$message,'messages'=>$messages,'csss'=>$csss]);
      }
     


      public function postfem($user)
      {
           $token_user ="67934854968e6ee06568847ead22132f608bf4ec1997265491df0efb";

           if($user==$token_user){
              // recupérer le code fidélité.  
               $this->coupons->getDatafemcode();
               // mettre le cron

               dd('succes');
           }


      }


      public function dashventes(Request $request)
      {
         $code_live = $request->get('ambassadrice');
         $mois =$request->get('mois');
         $annee = $request->get('annee');
         if($code_live!=""){
             // recupérer l'historique 
            $this->historique->gethistoriques($code_live,$mois,$annee);
  
         }
          $result_data = $this->historique->gethistorique();
          $result_name = $this->historique->getData();
          // Extraire les valeurs du tableau associatif
        
           return view('utilisateurs.ambassadricevente',['result_data'=>$result_data,'result_name'=>$result_name]);
      }

      public function codecreateleve()
      {
         $data = $this->codeleve->getstatistique();
          return view('utilisateurs.codecreateleve',['data'=>$data]);

      }

      public function cado(){

          return view('utilisateurs.cartecadeaux');
      }

      public function postcado(Request $request){
       
        // traiter la carte kdo.
        $date = $request->get('date');
        $email = $request->get('mail');
        $amount = $request->get('amount');
        $card = $request->get('card');

        if(empty($card)){
           $card="no";
        }
        
        $this->creategift->Creategift($date,$email,$amount,$card);


      }


      public function viewcalendars(){

        return view('utilisateurs.calendar');
     }


     public function getEventCalendarLive(Request $request){

       if(Auth()->user()->is_admin == 3){

           $id_live = $request->get('id_live');

         if($id_live){

           $data_live = $this->choixpanierlive->getByIdLive($id_live);
           if($data_live){
               $live = $data_live;
           } else {
               $live = $this->historiquelive->getByIdLive($id_live);
           }
           
           $tokens = explode(',', $live[0]['token_datas']);
           $list_products = $this->panierlive->getByTokens($tokens, ['libelle', 'panier_title', 'panier_title', 'mont_mini']);
           $products = [];

           foreach($list_products as $product){
               if(isset($products[$product['panier_title']])){
                 array_push($products[$product['panier_title']], $product);
               } else {
                 $products[$product['panier_title']] =  [$product];
               }
           }
               echo json_encode($products);  
         }
       } 
     }


     public function getEventCalendar(){
       // Adrien
      if(Auth()->user()->is_admin == 3){
          $lives_incoming = DB::table('codelives')->select('name as title','date_expire as start', 'choix_panier_lives.id_live as id')->join('users', 'users.id', '=', 'codelives.id_ambassadrice')
          ->join('choix_panier_lives', 'choix_panier_lives.code_live', '=', 'codelives.code_live')->where('css', 'activecode')->get()->toArray();
          $lives_past = DB::table('historique_panier_lives')->select('name as title','date_live as start','historique_panier_lives.id_live as id' )->join('users', 'users.code_live', '=', 'historique_panier_lives.code_live')->get()->toArray();
          
          $lives = array_merge($lives_incoming, $lives_past);
          $values_unique = array_unique($lives, SORT_REGULAR);

          $list = []; 
          foreach($values_unique as $value){
              $list [] = $value;
          }

          return $list;
      } else if(Auth()->user()->is_admin == 2){
          $lives_incoming = DB::table('codelives')->select('name as title','date_expire as start', 'choix_panier_lives.id_live as id', 'img_select as img')->join('users', 'users.id', '=', 'codelives.id_ambassadrice')
          ->join('choix_panier_lives', 'choix_panier_lives.code_live', '=', 'codelives.code_live')->where('css', 'activecode')->get()->toArray();
      
          $values_unique = array_unique($lives_incoming, SORT_REGULAR);

          $list = []; 
          foreach($values_unique as $value){
              $list [] = $value;
          }
          return $list;
      }
    }

      
 }

      

      



    