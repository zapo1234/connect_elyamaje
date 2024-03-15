<?php

namespace App\Repository\Alerts;

use App\Models\Alertstock;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Mail;
use DateTime;

class AlertstocksRepository implements AlertstocksInterface
{
     
     private $model;
     
     private $datalist = [];
     
     private $dataid = [];
     

    public function __construct(Alertstock $model)
    {
      $this->model = $model;
      
    }
    
    
    
    
     /**
   * @return array
    */
   public function getDatalist(): array
   {
      return $this->datalist;
   }
   
   
   public function setDatalist(array $datalist)
   {
     $this->datalist = $datalist;
    return $this;
   }
   
   
     
     /**
   * @return array
    */
   public function getDataid(): array
   {
      return $this->dataid;
   }
   
   
   public function setDataid(array $dataid)
   {
     $this->dataid = $dataid;
    return $this;
   }
   
   
   
    public function createcsv()
   {
     
     // créer un csv et l'enregsitrer dans le chemin.
     $data = Alertstock::all();
    
     // transformer les retour objets en tableau
        $name_list = json_encode($data);
        $name_lists = json_decode($data,true);
    
    
    $path = storage_path('app/public/files');

    $fileName = rand(2,20000000).'.csv';
    
    // lire le fichier 
    $file = fopen($path.$fileName, 'w');
    
    // créer la première ligne colone du csv.
    $columns = array('product_id', 'name_product','reference','quantite_restant');
    
    // ecrire dans un fichier csv
    fputcsv($file, $columns);

       foreach($name_lists as $values)
       {
           $data_row = [
            'product_id' => $values['product_id'],  
            'name_product' => $values['product'],    
            'reference'=>$values['ref'],
            'quantite_restant' => $values['quantite_restant']
         ];

          
       }
       
       // ecrire et telécharger le csv dans $path.
        fputcsv($file, $data_row);
    

    fclose($file);

     }
 
 
    
    
    public function getAll()
    {
        
        // recupérer tous les data de la table
        $data =  DB::table('alertstocks')->select('product_id','ref','product','quantite_restant')->get();
        $name_list = json_encode($data);
        $name_list = json_decode($data,true);
        
        return $name_list;
    }
    
    
    public function getarrayalertsotcks()
    {
        
        // recupérer l'api dolibar product 
        // initailisser le tableau de la list
        $list_array_alerte_stocks = [];
        // list des id_product  respectant la condition
        $list_product_id = [];
        
        // list des id_product ne respectant pas la condition
        $list_product_ids = [];
        
        // recupérer les product via l'api
         // information de la cle api
        $dolaapikey ="9W8P7vJY9nYOrE4acS982RBwvl85rlMa";
        $urls ="https://www.poserp.elyamaje.com/api/index.php/products?sortfield=t.ref&sortorder=ASC&limit=800";
            
         // recupération des données de l'api dolibar
          $curl = curl_init();
          $httpheader = ['DOLAPIKEY: '.$dolaapikey];
     
          curl_setopt($curl, CURLOPT_URL, $urls);
          curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($curl, CURLOPT_HTTPHEADER, $httpheader);
          $result = curl_exec($curl);
           curl_close($curl);
          // transformer en array les données
           $data =  json_decode($result,true);
           
           // recupere product_id existant
           $id_product = $this->getAll();
           
           foreach($data as $km=>$values)
           {
               if($values['seuil_stock_alerte']!="")
               {
               
               if($values['seuil_stock_alerte'] > $values['stock_reel'])
               {
                   $list_array_alerte_stocks[] = $values['label'];
                   
                   $list_product_id[] = $values['id'];
               }
               
               else{
                   
                   $list_product_ids[] = $values['id'];
               }
             }
           
           }
           
           
           // recupérer la liste des id
           $this->setDataid($list_product_ids);
           
           
           return $data;
        
    }
    
