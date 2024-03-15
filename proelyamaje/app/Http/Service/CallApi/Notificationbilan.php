<?php

namespace App\Http\Service\CallApi;

use App\Http\Service\CallApi\Apicall;
use Illuminate\Support\Facades\Http;
use App\Http\Service\Mailer\ServiceMailer;
use Automattique\WooCommerce\HttpClient\HttpClientException;
use Illuminate\Support\Facades\DB;
use Mail;

use DateTime;
use DateTimeZone;

class Notificationbilan
{
    
     
      
    
       public function __construct(ServiceMailer $mailer)
       {
          $this->mailer =$mailer;
       }



     public function getBilan()
     {
         // declencher chaque mois le 05
        // recupérer les statistique mensuel à envoyer Ambassadrice et partenaire 
        // recupérer 

         // recupérer les users.
         $dat =  DB::table('users')->select('id','email','name','is_admin')->get();
         $name_c = json_encode($dat);
         $name_c = json_decode($dat,true);
         $result_users =[];
         foreach($name_c as $vali){
            
          $chainex = $vali['email'].','.$vali['is_admin'].','.$vali['name'];
            $result_users[$chainex] = $vali['id'];
         }


         $data =  DB::table('ambassadricecustomers')->select('nom','prenom','date','code_promo','id_ambassadrice')->get();
         $name_list = json_encode($data);
         $name_list = json_decode($data,true);
         // recupérer les données user 
          $result= [];
          $date = date('m');
          $annee = date('Y');
          $int_m = (int)$date;
           $mois_recap ="";
          if($int_m ==1){
             $mois_recap = 12;
          }

          $mois_recap = $int_m-1;
          if($mois_recap <10){
             $mm ="0$mois_recap";
          }else{
             $mm= $mois_recap;
          }
          // recupérer la période
          $periode = "$mm/$annee";
          
          foreach($name_list as $valu){
             $chaine_date = explode('-',$valu['date']);
             $ms = (int)$chaine_date[1];
             if($ms==$mois_recap && $annee == $chaine_date[0]){
                  $results[] =[
                    'nom'=>$valu['nom'].' '.$valu['prenom'],
                    'id_ambassadrice'=>$valu['id_ambassadrice'],
                    'code_promo' => $valu['code_promo'],
                    'total' => $valu['id_ambassadrice'],
                  ];

                }
          }
           // compter le nombre code élève crée
           $y = $results;
           $result = array_reduce($y,function($carry,$item){
            if(!isset($carry[$item['id_ambassadrice']])){ 
              $carry[$item['id_ambassadrice']] = ['id_ambassadrice'=>$item['id_ambassadrice'],'total'=>$item['total']]; 
          } else { 
              $carry[$item['id_ambassadrice']]['total'] += $item['total']; 
          } 
            return $carry; 
        });

         // recupérer le nombre de code crée mensuelement 
         $result_data =[];
         foreach($result as $valc){
            
           $nombre_code_create = $valc['total']/$valc['id_ambassadrice'];
           $result_data[$nombre_code_create] = $valc['id_ambassadrice'];
         }
        
          // compte le nombre code utilisés
            // compter le nombre de id_live 
            $code_live =11;
            $sum_ventes = DB::table('ordersambassadricecustoms')
            ->select('id_ambassadrice' ,DB::raw('COUNT(id_ambassadrice) as nombre_vente'))
            ->where('code_mois','=',$mois_recap)
            ->where('annee','=',$annee)
            ->where('code_live','=',$code_live)
            ->groupBy('id_ambassadrice')
            ->get();

           // recupérer le montant le plus élévé
            $lis = json_encode($sum_ventes); // tranformer les données en json
            $lis = json_decode($sum_ventes,true); // tranformer le retour json en array tableau.

            // créer un tableau pour recupérer les deux premier infos nombre de code crée et utilisé
            $result_data1 =[];
            foreach($lis as $value){
            
              $result_data1[] = [
                'id_ambassadrice' => $value['id_ambassadrice'],
                 'nombre_code_create' => array_search($value['id_ambassadrice'],$result_data),
                 'nombre_code_utilise' => $value['nombre_vente']
              ];

            }
             
            // recupérer le client qui as fait de plus de commmande élève le mois pour les code élèvz
              $code_live =11;
             $somme_desc = DB::table('ordersambassadricecustoms') ->select('id','customer','code_promo','username','email','somme','id_ambassadrice','telephone')->where('code_mois','=',$mois_recap)->where('annee','=',$annee)
             ->where('code_live','=',$code_live)
             ->orderBy('somme','desc')
             ->get();

              // recupérer le montant le plus élévé
            $lisc = json_encode($somme_desc); // tranformer les données en json
            $lisc = json_decode($somme_desc,true); // tranformer le retour json en array tableau.
             
           // construire un array
            foreach($lisc as $va){
                  // créer en amont une chaine qui va recupérer les données.
                $chaine = $va['customer'].','.$va['username'].' ,'.$va['code_promo'].','.$va['email'].','.$va['somme'].','.$va['telephone'];
                $data_result[$chaine] = $va['id_ambassadrice'].','.$va['somme'];
            }

             $array_data =[];
            foreach($lisc as $val){
                $array_data[$val['id_ambassadrice']][] = $val['somme'];

             }
           
              // creer un tableau de valeur entre id_ambassadrice et le max du tableau en valeur
             foreach($array_data as $keys => $valu){
                  $result_donnees[] = $keys.','.max($valu);
             }
            
             // recupérer l'eleve qui as la meilleur vente élève
             $result_data2 =[];
             foreach($result_donnees as $values){
                  $amba = explode(',',$values)[0];
                  $chainex = array_search($values,$data_result);
                  $result_data2[$chainex] = $amba;
             }
             // recupérer le montant le plus élévé
              $list = json_encode($somme_desc); // tranformer les données en json
              $list = json_decode($somme_desc,true); // tranformer le retour json en array tableau.
              // recupérer les infos du clients qui 
              // recupérer le montant le plus élèvé pour les amba.
              $code_lives =12;
             $somme_descs = DB::table('ordersambassadricecustoms') ->select('customer','email','username','code_promo','id_ambassadrice','somme','telephone')->where('code_mois','=',$mois_recap)->where('annee','=',$annee)
             ->where('code_live','=',$code_lives)
             ->orderBy('somme','desc')
             ->get();

              // recupérer le montant le plus élévé
              $lisd = json_encode($somme_descs); // tranformer les données en json
              $lisd = json_decode($somme_descs,true); // tranformer le retour json en array tableau.

             // construire un array.
               foreach($lisd as $valcs){
                // créer en amont une chaine qui va recupérer les données.
                 $chaines = $valcs['customer'].','.$valcs['username'].','.$valcs['code_promo'].','.$valcs['email'].','.$valcs['somme'].','.$valcs['telephone'];
                 $data_results[$chaines] = $valcs['id_ambassadrice'].','.$valcs['somme'];
             }

                $array_datas =[];
                $result_donneess =[];
               foreach($lisd as $vac){
                 $array_datas[$vac['id_ambassadrice']][] = $vac['somme'];
              }
       
              // creer un tableau de valeur entre id_ambassadrice et le max du tableau en valeur
              foreach($array_datas as $kes => $valus){
                $result_donneess[] = $kes.','.max($valus);
           }

            $result_data3 =[];

            foreach($result_donneess as $valus){
                  $amba = explode(',',$valus)[0];
                  $chainex = array_search($valus,$data_results);
                  $result_data3[$chainex] = $amba;
         }


          // result_final
          $donnes_final =[];
          $donnees_finals =[];
         foreach($result_data1 as $van){
            // recupérer les infos de l'ambassadrice
            $chaine_info_user =  array_search($van['id_ambassadrice'],$result_users);
            $chaine_info_user1 = explode(',',$chaine_info_user);
            // recupéreration les infos des clients code elelve
            $chaine_customer = array_search($van['id_ambassadrice'],$result_data2);
            $chaine_customer1 = explode(',',$chaine_customer);
            // recupération meilleur commmande live
              // recupéreration les infos des clients code elelve
              $chaine_live = array_search($van['id_ambassadrice'],$result_data3);
              if($chaine_live!=false && $chaine_customer!=false){
                if($chaine_info_user1[1]==2){
                  $status ="Ambassadrice";
                }
                if($chaine_info_user1[1]==4){
                    $status="Partenaire";
                }
           
                  $chaine_live1 = explode(',',$chaine_live);
                  // Calculer le taux de %
                  $total_code = $van['nombre_code_utilise']+$van['nombre_code_create'];
                  $pr = $van['nombre_code_utilise']*100/$total_code;

                   // definit les niveau d'observation
                   // entre 0-25 // entre 25-50 entre 50-70 // et plus de 70%
                   if(0 < $pr && $pr <25){
                    $observation=" Vos élèves n'utilisent pas courament les codes élève, veuillez les relancer !";
                   }elseif(25> $pr  && $pr <50){

                    $observation=" L'equipe elyamaje vous encouragent à booster vos élèves  à  utiliser des codes élèves";
                   }
                   elseif(25 > $pr && $pr <70){
                    $observation=" L'equipe Elyamaje vous encourage vos élèves utilisent bien les codes élèves";
                      
                   }else{
                      $observation=" Félicitation vos élèves utilisent parfaitement les codes que vous avez crée";
                   }


                  $donnees_final[] =[
                 'nom_ambassadrice'=> $chaine_info_user1[2],// info sur amabssadrice
                 'status'=>$status,
                 'periode'=>$periode,
                 'observation'=>$observation,
                 'email'=>$chaine_info_user1[0],
                 'nom_great_eleve'=>$chaine_customer1[0].' '.$chaine_customer1[1],// nombre de code crée...
                 'montant_great_eleve'=>$chaine_customer1[4]*100/20,
                 'nombre_code_use'=>$van['nombre_code_utilise'],
                 'nombre_code_create'=> $van['nombre_code_create'],
                 'nom_code_live'=> $chaine_live1[0].' '.$chaine_live1[1],
                 'montant_live_great'=> $chaine_live1[4]*100/20
               
                 
             ];
         }
          
           if($chaine_live==false && $chaine_customer!=false) {

               if($chaine_info_user1[1]==2){
                 $status ="Ambassadrice";
               }
               if($chaine_info_user1[1]==4){
                   $status="Partenaire";
               }

                 // Calculer le taux de %
                 $total_code = $van['nombre_code_utilise']+$van['nombre_code_create'];
                 $pr = $van['nombre_code_utilise']*100/$total_code;
              
                 if(0 < $pr && $pr <25){
                $observation=" Vos élèves n'utilisent pas courament les codes élève, veuillez les relancer !";
               }elseif(25> $pr  && $pr <50){

                $observation=" L'equipe elyamaje vous encouragent à booster vos élèves  à  utiliser des codes élèves";
               }
               elseif(25 > $pr && $pr <70){
                $observation=" L'equipe Elyamaje vous encourage vos élèves utilisent bien les codes élèves";
                  
               }else{
                  $observation=" Félicitation vos élèves utilisent parfaitement les codes que vous avez crée";
               }


          
               $donnees_finals[] =[
                'nom_ambassadrice'=> $chaine_info_user1[2],// info sur amabssadrice
                'status' => $status,
                'periode'=>$periode,
                'observation'=>$observation,
                'email'=>$chaine_info_user1[0],
                'nom_great_eleve'=>$chaine_customer1[0].'  '.$chaine_customer1[1],// nombre de code crée...
                'montant_great_eleve'=>$chaine_customer1[4]*100/20,
                'nom_code_use'=>$van['nombre_code_utilise'],
                'nombre_code_create'=> $van['nombre_code_create'],
      
             ];
           
          }
        }

        dump($donnees_finals);
        dd($donnees_finals);

        $titre ="Point d'activité mensuelle chez elyamaje";
       // envoi de mail pour les ambassadrice ayant des live et code éléve .
    /*    foreach($donnees_final as $vals){
        
           $nom_ambassadrice = $vals['nom_ambassadrice'];
           $status = $vals['status'];
           $periode =$vals['periode'];
           $email = $vals['email'];
           $nombre_code_create = $vals['nombre_code_create'];
           $nombre_code_use = $vals['nombre_code_use'];
           $nom_great_eleve = $vals['nom_great_eleve'];
           $montant_great_eleve = $vals['montant_great_eleve'];
           // pour les lives
           $nom_code_live = $vals['nom_code_live'];
           $montant_live_great = $vals['montant_live_great'];
           Mail::send('email.envoimaillot', ['nom_ambassadrice'=>$nom_ambassadrice,'montant_great_eleve'=>$montant_great_eleve,'nom_great_eleve'=>$nom_great_eleve,'status'=>$status,'periode'=>$periode,'nombre_code_create'=>$nombre_code_create,'nombre_code_use'=>$nombre_code_use,'email'=>$email,'titre'=>$titre,'nom_code_live'=>$nom_code_live,'montant_live_great'=>$montant_live_great], function($message) use($nom_ambassadrice, $status, $periode,$nombre_code_create,$montant_great_eleve,$nom_great_eleve,$nombre_code_use,$email,$titre,$nom_code_live,$montant_live_great){
           $message->to($email);
           $message->from('no-reply@elyamaje.com');
           $message->subject($titre);

         });
  
      }

    // envoi de mail pour qui posséde seul des codes élève
      foreach($donnees_finals as $valu){

        $nom_ambassadrice = $vals['nom_ambassadrice'];
        $status = $vals['status'];
        $periode =$vals['periode'];
        $email = $vals['email'];
        $nombre_code_create = $vals['nombre_code_create'];
        $nombre_code_use = $vals['nombre_code_use'];
        $nom_great_eleve = $vals['nom_great_eleve'];
        $montant_great_eleve = $vals['montant_great_eleve'];
        Mail::send('email.envoimaillot1', ['nom_ambassadrice'=>$nom_ambassadrice,'montant_great_eleve'=>$montant_great_eleve,'nom_great_eleve'=>$nom_great_eleve,'status'=>$status,'periode'=>$periode,'nombre_code_create'=>$nombre_code_create,'nombre_code_use'=>$nombre_code_use,'email'=>$email,'titre'=>$titre], function($message) use($nom_ambassadrice, $status, $periode,$nombre_code_create,$montant_great_eleve,$nom_great_eleve,$nombre_code_use,$email,$titre){
        $message->to($email);
        $message->from('no-reply@elyamaje.com');
        $message->subject($titre);

        });
      }

        

          dump($donnees_finals);
          dd($donnees_finals);

          // envoi des messages.
          // envoi de Mail mutiple au Partenaire et Ambassadrice....
        
            $donnees_finales=[
             [ 'nom_ambassadrice'=> 'kouame',// info sur amabssadrice
               'status' => 'Ambassadrice',
               'periode'=> 'Septembre 2023',
               'email'=>'zapomartial@yahoo.fr',
                'nom_great_eleve'=>"Adrien Gonzalez",// nombre de code crée...
                'montant_great_eleve'=>"120 euro",
                'nombre_code_use'=>"20",
                'nombre_code_create'=>"10",
            ],

             [ 'nom_ambassadrice'=> 'Martial',// info sur amabssadrice
               'status' => 'Partenaire',
               'periode'=>  'Septembre 2023',
               'email'=>'mmajeri@elyamaje.com',
               'nom_great_eleve'=>"Zapo Adrien Lyes",// nombre de code crée...
               'montant_great_eleve'=>"50 euro",
               'nombre_code_use'=>"3",
               'nombre_code_create'=>"12",
           ]

          ];

           
          $titre ="Point d'activité mensuelle chez elyamaje.";
          foreach($donnees_finales as $vals){
            // notifier un mail d'envoi
            $nom_ambassadrice = $vals['nom_ambassadrice'];
            $status = $vals['status'];
            $periode =$vals['periode'];
            $email = $vals['email'];
            $nombre_code_create = $vals['nombre_code_create'];
            $nombre_code_use = $vals['nombre_code_use'];
            $nom_great_eleve = $vals['nom_great_eleve'];
            $montant_great_eleve = $vals['montant_great_eleve'];
            Mail::send('email.envoimaillot', ['nom_ambassadrice'=>$nom_ambassadrice,'montant_great_eleve'=>$montant_great_eleve,'nom_great_eleve'=>$nom_great_eleve,'status'=>$status,'periode'=>$periode,'nombre_code_create'=>$nombre_code_create,'nombre_code_use'=>$nombre_code_use,'email'=>$email,'titre'=>$titre], function($message) use($nom_ambassadrice, $status, $periode,$nombre_code_create,$montant_great_eleve,$nom_great_eleve,$nombre_code_use,$email,$titre){
            $message->to($email);
            $message->from('no-reply@elyamaje.com');
            $message->subject($titre);
 
           });
    
        }

        dd('succes opération');
      */
     }

     public function getNummois($moi)
       {
       
          if($moi=="Janvier") {
             $mo = 1;
         }
         
         if($moi=="Fevrier"){
             $mo=2;
         }
         
         if($moi=="Mars"){
             $mo =3;
         }
         
         if($moi=="Avril"){
             $mo=4;
         }
         
         if($moi=="Mai") {
             $mo =5;
         }
         
         if($moi=="Juin") {
             $mo=6;
         }
         
         if($moi=="Juillet"){
             $mo=7;
         }
         
         if($moi=="Août"){
             $mo=8;
         }
         
         if($moi=="Septembre"){
             $mo=9;
         }
         
         if($moi=="Octobre") {
             $mo=10;
         }
         
         if($moi=="Novembre") {
             $mo=11;
         }
         
         if($moi=="Decembre") {
             $mo=12;
         }
         
          return $mo;
     }
    
    
}
     
    


































?>