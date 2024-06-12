<?php

namespace App\Http\Controllers;

use App\Repository\Ambassadrice\AmbassadricecustomerRepository;
use App\Repository\Ambassadrice\Ordercustomer\OrderambassadricecustomsRepository;
use App\Repository\Ambassadrice\HistoriquePanierLiveRepository;
use  App\Repository\Users\UserRepository;
use App\Repository\Pointbilan\PointbilanRepository;
use App\Http\Service\FilePdf\CreateCsv;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Carbon\Carbon;
use Illuminate\Support\Str;


class UserAmbassadriceController
{
    
    private $amba;
    
    private $customs;
    public function __construct(AmbassadricecustomerRepository $amba,
    OrderambassadricecustomsRepository $orders,
    AmbassadricecustomerRepository $customs,
    HistoriquePanierLiveRepository $historique,
    UserRepository $users,
    PointbilanRepository $point,
    CreateCsv $csv)
    {
        
        $this->amba = $amba;
        $this->orders = $orders;
        $this->customs = $customs;
        $this->historique = $historique;
        $this->users =$users;
        $this->point =$point;
        $this->csv = $csv;
    }
   
   
   
   
   public function views($id)
   {
      if(Auth::check()){
           if(Auth::user()->is_admin==1){
              $id_ambassadrice = $id;
              $user =  $this->amba->getAmbassadricedata($id_ambassadrice);
              arsort($user);
              $array_name =[];
             $array_somme =[];
             foreach($user as $key => $values) {
                 $array_name[] = $values['name'];
                
             }
             
             
              $array_names =array_unique($array_name);
              $name = implode('',$array_names);
              $data = $this->orders->getcountorderss($id);
              //nombre commission en cours
               $ventes = count($data);
              //gaim commission en cours
               $gain = array_sum($data);
               $gains = $gain;
              // ventes réalisés total
              $donnees = $this->orders->getCountAll($id);
              $dones = count($donnees);
              // nombre de code promo crée
              $nombre = $this->customs->getCustomerId($id);
              $name_list = json_encode($nombre);
              $name_list = json_decode($nombre,true);
              
              $nombres = count($name_list);
              $total = count($user);
              
              
              return view('account.userambassadrice',['id'=>$id, 'name'=>$name, 'ventes'=>$ventes,'gains'=>$gains, 'dones'=>$dones,'nombres'=> $nombres,'total'=> $total, 'user'=>$user ]);
       
            }
                 
          }
   }

     
   public function  statsdata(Request $request)
   {
        // recupérer la liste des ambassadrice
         $id= $request->get('ambassadrice');
         $annee = $request->get('annee');

         if($annee!=""){
            $this->historique->gethistoriquevente($annee);
         }

        $result_datas = $this->historique->gethistorique();
        $result_names = $this->historique->getDataid();
        // Extraire les valeurs du tableau associatif
         $values = array_values($result_names);
        // Trier les valeurs en ordre alphabétique croissant
         sort($values);
         $result_name =[];

         foreach($values as $key =>$val){
            
            $result_name[$key] = $val;
         }
        
      // recupérer les données 
        // recuper les infos des ambassadrice.....
         $this->users->getUser();
         $users = $this->users->getUsrs();
         $data = $this->point->getAllfactures();
         $lis = json_encode($data);
         $list = json_decode($data,true);
         $result_data =[];
         foreach($list as $val){
            if($val['somme_live']!=0 OR $val['somme_eleve']!=0){
               if($val['is_admin']==2){
                $total = $val['somme_live']+$val['somme_eleve'];
                $pourcentageeleve = $val['somme_eleve']*100/$total;
                $pourcentagelive = $val['somme_live']*100/$total;
                $montant_live = number_format($val['somme_live'],2,',',' ');
                $montant_eleve = number_format($val['somme_eleve'],2,',',' ');
                $pr_eleve = number_format($pourcentageeleve, 2, ',', ' ');
                $pr_live = number_format($pourcentagelive, 2, ',',' ');
                $donnees = " Gain live(%) : $pr_live% ; Gain élève(%) : $pr_eleve%";
                // recupérer le nom de l'ambassadrice.
                $chaine_name = array_search($val['id_ambassadrice'],$users);
                if($chaine_name!=false){
                    $name = explode(',',$chaine_name);
                    $result_data[] =[
                    'periode'=> $val['mois'].'  '.$val['annee'],
                    'name' =>$name[1],
                    'commission_live'=> $montant_live,
                    'commission_eleve'=>$montant_eleve,
                    'pourcentage'=> $donnees
            
                ];
            }

            dd($result_data);
            
           }

          }
          }
         return view('utilisateurs.statsdatauser',['result_data'=>$result_data,'result_datas'=>$result_datas,'result_name'=>$result_name]);
    }


