<?php

namespace App\Repository\Pointbilan;
use Mail;
use Exception;

use Carbon\Carbon;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use App\Models\Ambassadrice\Pointbilan;



class PointbilanRepository implements PointbilanInterface
{

     private $model;
     private $orders;
     private $data =[];
     private $total ="";

     private $ids="";


    public function __construct(Pointbilan $model)
    {
         $this->model = $model;

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


    /**

   * @return array

    */

    public function getTotal()
    {
         return $this->total;
 
    }
 
    
   public function setTotal($total)
   {
 
      $this->total = $total;
 
     return $this;
 
   }


   public function getIds()
   {
        return $this->ids;

   }

   
  public function setIds($ids)
  {
     $this->ids = $ids;
     return $this;

  }




     public function getsearchamabassadrice($mois,$id)
     {
        return Pointbilan::where('id_mois', 'LIKE', "%$mois%")->where('id_ambassadrice', '=', $id)->orderByDesc('somme')->paginate(100);
     }

    public function getsearch($mois)
    {

      return Pointbilan::where('mois', 'LIKE', "%$mois%")->orderByDesc('somme')->paginate(100);
    }

     public function getnameambassadrice($id_ambassadrice)
     {
        return  Pointbilan::where('id_ambassadrice', '=', $id_ambassadrice)->orderByDesc('id')->paginate(100);
      }

     public function getdatasearch($id_mois,$annee)
     {
         return  Pointbilan::where('id_mois', '=', $id_mois)->where('annee','=',$annee)->orderByDesc('id')->paginate(100);
         // transformer les retour o
     }

     public function gettypeuser($is_admin)
     {
         return  Pointbilan::where('is_admin', '=', $is_admin)->orderByDesc('id')->paginate(100);
     }

     public function  getAllpay($id)
     {
        // recupérer la liste des facture
         return Pointbilan::select('pointbilans.*', 'users.rib')->join('users', 'users.id', '=', 'pointbilans.id_ambassadrice')->where('id_ambassadrice', '=', $id)->orderByDesc('pointbilans.id')->paginate(30);
         // transformer les retour o
     }
    
     public function getAllfacture()
    {
         // recupérer la liste des facture
         return Pointbilan::select('pointbilans.*', 'users.rib')->join('users', 'users.id', '=', 'pointbilans.id_ambassadrice')->orderByDesc('pointbilans.id')->get();
         // transformer les retour o
     }
    
    public function getAllfactures()
    {
        // recupérer la liste des facture
         return Pointbilan::select('pointbilans.*', 'users.rib')->join('users', 'users.id', '=', 'pointbilans.id_ambassadrice')->orderByDesc('pointbilans.id')->get();
         // transformer les retour o
    }

    public function getDatainvoices($id,$code,$annee)
    {
         $name_list = DB::table('pointbilans')->select('id','id_ambassadrice','somme','id_mois','mois','annee','status','somme_live','somme_eleve','nbrslive','nbrseleve')->where('id_ambassadrice', '=', $id)
         ->where('id_mois', '=', $code)
         ->where('annee','=',$annee)
         ->orderByDesc('id')
         ->get();
         $name_lists = json_encode($name_list);
          $name_lists = json_decode($name_list,true);
          return $name_lists;

    }

     public function getfactureambassadrice($id)
     {

        $name_list = DB::table('pointbilans')->select('id','name','id_ambassadrice','somme','id_mois','mois','css','tva','button','status','status_paiement','content','annee')->where('id_ambassadrice', '=', $id)
        ->orderBy('id', 'DESC')->get();
         $name_lists = json_encode($name_list);
         $name_lists = json_decode($name_list,true);

         return $name_lists;

      }

     public function getidpay($id)
     {
       $name_list = DB::table('pointbilans')->select('id','somme','ligne_note','id_mois')->where('id', '=', $id)->get();
       $name_lists = json_encode($name_list);
       $name_lists = json_decode($name_list,true);

       return $name_lists;
    }

    public function getfactureambassadriceim($id)
    {
       $css="im";
       $name_list = DB::table('pointbilans')->select('id','name','id_ambassadrice','somme','id_mois','mois','tva','css','button','status','content','annee')->where('css','=',$css)->where('id_ambassadrice', '=', $id)
       ->orderByDesc('id')
       ->get();
       $name_lists = json_encode($name_list);
       $name_lists = json_decode($name_list,true);
      return $name_lists;

   }

   public function insertpoint($id_ambassadrice,$is_admin,$account_societe,$tva,$email,$name,$type_compte){
         
       $index_mois = (int)date('m');

       if($index_mois ==1){
          $id_mois =12;
          $mois = "Décembre";
       }
       if( $index_mois >1){
         $id_mois = $index_mois-1;
         $mois="";
       }
   
      $array_point[] =[
   
      'id_ambassadrice'=>$id_ambassadrice,
      'is_admin'=>$is_admin,
      'account_societe'=> $account_societe,
       'tva'=>$tva,
       'email'=>$email,
       'name'=>$name,
       'id_mois'=> $id_mois,
       'mois' => $mois,
       'annee'=>date('Y'),
       'somme'=>0,
       'ligne_note'=>'',
       'status'=>'non payée',
       'type_compte'=>$type_compte,
       'nbrslive'=>0,
       'nbrseleve'=>0,
       'code_create'=>0,
       'nbrsfois'=>0,
       'somme_live'=>0,
       'somme_eleve'=>0,
       'content'=>'valider la facture',
       'button'=>'paiment',
       'css'=>'im',
       'csss'=>'inactifpay',
       'status_paiement'=>'non payée',

     ];

     DB::table('pointbilans')->insert($array_point);

  }

   public function getidsim($id)
   {
       $array_data = $this->getfactureambassadriceim($id);
       $array_ids =[];
       foreach($array_data as $val) {
         $array_ids[] = $val['id'];
       }

       return $array_ids;
    }


     
    public function alertpaypartenaire()
      {  
         try{
                
                 // recupérer toutes les factures impayées des partenaire !
                $css="im";
                // mois actuel 
                $mois = date('m');
               $id_mois = (int)$mois;
            
                if($id_mois==1){
                   $code_mois_true=12;
               }
               else{
                  $code_mois_true = $id_mois-1;
               }
               
               $data = Pointbilan::selectRaw("id_ambassadrice,email,tva,ligne_note,SUM(somme) as total_montant")
               ->where('css','=',$css)
               ->where('id_mois','=',$code_mois_true)
               ->groupBy('id_ambassadrice','email','tva','ligne_note')
                ->get();
                $name_lists = json_encode($data);
                $name_lists = json_decode($data,true);
                // recupérer les email de la table user valide
                 $name_lis = DB::table('users')->select('id','email','remember_token','name','username','is_admin')->get();
                 $name_list = json_encode($name_lis);
                 $lists = json_decode($name_list,true);

                 // RECupérer des tokens
                 $token_us = Str::random(60);
                 // recupérer tous les tokens.
                 $data_token = [];
                  // trier les partenaire existant .
                 $user_partenaire =[];
                  $email =[];

                  foreach($name_lists as $val) {
                       $email[] = $val['email'];
                  }

                  $email_autorise =[];
                  $user_id =[]; // array user les is_admin .

                  foreach($lists as $vac){
                     if(in_array($vac['email'],$email)) {
                        $email_autorise[] = $vac['email'];
                        $chaine = $vac['is_admin'].','.$vac['email'];
                         $user_id[$chaine]= $vac['email'];
                     }

                   }

                 $list_autorise =[];
                 $monts=0;

                 foreach($name_lists as $valc){
                    if(in_array($valc['email'],$email_autorise))  {

                          //
                          $ligne_note  = $valc['ligne_note'];
                          if($ligne_note!=""){
                             $line = explode('%',$ligne_note);
                             $line1 = explode(' ', $line[0]);
                             $montant_line = $line1[3];
                             // recupérer le montant
                             $montant_lines = explode('€',$montant_line);
                             $monts = $montant_lines[0];
                          }else{
                             $monts=0;
                          }
                           $tokens =  str_shuffle($token_us.$valc['id_ambassadrice']);
                           $list_autorise[] = [
                           'id_ambassadrice'=> $valc['id_ambassadrice'],
                           'email'=>$valc['email'],
                           'tva'=>$valc['tva'],
                           'total_montant'=> number_format($valc['total_montant'], 2, ',', ''),
                           'montant_line'=> $monts,
                           'token'=>$tokens

                           ];
                     }
                  }
            
                   $vx="30";
                   $toks = $token_us.'30';
                    $array[] =[
                   'id_ambassadrice'=>'31',
                   'email'=>'zapomartial@yahoo.fr',
                   'tva'=>20,
                   'total_montant'=> '210',
                   'montant_line'=>50,
                   'token'=>$toks
                   ];// pour faire des test.
                  $tok = $token_us.'91';
                   $array1[] =[
                   'id_ambassadrice'=>'30',
                   'email'=>'martial@elyamaje.com',
                   'tva'=>0,
                   'total_montant'=> '120', 
                   'montant_line'=>50,
                   'token'=>$tok
                    ];// pour faire des test.
                   $listx =  array_merge($list_autorise,$array); // tableau vrais pour notification de paimement(réel)
                   $arras = array_merge($array,$array1);// tableau fiftif pour test
                   // recupérer data tous les utilisateur dont le montant est supérieur a 200...........
                   $user_notif =[];// pour les motnant de plus de 200 euro
                   $user_notif1 =[];// pour les montant entre 100 et 200euro

               foreach($listx as $vb) {
                     // recupérer les montants..
                   if($vb['tva']==20){
                    $somme=160;
                   }

                   if($vb['tva']==0) {
                    $somme=200;
                   }
                    if($vb['total_montant'] > $somme ){
                      $user_notif[] = $vb;
                    }

                    if($vb['montant_line'] > $somme){
                      $user_notif[] = $vb;
                    }

                    if(100 < $vb['total_montant'] && $vb['total_montant'] <200){
                       $user_notif1[] = $vb;
                    }

                    if(100 < $vb['montant_line'] && $vb['montant_line'] <200){
                     $user_notif1[] = $vb;
                  }
               }

               
                       // envoi les email suivant a partir de 200euro..........
                        foreach($user_notif as $key => $vals) {
                          $date = date("d/m/Y");
                          $montant = $vals['total_montant'];
                           $code_amba = $vals['id_ambassadrice'];
                           // recupérer le is admin
                           if(array_search($vals['email'],$user_id)!=false) {  
                                 $chaine = array_search($vals['email'],$user_id);
                                 $is_admin = explode(',',$chaine);
                                 $is_adm = $is_admin[0];
                             }
                              else{
                                 $is_adm =2;
                              }
                               if($is_adm ==2){ 
                                  $libelle ="Ambassadrice";
                              }

                              else{
                                  $libelle = "Partenaire";
                              }

                              $token = $vals['token'];
                              Mail::send('email.notifpartenaire', ['montant'=>$montant,'date'=>$date, 'code_amba'=>$code_amba,'token'=>$token,'libelle'=>$libelle], function($message) use($date,$vals, $montant,$code_amba,$token){

                              $message->to($vals['email']);
                              $message->from('no-reply@elyamaje.com');
                               $message->subject('Notification de paiment chez elyamaje '.$date.' !');
                          });

                           // 
                            $data_token[] = 
                              [
                                 'id_partenaire'=> $vals['id_ambassadrice'],
                                 'tokens' => $vals['token']
                              ];
                     }
                         // insert dans la bdd...
                           $array_da = array_unique(array_column($data_token, 'id_partenaire'));
                           $data_selected_token = array_intersect_key($data_token, $array_da);
                           DB::table('partenaire_tokens')->insert($data_selected_token);
                           // insert dans la table token_user...
                           // recupérer les informations pour le paiement bon d'achat....

                           foreach($user_notif1 as $key => $vals) {
                              $date = date("d/m/Y");
                              $montant = $vals['total_montant'];
                               $code_amba = $vals['id_ambassadrice'];
                               // recupérer le is admin
                               if(array_search($vals['email'],$user_id)!=false) {  
                                     $chaine = array_search($vals['email'],$user_id);
                                     $is_admin = explode(',',$chaine);
                                     $is_adm = $is_admin[0];
                                 }
                                  else{
                                     $is_adm =2;
                                  }
                                   if($is_adm ==2){ 
                                      $libelle ="Ambassadrice";
                                  }
    
                                  else{
                                      $libelle = "Partenaire";
                                  }
    
                                  $token = $vals['token'];
                                  Mail::send('email.notifpartenaires', ['montant'=>$montant,'date'=>$date, 'code_amba'=>$code_amba,'token'=>$token,'libelle'=>$libelle], function($message) use($date,$vals, $montant,$code_amba,$token){
    
                                  $message->to($vals['email']);
                                  $message->from('no-reply@elyamaje.com');
                                   $message->subject('Notification de paiment chez elyamaje '.$date.' !');
                              });
    
                               // 
                                $data_token1[] = 
                                  [
                                     'id_partenaire'=> $vals['id_ambassadrice'],
                                     'tokens' => $vals['token']
                                  ];
                          }
                              // insert dans la bdd...
                               $array_da1 = array_unique(array_column($data_token1, 'id_partenaire'));
                               $data_selected_token1 = array_intersect_key($data_token1, $array_da1);
                               DB::table('partenaire_tokens')->insert($data_selected_token1);
                               // insert dans la table token_user...
                           return true;
                     } catch(Exception $e){
                        return $e->getMessage();
                     }

         }


          public function envoimail($id){
            // renvoi les mails à des ambassadrice ou partenaire(pour rappel)
         



          }


         public function getfacturepay() {
                $status="im";
                $somme =160;
                $data =   Pointbilan::where('css', '=', $status)->where('somme','>',$somme)->orderByDesc('id')->paginate(200);
                 return $data;
         }
        
         public function getusermoispay($id_ambassadrice,$mois,$annee){
            $somme="190";
            $status="im";
            $data =   Pointbilan::where('css', '=', $status)->where('somme','>',$somme)->where('is_admin','=',$id_ambassadrice)->where('id_mois','=',$mois)->where('annee','=',$annee)->orderByDesc('id')->paginate(200);
            return $data;
                       
         }

         public function  getusermoisim($id_ambassadrice,$mois,$annee){
              $somme="190";
              $status="im";
              $data =   Pointbilan::where('css', '=', $status)->where('somme','<',$somme)->where('is_admin','=',$id_ambassadrice)->where('id_mois','=',$mois)->where('annee','=',$annee)->orderByDesc('id')->paginate(200);
              return $data;
          }


         public function getfacturesolde($id_ambassadrice,$mois,$annee)
         {
              $status="pay";
              $data =   Pointbilan::where('css', '=', $status)->where('is_admin','=',$id_ambassadrice)->where('id_mois','=',$mois)->where('annee','=',$annee)->orderByDesc('id')->paginate(200);
             return $data;

         }

         public function userisadmin($id)
         {
            $data = DB::table('users')->select('id','is_admin')->where('id','=',$id)->get();
            $lis = json_encode($data);
            $list = json_decode($data,true);
            return $list;

         }

         public function getlastid($id){

            $lastOne = DB::table('pointbilans')->where('id_ambassadrice','=',$id)->latest('id')->first(); // id dernier enregsitrement de facture
            $last_id =$lastOne->id;
            return $last_id;
         }


         public function getcummulpay($id)
         {
              // recupérer le customer is_admin 
                $id_admins = $this->userisadmin($id);
                $this->setIds($this->getlastid($id));
              // recupérer le cummul de l'utilisateur à ses dernier facturede l'ambassadrice ou partenaire.
               $not ="im";
               $data = Pointbilan::Where('id_ambassadrice',$id)
              ->selectRaw("SUM(somme) as total_montant")
              ->where('css','=',$not)
              ->get();
              $name_lists = json_encode($data);
              $name_lists = json_decode($data,true);

              //dd($name_lists);
              
              // array retour .
              // recupérer les email de la table user valide
               $infos =false; 
               $montant_ht =500;// pour le lot de note pour les ambassadrice.
               $montant_hts =3000;// spécialement les partenaire.(le cumul)
               $array_montant =[];
               $libelle=[];

             foreach($name_lists as $values) {
                    
               $montant = (int)$values['total_montant'];
            
                    if($id_admins[0]['is_admin']==2){
                    if($montant < $montant_ht){
                          $infos = true;
                    }else{
                        $infos =false;
                    }
                   }

                  if($id_admins[0]['is_admin']==4){
                     if($montant < $montant_hts) {
                        $infos = true;
                    }else{
                      $infos =false;
                   }
                 }
              }

             if($infos==true){
                   // va me chercher les montants et les date des differement montant de l'utilisateur(partenaire ou ambassadrice.).
                   // recupérer la méthode pour les facture imapyées.
                   $result =  $this->getfactureambassadriceim($id);

                    // recupérer les montant de ces dernier 
                  foreach($result as $vc) {
                     $tva = $vc['tva'];
                     $somme_t = $vc['somme']+$vc['somme']*$tva/100;
                     $somme_true = number_format($somme_t, 2, ',', '');
                    
                    if($vc['somme']!=0.00){
                           if($vc['id_mois'] > 9){
                            $mois = $vc['id_mois'];
                          }

                          else{
                             $mois = '0'.$vc['id_mois'];
                          }
                          
                            $libelle[] =' solde du '.$mois.'/'.$vc['annee'].' '.$somme_true.'€';
                            $array_montant[] =   $somme_t;
                       }

                   }

                   $total = array_sum($array_montant);
                    // recupérer les libelle
                   // et le total
                 }

              if($infos==false) {
                 $libelle =[];
                  $total =0;
              }

                  // recupérer les libelle
                   // et le total
                   $this->setData($libelle);
                   $this->setTotal($total);// renvoi le montant total .
               
          }

   }

    

    



     

    





















