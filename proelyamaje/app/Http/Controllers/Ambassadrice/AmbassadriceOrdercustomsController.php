<?php

namespace App\Http\Controllers\Ambassadrice;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Repository\Ambassadrice\Ordercustomer\OrderambassadricecustomsRepository;
use App\Repository\Ambassadrice\AmbassadriceRepository;
use App\Repository\Ambassadrice\AccountambassadriceRepository;
use App\Repository\Pointbilan\PointbilanRepository;
use  App\Repository\Bilandate\BilandateRepository;
use App\Repository\Codespeciale\CodespecialeRepository;
use App\Repository\Giftcards\GiftcardsRepository;
use App\Repository\Cardsgift\CardsgiftRepository;
use App\Repository\Users\UserRepository;
use App\Http\Service\CallApi\Apicall;
use App\Http\Service\CallApi\Api;
use App\Http\Service\CallApi\GetgiftCards;
use App\Http\Service\CallApi\Generatormontantfacture;
use App\Http\Service\CallApi\TransfertOrderdol;
use App\Http\Service\FilePdf\CreatePdf;
use App\Http\Service\CallApi\AmbassadriceCustoms;
use App\Models\Ambassadrice\Orderambassadricecustom;
use App\Repository\Distributeur\DistributeurRepository;
use App\Models\Ambassadrice\Notification;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Mail;
use Carbon\Carbon;
use DateTime;

class AmbassadriceOrdercustomsController extends Controller
{
    //
    
    public function __construct(OrderambassadricecustomsRepository $repo, 
    AmbassadriceRepository $amba,
      Apicall $api,
      Api $apis,
      AmbassadriceCustoms $apic, 
      AccountambassadriceRepository $account,
      PointbilanRepository $point,
      Createpdf $pdf,
      UserRepository $users,
      BilandateRepository $bilan,
      UserRepository $user,
      CodespecialeRepository $codespecial,
       GiftcardsRepository $gift,
       CardsgiftRepository $getcard,
        GetgiftCards $apigift,
        Generatormontantfacture $generator,
        DistributeurRepository $distributeur,
        TransfertOrderdol $transfert)
      {
         $this->repo = $repo;
         $this->amba = $amba;
         $this->api = $api;
         $this->apis = $apis;
         $this->apigift = $apigift;
         $this->apic = $apic;
         $this->account = $account;
         $this->point = $point;
         $this->pdf = $pdf;
         $this->users =$users;
         $this->bilan = $bilan;
         $this->user = $user;
         $this->codespecial = $codespecial;
         $this->gift = $gift;
         $this->getcard = $getcard;
         $this->distributeur = $distributeur;
         $this->transfert = $transfert;
         $this->generator = $generator;
      }
      
      
      
      public function listorder()
      {
          
          // recupérer les order avec un code promo amabassadrice
          
          return view('ambassadrice.orders');
      }
      
      public function listorders()
      {
         // ceation des data amabassadrice
          //$users = $this->repo->getCustomerAll();
          //lister  les commande de l'ambassadrice via code parainnage
          $id = Auth()->user()->id;
          $is_admin =Auth()->user()->is_admin;
          
         if($is_admin==1 OR $is_admin ==3){
              $users = $this->repo->getCustomerAll();
          }
         return view('ambassadrice.orders',['users'=>$users]);
          // appelle api
     }
      
      public function listcodepromo()
      {
             $orders = $this->repo->getCustomerAll();
             // transformer en chaine en array les données objet
             $data_ordes = json_encode($orders);
             $data_orders = json_decode($data_ordes,true);
              dd($data_orders);
          return view('utilisateurs.orderscodepromo',['data_orders' =>$data_orders]);
       }
      
      // top 3
      public function getop3($id)
      {
         if(Auth()->user()->is_admin == 1)
         {
            // recupérer les informations sur l'ambassadrice
            $model_user = User::find($id);
            $name = $model_user->name;
        
              // recupérer le top 3 des produits les plus vendu par l'ambassadrice ou partenaire
              $data_ventes= DB::table('promotionsums')->select('id_product','label_product','sku','code_promo')->where('id_ambassadrice','=',$id)->get();
              $list = json_encode($data_ventes);
              $lists = json_decode($data_ventes,true);
                $data_vente =[];// pour les lives
              $data_vent = [];// pour les codes promo
              
              // deux varibale
              $lives ="-amb";
              $code_promo = "-10";
              $code_promos ="10";
              
               $data_vente_live =[];
              $data_vente_promo =[];
              
              foreach($lists as $kl=>$vb)
              {
                  if($vb['sku']!="")
                  {
                      $data_vente[] = $vb['label_product'].' ,'.$vb['sku'];
                  }
                  
                  if($vb['code_promo']!=""){
                       // recupérer les données des ventes lives si le code promo contient  -amb
                      if(strpos($vb['code_promo'],$lives)!=false) {
                          $data_vente_live[] = $vb['label_product'].' ,'.$vb['id_product'];
                      }
                       // recupérer des données ventes code promo si les code promo contient -10
                      elseif(strpos($vb['code_promo'],$code_promo)!=false) {
                          $data_vente_promo[] =  $vb['label_product'].' ,'.$vb['id_product'];
                      }
                       else{
                           $data_vente_live[] = $vb['label_product'].' ,'.$vb['id_product'];
                      }
                  }
              }
              
             
             if(count($data_vente_live)!=0){
                // compter le nombre de fois l'iteration dans les array lives et promo
                 $data_ventes_lives= array_count_values($data_vente_live);
                  // resortir un tableau decroissant via la valeur
                 arsort($data_ventes_lives);
                 // recupérer les clé du tableau qui sont des labels product 
                 $data_top_live = array_keys($data_ventes_lives);
                  // recupére les 3 premiers produits top live
                 $top_live11 = explode(',',$data_top_live[0]);
                 $top_live12 =  explode(',', $data_top_live[1]);
                 $top_live13 = explode(',',$data_top_live[2]);
                 $css="oui";
                  $top_live1 = $top_live11[0];
                 $top_live2 =  $top_live12[0];
                 $top_live3 =  $top_live13[0];
                 $css="oui";
             }
             
             else{
                    $top_live1 ="";
                     $top_live2 ="";
                     $top_live3 = "";
                     $css="no";
                 
             }
             
             if($data_vente_promo) {
                  $data_ventes_promo = array_count_values($data_vente_promo);
                  arsort($data_ventes_promo);
                  $data_top_promo = array_keys($data_ventes_promo);
                  // recupérer les 3 premiers produits top promo
                   $top_promo11 = explode(',',$data_top_promo[0]);
                   $top_promo21 =  explode(',',$data_top_promo[1]);
                   $top_promo31 = explode(',',$data_top_promo[2]);
                   $css="oui";
                   $top_promo1 = $top_promo11[0];
                   $top_promo2 =  $top_promo21[0];
                   $top_promo3 =  $top_promo31[0];
                   $css="oui";
                   
              }
             
             else{
                 
                  $top_promo1 = "";
                 $top_promo2 =  "";
                 $top_promo3 = "";
                 $css="no";
                 
             }
          } 
         
          return view('ambassadrice.top3produits',['name'=>$name,'top_live1'=>$top_live1, 'top_live2'=>$top_live2, 'top_live3'=>$top_live3, 'top_promo1'=>$top_promo1,'top_promo2'=>$top_promo2,'top_promo3'=>$top_promo3]);
      }
      
      
       public function listord(Request $request)
       {
            //lister  les commande de l'ambassadrice via code parainnage
             $id = Auth()->user()->id;
            $is_admin =Auth()->user()->is_admin;
             // Recuperer la variable
            $nom = $request->get('account_nom');
            if($is_admin==2)
            {
              if($nom=="")
              {
                $users = $this->repo->getCustomerId($id);
              }
              else
              {
                  $users = $this->repo->getCustomerIdsame($id,$nom);
              }
            }
              return view('ambassadrice.orderaccount',['users'=>$users]);
             // appelle api
         
        }
      
      
      public function getsuspend()
      {
          return view('ambassadrice.suspend');
      }
      
      public function listordersparain()
      {
          $id = Auth()->user()->id;
          // lister les commande via code promo éléves
          $users = $this->repo->getCustomerIds($id);
         return view('ambassadrice.ordersparain',['users'=>$users]);
      }
      
      
       public function lists()
       {
          $id = Auth()->user()->id;
          $users = $this->repo->getAlllistordersThisMonth($id);

         return view('ambassadrice.orderslists',['users'=>$users]);
       }
      
      
      