    public function suivicode()
    {

        // definir un tableau à renvoyer

        $result_datas = $this->historique->gethistorique();
        $result_name = $this->historique->getDataid();

         $array_donnees = [];
         // recupérer les infos des ambassadirece et partenaire
          $this->users->getUser();
          $data = $this->users->getListusers();
          // recupérer le nom de code élève créer en fonction de l'id de l'ambassadrcie
           $data1 = $this->customs->getdatacodepromo();
           // recupérer les orders et le nombre en fonctiond es id_ambassadrice
           $data2 = $this->orders->getcountcodeleve();
           $list =[];// recupérer  les infos et le nombre de code eleve créer dans un premier temps
           $list1 =[];// recupérer le nombre de code élève utilisé pour une commande
           $list2 = [];
           $list3 = []; // recupérer les ambassadrice et partenaire dont les codes élève n'ont jamais été utilisés
          // créer un tableau pour recupérer les valuers 
         foreach($data1 as $key => $values){
              foreach($data as $ks =>$vale){
                   if($ks == $values['id_ambassadrice']){
                       $list[$ks] = $vale.','.$values['codeleve_count'];

                          }
                }

          }

       // recupérer les partenaire et ambassadrice dont les codes élève ont éte utilisés
       $list_id =[];
       foreach($data2 as $ky => $valus) {
            foreach($list as $kv =>$vales){

                 if($kv == $valus['id_ambassadrice']){
                     $list1[$kv] = $vales.','.$valus['ordercode_count'];
                  }

               }

               // fournir le tableau
                $list_id[] = $valus['id_ambassadrice'];

        }

        // trier les partenaire et ambassadrice qui n'ont pas de commande orders!

        foreach($data1 as $kyt => $vals){
             foreach($list as $kb =>$vales){
                    if(!in_array($kb,$list_id)) {
                            $num =0;
                            $list3[$kb] = $vales.','.$num;
                     }
              }

          }

           // recupérer des tableau à afficher dans la vue
           // recuperer les données qui ont des orders utilisés un  code élève qui sont null.
            $array_list1 =[];
           foreach($list3 as  $valm){
               $array_list1[] =  explode(',',$valm);

           }

            // recupérer les donnéees ambassadrice partenaire ayant créer des codes promo deja utilisés
            $array_list2 =[];
            foreach($list1 as $valk){
                $array_list2[] = explode(',',$valk);
            }

            return view('utilisateurs.suivicode',['array_list2'=>$array_list2, 'array_list1'=>$array_list1,'result_name'=>$result_name,'result_datas'=>$result_datas]);

   }



   public function suivicodeambas()
    {

             // recupérer les données 
            // recuper les infos des ambassadrice.....
            $result_datas = $this->historique->gethistorique();
            $result_names = $this->historique->getDataid();
            // Extraire les valeurs du tableau associatif
             $values = array_values($result_names);
            // Trier les valeurs en ordre alphabétique croissant
             sort($values);
             $result_name =[];
    
             foreach($values as $key =>$val){
                
                $result_name[$key] = $val;
             }
            $this->users->getUser();
            $users = $this->users->getUsrs();
        
            $data = $this->point->getAllfactures();

            
            $lis = json_encode($data);
            $list = json_decode($data,true);
            
            $result_data =[];
            foreach($list as $val){
               if($val['somme_live']!=0){
                  if($val['is_admin']==2){
                
                  // recupérer le nom de l'ambassadrice.
                   $chaine_name = array_search($val['id_ambassadrice'],$users);
                   $name = explode(',',$chaine_name);
                   $result[] =[
                       'periode'=> $val['mois'].'  '.$val['annee'],
                       'name' =>'ambassadrice',
                       'nombre'=> $val['code_create'],
                       'use'=>$val['nbrseleve']
               
                   ];
                  }
               }
               
            }
            

            return view('utilisateurs.suivicodeamb',['result'=>$result,'result_name'=>$result_name,'result_datas'=>$result_datas]);

      

    }
    
    
    public function elevemabapostcsv(Request $request)
    {
        
        $id = $request->get('ambassadrice');
        $annee = $request->get('annee');

        if($id!="" && $annee!=""){
            $data = $this->customs->getcodeleve($id,$annee);
            // tirer le csv
            $this->csv->createcsvstatseleve($data); // tirer le csv.
        }
        
        
    }

    public function suivicodepart()
    {
           // recupérer les données 
            // recuper les infos des ambassadrice.....
           // $result_datas = $this->historique->gethistorique();
           // $result_name = $this->historique->getDataid();
            
            $this->users->getUser();
            $users = $this->users->getUsrs();// ambassadrice
            $partenaire  = $this->users->getParts();

            // tableau d'affichage des partenaire
            $result_names =[];

            foreach($partenaire as $key => $vals){
                  $chaine_key = explode(',',$key);

                  $result_names[$chaine_key[0]] = $chaine_key[1];
            }

            $values = array_values($result_names);
            // Trier les valeurs en ordre alphabétique croissant
             sort($values);

            $result_name =[];
    
             foreach($values as $key =>$val){
                
                $result_name[$key] = $val;
             }

            $data = $this->point->getAllfactures();
        
            $lis = json_encode($data);
            $list = json_decode($data,true);
    
            $result_data =[];
          
            $result =[];
            foreach($list as $val){
               
                  if($val['is_admin']==4 && $val['somme_eleve']!=0){
                  // recupérer le nom de l'ambassadrice.
                   $chaine_name = array_search($val['id_ambassadrice'],$partenaire);
                   if($chaine_name!=false){
                   $name = explode(',',$chaine_name);
                   $result[] =[
                    'periode'=> $val['mois'].'  '.$val['annee'],
                    'name' =>$name[1],
                    'nombre'=> $val['code_create'],
                    'use'=>$val['nbrseleve']
            
                   ];
                  }
                }
            }

            

            return view('utilisateurs.suivicodepart',['result'=>$result,'result_name'=>$result_name]);
         }


 }