    public function insert()
    {
        // inserère dans la table après verification et envoi de mail
        
        // vider la table des id qui respecte plus la condition
        $ids = $this->getDataid();
        
        $list_product = $this->getAll();
        
        // recupérer les id des product existant
        $list_id =[];
        
        foreach($list_product as $vas)
        {
            $list_id[] = $vas['product_id'];
        }
        
        
        // recupérer la liste des produit 
        $data = $this-> getarrayalertsotcks();
        
         $email_list_product = [];
            
            foreach($data as $valus)
            {
                
                if($valus['seuil_stock_alerte']!="")
                {
               // recupérer les produit qui respectent la condiftion suivante
                if($valus['seuil_stock_alerte'] > $valus['stock_reel'])
                {
                    
                    $email_list_product[] = [
                        
                    'product' =>$valus['label'],
                    'id_product'=>$valus['id'],
                    'ref'=>$valus['ref'],
                    'quantite_restant'=>$valus['stock_reel']
                        
                    ];
                }
                
                
                else{
                    
                        // si le produit est présent de la table suprime le
                         // recupérer les id produit présent dans la table qui ne respecte pas la condition voulu.
                        $array_id =[];
                         if(in_array($valus['id'],$list_id))
                        {
                          $array_id[] = $valus['id'];
                         }  
                        // faire un delete mutiple ici avec eloquent,suprimer.
                        DB::table("alertstocks")->whereIn('id',$array_id)->delete();
                    }
                
            }
            
            }
        
    
        
        if(count($list_product) == 0)
        {
             // envoi de mail
            $email ="martial@elyamaje.com";
            $date= date('d-m-Y');
            $subject ='Alerte de stocks, de nouveaux produits à ce jour'.$date;
              // notifier un mail d'envoi
                  Mail::send('email.alertstocks', ['email_list_product'=>$email_list_product,'date'=>$date], function($message) use($subject) {
                     $message->to('mmajeri@elyamaje.com');
                     $message->from('no-reply@prodev.elyamaje.com');
                     $message->subject($subject);
                  });
            
            foreach($email_list_product as $km => $val) 
            {
               // insert dans la base de données
                $alert = new Alertstock();
                $alert->product_id = $val['id_product'];
                $alert->ref = $val['ref'];
                $alert->email = $email;
                $alert->product = $val['product'];
                $alert->quantite_restant = $val['quantite_restant'];
            
                $alert->save();
            }
            
        }
        
        else{
                // verifier si le produit est deja passe en alert
                // nouveau tableau de list d'envoi de mail
                 $email_new_product =[];
                 foreach($data  as $valus)
                 {
                    if($valus['seuil_stock_alerte']!="")
                    {
                    
                    if($valus['seuil_stock_alerte'] > $valus['stock_reel'])
                    {
                   
                      if(!in_array($valus['id'],$list_id))
                      {
                         // recupérer la liste
                          $email_new_product [] = [
                          
                          'product' =>$valus['label'],
                         'id_product'=>$valus['id'],
                         'ref'=>$valus['ref'],
                         'quantite_restant'=>$valus['stock_reel'] 
                          
                          ];
                      
                  }
                  
                }
                
                }
              }
              
              
                // recupérer un tableau unique.
               // renvoyer un tableau unique par id product
                   $temp = array_unique(array_column($email_new_product, 'id_product'));
                   $email_unique_product = array_intersect_key($email_new_product, $temp);
              
                    // envoyer l'email si il n'est pas vide......
                    if(count($email_unique_product)!=0)
                    {
                      $email ="martial@elyamaje.com";
                      $email1 ="alertstocks@elyamaje.com";
                       $date =date('d-m-Y');
                       $subject = 'Alerts stocks sur les produits suivant'.$date;
                      // send email pour notification
                       Mail::send('email.alertstocks1', ['email_new_product' => $email_unique_product, 'date'=>$date], function($message) use($subject){
                       $message->to('mmajeri@elyamaje.com');
                       $message->from('no-reply@prodev.elyamaje.com');
                       $message->subject($subject);
                     });
                 
                    }
              
                 // insert en bdd
              
                 foreach($email_unique_product as $ks => $vad) 
                 {
                     // insert dans la base de données
                     $alert = new Alertstock();
                     $alert->product_id = $vad['id_product'];
                     $alert->ref = $vad['ref'];
                     $alert->email = $email;
                     $alert->product = $vad['product'];
                     $alert->quantite_restant = $vad['quantite_restant'];
                     $alert->save();
                }
              
            
             }
        
        
        }
        
    
    }