      public function getfacture()
      {
          $id = Auth()->user()->id;
          // recupérer les facture
          if(Auth()->user()->is_admin==1 OR Auth()->user()->is_admin==3) {
               // recupérer les ambassadrices et partenaire
               // recupérer la liste des ambassadrice et patenaire
               $this->users->getUser();
              // recupérer les tableau
              $ambassadrice = $this->users->getdata();
              $partenaire = $this->users->getdatas();
          
              $list =[];
              $lists = [];
              foreach($ambassadrice as  $k =>$val) {
              $v = explode(',',$val);
               $list[] = [
                 $k=> $v[0]
                  ];
            }
             foreach($partenaire as  $ks =>$vals){
              $vs = explode(',',$vals);
               $lists[] = [
                 $ks=> $vs[0]
                  ];
             }
        
              $users = $this->point->getAllfacture();
               $a =[];
               $option_default = "Type d'utilisateur";
              $option_default2 = "facture payable";
              
            }
          
           if(Auth()->user()->is_admin ==2 OR Auth()->user()->is_admin==4) {
            $users =  $this->point->getAllpay($id);

            $list =[];
            $option_default="";
            $option_default2="facture payable";
            $lists =[];
          }
          
          $message="";
          
          $datas =[];

        //   dd($users);
       
         return view('ambassadrice.factures', ['users'=>$users, 'datas' =>$datas,'list'=>$list,'lists'=>$lists,'option_default'=>$option_default,
         'option_default2'=>$option_default2,'message'=>$message]);
      }
      
      
      public function facturesusers()
      {
        $id = Auth()->user()->id;
        // recupérer les facture
        if(Auth()->user()->is_admin==1 OR Auth()->user()->is_admin==3) {
             // recupérer les ambassadrices et partenaire
             // recupérer la liste des ambassadrice et patenaire
             $this->users->getUser();
            // recupérer les tableau
            $ambassadrice = $this->users->getdata();
            $partenaire = $this->users->getdatas();
        
            $list =[];
            $lists = [];
        foreach($ambassadrice as  $k =>$val) {
            $v = explode(',',$val);
             $list[] = [
               $k=> $v[0]
                ];
         }
           foreach($partenaire as  $ks =>$vals){
            $vs = explode(',',$vals);
             $lists[] = [
               $ks=> $vs[0]
                ];
         }
      
            $users = $this->point->getAllfacture();
             $a =[];
             $option_default = "Type d'utilisateur";
            $option_default2 = "facture payable";
            
        }
        
        if(Auth()->user()->is_admin ==2 OR Auth()->user()->is_admin==4) {
          $users =  $this->point->getAllpay($id);

          $list =[];
          $option_default="";
          $option_default2="facture payable";
          $lists =[];
        }
        
          $message="";
          $datas =[];

       //   dd($users);
     
        return view('ambassadrice.utilisateurfact', ['users'=>$users, 'datas' =>$datas,'list'=>$list,'lists'=>$lists,'option_default'=>$option_default,
       'option_default2'=>$option_default2,'message'=>$message]);
         
          
      }
      
      
      public function getfactures(Request $request)
      {
          if(Auth()->user()->is_admin ==2 OR Auth()->user()->is_admin==4 OR Auth()->user()->is_admin==1){
            $id = Auth()->user()->id;
             // recupére la variable
             $periode = $request->get('date_from');
             $mois = $periode;
             
            $users =  $this->point->getAllpay($id);
             
             if($periode == 13){
                $users =  $this->point->getAllpay($id);
             }
             
             if($periode!="" && $periode!=13)
             {
                 $users = $this->point->getsearchamabassadrice($mois,$id);
             }
             
             if($periode=="")
             {
                 $users =  $this->point->getAllpay($id);
                 
             }
           

            $list =[];
            $option_default="";
            $lists =[];
          }
          
          $datas =[];

         return view('ambassadrice.fact', ['users'=>$users, 'datas' =>$datas,'option_default'=>$option_default]);
          
          
      }
      
      
      
       public function getfamabassadrice(Request $request)
       {
             $this->generator->updategeneratorfacture(14,2023);
            // $this->generator->updatecode_use();
            // recupérer les variable !ù
             $id = $request->get('ambassadrice');
             $mois = $request->get('datea_from');
             $annee = $request->get('datea_annee');

          if(isset($id) && isset($mois) && isset($annee)) {
               $id = $request->get('ambassadrice');
             $mois = $request->get('datea_from');
             $annee = $request->get('datea_annee');
               // lancer la fonction pour update et recupération des données factures !
             $this->repo->updatefacture($id,$mois,$annee);
          
          }
          
          $ids = $request->get('partenaire');
          $mois1 = $request->get('datep_from');
          $annee1 = $request->get('datep_annee');
          
           if(isset($ids) && isset($mois1) && isset($annee1)){
               $ids = $request->get('partenaire');
               $id =$ids;
              $mois1 = $request->get('datep_from');
              $annee1 = $request->get('datep_annee');
              $mois = $mois1;
              $annee = $annee1;
               // lancer la fonction pour update et recupération des données factures !
             }
          
          $data = $this->repo->updatefacture($id,$mois,$annee);
          
          if($data =="error"){
              return redirect()->route('ambassadrice.getfactures')->with('error','ces données de factures n\'existe pas !');
          }
          
          if($data =="success"){
            return view('gestion.confirmfacture');
          }
          
      }
      
      
      
      public function createfacture()
      {
          
        // recupérer les ambassadrices et partenaire
        
        // recupérer la liste des ambassadrice et patenaire
          
          $this->users->getUser();
          // recupérer les tableau
          $ambassadrice = $this->users->getdata();
          $partenaire = $this->users->getdatas();
          
          $list =[];
          $lists = [];
          foreach($ambassadrice as  $k =>$val) {
              $v = explode(',',$val);
              
              $list[] = [
                      
                      $k=> $v[0]
                  ];
          }
          
          foreach($partenaire as  $ks =>$vals){
              $vs = explode(',',$vals);
                $lists[] = [
                       $ks=> $vs[0]
                  ];
          }
        
        
        return view('ambassadrice.getfactures',['list'=>$list,'lists'=>$lists]);
      }
      
      
      
      public function getinvoices($id,$code,$annee)
      {
        if($id == Auth()->user()->id || Auth()->user()->is_admin == 1 || Auth()->user()->is_admin == 3){
            
            return $this->pdf->invoicespdf($id,$code,$annee);
        }
         
      }

      public function getinvoicess($id,$code,$annee)
      {
        if($id == Auth()->user()->id || Auth()->user()->is_admin == 1 || Auth()->user()->is_admin == 3){
            
            return $this->pdf->invoicespdf($id,$code,$annee);
        }
         
      }

      
      
      public function getexcelinvoices($id,$code,$annee)
      {
        if($id == Auth()->user()->id || Auth()->user()->is_admin == 1 || Auth()->user()->is_admin == 3){
          return $this->pdf->getexcel($id,$code,$annee);
        }
          
      }
      
      
      public function getprice()
      {
         // recupérer le nombre de vente  des customers.
         if(Auth()->user()->is_admin==1) {
             $id =2;
             $datas = $this->users->getambassadrice($id);
             $donnes =[];
             return view('ambassadrice.statistiques',['datas'=>$datas, 'donnes' => $donnes]);
          
         }
          
      }
      
      
      
