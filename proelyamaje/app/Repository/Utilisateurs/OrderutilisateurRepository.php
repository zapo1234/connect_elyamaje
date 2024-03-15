<?php

namespace App\Repository\Utilisateurs;

use App\Models\Utilisateurs\Orderutilisateur;
use App\Models\Ambassadrice\Ambassadricecustomer;
use App\Models\Ambassadrice\Ordersambassadricecustom;
use App\Models\Ambassadrice\Notification;
use App\Repository\Codespeciale\CodespecialeRepository;
use App\Repository\Coupon\CouponRepository;
use App\Repository\Ambassadrice\Ordercustomer\OrderambassadricecustomsRepository;
use App\Repository\Ambassadrice\AmbassadricecustomerRepository;
use App\Repository\Ambassadrice\CodeliveRepository;
use App\Repository\Users\UserRepository;
use App\Http\Service\CallApi\Apicall;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Hash;
use DateTime;

class OrderutilisateurRepository implements OrderutilisateurInterface
{
     
     private $coupons;
     
     private $orders;
     
     private $code;
     
     private $amba;
     
     private $users;
    
     private $codespecial;
    
    public function __construct(Apicall $api,
    CouponRepository $coupons, 
    OrderambassadricecustomsRepository $orders,
    CodeliveRepository $code,
    AmbassadricecustomerRepository $amba,
    CodespecialeRepository $codespecial)
    {
      $this->coupons = $coupons;
      $this->orders = $orders;
      $this->api = $api;
      $this->code = $code;
      $this->amba =$amba;
      $this->codespecial = $codespecial;
    }
    
    
   public function getList()
   {
      $user_account="null";
      $user_account1="marseille";
      $user_account2="nice";
      $session_email =  Auth()->user()->email;
      $type = Auth()->user()->account_societe;
      
      if($type=="User-marseille"){
        return Orderutilisateur::where('user_count','=',$user_account1)->orderBy('id', 'desc')->get();
        
      }
      
      if($type=="User-nice"){
           return Orderutilisateur::where('user_count','=',$user_account2)->orderBy('id', 'desc')->get();
      }
        
      
   }
   
