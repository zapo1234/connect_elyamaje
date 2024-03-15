<?php

namespace App\Repository\Ambassadrice\Ordercustomer;

use App\Models\Ambassadrice\Ordersambassadricecustom;
use App\Models\Orderrefunded;
use App\Models\Ambassadrice\Cardscustomercontrol;
use App\Repository\Ambassadrice\CardscustomercontrolsRepository;
use App\Models\Ambassadrice\Notification;
use Illuminate\Support\Facades\DB;
use App\Http\Service\CallApi\AmbassadriceCustoms;
use Carbon\Carbon;
use Hash;

class OrderrefundedRepository implements  OrderrefundedInterface
{
     
     private $model;
    private $apiamba;
    private $data =[];
    private $some =[];
     private $cards;
    

    public function __construct(Ordersambassadricecustom $model, 
    AmbassadriceCustoms $apiamba,
     CardscustomercontrolsRepository $cards)
    {
      $this->model = $model;
      $this->apiamba = $apiamba;
       $this->cards = $cards;
    }
    
     public function insert()
    {
         // insert dans la base de données
        // listes des status valables à  recupérer
          $data_status = array('cancelled','refunded');
        
        // status other
        $data_status_refunded= array('refunded','cancelled');
        
        // list des codes indésirable
        $data_code = array('olnails20','aurelie20', 'lounails30','decleor15');
        
        // recupérer les id _commande
        $data_ids = $this->cards->getAllidcommande();
        $datac =$this->apiamba->getCardslist();
        
        // recupérer les commande
        $data = $this->apiamba->getDataorder();
        
        
        foreach($data as $values)
        {
             if(in_array($values['status'], $data_status))
            {
            
            
               $ordernew = new Orderrefunded();
               $ordernew->datet = $values['date_created'];
               $ordernew->code_promo = $values['code_promo'];
               $ordernew->id_commande = $values['id_commande'];
               $ordernew->status = $values['status'];
               $ordernew->id_ambassadrice = $values['id_ambassadrice'];
               $ordernew->montant = $values['somme'];
               // insert to bdd
                 $ordernew->save();
         }
         
       }
    }
        
        
}
     
    
     
     
      