      public function str_generator()
      {
          // générer une chaine de caractère aléatoire de 16 
          $x = 0;
          $y = 10;
          $Strings = '0123456789abcdefghijklmnopqrstuvwxyz';
          $a = 0;
           $b = 8;
          $Strings='0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
          $xa = substr(str_shuffle($Strings), $a, $b);
        
          return $xa;
    }
      
      
     public function invoicespay(Request $request)
      {
          $id = Auth()->user()->id;
          // recupérer les facture
          if(Auth()->user()->is_admin==1){
              
              $int = $request->get('id_facture');
               // nature uusers
              $is_admin = $request->get('is_admin');
              // montant 
              $montant = $request->get('montant');
              // recupérer l'id amabssadrice
              $id_ambassadrice = $request->get('id_ambassadrice');
            // recupérer le nom du user 
              $name = $request->get('name_user');
              // recupérer l'email du recepient...
              $email_user = $request->get('email_user');
               // recupérer la dernier ligne 
              // recupérer les années et mois en cours
              $mois = $request->get('mois');
              $annee = $request->get('annee');
               $somme = number_format($montant, 2, ',', '');
              // générer un nombre aléatoire pour cards cadeau
             // requete ajax pour valider de la facture ambassadrice
              $date = date('Y-m-d');
              $heure = date('H:i');
               $dates = explode('-', $date);
               $datef = $dates[2].'/'.$dates[1].'/'.$dates[0];
              
              $debut="";
              if($is_admin ==2) {
                  $debut="A";
              }
              
              if($is_admin ==4){
                  $debut ="P";
              }
              // insert dans base de données gift cards.
               $code_number = $debut.'-'.$this->str_generator();
             // reponse en fonction du user Ambassadrice/partenaire
              //si c'est une ambassadrice
            if($is_admin!="") {
           
               if($is_admin ==2 OR $is_admin==4) {
                 $status ="payée par virement bancaire le $datef  à  $heure ";
                 $content ="Annuler la facture";
              }
           
              // si c'est un partenaire
               $ids = $this->point->getidsim($id_ambassadrice); // recupérer les ids en im.
               $array_choix =[];
               $array_deduction =[];
               foreach($ids as $value){
                 if($value <= $int){
                    $array_choix[] = $value;
                 }

                 if($value > $int){
                   $array_deduction =[];
                 }
               }

               $resultat_data = $this->point->getidpay($int);
               if(count($resultat_data)!=0){
                   $somme_data = $resultat_data[0]['somme'];
                   $line_data = $resultat_data[0]['ligne_note'];
                   if($line_data!=""){
                   // recupérer le montant 
                    $somme_r = explode('%',$line_data);
                    $ligne_end = end($somme_r);
                   // montant à recupérer
                    $montss = explode(' ',$ligne_end);
                    $mont = explode('€',$montss[1]);
                    //
                     $somme_paye = $mont[0];
                    $line_mois = $resultat_data[0]['id_mois'];// le mois et la somme à retirer

                 }
                // verifier si elle et la suivante possedent des lines de facture due...
             }
              $array_true_data =[];
              
              if(count($array_deduction)!=0 && count($resultat_data)!=0){
                  
                 $int_suivant = $array_deduction[0];
                   $resultat_data1 = $this->point->getidpay($int_suivant);

                  if($resultat_data1[0]['ligne_note']!=""){

                  $somme_data1 = $resultat_data1[0]['somme'];
                  $line_data1 = $resultat_data1[0]['ligne_note'];
                   $array_line_datas = explode('%',$line_data1);

                // recupérer la dernière chaine 
                  $end_index_array = end($array_line_datas);
                // suprimer le dernier index du tableau.
                  $end_data_array = count($array_line_datas)-1;
                  unset($array_line_datas[$end_data_array]);
                 
                  $nombre_line = count($array_line_datas); // chercher le nombre de mois à retirer.
                  $line_id = $line_mois-$nombre_line;
                   // construire le nouveau line note.
                  
                   foreach($array_line_datas as $key => $val){

                       for($i=$nombre_line; $i< $line_mois+1; $i++){
                           $chaine ="0$i";
                          if(strpos($val,$chaine)==true){
                           // retirer les chaine dans le tableau qui contient les mois passés comptant...
                            $a[] = $val;
                            $array_accept = array_diff($array_line_datas,$a);// retirer les mois qui seront payé.
                            $array_true_data = $array_accept;
                     }
                  }
                }
               
                     // retirer le montant du total et constituer le nouveau line...
                       $check_data = explode(' ',$end_index_array);

                        $ligne_true = $check_data[1];
                       // montant definitf
                        $monts = explode('€',$ligne_true);
                        $montant = $monts[0]; // le montant à rétirer

                        $somme_true = $montant-$somme_paye;

                         // ajouter le dernier index
                        $array_true_data[] = 'Total '.$somme_true.'€';
                       // update de la ligne selectionné le mettre en payé modifier le line
              }
             }

            
               $array_line_true = implode('%',$array_true_data);
               if($array_line_true!=""){
                $line_new_note = $array_line_true;
                $id_suiv = $array_deduction[0];
                DB::table('pointbilans')->where('id', $id_suiv)->update([
                  'ligne_note' => $line_new_note,
                  ]);

              }
                  // requete ajax pour valider de la facture ambassadrice
               $date = date('Y-m-d');
                $heure = date('H:i');
               $dates = explode('-', $date);
               $datef = $dates[2].'/'.$dates[1].'/'.$dates[0];
                $css="pay";
                $button ="annulerf";
               // modifier les données dans table.
                DB::table('pointbilans')->whereIn('id', $array_choix)->update([
                'status' => $status,
                'content' => $content,
                 'css'=> $css,
                'button' => $button
               ]);

               // faire un update sur toutes les ligne des facture impayés en payé
               // envoi de mail à l'ambassadrice sur notification de paimement
               if($is_admin == 2 OR $is_admin==4) {
                   
                    Mail::send('email.facturenotif', ['somme' =>$somme, 'mois'=>$mois, 'annee'=>$annee,'name'=>$name], function($message) use($request){
                          $message->to($request->get('email_user'));
                          $message->from('no-reply@elyamaje.com');
                         $message->subject('Paiement De Facture Elyamaje!');
                         
                         
                    });
                    
                   // recupérer la facture dans le dossier a télécharger par zip
                    // vartiable
                    //$ids = $request->get('id_ambassadrice');
                   // $mois_ids = $this->getNummois($mois);
                    
                   //$this->pdf->invoicespdfs($ids,$mois_ids);
                    
                    
                }
                
               
             }
             
              $this->users->getUser();
          // recupérer les tableau
          $ambassadrice = $this->users->getdata();
          $partenaire = $this->users->getdatas();
          
          $list =[];
          $lists = [];
          foreach($ambassadrice as  $k =>$val){
              $v = explode(',',$val);
                $list[] = [
                      
                      $k=> $v[0]
                  ];
          }
          
          foreach($partenaire as  $ks =>$vals){
              $vs = explode(',',$vals);
                $lists[] = [
                      
                      $ks=> $vs[0]
                  ];
          }
        
             
             
               // recupérer le search name
              /*  $name = $request->get('search_name');
                // recupérer les varaible du type utilisateur
                $user_search = $request->get('recher_user');
                 // recupérer les ambassadrices souhaités !
                $user_ambassadrice = $request->get('ambassadrice_facture');

                // recupérer les factture payable.
                $fact_pay = $request->get('fact_pay');
                
                 $id = $user_ambassadrice;
                $data_name = $this->point->getfactureambassadrice($id);
                
                $name_data="";
                foreach($data_name as $values)
                {
                    $name_data = $values['name'];
                }
                
              
              if($name=="" && $user_search=="" && $user_ambassadrice=="" && $fact_pay =="")
              {
                  $users = $this->point->getAllfacture();
                  $option_default="choisir";
              
              }
              
             
              
              if($name!="" && $user_search=="" && $user_ambassadrice=="" && $fact_pay =="")
              {
                  
                  $users = $this->point->getsearch($name);
                  $option_default="choisir";
              }
              
              
              if($user_search!="" && $name=="" && $user_ambassadrice=="" && $fact_pay =="")
              {
                  $is_admin = $request->get('recher_user');
                  $users =$this->point->gettypeuser($is_admin);
                  $option_default ="chosir";
              }
              
              
              
              if($user_ambassadrice!="" && $user_search=="" && $name=="" && $fact_pay =="")
              {
                  $id_ambassadrice = $user_ambassadrice;
                  $users = $this->point->getnameambassadrice($id_ambassadrice);
                  $option_default=$name_data;
                  
              }


                 
              if($user_ambassadrice=="" && $user_search=="" && $name=="" && $fact_pay !="")
              {
                   
                   $fact_pay = $request->get('fact_pay');
                   $users = $this->point->getfacturepay();
                   $option_default=$name_data;
                  
              }

              */


               // traiter les retour de réponses 
               // recupérer les variables du filtre formualaire
                 $type = $request->get('type_user');// type ambasadrice ou partenaire
                 $mois = $request->get('mois_cour');
                 $annee = $request->get('annee');
                $fact_status  = $request->get('fact_pay');

                 $id_ambassadrice = $type;
                 $option_default="Type d'utilisateur choix"; // type user
                 $option_default2 ="facture payable"; // mois sélectionné

                 $option_default3 =""; // année sélectioné
                 $option_default4=""; // type facture séléctionné.

                 $user_ambassadrice = $request->get('ambassadrice_facture');


                 if($type ==2){
                    $option_default ="Ambassadrice";
                 }

                 if($type==4) {
                    $option_default ="Partenaire";
                 }

                 if($fact_status ==""){
                    $option_default2="facture payable";
                 }

                 if($fact_status =="fact_pay"){
                    $option_default2="Oui";
                 }

                 if($fact_status=="fact_im"){
                    $option_default2 ="non";
                 }

                 if($fact_status=="fact_solde"){
                    $option_default2 ="soldé";
                 }


                 $id = $user_ambassadrice;
                 $data_name = $this->point->getfactureambassadrice($id);
                 
                 $name_data="";
                 foreach($data_name as $values){
                     $name_data = $values['name'];
                 }
                 
                 if($user_ambassadrice!=""){
                   $id_ambassadrice = $user_ambassadrice;
                   $users = $this->point->getnameambassadrice($id_ambassadrice);
                   
                   $option_default=$name_data;
                 }

                 
                if($type=="" && $user_ambassadrice==""){
                  $users = $this->point->getAllfacture();
                
                }
                
                if($type!=""){

                      $id_ambassadrice = $type;

                        if($mois=="") {
                            $jour = date('d');// jour paiment.
                            $jours = (int)$jour;
                            $mois= date('m');// mois en cours 

                          }

                        else{

                             $mois = $request->get('mois_cour');
                        }

                        if($annee=="") {
                            $annee = date('Y');
                        }

                        else{
                            $annee = $request->get('annee');
                        }

                        // traiter les status des factures

                        if($fact_status==""){
                            // afficher par defaut les facture payable
                           $users = $this->point->getusermoispay($id_ambassadrice,$mois,$annee);
                        }

                        if($fact_status=="fact_pay"){
                              // appeler la fonction de pay
                             $users = $this->point->getusermoispay($id_ambassadrice,$mois,$annee);
                        }

                        elseif($fact_status=="fact_solde") {
                             // appeler la fonction facture payée.
                            $users =  $this->point->getfacturesolde($id_ambassadrice,$mois,$annee);
                        }

                        else{

                              // appeler faction non payé
                              $users = $this->point->getusermoisim($id_ambassadrice,$mois,$annee);
                              
                        }

                        

                }
              
              
              
          }

             $datas =[];
             $message ="";
             
              return view('ambassadrice.factures', ['users'=>$users, 'datas'=>$datas,'list'=>$list,'lists'=>$lists,'option_default'=>$option_default,'option_default2'=>$option_default2,'message'=>$message]);
          
          
          
      }
      
      
      