   public function insert($code_promo,$somme,$ref,$date_vente)
   {
           $data = $this->coupons->getcode_promo($code_promo,$somme,$ref);
           $name = Auth()->user()->name;
           $account_email = Auth()->user()->email;
           $utilisateur = $name.' à enregistrée la commande';
           $date1 = $date_vente;
           $date2 = date('H:i');
            $date2 = explode('/',$date1);
            $dats = $date2[0].'/'.$date2[1].'/'.$date2[2];
           $k = $date2[1];
           $kdate  = (int)$k;
           $annee = (int)$date2[2];
           $utilisateur = $name. ' à enregistrée la commande';
           $status=" Doli-payé";
           //  recuperer les codes promo éléves
           $data_tab =$this->amba->getCode_promo();
           // recupérer les codes lives éléves
           $this->code->getAllcodelive();
           $data_tab1 = $this->code->donnees();
          
           // recupérer les données des codes spécifique
           $this->codespecial->getAllcode();
           $data_tab2 = $this->codespecial->getListecode();
            // recupérer le commission
            $commissions ="";
            if(in_array($code_promo,$data_tab)) {

               $code_live = 11;
               $commissions=20;
            }
         
            if(in_array($code_promo,$data_tab1)) {
               $code_live = 12;
               $commissions=20;
            }
         
           if(in_array($code_promo,$data_tab2)){
              $code_live = 13;
              $commissions = (int)$this->getdatacodespecifique($code_promo);
           }
         
      
            $som=(int)$somme*(int)$commissions/100;
            $notification = "commande N° $ref . $som €";
            $email1="melisa@elyamaje.com";
            $email2="kenza@elyamaje.com";
            $email21 ="manon.a@elyamaje.com";
             $email3="pamela@elyamaje.com";
          
             $type = Auth()->user()->account_societe;
             // type user
             $array_user_marseille = array('melisa@elyamaje.com','anissa@elyamaje.com','marina@elyamaje.com','deborah@elyamaje.com','ella@elyamaje.com');// utilisteur marseille.
             $array_user_nice = array('pamela@elyamaje.com');
              // list 
              if($type=="User-marseille"){
                 $user_account="marseille";
             }
          
            if($type=="User-nice"){
                $user_account ="nice";
            }
          
          
           
             foreach($data as $key => $valu){
               $order = new Orderutilisateur();
               $order->datet = $dats;
               $order->id_ambassadrice = $valu['id_ambassadrice'];
               $order->code_promo = $valu['code_promo'];
               $order->user_count = $user_account;
               $order->nom = $valu['nom'];
               $order->email = $valu['email'];
               $order->somme = $somme;
               $order->ref_facture = $ref;
               $order->utilisateur = $utilisateur;
          
               $order->save();
               // enregsitrer dans orderamabassadricecustoms
               $orders = new Ordersambassadricecustom();
               $orders->datet = $dats;
               $orders->code_promo = $valu['code_promo'];
               $orders->id_commande = $ref;
               $orders->id_ambassadrice = $valu['id_ambassadrice'];
               $orders->is_admin = $valu['is_admin'];
               $orders->status = $status;
               $orders->customer = $valu['nom'];
               $orders->username = $valu['nom'];
               $orders->email = $valu['email'];
               $orders->telephone = $valu['telephone'];
               $orders->adresse = $valu['adresse'];
               $orders->total_ht = $somme;
               $orders->somme = $som;
               $orders->commission = $commissions;
               $orders->notification = $notification;
               $orders->some_tva = $som;
               $orders->code_mois = $kdate;
               $orders->annee = $annee;
               $orders->code_live = $code_live;
      
               $orders->save();
               // modifier le coupons à usage_lit à zero dans api woocomerce
               $id = $valu['id_coupons'];
               $description ="Code élève Ambassadrice utilisé en boutique -$ref";
               $date_invalite ="2023-01-30T09:01:00";
           
           $data  = [
                    
                    'usage_count'=>'1',
                    'date_expires'=>$date_invalite,
                    'description'=>$description,
                    'individual_use' => true,
                
                ] ;
            
              // insert des données en post dans Api woocomerce Post
            
             $urls="https://www.elyamaje.com/wp-json/wc/v3/coupons/$id" ;
             $this->api->InsertPost($urls,$data);
     
       }
     
     }
     
     public function getcustomer($codepromo)
     {
         // recuperer les information pour le code promo
         $result =  DB::table('ambassadricecustomer')->where('code_promo', '=', $codepromo)->get();
         // transformer les retour objets en tableau
         $name_list = json_encode($result);
         $name_lists = json_decode($result,true);
        
         foreach($name_list as  $values){
            foreach($values as  $val){
                $array_data[] = $val;
            }
        }
        
         // modifier dans api woocomerce percent code barre
     }
   
    public function orderid($id)
    {
        return Orderutilisateur::find($id);
    }
   
    public function editdata($code_promo,$somme,$ref_facture,$id,$date_vente,$mois,$annee)
    {
         // modifier 
        $notification = "commande N° $ref_facture . $somme '€";
        DB::table('orderutilisateurs')->where('id', $id)->update([
        'somme' => $somme,
        'ref_facture'=>$ref_facture,
        'datet'=>$date_vente
                    ]);
                    
        // modifier les champs somme dans ordercustomsambassadrice
        // modifier 
          DB::table('ordersambassadricecustoms')->where('code_promo', $code_promo)->update([
         'somme' => $somme,
         'notification'=>$notification,
         'code_mois'=>$mois,
         'annee'=>$annee,
         'datet' => $date_vente
          ]);
       
   }
 
   
}
    
    