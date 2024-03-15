<?php

namespace App\Repository\Orders;

use Hash;
use Mail;
use Exception;
use Carbon\Carbon;
use App\Models\Boutiqueorder;
use Illuminate\Support\Facades\DB;
use App\Http\Service\CallApi\Apicall;
use App\Http\Service\CallApi\Distributedorders;

class BoutiqueorderRepository implements BoutiqueorderInterface
{
     
     private $model;
     
     private $data = [];
     
     private $orderboutique;
     
    public function __construct(Boutiqueorder $model,
     Distributedorders $orderboutique,
     Apicall $api)
    {
      $this->model = $model;
      $this->orderboutique = $orderboutique;
      $this->api = $api;
    }
    
    
    
    public function getids():array
    {
        
        
    }
    
    
    public function insert()
    {
        
        try {
              // recupéer les ids provenant de la fonction preparer en boutique
             // si la commande n'est pas encore traiter
             $data = $this->orderboutique->getDataorderboutique();
             // recupérer les données de nices
             $data_nice = $this->orderboutique->getData();
         
              if(count($data)!=0  || count($data_nice)!=0) {
                  
                  $order_ids =[]; // recupérer des donnés ids de marseile
                  $order_ids_nice =[];// recupérer les données id de nice
                  foreach($data as $values){
                      $order_ids[] = $values['id_commande'];
                     // change directement via api le statuts
                     // modifier le status en pret magasin
                     $id = $values['id_commande'];
                     $a="neant";
                     $orderboutique =  new Boutiqueorder();
                     $orderboutique->id_commande = $id;
                     $orderboutique->provenance = $a;
                     $orderboutique->save();


                     $status="commande-a-prep";
                     $datas  = [
                     'status'=>$status,
                       ] ;
            
                   // modifier le status des commandes récupérer.
                  // insert des données en post dans Api woocomerce Put sur les status
                   $urls="https://www.elyamaje.com/wp-json/wc/v3/orders/$id";
                   $this->api->InsertPost($urls,$datas);
                   // insert dans une table
                 
                // envoi de mail .
           
          }
        
         foreach($data_nice as $valus){
                 $order_ids_nice[] = $valus['id_commande'];
                 // change directement via api le statuts
                 // modifier le status en pret magasin
                 $status="commande-prenic";
                  $datas  = [
                     'status'=>$status,
                  ] ;
                 // modifier le status des commandes récupérer.
                 // insert des données en post dans Api woocomerce Put sur les status
                 $id_nice = $valus['id_commande'];

                 $a="neant";
                 $orderboutique =  new Boutiqueorder();
                 $orderboutique->id_commande = $id_nice;
                 $orderboutique->provenance = $a;
                 $orderboutique->save();
            
               $urls="https://www.elyamaje.com/wp-json/wc/v3/orders/$id_nice";
               $this->api->InsertPost($urls,$datas);
               // insert dans une table
              
               // envoi de mail .
           
             }
        
            if(count($order_ids)!=0){
              // envoi un email contentant les ids
               $date = date('d-m-Y H:i:s');
               // tranformer en chaine de caractère le tableau.
                     $datas_ids_commandes = implode(',',$order_ids);
                        // personne qui vont recevoir l'email
                     $list_email = array('anissa@elyamaje.com','sarah@elyamaje.com','zapomartial@yahoo.fr','marina@elyamaje.com','ryma@elyamaje.com','sarah@elyamaje.com');// array receptor de mail.../
                    
                     foreach($list_email as $val){
                         // notifier un mail d'envoi..
                        Mail::send('email.orderboutique', ['datas_ids_commandes' => $datas_ids_commandes, 'date'=>$date], function($message) use($date, $val){
                        $message->to($val);
                        $message->from('no-reply@elyamaje.com');
                        $message->subject('Nouvelle commande à préparer en magasin  marseille le '.$date.' !');
                
                        });
                   
                    }
              }
              
              
               if(count($order_ids_nice)!=0){
                    // envoi un email contentant les ids..
                    $date = date('d-m-Y H:i:s');
                     // tranformer en chaine de caractère le tableau.
                     $datas_ids_commandes_nice = implode(',',$order_ids_nice);
                     // personne qui vont recevoir l'email
                     $list_emails = array('pamela@elyamaje.com','zapomartial@yahoo.fr','marina@elyamaje.com');// array receptor de mail.../
                    
                    foreach($list_emails as $vals){
                         // notifier un mail d'envoi
                        Mail::send('email.orderboutiquenice', ['datas_ids_commandes_nice' => $datas_ids_commandes_nice, 'date'=>$date], function($message) use($date, $vals){
                        $message->to($vals);
                        $message->from('no-reply@elyamaje.com');
                        $message->subject('Nouvelle commande à préparer en magasin nice le '.$date.' !');
                
                        });
                   
                    }
              }
              
              
                dd('des commandes envoyées via email');
        
              }
              
              if(count($data)==0 && count($data_nice)==0){
                  
                  dd('aucune commande recupérée');
              }

          return true;
        } catch (Exception $e) {
          return $e->getMessage();
        }
        
     }
     
     
     
     public function insert_nice()
     {
         
         
         
         
         
         
         
     }
     
}
    
    