      public function invoicescards(Request $request)
      {
            $id = Auth()->user()->id;
            // recupérer la le nom du user..
            $user_connect = Auth()->user()->name;
          // recupérer les facture
          if(Auth()->user()->is_admin==1  OR Auth()->user()->is_admin==3){
              $int = $request->get('id_facturees');
              // recupérer les donnée
              $results = $this->point->getidpay($int);
              $some_v ="";

              foreach($results as $vac) {
                 $some_v = $vac['ligne_note'];
              }

              if($some_v==""){
                 $montant = $request->get('montants');

              }

              else{

                    $ligne_m = explode('%',$some_v);
                    $last_index = end($ligne_m);
                    $check_data = explode(' ',$last_index);
                    $add="x";
                    $ligne_true = $check_data[1];
                    // montant definitf
                    $monts = explode('€',$ligne_true);
                    $montant = $monts[0];
            
                }
                
                   // nature uusers
                   $is_admin = $request->get('is_admins');
                   // recupérer le montant  à passer
                   // recupérer l'id amabssadrice
                   $id_ambassadrice = $request->get('id_ambassadrices');

                   $data  = $this->user->getUserId($id_ambassadrice);
                   $status_societe = $data->account_societe;
                    // recupérer le type de compte
                   $array_societe = array('SASU','SARL','SAS');
                   $array_societe1 = array('EI',null);
           
                    if(in_array($status_societe,$array_societe)){
                    $tva = 20;
                      }else{
                      $tva = 0;
                    }
                  // recupérer le bon d'achat le code
                   //$data_cards = $this->gift->getIdcards($id_ambassadrice);
                   // $code_numbers = $data_cards[0]['code_number'];
                   // recupérer le nom du user 
                   $name = $request->get('name_users');
                  // recupérer l'email du recepient...
                  $email_user = $request->get('email_users');

                  $montants = $montant+$montant*$tva/100;
               
                  $somme = number_format($montants, 2, ',', '');
                   // $sommes = explode(',',$montant);
                  // insert dans base de données gift cards.
                  $code_number = $name.'-'.$this->str_generator();
                  // requete ajax pour valider de la facture ambassadrice
                  $date = date('Y-m-d');
                  $heure = date('H:i');
                  $dates = explode('-', $date);
                  $datef = $dates[2].'/'.$dates[1].'/'.$dates[0];
           
                 // insert dans base de données gift cards.
                 // reponse en fonction du user Ambassadrice/partenaire
                 //si c'est une ambassadrice
                 $debut="";
                 if($is_admin ==2) {
                   $status ="La somme de $somme €  a été ajouté par bon d'achat N°   le $datef";
                   $content ="Annuler le bon d'achat";
                   $debut ="A";
                }
                  // si c'est un partenaire....
                 if($is_admin ==4){
                 $status ="La somme de $somme €  a été ajouté par bon d'achat  N°  le $datef";
                 $content ="Annuler le bon d'achat";
                 $debut ="P";
                }  

                // la note
                  $note ="$user_connect a ajouté la somme de $somme à la cagnote";
                  // insert dans base de données gift cards.
                  $code_number = $debut.'-'.$this->str_generator();
                 // créer un gits card dans api woocomerce(carte cadeaux)
                  // verifier que l'id amabassadrice n'est pas dans la table
                  $id = $id_ambassadrice;
                  $data_giftcards = $this->gift->getIdcards($id);
                  $line_count  = count($data_giftcards);// compter le nombre de ligne
                
                  if($line_count==0){
                    $datas = [
                   "number" => $code_number,
                    "active" => "1",
                    "amount"=>$somme,
                    "note" =>$note,
                    "expiration_date" => null,
                    "pimwick_gift_card_parent" => null,
                    "recipient_email" => $email_user,
               
                    ];
               
                      // Mise dans l'api woocommerce
                      $urls = "https://www.elyamaje.com/wp-json/wc-pimwick/v1/pw-gift-cards";
                      // post 
                      $this->api->InsertPost($urls,$datas);
                      // insert dans bdd.
                     $this->gift->insert($code_number,$id_ambassadrice,$montant);
               
                        // faire un update sur le code gift cards
                        $id = $id_ambassadrice;
                         DB::table('users')->where('id','=',$id_ambassadrice)->update([
                        'code_giftcards' => $code_number,
                        ]);
               
                        $date = date('d-m-Y');
                       // envoi de mail au partenaire
                        Mail::send('email.emailgiftcards', ['somme' =>$somme,'date'=>$date,'code_number' => $code_number], function($message) use($request){
                        $message->to($request->get('email_users'));
                        $message->from('no-reply@elyamaje.com');
                         $message->subject('Attribution de bon Achat Elyamaje !');
                     });

                 
                }
              
              else{
                         // recupérer les données en fonction de l'id de l'mabassadrice..
                           $id = $id_ambassadrice;
                           $donnees = $this->gift->getIdcards($id);
                            // recupérer le code_number
                              $code = $donnees[0]['code_number'];
                              $somme_code = $donnees[0]['montant'];
                              $id_api = $donnees[0]['id_api'];

                               // recupérer le id_api de git card pour un update et le montant....
                            // recupérer id du code carte cadeau et faire un update.
                             $urss ="https://www.elyamaje.com/wp-json/wc-pimwick/v1/pw-gift-cards?number=$code";
                            $result_number = $this->api->getDataApiWoocommerce($urss);

                            dd($result_number);
                            
                             $codecards = $code;
                            // $infos_cards= $this->getcard->getCodecards($codecards);
                            // recupérer les infos.
                              $montant_api = $result_number[0]['balance'];
                            // faire des update dans l'api 
                             // Mise dans l'api woocommerce...
                              $uri = "https://www.elyamaje.com/wp-json/wc-pimwick/v1/pw-gift-cards/$id_api";

                              $data = [
                              'amount'=> $somme,
                            ];
                            
                            // mettre a jour dans l'api
                           // post 
                              $this->api->InsertPost($uri,$data);

                           // envoyer un email 
                             $date = date('d-m-Y');
                            // solde
                              $montant_apis = number_format($montant_api, 2, ',', '');// convertir le monant
                             $soldes = $montant + $montant_api;
                             $solde = number_format($soldes, 2, ',', '');
                             // envoi de mail au partenaire
                         
                         // envoi de mail au partenaire
                         Mail::send('email.emailgiftcards1', ['somme' =>$somme,'date'=>$date,'code' => $code,'montant_apis'=>$montant_apis,'solde'=>$solde], function($message) use($request){
                          $message->to($request->get('email_users'));
                          $message->from('no-reply@elyamaje.com');
                          $message->subject('Mise à jour de bon Achat Elyamaje !');
                          
                        });
                         
                        // requete ajax pour valider de la facture ambassadrice
                         $date = date('Y-m-d');
                        $heure = date('H:i');
                       $dates = explode('-', $date);
                       $datef = $dates[2].'/'.$dates[1].'/'.$dates[0];
                       $css="pay";
                       $button ="annulerf";
                       // modifier les données dans table
                          $ids = $this->point->getidsim($id_ambassadrice); // ids en non payé im .

                      // recupérer le dernier id 
                     // modifier 
                      $array_choix =[];
                      $array_deduction =[];
                       foreach($ids as $value){
                       if($value <= $int){
                         $array_choix[] = $value;
                       }

                       if($value > $int){
                       $array_deduction[] = $value;
                     }
                   }

                    DB::table('pointbilans')->whereIn('id', $array_choix)->update([
                   'status' => $status,
                   'content' => $content,
                   'css'=> $css,
                   'button' => $button
                   ]);
              

                        return view('superadmin.confirmpay');// gérer la sécrutié d'envoi contre ajax rafrichissement.
               }
           
              // requete ajax pour valider de la facture ambassadrice
                  $date = date('Y-m-d');
                  $heure = date('H:i');
                 $dates = explode('-', $date);
                 $datef = $dates[2].'/'.$dates[1].'/'.$dates[0];
                 $css="pay";
                 $button ="annulerf";
                 // modifier les données dans table

                 $ids = $this->point->getidsim($id_ambassadrice); // ids en non payé im .

                  // recupérer le dernier id 
                  // modifier 
                 $array_choix =[];
                 $array_deduction =[];
                 foreach($ids as $value){
                   if($value <= $int){
                      $array_choix[] = $value;
                   }

                   if($value > $int){
                     $array_deduction[] = $value;
                   }
                 }

                 
              
                    DB::table('pointbilans')->whereIn('id', $array_choix)->update([
                   'status' => $status,
                  'content' => $content,
                   'css'=> $css,
                   'button' => $button
                 ]);
              
           
                 // recupérer les ambassadrices et partenaire
        
                // recupérer la liste des ambassadrice et patenaire
          
                 $this->users->getUser();
                  // recupérer les tableau
                 $ambassadrice = $this->users->getdata();
                 $partenaire = $this->users->getdatas();
          
                $list =[];
                $lists = [];
             foreach($ambassadrice as  $k =>$val){
                $v = explode(',',$val);
              
                $list[] = [
                      
                      $k=> $v[0]
                  ];
              }
          
               foreach($partenaire as  $ks =>$vals){
                  $vs = explode(',',$vals);
                    $lists[] = [
                      
                      $ks=> $vs[0]
                  ];
              }
        
               
               
                // recupérer le search name.
                $name = $request->get('search_name');
                // recupérer les varaible du type utilisateur
                $user_search = $request->get('recher_user');
                
                // recupérer les ambassadrices souhaités !
                $user_ambassadrice = $request->get('ambassadrice_facture');
                
                 $id = $user_ambassadrice;
                $data_name = $this->point->getfactureambassadrice($id);
                
                $name_data="";
                foreach($data_name as $values){
                    $name_data = $values['name'];
                }
            
              if($name=="" && $user_search=="" && $user_ambassadrice==""){
                  $users = $this->point->getAllfacture();
                  $option_default="choisir";
              
              }
              
               if($name!="" && $user_search=="" && $user_ambassadrice==""){
                 $users = $this->point->getsearchamabassadrice($name);
                  $option_default ="choisir";
              }
              
              
              if($user_search!="" && $name=="" && $user_ambassadrice==""){
                  $is_admin = $request->get('recher_user');
                  $users =$this->point->gettypeuser($is_admin);
                  $option_default="choisir";
                  
              }
              
              
              if($user_ambassadrice!="" && $user_search=="" && $name!="") {
                  $id_ambassadrice = $user_ambassadrice;
                  $users = $this->point->getnameambassadrice($id_ambassadrice);
                  $option_default=$name_data;
                  
              }
              
          }
          
          
          $datas =[];
          $message="";
         return view('ambassadrice.factures', ['users'=>$users, 'datas'=>$datas, 'list'=>$list,'lists'=>$lists,'option_default'=>$option_default,'message'=>$message]);
              
     
          }
      
      
      
