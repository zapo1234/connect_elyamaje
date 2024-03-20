<?php

namespace App\Http\Controllers\Ambassadrice;

use App\Models\ConfigurationPanierLive;
use App\Models\PanierLive;
use App\Models\ChoixPanierLive;
use App\Models\HistoriquePanierLive;
use App\Models\ProductWoocommerce;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Repository\Users\UserRepository;
use App\Repository\Ambassadrice\CodeliveRepository;
use App\Repository\Ambassadrice\LivestatistiqueRepository;
use App\Repository\Notification\NotificationRepository;
use App\Repository\PanierLive\ChoixPanierLiveRepository;
use App\Repository\PanierLive\PanierLiveRepository;
use App\Repository\Ambassadrice\HistoriquePanierLiveRepository;
use App\Http\Service\CallApi\Apicall;
use App\Http\Service\CallApi\PalierLive;
use Illuminate\Support\Facades\Auth;
use Mail;
use Carbon\Carbon;
use DateTime;
use Illuminate\Support\Str;

class AmbassadriceCodeliveController extends Controller
{
    //
    
    private $data =[];
    
    private $donnees =[];
    
    private $categories = [];
    
    private $panierLiveRepo;

    private $choixPanierLiveRepo;

    private $code;
    

    public function __construct(
      UserRepository $users, 
      CodeliveRepository $code, 
      Apicall $api, 
      LivestatistiqueRepository $live,
      NotificationRepository $note,
      PalierLive $panierlive,
      PanierLiveRepository $panierLiveRepo,
      HistoriquePanierLiveRepository $historiquelive,
      ChoixPanierLiveRepository $choixPanierLiveRepo
      )
      {
        $this->panierLiveRepo = $panierLiveRepo;
        $this->users =$users;
        $this->code = $code;
        $this->api = $api;
        $this->live = $live;
        $this->note = $note;
        $this->panierlive = $panierlive;
        $this->historiquelive = $historiquelive;
        $this->choixPanierLiveRepo = $choixPanierLiveRepo;
      }
      
      
    
