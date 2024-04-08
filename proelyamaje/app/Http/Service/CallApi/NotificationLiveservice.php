<?php

namespace App\Http\Service\CallApi;

use App\Http\Service\CallApi\Apicall;
use Illuminate\Support\Facades\DB;
use App\Repository\Ambassadrice\HistoriquePanierLiveRepository;
use Mail;

use DateTime;
use DateTimeZone;

class NotificationLiveservice
{
      private $historique;
     
       public function __construct(HistoriquePanierLiveRepository $historique)
       {
           $this->historique = $historique;
       }

       public function getLives()
       {
            // recupérer les lives dela date encurs de delenchement
            // recupérer tous les live nom declenche de live 
            $result = DB::table('choix_panier_lives')->select('id_live','date_live','code_live')->get();
            $list = json_encode($result);
            $lists =  json_decode($result,true);
            
            // recupérer les champs
            $dateActuelle = new DateTime();
           // Soustraire un jour à la date actuelle..
           $dateMoins = date('Y-m-d');
           $date = new DateTime();
           $date->modify('-1 days');
           $dates_true = $date->format('Y-m-d H:i:s');
          
           //$nombre = DB::connection('mysql3')->select("SELECT code_client FROM prepa_tiers WHERE created_at > '$dates'");
           //$results = DB::table('historique_panier_lives')->select('id_live')->where('date_live','>',"$dates_true")->get();
           $donnees = DB::table('historique_panier_lives')
           ->where('date_live', '>', $dates_true)
           ->get();
            //
            $response = json_encode($donnees);
            $resp = json_decode($response,true);
            
            
            $id_lives =[];// recupérer les id de live moins de deux jours
            foreach($resp as $vl){
               $id_lives[] = $vl['id_live'];
            }
            

          // je veux cibler tous les live en cours dont l'ambassadrice n'a pas cliquer le bouton après 1h du live prévu
            $array_accept_condition =[];
            $code_live_notification =[];
            $code_live =[];
            $date = date('Y-m-d');
            $date_heure = date('H');
            
            foreach($lists as $values){
                $date_chaine = explode(' ',$values['date_live']);
                // recupérer la date 
                $date_live = $date_chaine[0];
                $heure_chaine = explode(':',$date_chaine[1]);
                $heure_fixe = (int)$heure_chaine[0];
                
                // je veux la date sois celle aujour d'huit et l'heure sois 
                if($date_live==$date && $date_heure - $heure_fixe >= 1){
                     // recupérer les id live et code live
                     // et léver la restriction souhaités à 6 jours
                     $code_live_notification[] = $values['id_live'];
                     $code_live[] = $values['code_live'];
                  }
              }

              if(count($code_live_notification)!=0){

                    $date ="2020-01-01 00:00:00";
                    DB::table('choix_panier_lives')
                   ->whereIn('code_live', $code_live_notification)
                   ->update(array('date_live'=> $date));

                   //envoi de mail
                   $list_email = array('zapomartial@yahoo.fr','mmajeri@elyamaje.com','live@elyamaje.fr');
                   $list_code = implode(',',$code_live);

                   foreach($list_email as $val) {
                       // envoi du mail mutiple au customer
                       Mail::send("email.notificationlive",['list_code' => $list_code] , function($message) use ($subject, $val) {
                       $message->to($val);
                       $message->from('no-reply@elyamaje.com');
                       $message->subject($subject);
    
                });

                dd('des live notifiés annulé');
           
              }

            }


            dd('pas de live notive');
         
      }

  }
     
    


































?>

