       public function invoicespays(Request $request)
       {
          $id = Auth()->user()->id;
          // recupérer les facture
          if(Auth()->user()->is_admin==1){
              
              // annulé le montant dans l'api au cas ou il est en bon d'achat
            $int = $request->get('id_factures');
              // recupérer l'id de l'ambassadrice ou partenaire
              $id_ambassadrice = $request->get('id_ambassadricess');
             $montant = $request->get('montantss');
               $somme = number_format($montant, 2, ',', '');
              // verifier que l'id amabassadrice n'est pas dans la table
                  $id = $id_ambassadrice;
                  $data_giftcards = $this->gift->getIdcards($id);
                 
                 $line_count  = count($data_giftcards);// compter le nombre de ligne
            // requete ajax pour valider de la facture ambassadrice
             $date = date('Y-m-d');
            $heure = date('H:i');
            $dates = explode('-', $date);
            $datef = $dates[2].'/'.$dates[1].'/'.$dates[0];
             $content ="payer par virement";
             $status ="facture provisoire";
             $css="im";
              $button ="paiment";
           // modifier les données dans table
           // modifier 
             DB::table('pointbilans')->where('id', $int)->update([
             'status' => $status,
             'content' => $content,
             'css'=> $css,
              'button' => $button
             ]);
              
              
               // recupérer les ambassadrices et partenaire
               
              // envoi de mail à l'ambassadrice(notification de paimement)
              
            // recupérer la liste des ambassadrice et patenaire
          $this->users->getUser();
          // recupérer les tableau
          $ambassadrice = $this->users->getdata();
          $partenaire = $this->users->getdatas();
          
          $list =[];
          $lists = [];
          foreach($ambassadrice as  $k =>$val){
              $v = explode(',',$val);
              
              $list[] = [
                      
                      $k=> $v[0]
                  ];
          }
          
          foreach($partenaire as  $ks =>$vals) {
              $vs = explode(',',$vals);
              
              $lists[] = [
                      
                      $ks=> $vs[0]
                  ];
          }
        
              // recupérer le search name
                $name = $request->get('search_name');
                // recupérer les varaible du type utilisateur
                $user_search = $request->get('recher_user');
                
                // recupérer les ambassadrices souhaités !
                $user_ambassadrice = $request->get('ambassadrice_facture');
                // defini le nom 
                $id = $user_ambassadrice;
                $data_name = $this->point->getfactureambassadrice($id);
                
                $name_data="";
                foreach($data_name as $values){
                    $name_data = $values['name'];
                }
            
              if($name=="" && $user_search=="" && $user_ambassadrice=="") {
                  $users = $this->point->getAllfacture();
                  $option_default="choisir";
              
              }
              
             if($name!="" && $user_search=="" && $user_ambassadrice==""){
                  
                  $users = $this->point->getsearchamabassadrice($name);
                  $option_default="choisir";
              }
              
              
              if($user_search!="" && $name=="" && $user_ambassadrice=="") {
                  $is_admin = $request->get('recher_user');
                  $users =$this->point->gettypeuser($is_admin);
                  $option_default="choisir";
                  
              }
              
              
              if($user_ambassadrice!="" && $user_search=="" && $name!=""){
                  $id_ambassadrice = $user_ambassadrice;
                  $users = $this->point->getnameambassadrice($id_ambassadrice);
                  $option_default=$name_data;
                  
              }
              
              
             }
          
          if(Auth()->user()->is_admin ==2 OR Auth()->user()->is_admin ==4) {
            $users =  $this->point->getAllpay($id);
            $list=[];
            $option_default="";
          }
          
          $datas =[];
         return view('ambassadrice.factures', ['users'=>$users, 'datas'=>$datas, 'list'=>$list,'option_default',$option_defalut]);
          
          
          
      }
      