   public function getData(): array
   {
      return $this->data;
   }
   
   
   public function setData(array $data)
   {
     $this->data = $data;
    return $this;
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
   
   
     public function getCategories(): array
   {
      return $this->categories;
   }
   
   
   public function setCategories(array $categories)
   {
     $this->categories = $categories;
     return $this;
   }
   
  
      
      public function index_codelive(Request $request)
      {
         if(Auth()->user()->is_admin ==1 OR Auth()->user()->is_admin==3) {
             // recupérer les ambassadrice
             // recupérer les varibale.
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
             if($date_expire==""){
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
                 $id_coupons =""; // coupons du code live.
                 foreach($data as $kj => $values)  {
                     $retour_expiration = $values['date_expire'];
                     $nombre = $values['nombre_fois'];
                     $code_live = $values['code_live'];
                     $nbres_live = $values['nbres_live'];
                     $id_coupons = $values['id_coupons'];
                 
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
                       // recupérer la date de descativation 
                       // soustraire 3h à la date programmé depuis la bdd
                       $date_live_fin = date("d-m-Y", strtotime($datet.'+1 days'));
                       $date_live_fin1 = str_replace('-','/',$date_live_fin);
                       // recupérer l'heure 
                       $x_heure = explode(':',$datet1);
                       $x_heures = (int)$x_heure;
                       if($x_heures < 18){
                           $chaine_add =" NB : Votre live sera désactivé le $date_live_fin1 à  $datet1";
                       }
                       
                       else{
                           
                           $chaine_add="";
                       }
                       
                 
                    if(!in_array($date_expiration1,$list_date)){
                    // faire les action ici 
                    // modifier le status de la table et les differentes dates..
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
                 
                    // traiter les données de panier live
                    // généré un id live 
                     // vérifier si le code live de l'ambassadrice existe deja 
                     Mail::send('email.codelive', ['id_code' => $id_code, 'email_destinataire' =>$email_destinataire,'code_live'=>$code_live,'date_finish1'=>$date_finish1,'chaine_add'=>$chaine_add], function($message) use($request){
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
              $date_after = Carbon::parse($val['date_after']);
              $date_after = $date_after->addHours(1);
              $date_after = $date_after->isoFormat("Y-MM-DD H:mm:s");

              if($date_after < $date_actuel){
                  $array_id[] = $val['id_ambassadrice'];
              }
          }


          // mettre a jour le tableau de bord pur les id
          $new_status ="";
          $csss="";
          $nombre_fois=0;
          DB::table('codelives')
                ->whereIn('id_ambassadrice', $array_id)
                ->update(array('status' => $new_status,
                'css'=> $csss,
                'nombre_fois'=>$nombre_fois
          
            ));
          
            return view('ambassadrice.codelive', ['userlives'=>$userlives,'error'=>$error, 'message'=>$message,'message_error'=>$message_error,'css'=>$css]);
       }
      }

      public function force_active_codelive(Request $request){
          
             if(Auth()->user()->is_admin == 1 OR Auth()->user()->is_admin==3 OR Auth()->user()->is_admin==2){

                $id = Auth()->user()->id;
                 $data = $this->code->getdatacodelive($id);

              if($data){
               $date = date('Y-m-d H:i:s');
                $debut_live = date("Y-m-d H:i:s", strtotime($data[0]['date_after'].'- 3 hours'));
              } else {
                $error_type = "Live non programmé par un administrateur !";

            return view('ambassadrice.errorlive', ['error_type'=> $error_type]);
          }
          
          $is_active = DB::table('codelives')->select('nombre_fois', 'css')->where('id_ambassadrice', $id)->get();
          if($is_active[0]->nombre_fois == 0 && $is_active[0]->css == "activecode" && $date >= $debut_live){

             $id_coupons =""; // id_coupons à udapte api woocomerce
            $code_live ="";
            $nbres_live ="";
            $date_live ="";
            foreach($data as $kj => $values){
                $id_coupons = $values['id_coupons'];
                $code_live = $values['code_live'];
                $nbres_live = $values['nbres_live'];
                $date_live = $values['date_expire'];
            }
             
          
            // recupérer la date courant et ajouter 2 
            // modifier les date d'expiration dans l'api wwocomerce put expire
            $current = Carbon::now();
              
            // ajouter un intervale plus un jour !
            $current1 = $current->addDays(1);
            $currens = $current1->addHours(2);
            $current2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$currens)->format('Y-m-d\TH:i:s',$currens);
            // faire un upadate de la date id_coipons
            
            $data_donnes = [
              'date_expires' => $current2,
            ];

            $urls="https://www.elyamaje.com/wp-json/wc/v3/coupons/$id_coupons" ;
            $this->api->InsertPost($urls,$data_donnes);
            $this->panierlive->Actionlive();
  
            $id_ambassadrice = Auth()->user()->id;
            $name = Auth()->user()->id;
            $email =  Auth()->user()->email;
  
            
            $reel_heure = Carbon::now();
            $date = $reel_heure;
            $this->live->insert($id_ambassadrice,$name,$email,$date);

            // mettre a jour le tableau de bord pur les id
            $status =1;
            $nombre =1;
            DB::table('codelives')
              ->where('id_ambassadrice', $id)
              ->update(array('nombre_fois' =>$status,
              'nbres_live' =>$nombre+$nbres_live
            ));
         

            Mail::send('email.activelive', ['id_codes' => $id_ambassadrice, 'email' =>$email], function($message) use($email){
                $message->to($email);
                $message->from('no-reply@elyamaje.com');
                $message->subject('Votre live chez elyamaje à bien demaré !');
            }); 
         
            if(Auth()->user()->is_admin == 2) {
              $date_limit = Carbon::parse($date);
              $newDate = $date_limit->addHours(24);
              $date_limit = $newDate->isoFormat(' DD/MM/YYYY à HH:mm');
  
              // return en cas d'activation
              return view('ambassadrice.confirmlive', ["date_limit" =>  $date_limit]);
            
            } else{ 
                $message ="Le live à bien été lancé, une notification par mail a été envoyée à l'amabassadrice";
                $this->users->getUser();
                $userlives = $this->users->getdatausercodelive();
                $css="";
                $error="";
                $message_error="";
                
                return view('ambassadrice.codelive', ['userlives'=>$userlives,'error'=>$error, 'message'=>$message,'message_error'=>$message_error,'css'=>$css]);
            }
          
          
          } else {

            if($date < $debut_live){
              $error_type = "Vous ne pouvez pas encore activer  votre live, vous pourrez l'activer à partir de ".$debut_live;
            } else if($is_active[0]->nombre_fois == 1) {
              $error_type = "Le live a déjà été activé !";
            } else {
              $error_type = "Live non programmé par un administrateur !";
            }

            return view('ambassadrice.errorlive', ['error_type'=> $error_type]);

          }

        }
      }
      
      public function active_codelive(Request $request)
      {

         if(Auth()->user()->is_admin == 1 OR Auth()->user()->is_admin==3 OR Auth()->user()->is_admin==2){
             // recupérer l'id 
              $id_codes = $request->get('id_codes');
              $email_destinatire  = $request->get('names_email');
               $code_live = Auth()->user()->code_live;
              // recupérer le id_live .
              $id_live = $this->choixPanierLiveRepo->getidlive($code_live);
              // recupérer id du live .
          
            if($id_codes!="") {
                 // recupérer l'id du code live associé dans les coupons api woocommerce..
                 $id = $id_codes;
                 $data = $this->code->getdatacodelive($id);
                 $id_coupons =""; // id_coupons à udapte api woocomerce
                 $code_live ="";
                 $nbres_live ="";
                 $date_live="";
             foreach($data as $kj => $values){
                 $id_coupons = $values['id_coupons'];
                 $code_live = $values['code_live'];
                 $nbres_live = $values['nbres_live'];
                 $nbres_fois = $values['nombre_fois'];
                 $date_live = $values['date_expire'];
               }
               
                 // Empêche le clique deux fois
                if($nbres_fois == 1){
                    return redirect()->back();  
                }
                  // recupérer la date courant et ajouter 2 
                  // modifier les date d'expiration dans l'api wwocomerce put expire
                  $current = Carbon::now();
                  // ajouter un intervale plus un jour !
                  $current1 = $current->addDays(1);
                  $currens = $current1->addHours(2);
                  $current2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$currens)->format('Y-m-d\TH:i:s',$currens);
                 
                    // faire un upadate de la date id_coipons
                  $data_donnes = [
                   'date_expires' => $current2,
                  ];
                            
                    $urls="https://www.elyamaje.com/wp-json/wc/v3/coupons/$id_coupons" ;
                    $this->api->InsertPost($urls,$data_donnes);
                     // recupére les date existante 
                     // envoi code live dans la route via api adrien
                     $this->panierlive->Actionlive();
                     // insert dans la base de données le lien
                     // recupérer le varible
                     $id_ambassadrice = $id_codes;
                    $name = Auth()->user()->id;
                    $email = $request->get('names_email');
                    $reel_heure = Carbon::now();
                    $date = $reel_heure;
                    $this->live->insert($id_ambassadrice,$id_live,$name,$email,$date);
                  
                    // modifier le nombre_de_fois pour afficher le live
                    // mettre a jour le tableau de bord pur les id
                      $status =1;
                      $nombre =1;
                      DB::table('codelives')
                          ->where('id_ambassadrice', $id_codes)
                          ->update(array('nombre_fois' =>$status,
                          'nbres_live' =>$nombre+$nbres_live
                      ));
                  
                      // notifier un mail d'envoi
                      Mail::send('email.activelive', ['id_codes' => $id_codes, 'email' =>$email], function($message) use($request){
                     $message->to($request->get('names_email'));
                     $message->from('no-reply@elyamaje.com');
                     $message->subject('Votre live chez elyamaje à bien demaré !');
                  });
                 
                 
                 if(Auth()->user()->is_admin == 2) {
                    $date_limit = Carbon::parse($date);
                    $newDate = $date_limit->addHours(24);
                    $date_limit = $newDate->isoFormat(' DD/MM/YYYY à HH:mm');
        
                    // return en cas d'activation
                    return view('ambassadrice.confirmlive', ["date_limit" =>  $date_limit]);
                  
                 }
                 
                 else{
                     
                     $message ="le live à été bien ,une notification mail à été envoyé à l'amabassadrice";
                      $this->users->getUser();
                      $userlives = $this->users->getdatausercodelive();
                      $css="";
                      $error="";
                      $message_error="";
                     
                      return view('ambassadrice.codelive', ['userlives'=>$userlives,'error'=>$error, 'message'=>$message,'message_error'=>$message_error,'css'=>$css]);
                 }
                 
                 
            }
            
            
         }
      }
      
      
       public function active_force_live(Request $request)
       {
           // au click bouton vert qui declenche le live
          // recupérer l'id
           $id_codes = $request->get('id_codes');
           $email_destinatire  = $request->get('names_email');
          
          if($id_codes!="") {
              // recupérer l'id du code live associé dans les coupons api woocommerce
               $id = $id_codes;
               $data = $this->code->getdatacodelive($id);
               $id_coupons =""; // id_coupons à udapte api woocomerce
               $code_live ="";
               $nbres_live ="";
               $date_live ="";
                foreach($data as $kj => $values){
                  $id_coupons = $values['id_coupons'];
                  $code_live = $values['code_live'];
                  $nbres_live = $values['nbres_live'];
                  $date_live = $values['date_expire'];
               }
             
                  // recupérer la date courant et ajouter 2 
                  // modifier les date d'expiration dans l'api wwocomerce put expire
                    $current = Carbon::now();
                  // ajouter un intervale plus un jour !
                    $current1 = $current->addDays(1);
                    $currens = $current1->addHours(2);
                    $current2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$currens)->format('Y-m-d\TH:i:s',$currens);
                 
                     

                         $data_donnes = [
                        'date_expires' => $current2,
                        ];
                            
                      $urls="https://www.elyamaje.com/wp-json/wc/v3/coupons/$id_coupons" ;
                  
                       $this->api->InsertPost($urls,$data_donnes);
                      // recupére les date existante 
                      // flush api palier
                      // recupérer le id_live .
                      $this->panierlive->forcerlive($id_codes);
                      // insert dans la base de données le lien
                      // recupérer le varible
                       $id_ambassadrice = $id_codes;
                       $name = Auth()->user()->id;
                       $email = $request->get('names_email');
                       $reel_heure = Carbon::now();
                       $date = $reel_heure;
                       $id_live = $this->choixPanierLiveRepo->getidlive($code_live);
                       $this->live->insert($id_ambassadrice,$id_live,$name,$email,$date);
                       // modifier le nombre_de_fois pour afficher le live
                      // mettre a jour le tableau de bord pur les id
                      $status =1;
                      $nombre =1;
                      DB::table('codelives')
                   ->where('id_ambassadrice', $id_codes)
                    ->update(array('nombre_fois' =>$status,
                                   'nbres_live' =>$nombre+$nbres_live
                    ));
                  
            
                   // notifier un mail d'envoi
                  // Mail::send('email.activelive', ['id_codes' => $id_codes, 'email' =>$email], function($message) use($request){
                  //   $message->to($request->get('names_email'));
                  //   $message->from('no-reply@elyamaje.com');
                  //   $message->subject('Votre live chez elyamaje à bien demaré !');
                 // });
                 
                 
                 if(Auth()->user()->is_admin == 2){
                   // return en cas d'activation
                    return view('ambassadrice.confirmlive');
                  }
                  else{
                       $message ="le live à été bien ,une notification mail à été envoyé à l'amabassadrice";
                       $this->users->getUser();
                       $userlives = $this->users->getdatausercodelive();
                       $css="";
                       $error="";
                       $message_error="";
                     
                      return view('ambassadrice.codelive', ['userlives'=>$userlives,'error'=>$error, 'message'=>$message,'message_error'=>$message_error,'css'=>$css]);
                 }
                 
                 
            }
            
       }
      
       public function index_give()
       {
          
          if(Auth()->user()->is_admin ==2) {

            // Live programmé
            $lives_incoming = DB::table('codelives')->select('name as title','date_after as start')->join('users', 'users.id', '=', 'codelives.id_ambassadrice')
            ->where('css', 'activecode')->get()->toArray();

            $code_live = Auth()->user()->code_live;
                
             $data = DB::table('choix_panier_lives')->select('id_live','token_id','actif','date_live')->where('code_live','=',$code_live)->get();
             $lis = json_encode($data);
             $list = json_decode($data,true);
             // recupérer les donées de code live;
             $datas = DB::table('codelives')->select('css','status')->where('code_live','=',$code_live)->get();
             $lis = json_encode($datas);
             $lists = json_decode($datas,true);
          
          // recupéré le status
          $status ="";
          
           foreach($lists as $vb) {
             if($vb['status'] != "Live demandé le  10/02/2020 à 20:00"){
              $status = $vb['css'];
             }
   
            }

             if($status=="activecode"){
              $status="Un live est déjà programmé !";
              $css="livecssaccept";
            }
         
            else if($status=="") {
              $status="";
              $css="nolive";
             
            }
         
            else{
                $status="Demande de live déjà en cours !";
                $css="livecssaccept";
            }
    
               foreach($list as $vf){
                  // recupérer la date du live +48h  pour passer l'actif en 0 après l'activation de live
                  $date2 = date("Y-m-d H:i:s", strtotime($vf['date_live'].'+ 6 days'));
                  $date_actuel = date('Y-m-d H:i:s'); // date actuel

                  $ext ="";
                  if($date2 < $date_actuel){
                     // update sur actif pour le renvoyer à zéro
                     $actif=0;
                     $new_date = "2020-02-10 20:00:00";
                        DB::table('choix_panier_lives')
                          ->where('code_live', $code_live)
                            ->update(array('actif' => $actif,
                                    'date_live'=>$new_date
                        ));

                        $date_french = Carbon::parse($new_date)->isoFormat(' DD/MM/YYYY à HH:mm');
                         // UPDATE CODE LIVE
                         $this->code->updateByCodeLive(['status' => 'Live demandé le '.$date_french.'', 'css' => 'demandecode', 'date_after' => $new_date], $code_live);
                  
                   }
                   
               }
              
              
               // recupérer les données dans un array pour les paniers d'offre de live  à construire
                 $datas_panier =[];
                $array = PanierLive::all()->groupBy('pseudo')->sortBy->toArray();// grouper les paniers en fonction du pseudo .
                // transformer en tableau
             foreach($array as $keys => $values) {
                  
                  foreach($values as $valu) {
                      $panier_title = $valu['panier_title'];
                      $mont_max= $valu['mont_max'];
                      $mont_mini = $valu['mont_mini'];
                      $num = $valu['num'];
                       $datas_panier[] =[
                           'title' => $panier_title,
                            'mont_max'=> $mont_max,
                            'mont_mini'=>$mont_mini,
                            'num'=> $num,
                            'data' => $values
                          
                          
                          ];
                      }
                  
              }
              
               $array_da = array_unique(array_column($datas_panier, 'title'));
               $data_panier_uniques = array_intersect_key($datas_panier, $array_da);// recupérer des panier unique avec leur données.
               // recupérer les ids produits souhaités
               $code_live = Auth()->user()->code_live;
               $liste_choix = $this->note->getdatapanierlive($code_live);

              return view('ambassadrice.liveforms',['lives_incoming' => $lives_incoming,'data_panier_uniques'=>$data_panier_uniques,'liste_choix'=>$liste_choix,'css'=>$css,'status'=>$status]);
          
          }
          
      }
      
      
      
       public function gestionlive()
       {
         
         // gérer le live demande par l'amabassadrice
         // recupérer le id_coupons si existe
           $code_live = Auth()->user()->code_live;
           $data = DB::table('choix_panier_lives')->select('id_coupons','date_live','token_datas','id_live','token_id','actif')->where('code_live','=',$code_live)->get();
           $lis = json_encode($data);
           $list = json_decode($data,true);
           // recupérer les donées de code live;
           $datas = DB::table('codelives')->select('css','status', 'nbres_live')->where('code_live','=',$code_live)->get();
           $lis = json_encode($datas);
           $lists = json_decode($datas,true);
          // recupéré le status

          $nbres_live = 0;
          $status ="";
          
         foreach($lists as $vb){
             $status = $vb['css'];
             $nbres_live = $vb['nbres_live'];

             $cssss="nolive";
         }
         
         if($status=="") {
             $status="";
            $cssss ="livecssaccept";
         }
         
         else{
             $status="Elyamaje a confirmé votre live !";
             
         }
    
         
         $token_id ="";
         $css="";
         
         if(count($list)==0) {
             $message ="Aucune demande enregistrée !";
             $id_live ="xxxxx";
             $date_live="";
             $token_id="";
             $css="";
            $formcss="";
            $pak ="";
            $but1="nonexx";
            $but2="nonexx";
             $liste_choix =[];
             $choix_cadeaux ="Aucun choix sur les cadeaux de live !";
             $action="";
             $heure1="";
             
             $formscc = "";
         }
         
            foreach($list as $vf) {
               // recupérer la date du live +48h  pour passer l'actif en 0 après l'activation de live
               // recupération des données ....
               $date2 = date("Y-m-d H:i:s", strtotime($vf['date_live'].'+ 6
                days'));
               
               $date_actuel = date('Y-m-d H:i:s'); // date actuel
               $ext="";// vider le champs.
                if($date2 < $date_actuel) {
                   // update sur actif pour le renvoyer à zéro..
                    $actif=0;
                   
               }
               
               $action="";
 
             
             if($vf['date_live']=="" || $vf['date_live']=="2020-02-10 20:00:00") {
              $message ="Aucune demande enregistrée !";
              $id_live ="xxxxx";
              $date_live="";
              $token_id="";
               $action="";
               $css="";
               $formcss="";
              $pak ="";
              $but1="nonexx";
              $but2="nonexx";
              $liste_choix =[];
              $choix_cadeaux ="Aucun choix sur les cadeaux de live !";
              $heure1="";
              
              $formscc = "";
          } else{
              
              // recupérer la date et l'id_live token
               $date_live="";
               $id_live ="";
               $token_id="";
 
               foreach($list as $liv) {
                   $live_day = $liv['date_live'];
                   $x_day  =  explode(' ',$live_day);
                   
                   // transformer la date
                   $x_days = $x_day[0];
                   $date_live = explode('-',$x_days);
                   
                  
                   // heure
                   $heure = explode(':',$x_day[1]);
                   $heure1 = $heure[0].'H'.$heure[1];
                   
 
                   // transformer la date 
                   $message =''.$date_live[2].'/'.$date_live['1'].'/'.$date_live[0].' à '.'';
                   
                   $id_live = $liv['id_live'];
                   $token_id = $liv['token_id'];
                   $action= $liv['actif'];
                   $css="xxxxdavxxx";
                   $formcss ="form_live";
                   $pak ="pak";
                   $but1="annulergx";
                   $but2="gestionxx";
                   $formscc ="form_edit_choix";
               }
               
                $choix_cadeaux ="";
                
                  
            }
            
          }

               $liste_choix = $this->note->getdatapanierlive($code_live);
               // recupérer le choix  des clients.
               $message_response="";
               $status="";
                //  dd($data[0]);

               if(isset($data[0])){
                $actif = $data[0]->actif;
               } else {
                $actif = 0;
               }

               
               
         return view('ambassadrice.gestionlive',['nbres_live' => $nbres_live, 'actif' => $actif, 'message'=>$message,'heure1'=>$heure1,'status'=>$status,'token_id'=>$token_id,'action'=>$action,'status'=>$status,'css'=>$css,'formcss'=>$formcss,'pak'=>$pak,'message_response'=>$message_response,'but1'=>$but1,'but2'=>$but2,'liste_choix'=>$liste_choix,'formscc'=>$formscc,'actif'=>$actif]);
      }
      
      
      
       // ANNULER le live.
      
      
      public function anullive(Request $request)
      {
           // annuler live
            $code_live = Auth()->user()->code_live;
            $id_token = $request->get('id_token_liv');
            //suprimer
              $data = DB::table('choix_panier_lives')->select('id_coupons','date_live','token_datas','token_id','id_live','actif')->where('code_live','=',$code_live)->get();
              $lis = json_encode($data);
              $list = json_decode($data,true);
              // recupérer les données du code live .
              $token_id ="";
              $css="";
              // recupérer la date et l'id_live token
              $date_live="";
              $id_live ="";
              $token_id="";
              $status_actif="";
              $message="";
              foreach($list as $liv) {
                  $live_day = $liv['date_live'];
                  $x_day  =  explode(' ',$live_day);
                  
                  // transformer la date
                  $x_days = $x_day[0];
                  $date_live = explode('-',$x_days);
                  
                  // heure
                  $heure = explode(':',$x_day[1]);
                  $heure1 = $heure[0].'H'.$heure[1];
                  
                 // transformer la date 
                  // transformer la date 
                  $message =''.$date_live[2].'/'.$date_live['1'].'/'.$date_live[0].' à '.'';
                  $id_live = $liv['id_live'];
                  $token_id = $liv['token_id'];
                  $status_actif = $liv['actif'];
                  $action= $liv['actif'];
                  $css="xxxxdavxxx";
                  $formcss ="form_live";
                  $pak ="pak";
                  $but1="annulergx";
                  $but2="gestionxx";
                  $formscc ="form_edit_choix";
                  $status="";
              }
              
           // new
          
           if($status_actif==0) {

              $new_date = "2020-02-10 20:00:00";
              $actif="0";
             DB::table('choix_panier_lives')
             ->where('token_id', $id_token)
             ->update(array('date_live' => $new_date,
                         'actif'=> $actif
              ));
          
                // modfifier la table codelive a nouveau 
                $css="";
               $status="";
          
              // modifer les donnnées  de la table
                DB::table('codelives')
               ->where('code_live', $code_live)
               ->update(array('css' => $css,
                         'status'=>$status,
                         'date_after'=>$new_date,
                         'date_expire'=>$new_date
                ));
                
           
          
               $message ="Aucune demande enregistrée !";
               $id_live ="xxxxx";
               $date_live="";
               $token_id="";
               $action="";
               $css="";
               $formcss="";
               $status="";
              $pak ="";
              $but1="nonexx";
               $but2="nonexx";
               $choix_cadeaux ="";
               $liste_choix =[];
               $status="";
               $formscc="";
              $cssss="nolive";
              $heure1="";
              
           }
            
              $message_response  = "votre live à été suprimé";
          
              $liste_choix = $this->note->getdatapanierlive($code_live);
             return view('ambassadrice.gestionlive',['actif' => $status_actif, 'message'=>$message,'heure1'=>$heure1,'status'=>$status,'token_id'=>$token_id,'action'=>$action,'css'=>$css,'formcss'=>$formcss,'pak'=>$pak,'message_response'=>$message_response,'but1'=>$but1,'but2'=>$but2,'liste_choix'=>$liste_choix,'choix_cadeaux'=>'choix_cadeaux','formscc'=>$formscc]);
          
          }
              

      
      // modifier les live la date
      
      public function updatelivedate(Request $request)
      {
           
          // modifier les champs souhaités. date.
           $list_email = array('live@elyamaje.com','zapomartial@yahoo.fr','martial@elyamaje.com');// liste des destinatire
           $id_token = $request->get('id_token_ss');
            $date = $request->get('search_dates');

             // bloquer le live si la demande est faite un mardi .
             $name_of_the_day = date('l', strtotime($date));
             $date_x = $name_of_the_day;

              $restriction=0; // declarer une restriction 
             if($date_x=="Tuesday"){
                 $restriction=1;
               }
            
           
            $email = Auth()->user()->email;
            $code_live =  Auth()->user()->code_live;
                  
            // modifier les date d'expiration dans l'api wwocomerce put expire
             $current = Carbon::now();
            $date1 = $date.':00';
            // mettre au format la date
             $dates = $date.':00';
             // transformer la date au format chaine de caractère bd
             
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
                  $date_express = explode('à', $date1);
                   $heure1 = str_replace(':','H',$datet1);
                 //date finish
                  $message_send ="Votre demande à été bien prise en compte, vous recevrez un mail !";
                  // envoyer un message
                   // recupérer la date de descativation 
                   // soustraire 3h à la date programmé depuis la bdd
                   $date_live_fin = date("d-m-Y", strtotime($datet.'+1 days'));
                    // recupérer l'heure 
                       $x_heure = explode(':',$datet1);
                       $x_heures = (int)$x_heure;
                       if($x_heures < 18) {
                           $chaine_add =" NB : Votre live sera désactivé le $date_live_fin à  $datet1";
                       }
                       
                       else{
                           
                           $chaine_add="";
                       }
                       
                       
                       
                    $code_live = Auth()->user()->code_live;
                    $data = DB::table('choix_panier_lives')->select('id_coupons','date_live','token_datas','id_live','token_id','actif')->where('code_live','=',$code_live)->get();
                    $lis = json_encode($data);
                    $list = json_decode($data,true);
                   $token_id ="";
                   $css="";
                   $status_actif="";
                   $date_live_cours ="";
                foreach($list as $vn) {
                    $status_actif= $vn['actif'];
                    $date_live_cours = $vn['date_live'];
                }
                
                
                // recupérer les dates à restreinte pour un live.
                if($restriction==0){
                 if($status_actif==0) {
                   // changer la date
                   $new_date = $date_expiration1;
                   DB::table('choix_panier_lives')
                    ->where('token_id', $id_token)
                    ->update(array('date_live' => $new_date
                  ));

                  $status ="Live programmé le ".$date_finish." à ".$datet1;
                  $css="yessend";
                  $name = Auth()->user()->name;
                  $emails = Auth()->user()->email;
                  $code_live = Auth()->user()->code_live;
                  
                  // envoi la confirmation de mail !
                  $subject="Modification de date demande live  par l' Ambassadrice $name";
                  // modifier les données de la table pour réprogrammé son live.
                  $this->code->updateByCodeLive(['status' => $status, 'css' => 'demandecode', 'date_after' => $new_date], $code_live);
                  
                  // envoie d'un mail 
                  Mail::send('email.confirmationlive', ['emails' =>$emails,'date_finish1'=>$date_finish1,'code_live'=>$code_live,'name' => $name,'chaine_add'=>$chaine_add], function($message) use($request){
                  $message->to(Auth()->user()->email);
                  $message->from('no-reply@elyamaje.com');
                  $message->subject('Confirmation de reception de votre demande !');
                });
                 
                 
                        foreach($list_email as $val) {
                             // envoi du mail mutiple au customer
                             Mail::send("email.sendlive",['name' => $name, 'email' =>$email, 'val'=>$val, 'date_finish1'=>$date_finish1] , function($message) use ($subject, $val) {
                             $message->to($val);
                            $message->from('no-reply@elyamaje.com');
                             $message->subject($subject);
             
                         });
                    
                       }
                       
                       
                       // inserer une notification lors de la demande.
                       $id_commande="";
                       $id_ambassadrice= "$name a prévu un live, le $date_finish1";
                       
                       $this->note->livestat($id_commande,$id_ambassadrice);
                       
              }
              
                else{
                       foreach($list as $lic){
                         $new_date = $lic['date_live'];
                       }
                
                }
              } else{
                 
                   $date_live="";
                   $id_live ="";
                   $token_id="";
                   $actif="";
                    $message="impossible de faire un live Mardi";
                    $css="";
                    $formcss="";
                    $actif="";
                    $but1="";
                    $but2="";
                    $list_choix="";
                    $message_response="";
                    $status="";
                    $pak="";
                    $liste_choix= $this->note->getdatapanierlive($code_live);
                    $formscc="";
                 return view('ambassadrice.gestionlive',['message'=>$message,'heure1'=>$heure1,'status'=>$status,'token_id'=>$token_id,'css'=>$css,'formcss'=>$formcss,'pak'=>$pak,'message_response'=>$message_response,'but1'=>$but1,'but2'=>$but2,'liste_choix'=>$liste_choix,'formscc'=>$formscc,'actif'=>$actif]);

              }
                       
                  // afficher la page 
                 // recupérer la date et l'id_live token
                 $date_live="";
                 $id_live ="";
                 $token_id="";
                 $actif="";
              foreach($list as $liv) {
                  $live_day = $new_date;
                   $x_day  =  explode(' ',$live_day);
                  // transformer la date
                  $x_days = $x_day[0];
                  $date_live = explode('-',$x_days);
                  // heure
                  $heure = explode(':',$x_day[1]);
                  $heure1 = $heure[0].'H'.$heure[1];
                  
                   // transformer la date 
                  $message =''.$date_live[2].'/'.$date_live['1'].'/'.$date_live[0].' à '.'';
                  
                  $id_live = $liv['id_live'];
                  $token_id = $liv['token_id'];
                  $css="xxxxdavxxx";
                  $formcss ="form_live";
                  $pak ="pak";
                  $but1="annulergx";
                  $but2="gestionxx";
                  $formscc ="form_edit_choix";
                  $actif = $liv['actif'];
              }
              
               $choix_cadeaux ="";
               $liste_choix = $this->note->getdatapanierlive($code_live);
               // recupérer le choix  des clients.
               $message_response="";
               $status="";

                return view('ambassadrice.gestionlive',['message'=>$message,'heure1'=>$heure1,'status'=>$status,'token_id'=>$token_id,'css'=>$css,'formcss'=>$formcss,'pak'=>$pak,'message_response'=>$message_response,'but1'=>$but1,'but2'=>$but2,'liste_choix'=>$liste_choix,'formscc'=>$formscc,'actif'=>$actif]);
            
            
        }
      
      
      
      public function add_livesforms(Request $request)
      {

          if(Auth()->user()->is_admin ==2) {
               // un tableau d'array_list mail
              $email = Auth()->user()->email;
              $code_live = Auth()->user()->code_live;
              $list_email = array('live@elyamaje.com','zapomartial@yahoo.fr','martial@elyamaje.com','adrien@elyamaje.com');// liste des destinataires

              if($request->get('search_dates')!=""){
                   $date = $request->get('search_dates');
                   // recupérer la confirmation de live les Mardis.
                   $confirm = $request->get('choixtype');

                     // modifier les date d'expiration dans l'api wwocomerce put expire
                     $current = Carbon::now();
                     $date1 = $date.':00';
                     // mettre au format la date
                    $dates = $date.':00';
                      // transformer la date au format chaine de caractère bd
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
                         $message_send ="Votre demande à été bien prise en compte, vous recevrez un mail !";
                         // envoyer un message
                        // recupérer la date de descativation 
                        // soustraire 3h à la date programmé depuis la bdd
                        $date_live_fin = date("d-m-Y", strtotime($datet.'+1 days'));
                        // recupérer l'heure 
                       $x_heure = explode(':',$datet1);
                       $x_heures = (int)$x_heure;
                       if($x_heures < 18) {
                           $chaine_add =" NB : Votre live sera désactivé le $date_live_fin à  $datet1";
                       }
                       
                       else{
                            $chaine_add="";
                       }


                        // bloquer le live si la demande est faite un mardi .
                        $name_of_the_day = date('l', strtotime($date));
                        $date_x = $name_of_the_day;

                         $restriction=0; // declarer une restriction 
                        
                        if($date_x=="Tuesday" && $confirm==""){
                            $restriction=1;
                          }

                          if($date_x=="Tuesday" && $confirm=="xx%xxtypey%"){
                             $restriction=0;
                          }

                         // traiter les données des paniers lives
                        //vérifier si le coupons existe deja
                        // recupérer les données des produits
                         // recupérer les données du code live corresponds a l'ambassadrice !
                         $id = Auth()->user()->id;
                         $datas = DB::table('codelives')->select('status', 'css','code_live','id_coupons')->where('id_ambassadrice','=',$id)->get();
                         $liss = json_encode($datas);
                         $lists = json_decode($datas,true);
                         $code_live="";
                         $id_coupons ="";
                     
                     foreach($lists as $va) {
                         $code_live = $va['code_live'];
                         $id_coupons = $va['id_coupons'];
                         $already_live = $va['css'];
                         $status_live = $va['status'];
                     }
                     
                    
                     if($already_live != "" && $status_live != "Live demandé le  10/02/2020 à 20:00"){
                        return redirect()->route('ambassadrice.liveforms')->with('alert','Une demande à déjà été faite !');
                     }
                     
                      // recupérer le id_coupons si existe
                      $data = DB::table('choix_panier_lives')->select('id_coupons','actif','code_live','date_live')->where('id_coupons','=',$id_coupons)->get();
                      $lis = json_encode($data);
                      $list = json_decode($data,true);
                      $token = Str::random(30);
                      $list_coupons =[];
                   
                        // si l'id_coupons n'existe pas
                        $status_actif =""; // declecher l'action si actif == 1.
                        $array_live =[];
                        $date_cours ="";
                       foreach($list as $m => $vac) {
                          $list_coupons[] = $vac['id_coupons'];
                          $status_actif = $vac['actif'];
                          $array_live[] = $vac['code_live'];
                          $date_cours = $vac['date_live'];
                        
                       }
                      
                       // date à laquelle l'ambassadrice peut demander un live.
                       $date_new_cours = date('Y-m-d H:i', strtotime($date_cours. ' + 6 days'));
                       $date_new_cours = Carbon::parse($date_new_cours)->isoFormat(' DD/MM/YYYY à HH:mm');
                       $tab_date =[];

                       // $recupérer les dates  à lesquelles l'ambassadrice peut pas faire un live.
                       $x_date = explode('T',$date);
                       $x_dat = $x_date[0];

                       for($i=1; $i<7; $i++){
                         $tab_date[] =  date('Y-m-d', strtotime($date_cours. ' + '.$i.' days'));
                       }

                       // recupérer la dernière date du tableau
                       $date_max = max($tab_date);
                       
                       // la date en format francais....
                       $date_true_fr_max = date('d/m/Y', strtotime($date_max.'+ 1 days'));
        
                       if(!in_array($code_live,$array_live)) {
                         $status_actif=0;
                     }
                    
                         $token_data = $request->get('id_token');
                          // transformer les données en chaine de caractère
                        if($restriction==0) {
                      
                         if($x_dat > $date_max){
                      
                               if($token_data!="") {
                                   $token_datas = implode(',',$token_data); // obtenir une chaine de caractère.
                                  // $id_live = rand(5000,2000000);
                                   // Get last id live and add +1
                                   $id_live = $this->choixPanierLiveRepo->getOrderByIdLive('id_live');
                                  $id_live = $id_live[0]["id_live"] + 1;
                                  $code = $code_live;
                                   $date_live = $date_expiration1;
                                  // compter le nombre de palier recupérer
                                  $group_token = $token_data;
                                   $nombre_palier = count($this->note->gettokendata($group_token));
                               
                               
                             if(!in_array($id_coupons,$list_coupons)){
                                   // faire un delete sur l'existant !
                                 if($nombre_palier ==4){
                               
                                    $actif =0;// rentre inactif au clic
                                    // insert bdd
                                    $panier = new ChoixPanierLive();
                                    $panier->id_live = $id_live;
                                    $panier->date_live = $date_live;
                                    $panier->id_coupons = $id_coupons;
                                    $panier->token_id = $token;
                                    $panier->code_live = $code_live;
                                    $panier->token_datas = $token_datas;
                                    $panier->actif = $actif;
                                      // insert....... !-----
                                     $panier->save();


                                     $date_french = Carbon::parse($date_live)->isoFormat(' DD/MM/YYYY à HH:mm');
                                     // UPDATE CODE LIVE
                                     $this->code->updateByCodeLive(['status' => 'Live demandé le '.$date_french.'', 'css' => 'demandecode', 'date_after' => $date_live], $code_live);
                             }
                               
                               
                           }
                           
                           else{
                               
                                  if($nombre_palier ==4){
                                  // update sur les prduit
                                 DB::table('choix_panier_lives')
                                    ->where('code_live', $code_live)
                                    ->update(array( 'id_live'=> $id_live,
                                               'token_datas' => $token_datas,
                                              'date_live'=> $date_live
                                   ));

                                    $date_french = Carbon::parse($date_live)->isoFormat(' DD/MM/YYYY à HH:mm');
                                    // UPDATE CODE LIVE
                                    $this->code->updateByCodeLive(['status' => 'Live demandé le '.$date_french.'', 'css' => 'demandecode', 'date_after' => $date_live], $code_live);
                                   
                                }
                     
                            }
                            
                              
                               // insert dans la table historique
                               //  $panier = new HistoriquePanierLive();
                              //   $panier->id_live = $id_live;
                              //   $panier->date_live = $date_live;
                              //   $panier->code_live = $code_live;
                              //   $panier->token_datas = $token_datas;
                                 // insert....... !-----
                              //   $panier->save(); 
                            
                            
                             }
                   
                               if($nombre_palier == 4) {
                                 // inserer une notification lors de la demande.
                                  $name = Auth()->user()->name;
                                  $emails = Auth()->user()->email;
                                  $id_commande="";
                                  $id_ambassadrice= "$name a prévu un live, le $date_finish1";
                                 $css="yessend";
                                 // envoi la confirmation de mail !
                                $subject="Demande d'activation de live effectuée par l' Ambassadrice $name";
                                // envoie d'un mail 
                                Mail::send('email.confirmationlive', ['emails' =>$emails,'date_finish1'=>$date_finish1,'code_live'=>$code_live,'name' => $name,'chaine_add'=>$chaine_add], function($message) use($request){
                                $message->to(Auth()->user()->email);
                                $message->from('no-reply@elyamaje.com');
                                $message->subject('Confirmation de reception de votre demande !');
                         });
                 
                 
                        foreach($list_email as $val) {
                            //  envoi du mail mutiple au customer
                             Mail::send("email.sendlive",['name' => $name, 'email' =>$email, 'val'=>$val, 'date_finish1'=>$date_finish1] , function($message) use ($subject, $val) {
                              $message->to($val);
                              $message->from('no-reply@elyamaje.com');
                              $message->subject($subject);
              
                            });
                    
                       }
                       
                          $this->note->livestat($id_commande, $id_ambassadrice);
                     
                     return redirect()->route('ambassadrice.liveforms')->with('success','votre demande à été bien prise en compte,un mail vient d\'être envoyé sur votre adresse e-mail !');
              
             
                  }
                  
                  else{
                      
                         return redirect()->route('ambassadrice.liveforms')->with('alert','vous devrez absolument avoir un produit par palier !');
              
                  }
          
              }
              else{
                     return redirect()->route('ambassadrice.liveforms')->with('alert','Votre prochain live peut etre effectué à parti du '.$date_true_fr_max.'');
                  
              }
            }
            else{

                 return redirect()->route('ambassadrice.liveforms')->with('alert','Vous ne pouvez pas faire de live un Mardi');
            }
              
              }
          }
          
      }
      
      // modifier les panier
      public function updatepanierlive(Request $request)
      {
          // modifier le choix des paniers .
           $token_data = $request->get('id_token');
          $code_live = Auth()->user()->code_live; 
          // transformer les données en chaine de caractère.
          $list_token = implode(',',$token_data);
          
        
          $data = DB::table('choix_panier_lives')->select('id_coupons','date_live','token_datas','token_id','id_live','actif')->where('code_live','=',$code_live)->get();
          $lis = json_encode($data);
          $list = json_decode($data,true);
          // recupérer les données du code live .
         
          $token_id ="";
          $css="";
        
            // recupérer la date et l'id_live token
              $date_live="";
              $id_live ="";
              $token_id="";
              $status_actif="";
              $message="";
              foreach($list as $liv) {
                  $live_day = $liv['date_live'];
                  $x_day  =  explode(' ',$live_day);
                  
                  // transformer la date
                  $x_days = $x_day[0];
                  $date_live = explode('-',$x_days);
                  
                 
                  // heure
                  $heure = explode(':',$x_day[1]);
                  $heure1 = $heure[0].'H'.$heure[1];
                  
                  
                  
                  // transformer la date 
                  // transformer la date 
                  $message =''.$date_live[2].'/'.$date_live['1'].'/'.$date_live[0].' à '.'';
                  $id_live = $liv['id_live'];
                  $token_id = $liv['token_id'];
                  $status_actif = $liv['actif'];
                  $css="xxxxdavxxx";
                  $formcss ="form_live";
                  $pak ="pak";
                  $but1="annulergx";
                  $but2="gestionxx";
                  $formscc ="form_edit_choix";

                  //..
                  if($liv['date_live']=="2020-02-10 20:00:00"){
                      $message ="Aucune demande enregistrée !";
                      $id_live ="xxxxx";
                      $date_live="";
                      $token_id="";
                      $action="";
                      $css="";
                      $formcss="";
                      $pak ="";
                      $but1="nonexx";
                      $but2="nonexx";
                      $liste_choix =[];
                      $choix_cadeaux ="Aucun choix sur les cadeaux de live !";
                      $heure1="";
                      
                      $formscc = "";
                  }
               }
              
               $choix_cadeaux ="";
              
                // faire un update
                // changer la liste des produits via leur token
                // recupérer le nombre de palier
                 $group_token = $token_data;
                 $x_count  =  $this->note->gettokendata($group_token);            
                  $nombre_palier = count($x_count);
                  // recupérer le nimbre de produit
                $nombre_product =  $this->note->getDonnes();
                 $indice =[];
              
              foreach($nombre_product as $vl){
                 if($vl > 4) {
                    $indice[] = $vl;
                 }
              }
              
              if($status_actif==0){
                if(count($indice)==0) {
               
                  if($nombre_palier ==4){
                   $codelive = $this->code->getdatacodelive(Auth()->user()->id);
                     // MODIFIER LA liste
                      DB::table('choix_panier_lives')
                        ->where('code_live', $code_live)
                        ->update(array('token_datas' => $list_token
                      ));

                      if($codelive[0]['css'] == "paliervide"){
                        $this->code->updateByCodeLive(['status' =>  $codelive[0]['status'], 'css' => "activecode"], $code_live);
                      }
                      
                    }
              
                  else{
                  
                      
                   }
                }
                else{
                    
                }
            
               }
               
                $liste_choix = $this->note->getdatapanierlive($code_live);
                // recupérer le choix  des clients.
                // recupérer le choix  des clients.
                $message_response="";
                $status ="";

              return view('ambassadrice.gestionlive',['actif' => $status_actif, 'message'=>$message,'heure1'=>$heure1,'status'=>$status,'token_id'=>$token_id,'css'=>$css,'formcss'=>$formcss,'pak'=>$pak,'message_response'=>$message_response,'but1'=>$but1,'but2'=>$but2,'liste_choix'=>$liste_choix,'formscc'=>$formscc]);
            
            
            
      }
      
     
      public function configuration()
      {
          
          if(Auth()->user()->is_admin==1) {
              // recupérer les données des produits
              // recupérer les données pour afficher le top 3 produits les plus achétés lors des lives et code élève
              $data = DB::table('product_woocommerces')->select('token','libelle','ids_product','id_variations')->get();
              $lis = json_encode($data);
              $list = json_decode($data,true);
               // recupérer les categories.
              
                $datas = DB::table('categoris_woocommerces')->select('rowid','label')->get();
                 $liss = json_encode($datas);
                $lists = json_decode($datas,true);
                return view('ambassadrice.configuration',['list'=>$list,'lists'=>$lists]);
          }
          
          
      }
      
      
      
      public function listerpanier()
      {
          $this->paniercount();
          $datas = $this->getDonnees();
          
          
          return view('ambassadrice.listerpanier',['datas'=>$datas]);
      }
      
      
      
      public function assoc_product()
      {
         
           // gérer un jeu de données pour les categoris
           // lister les produits existant......;
            $data = DB::table('categoris_woocommerces')->select('rowid','label')->get();
              $lis = json_encode($data);
              $list = json_decode($data,true);
              
              $categoris_assoc =[];
              foreach($list as $valc){
                 $chaine_vl = $valc['label'].','.$valc['rowid'];
                  $categoris_assoc[$chaine_vl] = $valc['rowid'];
             }
              // lister les produits existant;
              $data = DB::table('product_woocommerces')->select('token','libelle','ids_product','id_variations')->get();
              $lis = json_encode($data);
              $list = json_decode($data,true);
              
              // créer des tableau associative entre ids_product et ids , libelle.
              $libelle_product =[];
              $ids_product_assoc =[];
              $id_variations_assoc =[];
              
              foreach($list as $values) {
                   $chaine = $values['libelle'].','.$values['ids_product'];
                    $chaine1 = $values['id_variations'].'%'.$values['ids_product'];
                    $array_data_soc[$chaine] = $values['ids_product'];
                    $array_data_assoc[$chaine1] = $values['ids_product'];
              }
              
              
               // recupérer le tableau des variation passés
               $this->setData($array_data_assoc);
               // recupérer les association 
               $this->setCategories($categoris_assoc);
              
              return $array_data_soc;
          
          
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
      
      
      public function postconfig(Request $request)
      {
              // traitement de données pour recupérer les donées du formulaire
              //construire les données pour les paniers actif.
              $array1 = $this->assoc_product();
              $array2 =  $this->getData();
              // recuppérer le tableau associatif des categoris
              $categoris_data = $this->getCategories();
              // recupérer le count du panier pour indexé les panier 
              $num = $this->paniercount();
              $num1 =$num+1;
              $num2 = $num+2;
          
              $donnees  = $request->get('data1'); // array de Niveau1
              $donnees1 = $request->get('data2'); //panier Niveau2
              // recupérer les categoris  et traiter les categoris.
              $categories = $request->get('datas12');// niveau 12
              $categories1 = $request->get('data23');
              $libelle_categories =[];// recupérer les libelle
              $id_categories = [];   // recupérer les ids.
               $libelle_categories1 =[];// recupérer les libelle
               $id_categories1 = [];   // recupérer les ids.
              //palier niv1
              foreach($categories as $valuc) {
                $chaine = explode(',',$valuc);
                 $libelle_categories[] = $chaine[1];
                 $id_categories[] = $chaine[0];
              }
            
             //palier niv2
             foreach($categories1 as $valucs){
                $chaine1 = explode(',',$valucs);
                $libelle_categories1[] = $chaine1[1];
                $id_categories1[] = $chaine1[0];
            }
            
              // transformer en chaine de caractère les données
              // recupérer les id_produit , les ids_variant et libelle. 
             $ids_product =[];
             $ids_variantes =[];
             $libelle = [];
             // recupérer les id_produit , les ids_variant et libelle. 
             $ids_product2 =[];
             $ids_variantes2 =[];
             $libelle2 = [];
             $ch ="%%%dar"; //slog des id_prduit
             $ch1 ="v@@@";// slog des ids produit
             // créer les token et categories // traiter les categoris.
             $line_get_categoris =[];
            $line_get_categoris1 =[];
             $token = Str::random(30);
            
            
            foreach($id_categories as $vav){
                 $code = str_shuffle($token.$vav);
                  $chaine_libelle = array_search($vav,$categoris_data);
                   $chaine_l =  explode(',',$chaine_libelle);
                  $name= "Toute la catégorie  $chaine_l[0]";
                
                 $line_get_categoris[] = [
                    
                 'id_product' =>$vav,
                 'ids_variation'=>"",
                 'libelle' =>$name,
                 'token'=> $code,
                 'pseudo'=>"panier.$num1",
                 'num'=>$num1,
                 'mont_mini'=> $request->get('montant_mini1'),
                 'mont_max' => $request->get('montant_max1'),
                 'title'=> $request->get('panier1')
                    
                    
                    ];
                
            }
            
                 foreach($id_categories1 as $van) {
                  $code = str_shuffle($token.$van);
                  $chaine_libelle = array_search($van,$categoris_data);
                  $chaine_l =  explode(',',$chaine_libelle);
                  $name= "Toute la catégorie  $chaine_l[0]"; // nommer les categoris dans la liste
                
                 $line_get_categoris1[] = [
                    
                 'id_product' =>$van,
                 'ids_variation'=>"",
                 'libelle' =>$name,
                 'token'=> $code,
                 'pseudo'=>"panier.$num2",
                 'num'=>$num1,
                 'mont_mini'=> $request->get('montant_mini2'),
                 'mont_max' => $request->get('montant_max2'),
                 'title'=> $request->get('panier2')
                    
                    
                    ];
                
            }
             // Créer un merge de données pour des données de categoris.
             $listers_categories = array_merge($line_get_categoris,$line_get_categoris1);
             // insert dans la bdd .
             // PANIER 2
            foreach($donnees as $val2){
                $chaine[] = explode(',',$val2);
                
             }
            
             unset($chaine[0],$chaine[1]); // vider les deux index.
            
            foreach($chaine as $valc){
                 foreach($valc as $p) {
                 
                    if(strpos($p,$ch) !==false){
                          $ids_product[] = substr($p,0,-6);// les ids_product
                       }
                       
                       elseif(strpos($p,$ch1) !==false){
                          $ids_variantes[] = substr($p,0,-4);// les ids_variations
                       }
                       
                       else{
                              $libelle[] = $p;  // recupérer les libéllé forcement
                       }
                         // Recupérer les ids_variation
                 }
            }
            
           $ch2 ="%%%dar"; //slog des id_prduit
            $ch12 ="v@@@";// slog des ids produit
            
            foreach($donnees1 as $val2) {
                $chaine2[] = explode(',',$val2);
                
            }
            
           foreach($chaine2 as $valc2){
                 foreach($valc2 as $p2) {
                 
                    if(strpos($p2,$ch2) !==false){
                          $ids_product2[] = substr($p2,0,-6);// les ids_product
                       }
                       
                     elseif(strpos($p2,$ch12) !==false) {
                          $ids_variantes2[] = substr($p2,0,-4);// les ids_variations
                       }
                       
                       else{
                           
                           $libelle2[] = $p2;  // recupérer les libéllé forcement
                       }
                       
                 }
            }
            
            
            
            // Récuperer les ids_product et construire les données à manger dans le panier niveau1!
            $line_get_affich =[];
             $line_get_affich1 =[];
            $token = Str::random(30);
            // vétifier creéer des données  pour les prduits le produits.
            
            foreach($ids_product as $vad) {
                $ids_pr = array_search($vad,$array1);
                
                $ids_p =  explode(',',$ids_pr); //LES LIBELLES
                
                $ids_var = array_search($vad,$array2);// les variation
                
                $ids_va  = explode('%',$ids_var);
                
                // créer un token utilie panier
                $code = str_shuffle($token.$vad);// create token unique via un produit par panier ....
                $line_get_affich[] = [
                    
                 'id_product' => $vad,
                 'ids_variation'=>$ids_va[0],
                 'libelle' =>$ids_p[0],
                 'token'=> $code,
                 'pseudo'=>"panier.$num1",
                 'num'=>$num1,
                 'mont_mini'=> $request->get('montant_mini1'),
                 'mont_max' => $request->get('montant_max1'),
                 'title'=> $request->get('panier1')
                    
                    
                    ];
            }
            
            
            
            // PANIER 2
             foreach($ids_product2 as $vad) {
                $ids_pr = array_search($vad,$array1);
                
                $ids_p =  explode(',',$ids_pr); //LES LIBELLES
                
                $ids_var = array_search($vad,$array2);// les variation
                
                $ids_va  = explode('%',$ids_var);
                
                // créer un token utilie panier
                $code = str_shuffle($token.$vad);// create token unique via un produit par panier ....
                $line_get_affich2[] = [
                    
                 'id_product' => $vad,
                 'ids_variation'=>$ids_va[0],
                 'libelle' =>$ids_p[0],
                 'token'=> $code,
                 'pseudo'=>"panier.$num2",
                  'num'=>$num2,
                  'mont_mini'=> $request->get('montant_mini2'),
                 'mont_max' => $request->get('montant_max2'),
                 'title' => $request->get('panier2'),
                    
                    
                    ];
             }
            
            
             $lister = array_merge($line_get_affich,$line_get_affich2);// merge les arrays
             
              // recupérer les données du panier
              $panier = $request->get('panier1');
              $ids_product1 = implode(',',$ids_product);
              $ids_variantes1 = implode(',',$ids_variantes);
              $libelle1 = implode(',',$libelle);
              $mont_max = $request->get('montant_max1');
              $mont_mini = $request->get('montant_mini1');
              
              // categories panier 1
              $libelle_categories_data = implode(',',  $libelle_categories);
              $id_categories_data = implode(',',$id_categories);
              
              
              
              // recupérer les données du panier2
              $panier2 = $request->get('panier2');
              $ids_product12 = implode(',',$ids_product2);
              $ids_variantes12 = implode(',',$ids_variantes2);
              $libelle12 = implode(',',$libelle2);
              $mont_max2 = $request->get('montant_max2');
              $mont_mini2 = $request->get('montant_mini2');
              
              // categoris palier 2
               // categories panier 1
              $libelle_categories_data2 = implode(',',  $libelle_categories1);
              $id_categories_data2 = implode(',',$id_categories1);
              
              
              // flus en bdd
               $panierlive = new ConfigurationPanierLive();
               $panierlive->panier_title = $panier;
               $panierlive->libelle = $libelle1;
               $panierlive->ids_produit =$ids_product1;
               $panierlive->ids_variation = $ids_variantes1;
               $panierlive->ids_categories = $id_categories_data;
               $panierlive->libelle_categories =  $libelle_categories_data;
               $panierlive->mont_mini = $mont_mini;
               $panierlive->mont_max = $mont_max;
               
               $panierlive->save();
               
               
               // flus en bdd PANIER 2
               $panierlive2 = new ConfigurationPanierLive();
               $panierlive2->panier_title = $panier2;
               $panierlive2->libelle = $libelle12;
               $panierlive2->ids_produit =$ids_product12;
               $panierlive2->ids_variation = $ids_variantes12;
                $panierlive2->ids_categories = $id_categories_data2;
               $panierlive2->libelle_categories =  $libelle_categories_data2;
               $panierlive2->mont_mini = $mont_mini2;
               $panierlive2->mont_max = $mont_max2;
               
               $panierlive2->save();
               
               // remplir les panier dans live panier
               
               foreach($lister as $vl){
                   $nature="produit";
                   $listers = new PanierLive();
                   $listers->id_product = $vl['id_product'];
                   $listers->ids_variations = $vl['ids_variation'];
                   $listers->libelle = $vl['libelle'];
                   $listers->token = $vl['token'];
                   $listers->pseudo = $vl['pseudo'];
                   $listers->num = $vl['num'];
                   $listers->panier_title = $vl['title'];
                   $listers->nature = $nature;
                   $listers->mont_mini = $vl['mont_mini'];
                   $listers->mont_max = $vl['mont_max'];
                   
                   
                   // insert 
                   $listers->save();
               }
               
               
               foreach($listers_categories as $vl){
                   $nature="categorie";
                   $listers = new PanierLive();
                   $listers->id_product = $vl['id_product'];
                   $listers->ids_variations = $vl['ids_variation'];
                   $listers->libelle = $vl['libelle'];
                   $listers->token = $vl['token'];
                   $listers->pseudo = $vl['pseudo'];
                   $listers->num = $vl['num'];
                   $listers->panier_title = $vl['title'];
                   $listers->nature = $nature;
                   $listers->mont_mini = $vl['mont_mini'];
                   $listers->mont_max = $vl['mont_max'];
                   // insert 
                   $listers->save();
               }
               
               
               
               // recupérer les ids des produits 
               $this->paniercount();
               $datas = $this->getDonnees();
               
              return view('ambassadrice.listerpanier',['datas'=>$datas]);
              
              
              // insert dans la bdd .
          
    }
    
    
    public function editpanier($id)
    {
        // recupérer les données via id 
        // lister et compter le nombre de panier à incremente
            $data = DB::table('configuration_panier_lives')->select('id','panier_title','mont_mini','mont_max','ids_produit','libelle','ids_categories','libelle_categories')->where('id','=',$id)->get();
            $lis = json_encode($data);
            $list = json_decode($data,true);
            
            // recupérer des données
            $array1 = $this->assoc_product();
            $array2 =  $this->getData();
            $array_categoris = $this->getCategories();
            
            // recupérer les données choisis lors de la configuration
            $data_select =[];
            
            $data_select_categories = []; // récupérer les données
            
            foreach($list as $val){
                //
                $chaine =  explode(',',$val['ids_produit']);
                 $data_select[] = $chaine;
                 $chaine1 = explode(',',$val['ids_categories']);
                  $data_select_categories[]= $chaine1; // categories;
                
            }
            
          
            $data_selected =[];// recupérer les données product à afficher.
            $data_selected_categories =[];// recupérer les données à afficher .
            
            foreach($data_select as $key => $vs) {
               
               foreach($vs as $x){
                  // recupérer les données
                  $chaine1 = array_search($x,$array1);
                 // recupérer panier
                  $product_id =  explode(',',$chaine1);
                  $chaine2 = array_search($x,$array2);
                  $id_var = explode('%',$chaine2);
                  // recupérer les données
                    $data_selected[]=[
                     'id_product'=>$x,
                      'id_variations'=>$id_var[0],
                      'label'=> $product_id[0]
                    
                    ];
             }
            
            }
            
            foreach($data_select_categories as $vac){
                
                foreach($vac as $vq) {
                    // recupérer 
                    $id_categoris = array_search($vq,$array_categoris);
                    $id_cat = explode(',',$id_categoris);
                       $data_selected_categoris[] =[
                         'rowid'=>$vq,
                        'label'=>$id_cat[0]
                        
                        ];
                }
            }
            
             // recupérer les données des produits
              // recupérer les données pour afficher le top 3 produits les plus achétés lors des lives et code élève
              $data = DB::table('product_woocommerces')->select('token','libelle','ids_product','id_variations')->get();
              $lis = json_encode($data);
              $donnes = json_decode($data,true);
              
              // recupérer les categoris
                // recupérer les données des produits
              // recupérer les données pour afficher le top 3 produits les plus achétés lors des lives et code élève
              $data_c = DB::table('categoris_woocommerces')->select('rowid','label')->get();
              $lis = json_encode($data_c);
              $donnes_array = json_decode($data_c,true);
              
            
            // recupérer tous les produits lister.
             $this->paniercount();
             $datas = $this->getDonnees();
             $choix ="selected";
            
        
        return view('ambassadrice.editpanier',['data_selected'=>$data_selected,'data_selected_categoris'=>$data_selected_categoris,'list'=>$list,'donnes'=>$donnes,'donnes_array'=>$donnes_array,'datas'=>$datas,'choix'=>$choix]);
    }
    
    
    public function editpaniers(Request $request,$id)
    {
         $panier = "panier.$id";
         $datac = DB::table('panier_lives')->select('id_product','nature')->where('pseudo','=',$panier)->get();
         $lis = json_encode($datac);
         $lisc = json_decode($datac,true);
         $id_existant =[];

         $nature_cat =[];
         $nature_product =[];

         foreach($lisc as $vale){
            if($vale['nature']=="categorie"){
              $id_existant_cat[] = $vale['id_product'];
            }

            else{

              $id_existant_product[] = $vale['id_product'];
            }
         }
          
         // recupérer 
        $data = DB::table('configuration_panier_lives')->select('id','mont_mini','ids_produit', 'ids_categories', 'libelle')->get();
        $lis = json_encode($data);
        $list = json_decode($data,true);
       // recupérer les valeur suivante ids_product et mon_ni
        $mont_mini =[];
        $ids_product = [];
        $ids_categorie = [];
        
        foreach($list as $val){
            $ids_product[] = $val['ids_produit'];
            $ids_categorie[] = $val['ids_categories'];
             $mont_mini = $val['mont_mini'];
        }
        
            // recupérer des données
            $array1 = $this->assoc_product();
            $array2 =  $this->getData();
            $categoris_data = $this->getCategories();
             // recupérer le traitement pour les categoris
             $dass = $request->get('data12');
             // recupérer les champs id_categories et libelle.
              $id_cat =[];  // // categoris id
              $libelle_cat =[];// categoris id // categoris libelle.

          
          if($dass){
            foreach($dass as $vx){
                $chaine_x = explode(',',$vx);
                
                $id_cat[]= $chaine_x[0];
                
                $libelle_cat[] = $chaine_x[1];
            }
            
          }
          
          $cat_new =[];
          // recupére les nouvelle categoris ajoutés.
          $cat_new = array_diff($id_cat,$id_existant_cat);
          // recupérer les ids cat remplacé.
          $ids_cats = []; // les catégoris à suprimer dans le palier en cas de retrait.

          foreach($id_existant_cat as $vn) {
               if(!in_array($vn,$id_cat)) {
                 $ids_cats[] = $vn;
               }
          }
          
          $line_get_categoris = [];
            $token = Str::random(30);
          // tableau des categoris
          foreach($cat_new as $vax) {
                   $code = str_shuffle($token.$vax);// create token unique via un produit par panier ....
                   $chaine =  array_search($vax,$categoris_data);
                   $chaine_dat = explode(',',$chaine);
                   $name ="Toute la catégorie $chaine_dat[0]";
                   $line_get_categoris[] = [
                    'id_product' => $vax,
                    'ids_variation'=>"",
                    'libelle' =>$name,
                     'token'=> $code,
                     'pseudo'=>"panier.$id",
                     'num'=>$id,
                     'mont_mini'=> $request->get('montant_mini'),
                     'mont_max' => $request->get('montant_max'),
                     'title'=> $request->get('panier')
                    
                    
                    ];
              }
          
          // recupérer les variable ids présent dans le select pour les produit.
          $das = $request->get('data1');
          $ids_prod = [];
          $id_variations = [];
          $label = [];
         // traiter les données  pour les produit .
          if($das){
          
            foreach($das as $vad){
             $id_data = explode(',',$vad);
             // eliminée les % dans les chaine
             $idss = str_replace('%%%dar',' ',$id_data[0]);// eliminé l'extension copté
            $idsc = trim($idss);// eliminer les espace
              $ids_prod[] =  $idsc;
          }
        }
        
        
         // recupérer les nouveau produit ajoutés via leur id.
         // recupére les nouvelle categoris ajoutés.
         $product_new =[];
         $product_new = array_diff($ids_prod,$id_existant_product);
         $ids_products = []; // les produit à suprimer dans le palier en cas de retrait.

         foreach($id_existant_product as $vns) {
              if(!in_array($vns,$ids_prod)) {
                $ids_products[] = $vns;
              }
         }
         
         // verifier l'intersection des tableau
         $intersect = array_intersect($ids_product,$ids_prod);
         $mont_mi = $request->get('montant_mini');
         $panier_title = $request->get('panier');
         $mont_max = $request->get('montant_max');
          $line_get_affich1 =[]; // recupérer les données à flush dans panier live.
          $token = Str::random(30);
          
          $line_get_affich =[];
            
            if($product_new){
              foreach($product_new as $x) {
                   // recupérer les données
                    $chaine1 = array_search($x,$array1);
                   // recupérer panier
                    $product_id =  explode(',',$chaine1);
                     $chaine2 = array_search($x,$array2);
                     $id_var = explode('%',$chaine2);
                  
                        $id_variations[] = $id_var[0];
                        $label[]=$product_id[0];
                        
                        $code = str_shuffle($token.$x);// create token unique via un produit par panier ....
                       $line_get_affich[] = [
                        'id_product' => $x,
                      'ids_variation'=>$id_var[0],
                      'libelle' =>$product_id[0],
                       'token'=> $code,
                       'pseudo'=>"panier.$id",
                       'num'=>$id,
                       'mont_mini'=> $request->get('montant_mini'),
                       'mont_max' => $request->get('montant_max'),
                       'title'=> $request->get('panier')

                      ];
     
              }

             }
             
             
             foreach($ids_prod as $n){
                // capter les libelle et id_product pour la coonfig
                $chaine1 = array_search($n,$array1);
                // recupérer panier
                $product_id =  explode(',',$chaine1);
                $chaine2 = array_search($n,$array2);
                $id_var = explode('%',$chaine2);
                $labels[]=$product_id[0];// 
               
             }
        
              // mettre à jours 
              // transformer en chaine de caractère mes données
              $list_product = implode(',',$ids_prod);
              $list_variation = implode(',',$id_variations); //variation
              $labels = implode(',',$labels); // libelle
             
               // les categories
              $id_cats = implode(',',$id_cat);
              $libelle_cats = implode(',',$libelle_cat);
              // produits et catégories qui ont été supprimées
              $products_to_remove = array_diff(explode(',',$ids_product[$id-1]), $ids_prod);
              $categoies_to_remove = array_diff(explode(',',$ids_categorie[$id-1]), $id_cat);
              $ids_to_remove = array_merge($products_to_remove, $categoies_to_remove);
             // Récupère les tokens des produits et catégories supprimées
              $tokens_to_remove = $this->panierLiveRepo->getByIds($ids_to_remove, 'token');

             // Liste des paniers ayant ce token qu'il faut supprimer
              $choix_panier_with_token = $this->choixPanierLiveRepo->getLikeToken($tokens_to_remove);
             // PanierLive::where('pseudo','=', $panier)->delete();
             $id_sups = array_merge($ids_cats,$ids_products);
              // vider les categoris et produits rétirer.
              DB::table('panier_lives')->whereIn('id_product', $id_sups)->delete();
          
          // insert dans la bdd
           foreach($line_get_affich as $vl) {
                $nature="produit";
                $listers = new PanierLive();
                $listers->id_product = $vl['id_product'];
                $listers->ids_variations = $vl['ids_variation'];
                $listers->libelle = $vl['libelle'];
                $listers->token = $vl['token'];
                $listers->pseudo = $vl['pseudo'];
                $listers->num = $vl['num'];
                $listers->panier_title = $vl['title'];
                $listers->nature = $nature;
                $listers->mont_mini = $vl['mont_mini'];
                $listers->mont_max = $vl['mont_max'];
                 // insert 
                $listers->save();
            }
            
            // flush les categoris .
            
             foreach($line_get_categoris as $vls){
               $nature="categorie";
                $cat = new PanierLive();
                $cat->id_product = $vls['id_product'];
                $cat->ids_variations = $vls['ids_variation'];
                $cat->libelle = $vls['libelle'];
                $cat->token = $vls['token'];
                $cat->pseudo = $vls['pseudo'];
                $cat->num = $vls['num'];
                $cat->panier_title = $vls['title'];
                $cat->nature = $nature;
                $cat->mont_mini = $vls['mont_mini'];
                $cat->mont_max = $vls['mont_max'];
                 // insert 
                $cat->save();
            }
            
          
          
            // Token datas à modifier
            $new_panier_live = [];
            foreach ($choix_panier_with_token as $panier) {
              $new_panier_live[] = ['id_coupons' => $panier['id_coupons'], 'id' => $panier['id'], 'token_datas' => array_diff(explode(',', $panier['token_datas']), array_column($tokens_to_remove,'token'))];
            }



            if(count($new_panier_live)>0){

              // Update des paniers avec les nouveaux tokens
              $this->choixPanierLiveRepo->updatebyTokens($new_panier_live);

              // Récupère la liste des paniers de ces produits pour chaque panier live et si différents de 1, 2, 3, 4 c'est qu'un palier est vide !
              $listPalier = $this->panierLiveRepo->getPanierByTokens($new_panier_live);
              $totalPalier = $this->panierLiveRepo->getAllPanier();
              $listUsers= $this->users->getAll(['id', 'name', 'username', 'email']);
              // Récupère la liste des lives programmés ou demandés
              $live = $this->code->getNextLives(['id_ambassadrice', 'id_coupons', 'status']);
              
              if(count($totalPalier)>0){
             
              foreach($listPalier as $palier){
                $diff = array_diff(array_column($totalPalier,'panier_title'), $palier['palier']);
                // Panier vide détecter sur un panier live

                $key_coupon = array_search($palier['id_coupons'], array_column($live,'id_coupons'));
                $key_email = array_search($live[$key_coupon]['id_ambassadrice'], array_column($listUsers,'id'));
                $email = $listUsers[$key_email]['email'];
                $name = $listUsers[$key_email]['name'];
                $username = $listUsers[$key_email]['username'];

                if(count($diff) >= 1){
                  if(in_array($palier['id_coupons'], array_column($live,'id_coupons'))){
                    // Update de la table code live avec un status bloquant le déclenchement de celui-ci
                    $this->code->updateByIdCoupon(['css' => 'paliervide'], $palier['id_coupons']);
                    // Envoie email aux ambassadrices avec live programmés ou demandés
                      Mail::send('email.alertPalier', ['empty' => true, 'name' => $name, 'username' => $username, 'palier' => $diff], function($message) use($email){
                        $message->to($email);
                        $message->from('no-reply@elyamaje.com');
                        $message->subject('Alerte Palier Live');
                      });  
                    
                     
                  } 
                } else {
                    $key_coupon = array_search($palier['id_coupons'], array_column($live,'id_coupons'));
                    $key_email = array_search($live[$key_coupon]['id_ambassadrice'], array_column($listUsers,'id'));
                    $email = $listUsers[$key_email]['email'];
                    $name = $listUsers[$key_email]['name'];
                    $username = $listUsers[$key_email]['username'];

                      Mail::send('email.alertPalier', ['empty' => false, 'name' => $name, 'username' => $username, 'palier' => $diff], function($message) use($email){
                        $message->to($email);
                        $message->from('no-reply@elyamaje.com');
                        $message->subject('Alerte Palier Live');
                      });  
                    
                }
              }

            }

          }
          

            //recupérer is_product et libelle, variation product
            // exécuter la tache
            DB::table('configuration_panier_lives')
              ->where('id', $id)
              ->update(array('panier_title' =>$panier_title,
              'libelle'=> $labels,
              'ids_produit'=>$list_product,
              'ids_variation'=> $list_variation,
              'ids_categories'=>$id_cats,
              'libelle_categories'=>$libelle_cats,
              'mont_mini' =>$mont_mi,
              'mont_max'=>$mont_max
            ));
                    
                    
            // suprimer les ligne ayant la valeur du panier $id
            //$panier = "panier.$id";
             $message="votre palier est bien modifé";
               // echec
               $message ="un produit ou le montant mini est deja dans un palier de cadeaux";
               $this->paniercount();
              $datas = $this->getDonnees();
               
              return view('ambassadrice.listerpanier',['datas'=>$datas]);
         
        
        
    }


    public function historiquepalier()
    {
        
        if(Auth()->user()->is_admin ==2) {
            $data = $this->historiquelive->getall();
           return view('ambassadrice.historiquepalierlive',['data'=>$data]);
         
        }
   }


    public function historiquelivepalier($id){ 
          $user = $this->users->getUserId($id);

          if($user){
            $data = $this->historiquelive->getalls($id);
            $lives_historique = [];
            $list_panier_montant = [];
            
            foreach($data as $lives){
              $first_key = $lives[0]["id_live"];
  
              foreach($lives as $live){
                $list_panier_montant[$live['pseudo']] = $live['montant'];
                if(isset($lives_historique[$first_key][$live['pseudo']])){
                  array_push($lives_historique[$first_key][$live['pseudo']], $live);
                } else {
                  $lives_historique[$first_key][$live['pseudo']] =  [$live];
                }
  
              }
            }
            
              return view('ambassadrice.livehistorique',['data'=>$lives_historique, 'list_panier_montant' => $list_panier_montant, 'user' => $user]);
          } else {
              return redirect('ambassadrice/activate/code_live');
          }
          
    }

}
      
    