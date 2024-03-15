<?php

namespace App\Http\Service\CallApi;

use App\Http\Service\CallApi\Apicall;
use Illuminate\Support\Facades\DB;
use App\Repository\Ambassadrice\HistoriquePanierLiveRepository;
use Mail;

use DateTime;
use DateTimeZone;

class NotificationLive
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
           $result = DB::table('choix_panier_live')->select('id_live','date_live','code_live');
           $list = json_encode($result);
           $lists =  json_decode($result,true);
           // je veux cibler tous les live en cours dont l'ambassadrice n'a pas cliquer le bouton après 1h du live prévu
           $array_accept_condition =[];
           $code_live_notification =[];
           $date = date('Y-m-d');
           $date_minute = (int)date('h');
           foreach($lists as $values){
               $date_chaine = explode(' ',$values['date_live']);
               // recupérer la date 
               $date_live = $date_chaine[0];
               $heure_chaine = explode(':',$date_chaine[1]);
               $heure_fixe = (int)$heure_chaine[0];

               // je veux la date sois celle aujour d'huit et l'heure sois 
               if($date_live==$date && $date_heure - $heure_fixe > 1){
                     // recupérer les id live et code live
                     // envoi un email
                     // et léver la restriction souhaités à 6 jours
                    $code_live_notification[] = $val['code_live'];
                    // faire une notification a l'emabassadrice et nous
                    // lever la restriction
                    $date ="2020-01-01 00:00:00";
                    DB::table('choix_panier_lives')
                   ->where('code_live', $code_live)
                   ->update(array('date_live'=> $date));

                   // envoie un email zapomartial,live@elyamaje.fr,mmajeri@elyamaje.com

               }


           }
         
          return $lists;

       }

    
    
    
}
     
    


































?>

