      public function getvalidationmutiple(Request $request)
      {
          
          // recupérer les variables souhaités.
          $data_donnees = $request->get('check');
          
          // declarer des arrays pour recupérer les données
          $ids = [];// recupérer tous les ids souhaités
          
            
          $this->users->getUser();
          // recupérer les tableau
          $ambassadrice = $this->users->getdata();
          $partenaire = $this->users->getdatas();
          
          $list =[];
          $lists = [];
          foreach($ambassadrice as  $k =>$val)
          {
              $v = explode(',',$val);
              
              $list[] = [
                      
                      $k=> $v[0]
                  ];
          }
          
          foreach($partenaire as  $ks =>$vals)
          {
              $vs = explode(',',$vals);
              
              $lists[] = [
                      
                      $ks=> $vs[0]
                  ];
          }
        
         
          if(Auth()->user()->is_admin==1)
          {
             
            if($data_donnees!="") {
               
               // recupérer les variables souhaités.
               $data_donnees = $request->get('check');
               
               // declarer des arrays pour recupérer les données
               $ids = [];// recupérer tous les ids souhaités
               $data_email =[];// recupérer des array associative entre email et le mois.
               
               $data_ids_code = [];// recupérer pour flush la facture dans un dossier.
          
               foreach($data_donnees as $values) {
                   $data[] = explode(',' ,$values);
              
              }
             
          
                 // recupérer les clé souhaité
               for($i=0; $i<count($data); $i++) {
                 $ids[] = $data[$i][1];
                 $data_email[$data[$i][0]] = $data[$i][2];
                 $data_ids_code[$data[$i][3]] = $data[$i][4];
               }
           
                 // notifier un email au ambassadrice de paiment
                 // faire un update du status 
                $date = date('Y-m-d');
                  $heure = date('H:i');
                 $dates = explode('-', $date);
                 $datef = $dates[2].'/'.$dates[1].'/'.$dates[0];
              
                $css="pay";
                $button ="annulerf";
                $status ="payée le $datef  à  $heure ";
                $content ="payer par virement";
               // modifier les données dans table
               // modifier 
                DB::table('pointbilans')->whereIn('id', $ids)->update([
                'status' => $status,
                'content' => $content,
                 'css'=> $css,
                'button' => $button
               ]);
               
                // envoyer l'email au user
                     foreach($data_email as $key => $valus) {
                          
                          Mail::send('email.facturenotifs', [], function($message) use($key){
                          $message->to(trim($key));
                          $message->from('no-reply@elyamaje.com');
                          $message->subject('Paiment de votre facture chez elyamaje');
                
                          });
                   
                        }
             
             
                  $users = $this->point->getAllfacture();
                  $option_default="type utilisateur(choix)";
                  $option_default2 ="facture payable";
                  $message="";
          
          }
        
          else{
            
                  $users = $this->point->getAllfacture();
                  $option_default="type utilisateur";
                  $option_default2 ="facture payable";
                   $message="";
             }
        
            }
        
          
             return view('ambassadrice.factures', ['users'=>$users,'list'=>$list, 'lists'=>$lists,'option_default'=>$option_default,'option_default2'=>$option_default2,'message'=>$message]);
        
      }
      
      
      
      
      
      public function getfactureid($id)
      {
          // recupérer les facture
          if(Auth()->user()->is_admin==1)
          {
             
             $date_actuel = date('Y-m-d');
             
             $datet = explode('-',$date_actuel);
             
             // recupérer le mois.
             $mois = $datet[1];
             
              // delencher la génération de facture
              $this->bilan->insert($id);
              $users = $this->point->getfactureambassadrice($id);

          
              return view('ambassadrice.idfacture', ['users'=>$users]);
          }
       }
       
       
       public function getnotificationid($id_commande,$id)
       {
           
           if(Auth()->user()->is_admin ==2 OR Auth()->user()->is_admin==4)
           {
             $users  = $this->repo->getDataorder($id_commande);
             
            return view('ambassadrice.notificationid', ['users'=>$users]);
            
           }
           
       }
       
       
      public function destroy($id)
     {
          DB::table('notifications')->where('id_ambassadrice','=',$id)->delete();
          return true;
         
     }
     
     
      public function codespecial()
      {
          
          // recupérer la liste des ambassadrice et patenaire
          
          $this->users->getUser();
          // recupérer les tableau
          $ambassadrice = $this->users->getdata();
          $partenaire = $this->users->getdatas();
          
          $list =[];
          $lists = [];
          foreach($ambassadrice as  $k =>$val)
          {
              $v = explode(',',$val);
              
              $list[] = [
                      
                      $k=> $v[0]
                  ];
          }
          
          foreach($partenaire as  $ks =>$vals)
          {
              $vs = explode(',',$vals);
              
              $lists[] = [
                      
                      $ks=> $vs[0]
                  ];
          }
          
          
    
          return view('account.codespeciale', ['list'=>$list, 'lists'=>$lists]);
      }
      
      
      
