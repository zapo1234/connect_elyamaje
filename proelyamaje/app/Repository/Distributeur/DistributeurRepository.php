<?php

namespace App\Repository\Distributeur;

use Mail;
use DateTime;
use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Distributeur\Distributeurorder;
use App\Models\Distributeur\Distributeur;
use App\Http\Service\CallApi\Distributedorders;

class DistributeurRepository implements DistributeurInterface
{
     
     private $model;
     
     private $datalist = [];
     private $orders =[];
     private $socidorder =[];
     private $emailgroup =[];
     
    
     public function __construct(Distributeurorder $model,
      Distributedorders $ordersdistributeur)
    {
      $this->model = $model;
      
      $this->ordersdistributeur = $ordersdistributeur;
      
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


  public function getOrders(): array
  {
     return $this->orders;
  }
  
  
  public function setOrders(array $orders)
  {
    $this->orders = $orders;
   return $this;
  }


  public function getSocidorder(): array
  {
     return $this->socidorder;
  }
  
  
  public function setSocidorder(array $socidorder)
  {
    $this->socidorder = $socidorder;
     return $this;
  }


  public function getEmailgroup(): array
  {
      return $this->emailgroup;

  }
  
  
  public function setEmailgroup(array $emailgroup)
  {
     $this->emailgroup = $emailgroup;
      return $this;
  }




    public function getDistributeur()
    {
         // recupérer tous les data de la table.
        $data =  DB::table('distributeurs')->select('socid','nom','prenom','customer_id_wc','phone','email','country','code_postal')->get();
        $name_list = json_encode($data);
        $name_lists = json_decode($data,true);

        $socids =[];
         $chaine_info =[];
         $chaine_infos =[];
        foreach($name_lists as $key => $val){
           $socid[$val['socid']] = $key;
           $chaine = $val['socid'].','.$val['nom'].','.$val['prenom'].','.$val['phone'].','.$val['customer_id_wc'].','.$val['email'].','.$val['country'].','.$val['code_postal'];
           $chaine_info[$chaine] = $val['socid'];
           $chaine_infos[$val['email']] = $key;
        }

        // recupérer les infos
        $this->setDatalist($chaine_info);
        // recupérer ici
        $this->setEmailgroup($chaine_infos);
        return $socids;

    }

    public function getinfodsitributeur($socid)
    {
       $data =  DB::table('distributeurs')->select('socid','nom','prenom','customer_id_wc','phone','email','country','adresse','code_postal','city')->where('socid','=',$socid)->get();
       $name_list = json_encode($data);
       $name_lists = json_decode($data,true);

       $list_user ="";
       foreach($name_lists as $val){
         $list_user =[
         'nom'=> $val['nom'],
         'prenom'=>$val['prenom'],
         'phone' => $val['phone'],
         'email'=>$val['email'],
         'customer_id_wc'=>$val['customer_id_wc'],
         'code_postal' => $val['code_postal'],
         'city'=>$val['city'],
         'adresse'=>$val['adresse'],
          ];

       }
      
       return $list_user;

    }

    // recupérer les produit de woocomerce barcode et id product libelle
    public function  getproductorder()
    {
         // recupérer les produits disponible avec synchro avec les code bar
          $data =  DB::table('prepa_products')->select('name','product_woocommerce_id','price','barcode')->get();
          $name_list = json_encode($data);
          $name_lists = json_decode($data,true);
          $info_product =[];
          foreach($name_lists as $values){
            if($values['barcode']!=""){
              $chaine  = $values['product_woocommerce_id'].','.$values['name'].','.$values['barcode'];
              $info_product[$chaine] = $values['barcode'];
            }
          }
            return $info_product;

    }


     // recupérer les bonnes correspondances
     public function getProductbaroce()
     {
          // recupérer les produits  barcode et id parent
          $data =  DB::table('productbarcodewcs')->select('ids_product','id_parent','libelle','barcode')->get();
          $name_list = json_encode($data);
          $name_lists = json_decode($data,true);
          $info_product =[];
          foreach($name_lists as $values){
            if($values['barcode']!=""){
              $chaine  = $values['ids_product'].','.$values['libelle'].','.$values['id_parent'].','.$values['barcode'];
              $info_product[$chaine] = $values['barcode'];
            }
          }
            return $info_product;

      }

    public function getdetailsorder($id)
    {
          // recupérer tous les data de la table.
        $data =  DB::table('orders_distributeurs_line_products')->select('order_id','ref','libelle','quantite','subprice','barcode','total_ht')->where('order_id','=',$id)->get();
        $name_list = json_encode($data);
        $name_lists = json_decode($data,true);

        return $name_lists;

    }

    public function getorderiddistributeur()
    {
        // recupérer tous les data de la table.
        $data =  DB::table('order_distributeur_status')->select('id','date_create','ref_commande','socid','order_id','status','total_ht','total_ttc','user')->orderBydesc('id')->get();
        $name_list = json_encode($data);
        $name_lists = json_decode($data,true);
        $order_id =[];
        $list_orders =[];// recupérer la liste des commande voulu
        $user_distributeur =[];// recupérer la liste des distributeur à partir de leur order_id
        $status="";
        $user="";
        $users = Auth()->user()->is_admin;
        $name = Auth()->user()->name;
        $date = date('Y-m-d');
        if($users ==1){
          $pseudo ="par SuperAdmin";
        }

        if($users ==3){
          $pseudo ="par Utilisateur Elyamaje";
        }
        foreach($name_lists as $key => $val){
          $order_id[$val['order_id']] = $key;
          $chaine = $val['socid'].','.$val['order_id'];
          $user_distributeur[$chaine]= $val['order_id'];
           if($val['status']=="untreated"){
            $status="En attente";
            $css="buttontransfert";
          }
          else{
             $css="validetransfert";
             $status ="commande bien transférée vers wc $pseudo $name le $date";
          }


          if($val['user']=="no"){
            $user="";
          }else{
             // 
          }
            $list_orders[] =[
           'date_create' => $val['date_create'],
           'order_id'=> $val['order_id'],
           'ref_commande'=>$val['ref_commande'],
           'status' => $status,
           'total_ht'=>$val['total_ht'],
           'total_ttc'=>$val['total_ttc'],
            'user' => $val['user'],
            'css'=>$css

            ];
          
       }
       // recupérer le tableau 
       $this->setOrders($list_orders);

       // recupérer les infos socid
       $this->setSocidorder($user_distributeur);

       return $order_id;

    }

    public function getcommandeid($id)
    {
       $data =  DB::table('order_distributeur_status')->select('date_create','ref_commande','socid','order_id','status','total_ht','total_ttc','user')->where('order_id','=',$id)->get();
       $name_list = json_encode($data);
       $name_lists = json_decode($data,true);
      
      $list_order =[];
      foreach($name_lists as $key => $val){
           
        $list_order =[
          'date_create' => $val['date_create'],
          'total_ht'=>$val['total_ht'],
          'total_ttc'=>$val['total_ttc'],
          'status'=>$val['status']
           ];
           
      }

      return $list_order;

    }
   
   
   
    public function getAllidcommande()
    {
        
        // recupérer tous les data de la table
        $data =  DB::table('distributeurorders')->select('id_commande')->get();
        $name_list = json_encode($data);
        $name_list = json_decode($data,true);
        
        // recupérer les id commande deja passé
        $arrays_id = [];
        
        foreach($name_list as $values){
            $arrays_id[] = $values['id_commande'];
        }
        
        return $arrays_id;
    }
    
    
    public function insert()
    {
        try{
        
               // insert dans la table mail et envoi de nouveau mail !
               // recupérer le tableau via woocomerce api
          
               //$count_array = count($this->getAllidcommande());
                //$array_data = $this->getAllidcommande();// les id commande de la base de données.
                   $data_distributeur = $this->ordersdistributeur->getDataorder();
           
              // recupérer les ids dans le tableau et faire vérifier si il est deja dans la table 
                    // envoi un email avec des nouveau identifiant et data commande....
                    $ids_commande = [];
                    foreach($data_distributeur as $key => $values)  {
                    // recupérer les id_commande venaant de distriubuteur dans les données woocomerce.
                          
                         $ids_commande[] = $values['id_commande'];
                                  // inserer des données dans la base de données.
                                $distributed = new Distributeurorder();
                                $distributed->id_commande = $values['id_commande'];
                                $distributed->name = $values['customer'];
                                $distributed->email = $values['email'];
                                $distributed->status = $values['status'];
                                $distributed->adresse = $values['adresse'];
                                $distributed->telephone = $values['telephone'];
                                $distributed->somme = $values['somme'];
                        
                                // insert bdd
                                  $distributed->save();
                        
                         }
                
                         // faire un insert entre mes deux tableau ou un array diff
                        // et envoyer mon mail
                        $data_id_commande = $ids_commande;
                         // envoyer de mail
                        if(count($ids_commande)!=0){
                          $email_distributeur="distributeurs@elyamaje.com";
                          $email1="martial@elyamaje.com";
                            $date = date('d-m-Y H:i:s');
                        
                            // tranformer en chaine de caractère le tableau.
                            $datas_ids_commandes = implode(',',$ids_commande);
                            // mail à recevoir 
                            $list_email = array('marina@elyamaje.com','linda@elyamaje.com','zapomartial@yahoo.fr');
                        
                             foreach($list_email as $vals){
                                // notifier un mail d'envoi
                                Mail::send('email.distributeurs', ['datas_ids_commandes' => $datas_ids_commandes, 'date'=>$date], function($message) use($date,$vals){
                                $message->to($vals);
                                $message->from('no-reply@elyamaje.com');
                                $message->subject('Nouvelle commande distributeur chez Elyamaje le '.$date.' !');
                    
                               });
                          
                             }
                
                      }

                    //dd('operation succees');

                  return true;
              } catch (Exception $e) {
                  return $e->getMessage();
              }
    
        }

}