      public function createcode(Request $request)
      {
          
          if(Auth()->user()->is_admin ==1 OR Auth()->user()->is_admin ==3){
               // verification du email
              $this->codespecial->getAllcode();
              // recupérer la liste des email existant
             $array_email =  $this->codespecial->getListemail();
           
              // recupérer la liste des codes promo
              $array_code = $this->codespecial->getListecode();
           
              // recupération des variale
              $id_ambassadrice = $request->get('ambassadrice');
              $id_partenaire  = $request->get('partenaire');
              $reduction  = $request->get('reduction');
              $commission = $request->get('commission');
              $nom_eleve = $request->get('nom');
               $email = $request->get('email');
              
              
              // comissioN
           
             // recupérer le nom de l'ambassadrice
            if($id_ambassadrice=="") {
               $a_id = $id_partenaire;
               $is_admin = 4;
               $libelle ="partenaire";
           }
           
           else{
               $a_id = $id_ambassadrice;
               $is_admin=2;
               $libelle="ambassadrice";
           }
           
            if($id_partenaire=="")
           {
               $a_id = $id_ambassadrice;
               $is_admin =2;
               $libelle ="ambassadrice";
           }
           
           else{
               
               $a_id = $id_partenaire;
               $id_admin = 4;
               $libelle ="partenaire";
           }
           
           
           
            if($id_ambassadrice =="" AND $id_partenaire==""){
              // envoi d'un message error
              
               return redirect()->route('account.codespeciale')->with('errors','Vous devez selectionnez une ambassadrice ou un partenaire obligatoirement !');
               
            }
           
             // accepte l'action
            // recupérer le nom de l'ambassadrice ou partenaire
              $data = $this->user->getUserId($a_id);
            // recupérer le nom de l'ambassadrice ou partenaire
             $nom_ambassadrice = $data->name;
            // creation code promo code promo
            $number = rand(100,20000);
            $nom_eleves = substr($nom_eleve,0,10);
            $code_promof = $nom_ambassadrice.'-'.$nom_eleves.'-'.$number.'-'.$reduction;
            $code_promo = strtolower($code_promof);
            // recupération des données
            // création d'un tableau pour insert
             if(!in_array($code_promof,$array_code)) {
                
             if(!in_array($email,$array_email)){
            
              $data =[
                     
                'id_user'=>$a_id,
                'is_admin'=>$is_admin,
                'name' => $nom_ambassadrice,
                'code_promos'=>$code_promo,
                'status'=>$libelle,
                'nom_eleve' => $nom_eleves,
                'email' => $email,
                'pourcentage'=>$reduction,
                'commission' => $commission
                
                ];
                
                
                 // insert dans la base de données
                 // insert les données dans la table
                   DB::table('codespeciales')->insert($data);
                  // creation dans l'api woocomerce du coupons
                  // insert dans Api wooocomerce
                  // insere POST dans Api woocomerce 
                    // créer les données datas 
                    $data_donnes =[];
                   // recupère la date actuel en cours
                   $date = date('Y-m-d');
                   // recupérer le mot en cours
                   $date1 = explode('-',$date);
                   $code_mois  = $date1[1];
                   $code_annee = $date1[0];
                   // recupérer le mois en francais
                  $mois = $this->bilan->code_mois($code_mois);
                   $description = " Code promo  élève $libelle $nom_ambassadrice $mois";            
                    $currents = Carbon::now();
                    $current = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$currents)->format('Y-m-d\TH:i:s',$currents);
                                                 
                 
                       $data_donnes  = [
                       'code' => $code_promo,
                        'amount' => $commission,
                        'date_created' => $current,
                        'date_created_gmt'=> $current,
                        'date_modified' => $current,
                        'date_modified_gmt' => $current,
                        'description'=>$description,
                        'discount_type' => 'percent',
                        'usage_limit' => '1',
                        'exclude_sale_items'=> true,
                        'individual_use' => true,
                
                     ];
              
                         // insert des données en post dans Api woocomerce Post
                    $urls="https://www.elyamaje.com/wp-json/wc/v3/coupons";   
                    $this->api->InsertPost($urls, $data_donnes);
                    
                    
                    // envoi de Mail à l'elève
                     // send email
                       Mail::send('ambassadrice.emails2', ['code_promo' => $code_promo, 'email' =>$email, 'libelle'=>$libelle, 'nom_eleve'=>$nom_eleve,'nom_ambassadrice'=>$nom_ambassadrice], function($message) use($request){
                        $message->to($request->get('email'));
                         $message->from('no-reply@connect.elyamaje.com');
                        $message->subject('Confirmation de création de code promo !');
                    });
               
               
                return redirect()->route('account.codespeciale')->with('succes','Vous avez bien crée le code élève pour '.$nom_ambassadrice.'!');
           }
           
           else{
               
               
               return redirect()->route('account.codespeciale')->with('errors','le Mail à eté deja utilisé pour un code élève  !');
           }
           
          }
          
          }
          
      }
      
      
      public function viewcode()
      {
          if(Auth()->user()->is_admin == 1 OR Auth()->user()->is_admin == 3)
          {
              $users = $this->codespecial->getAllcodes();
          
             return view('account.codeeleves',['users'=>$users]);
          
          }
      }
     
     
     public function editcodespecifique(Request $request,$id)
     {
         // update sur les ligne des codes spécifique
         $resultat = $this->codespecial->getIdcodepromo($id);
         
         return view('account.editcodespecifique',['resultat'=>$resultat]);
     }
     
     
     public function posteditcode(Request $request,$id)
     {
         if(Auth()->user()->is_admin ==1 OR Auth()->is_admin ==3)
         {
           // traiter des données
            $code = $request->get('code_specifique');
            // recupérer le variable
            $commission = $request->get('commission');
            $reduction = $request->get('reduction');
             $email = $request->get('email');
             $nom_eleve = $request->get('nom');
         // verifier si le code à été deja utilisé pour une commande
          $this->repo->getDataIdcodeorders();
             // recupérer tous les code promo utilisés dans une commande deja 
             $array_data = $this->repo->donnees();
               if(in_array($code,$array_data)){
                    // effectuer les action
                    // recupérer les données du code promo 
                    $data = $this->repo->getdatacodespecifique($code);
                     // calcule de la nouvelle somme
                     $somme="";
                     foreach($data as $k => $values) {
                         $somme = ($values['total_ht']*$commission)/100;
                      }
                 
                      // faire un update sur les table
                       $this->repo->updatecodespecifique($code,$somme,$commission);
                       $this->codespecial->updatecodespecifique($code,$commission,$reduction,$nom_eleve,$email);
                 
                }  
             
              else{
                 
                   // effectuer les action
                    $this->codespecial->updatecodespecifique($code,$commission,$reduction,$nom_eleve,$email);
             }
             
             
             // rediriger vers la liste des codes 
             
     }
     
     }
     
     public function getpaiementpartenaire(Request $request)
     {
         // paimement et notification au partenaire qui ont plus de 200 euro dans leur cagnote.
         if(Auth()->user()->is_admin==1) {
            if($request->from_cron){
                $request->from_cron == "false" ? $from_cron = false : $from_cron = true;
              } else {
                $from_cron = true;
              }
    
                DB::transaction(function () use ($from_cron) {
                  $response = $this->point->alertpaypartenaire();
                  $data = ['name' => 'notification_paiement_woocommerce', 'origin' => 'connect', 'error' => is_bool($response) ? 0 : 1,
                  'message' => is_bool($response) ? null : $response, 'code' => null, 'from_cron' => $from_cron == false ? 0 : 1];
                  echo $this->api->insertCronRequest($data);
               });
         }
     }


      public function orderdistributeur(Request $request)
      {
          $this->distributeur->getorderiddistributeur();
          $orders = $this->distributeur->getOrders();// recupérer la commande.

          $id_order = $request->get('order-id');

          
          $status_order = $request->get('status-order');
          
          $message="";
          $css="noaffiche";
          $messages ="";
          
          if($status_order!=""){

             // mise a jours des produits dolibar
               $token ="$2y$10wr3TnLUiPIyY5etJDv8vzBy9mQDdfI75OFVHCKEzKQ.rO";
               if($status_order==$token){
                 // faire l'action ici
                 $this->transfert->getordersdol();
                 $css="yesaffiche";
                 $message="L'import de commande effectuée";
                 $messages="";

                 return view('account.confirmportorder');
                 
                 //return view('distributeur.orders',['orders'=>$orders,'message'=>$message,'css'=>$css,'messages'=>$messages]);
                  
               }

               $message ="";
               $css="noaffiche";
               $messages="";

          }
          if($id_order!=""){
            
              // traiter le transfert de la commande.
              // recupérer l'utilisateur et les commande associé.
              $this->distributeur->getorderiddistributeur();
              $info_user = $this->distributeur->getSocidorder();

              // recupérer tous les infos et le customer _id dans woommerce.
                $data =  DB::table('tiers_woocommerce')->select('name','email','customer_id')->get();
                $name_list = json_encode($data);
                $name_lists = json_decode($data,true);
                $result_data = [];
                foreach($name_lists as $key => $val){
                $result_data[$val['email']] = $key;
                $result_id_custom[$val['customer_id']] = $val['email'];
              }
            

               // dd($info_user);
              $ch_info_user = array_search($id_order,$info_user);
              $socid_info = explode(',',$ch_info_user);
              $socid_true = $socid_info[0];
    
              $user_info = $this->distributeur->getinfodsitributeur($socid_true); // recupérer les info de l'utilisateur
               $customer = $this->apigift->getdescid();
               
               $last_id = $customer[0]['id'];
               $customer_id = $last_id +1;// important 
              // recupérer le dernier id customers de wc
              // verfion si l'utilisateur n'a pas affecté des commmande order wc
              // Role distributeur_4
              $data_tiers =[];// les infos du du customers à affecté dans l'api
              
              $current = Carbon::now();
              // ajouter un intervale plus un jour de 10jours.
              $now = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current)->format('Y-m-d\TH:i:s',$current);
              $customer_role ="dsitributeur_4";
              
              if($user_info['customer_id_wc']=="not_attribute"){
                  // créer l'utilisateur dans l'api cusotmers
                   $mm =  $user_info['email'];
                  $fk_customer_id =  array_search($mm,$result_id_custom);
                  if($fk_customer_id == false){
                    $id_customer = $customer_id;

                    $data_tiers =[
                      'date_created'=>$now,
                      'date_created_gmt'=>$now,
                      'date_modified_gmt'=>$now,
                      'email'=>$user_info['email'],
                      'first_name'=> $user_info['nom'],
                      'last_name'=> $user_info['prenom'],
                      'role' => $customer_role,
                      'username'=>'',
                      'billing'=>[
                        'first_name' => $user_info['nom'],
                        'last_name' =>  $user_info['nom'],
                        'company' => $user_info['nom'],
                        'address_1' => $user_info['adresse'],
                        'address_2' => '',
                        'city' => '',
                        'state' => '',
                        'postcode' => $user_info['code_postal'],
                        'country' => '',
                        'email' => $user_info['email'],
                        'phone' => $user_info['phone']
                      ],
    
                       'shipping'=>[
                        'first_name' => $user_info['nom'],
                        'last_name' =>  $user_info['nom'],
                        'company' => $user_info['nom'],
                        'address_1' => $user_info['adresse'],
                        'address_2' => '',
                        'city' => $user_info['city'],
                        'state' => '',
                        'postcode' => $user_info['code_postal'],
                        'country'=>''
                        ]
                      
                      ];
    
                     }else{
                      $id_customer = $fk_customer_id;
                  }
                  // recupérer le customer id si il existe pas .
              
                   }else{
                       // attribuue la commande à 'utilisateur à partir de son customer_id_wc top.(important !)
                       $id_customer = $user_info['customer_id_wc'];
                       $data_tiers =[];
                  }
                   
                    // recupérer les correspondance barcode id product et le libélle dans notre syteme
                    $order_product =[];
                    //$list_product_info = $this->distributeur->getproductorder();// les infos du product via woocomerce// important bar code id_product
                    $user_order = $this->distributeur->getdetailsorder($id_order);// le details de la commande arrivante.
                    $recap_total_order  =  $this->distributeur->getcommandeid($id_order);// total de la comande.
                    $total_tax = strval($recap_total_order['total_ttc']*20/100);// 20%;

                    // pour les product barcode 
                    //$list_product_info1 = $this->distributeur->getProductbaroce();// produit avec code bar
                 
                    $datas_facture = DB::connection('mysql3')->select("SELECT barcode,product_woocommerce_id,parent_id, name as libelle FROM prepa_products");
                    $datas = json_encode($datas_facture);
                     $datas = json_decode($datas,true);

                     $result_data= [];// result_data.

                  foreach($datas as $values){
                    $chaine_ext = $values['product_woocommerce_id'].','.$values['libelle'].','.$values['parent_id'].','.$values['barcode'];
                     $result_data[$chaine_ext] = $values['barcode'];
                  }

                
                 $product_bar_exist =[];
                 $info_product_bar =[];// crée des meta avec des barcode..
                 $barcode='';
                
                  
                 foreach($user_order as $valu){
                        if($valu['barcode']!=""){
                        $key_search =  array_search($valu['barcode'],$result_data);
                        $indicator = explode(',',$key_search);
                        if($key_search!=false){
                          $meta[] = [
                            'key'=>'barcode',
                            'value'=>$valu['barcode']
                          ];

                          if($indicator[2]==0){
                              $id_parent = $indicator[0];
                              $id_variation = 0;
                          }else{
                               $id_parent = $indicator[2];
                                $id_variation = $indicator[0];
                          }
                          $product_bar_exist[] = [
                            'name'=>$indicator[1],
                            'product_id'=>$id_parent,
                            'variation_id' => $id_variation,
                             'quantity'=> $valu['quantite'],
                              'meta_data' => $meta,
                              //'price'=>$valu['subprice']
                             ];
                        }
                         
                     }
                 }
                     
                 $id_customer=13770;
                    
                  $order_product = [
                     'status' => 'order-new-distrib',
                     'currency'=> "EUR",
                     'date_created'=> $now,
                     'date_created_gmt'=> $now,
                     'date_modified'=> $now,
                     'date_modified_gmt'=> $now,
                     'cart_tax'=> $total_tax,
                     'total'=> $recap_total_order['total_ttc'],
                     'total_tax'=>$total_tax,
                     'prices_include_tax' => true,
                     
                     'customer_ip_address'=> '',
                     "customer_user_agent"=>'',
                     "customer_note" => '',
                     'billing'=>[
                      'first_name' => $user_info['nom'],
                      'last_name' =>  '',
                      'company' => $user_info['nom'],
                      'address_1' => $user_info['adresse'],
                      'address_2' => '',
                      'city' => '',
                      'state' => '',
                      'postcode' => $user_info['code_postal'],
                      'country' => '',
                      'email' => $user_info['email'],
                      'phone' => $user_info['phone']
                    ],
  
                     'shipping'=>[
                      'first_name' => $user_info['nom'],
                      'last_name' =>  '',
                      'company' => $user_info['nom'],
                      'address_1' => $user_info['adresse'],
                      'address_2' => '',
                      'city' => '',
                      'state' => '',
                      'postcode' => $user_info['code_postal'],
                      'country'=>''
                     ],
                     'line_items'=>$product_bar_exist,
                     
                   ];
                    

                   if($recap_total_order['status']!="untreated"){
                          $data_tiers =[];
                           $order_product =[];
                           $messages="cette commande à été deja envoyé, action réfusée !";
                           $css="yesaffic";
                           $message="";
                           $css="noaffiche";

                           return view('distributeur.orders',['orders'=>$orders,'message'=>$message,'css'=>$css,'messages'=>$messages]);
                    }

                  
                    //$data = json_encode($order_product);

                   // dd($data);
                      // flush dans api avec un post create customers distributeur...
                      // faire un update sur la table distributeur mettre à jour son customer_wc_id.
                        //if(count($data_tiers)!=0){
                        //   $url="https://www.staging.elyamaje.com/wp-json/wc/v3/customers";
                        //      $this->api->InsertPost($url,$data_tiers);
                             // envoi de Mail au distributeur pour reinitialiser son mot de pass sur la boutique
                        //   }
                        
                
                          $urls="https://www.elyamaje.com/wp-json/wc/v3/orders";
                          $this->api->InsertPosts($urls,$order_product);
 
                       // actualiser le customer_id dans la table.
                        DB::table('distributeurs')->where('socid', $socid_true)->update([
                        'customer_id_wc' => $id_customer
                        ]);

                      // infos utilisateurs !
                      $users = Auth()->user()->is_admin;
                      $name = Auth()->user()->name;
                     
                      if($users ==1){
                        $pseudo ="par SuperAdmin";
                      }
              
                      if($users ==3){
                        $pseudo ="par Utilisateur Elyamaje";
                      }

                         $date = date('d/m/Y');
                         $user = "commande bien transférée vers wc $pseudo $name le $date";
                        //Modifier les informations de la commande deja traité.
                         $status ="treated";
                         DB::table('order_distributeur_status')->where('order_id', $id_order)->update([
                        'status'=>$status,
                        'user' => $user,
  
                      ]);
                   

                        $message="la commande est bien transféré vers woocomerce";
                         $css ="yesaffiche";

                         //return view('account.confirmtransfert');
                   
                       // traiter la commande ici construire le tableau de la commande 
                     return view('distributeur.orders',['orders'=>$orders,'message'=>$message,'css'=>$css]);

                 }

                // traiter la commande ici construire le tableau de la commande 
              return view('distributeur.orders',['orders'=>$orders,'message'=>$message,'css'=>$css,'messages'=>$messages]);

      }

      public function orderiddistributeur(Request $request,$id)
      {
          // recupérer des details de vente 
          // recupérer de l'utilisateur à qui appartient cette commande.
          $this->distributeur->getorderiddistributeur();
          $info_user = $this->distributeur->getSocidorder();
           $ch_info_user = array_search($id,$info_user);
           $socid_info = explode(',',$ch_info_user);
           $socid_true = $socid_info[0];
 
          $user_info = $this->distributeur->getinfodsitributeur($socid_true); // recupérer les info de l'utilisateur
          $user_order = $this->distributeur->getdetailsorder($id);// recupérer les commande avec id.
          // recupérer le user et la commande lié à ce dernier.
          // recupérer la variable post au click de transfert
         

          return view('distributeur.ordersiddistributeur',['user_info'=>$user_info,'user_order'=>$user_order,'id'=>$id]);
      }
     
      public function getNummois($moi)
       {
       
         if($moi=="Janvier")
         {
             $mo = 1;
         }
         
         if($moi=="Fevrier")
         {
             $mo=2;
         }
         
         if($moi=="Mars")
         {
             $mo =3;
         }
         
         if($moi=="Avril")
         {
             $mo=4;
         }
         
         if($moi=="Mai")
         {
             $mo =5;
         }
         
         if($moi=="Juin")
         {
             $mo=6;
         }
         
         if($moi=="Juillet")
         {
             $mo=7;
         }
         
         if($moi=="Août")
         {
             $mo=8;
         }
         
         
         if($moi=="Septembre")
         {
             $mo=9;
         }
         
         if($moi=="Octobre")
         {
             $mo=10;
         }
         
         if($moi=="Novembre")
         {
             $mo=11;
         }
         
         if($moi=="Decembre")
         {
             $mo=12;
         }
         
         
         return $mo;
     }


     // excuter des taches crons .
     public function datactioncron4($token,Request $request)
     {
          if($token=="67934854968e6ee06568847ead22132f608bf4ec1997265491df0efb")
          {
            DB::transaction(function () {
                $response = $this->point->alertpaypartenaire();
                $data = ['name' => 'notification_paiement_woocommerce', 'origin' => 'connect', 'error' => is_bool($response) ? 0 : 1,
                'message' => is_bool($response) ? null : $response, 'code' => null, 'from_cron' => 1];
                $this->api->insertCronRequest($data,false);
            });
        }
   }
  }

    