<?php

namespace App\Repository\Ambassadrice;

use App\Models\HistoriquePanierLive;
use App\Models\Ambassadrice\Ordersambassadricecustom;
use App\Http\Service\FilePdf\CreateCsv;
use App\Models\PanierLive;
use App\Models\PalierHistorique;
use App\Models\Ambassadrice\Ambassadricecustomer;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Hash;

class HistoriquePanierLiveRepository implements HistoriquePanierLiveInterface
{
     
    private $date;

    private $nombre;

    private $data =[];
    
    private $datas =[];
    
    private $dates = []; // recupérer les dates de live +1 ecris via dolibarr pour les recettes.
    private $codelive =[];// recupérer l'ensemble des code live

    private $codes =[];// recupérer les données ...

    private $dataid =[];// un array id index et name ambassadrice.
    private $someleve;// montant somme.
    private $somelive;// montant live.
    
     public function __construct(
      HistoriquePanierLive $model,
      CreateCsv $csv
     )
    {
       $this->model = $model;
       $this->csv = $csv;
    }

    public function getDate()
    {
       return $this->date;
    }
    
    
    public function setDate($date)
    {
      $this->date = $date;
      return $this;
    }

    public function getNombre()
    {
       return $this->nombre;
    }
    
    
    public function setNombre($nombre)
    {
      $this->nombre = $nombre;
      return $this;
    }

    
    public function getSomeleve()
    {
       return $this->someleve;
    }
    
    
    public function setSomeleve($someleve)
    {
      $this->someleve = $someleve;
      return $this;
    }

    public function getSomelive()
    {
       return $this->somelive;
    }
    
    
    public function setSomelive($somelive)
    {
      $this->somelive = $somelive;
      return $this;
    }


    public function getData(): array
    {
        return $this->data;
    }

    public function setData(array $data)
     {
         $this->data = $data;
          return $this;
      }


      public function getDatas(): array
      {
          return $this->datas;
      }
  
      public function setDatas(array $datas)
      {
           $this->datas = $datas;
            return $this;
      }

      public function getDates(): array
      {
          return $this->dates;
      }
  
      public function setDates(array $dates)
      {
           $this->dates = $dates;
            return $this;
      }

      public function getCodelive(): array
      {
          return $this->codelive;
      }
  
      public function setCodelive(array $codelive)
      {
           $this->codelive = $codelive;
            return $this;
      }


      public function getCodes(): array
      {
          return $this->codes;
      }
  
      public function setCodes(array $codes)
      {
           $this->codes = $codes;
            return $this;
      }

     
      public function getDataid(): array
      {
          return $this->dataid;
      }
  
      public function setDataid(array $dataid)
      {
           $this->dataid = $dataid;
            return $this;
      }

  
    
    public function getByIdLive($id_live){
        return HistoriquePanierLive::select('*')->where('id_live', $id_live)->get()->toArray();
    }
    

    
    public function getall()
    {
        
          $code_live = Auth()->user()->code_live;
         
         $name_list = DB::table('historique_panier_lives')->select('id','id_live','date_live','code_live','token_datas')->where('code_live','=',$code_live)->get();
         $name_lists = json_encode($name_list);
         $name_lists = json_decode($name_list,true);

        // recupérer les données des paniers choisir par les emabassadrice
           $datas = DB::table('panier_lives')->select('id_product','pseudo','token','libelle','mont_mini')->get();
           $lis = json_encode($datas);
           $lists = json_decode($datas,true);
           $donnees =[];
           $donnes = [];
          foreach($lists as $key => $valc){
              $chaine1 = $valc['id_product'].'%A'.$valc['token'].'%A'.$valc['pseudo'].'%A'.$valc['libelle'].'%A'.$valc['mont_mini'];
              $donnees[$chaine1] = $valc['token'];
          }
          
           // recupérer les données a afficher .
            $donnes_live = [];
            $list_product = [];
          
          foreach($name_lists as $ks => $vals){
              $chaine_token_produit =  explode(',',$vals['token_datas']);
              
              foreach($chaine_token_produit as $val) {
                    // $chaine token pour ids product
                 $id_products = array_search($val,$donnees);
                 $ids_var_ps = explode('%A',$id_products);
                 
                 $libelle = $ids_var_ps[3];
                 $pseudo = $ids_var_ps[2];
                 $montant = $ids_var_ps[4].'€';
                  // date courante
                 $date_actuel =date('Y-m-d');
                 $date_live  = explode(' ',$vals['date_live']);
                 $date_live_true = $date_live[0];
                 
                 $date_francais = explode('-',$date_live_true);
                 $date_fr = $date_francais[2].'/'.$date_francais[1].'/'.$date_francais[0];
                  $x_heure = $date_fr.' '.$date_live[1];
                 
                 if($date_live_true < $date_actuel){
                     $action ="falsecss";
                 }
                 
                 else{
                     
                     $action ="yepcss";
                 }
                 
                 // recupérer le pseudo et le group.
                 $list_product[] =[
                     
                     'id_live'=>'N° de live : '.$vals['id_live'].' efffectué le '.$x_heure,
                     'pseudo'=>$pseudo,
                      'libelle'=>$libelle.'  '.$montant,
                    
                     ];
              }
              
          }
          
           function groupByTile($list_product){
         $final_array =[];
          foreach($list_product as $key=>$valc){
           $final_array[$valc['id_live']][] = $valc;
           
         }

           return $final_array;  
       }

         $data_panier_uniques = groupBytile($list_product);
          return $data_panier_uniques;
         
         }

        
         public function getalls($id_ambassadrice)
         {
             $date_limite = Carbon::now()->subMonths(2)->toDateTimeString();
             $name_l = DB::table('historique_panier_lives')->select('id','id_live','date_live','code_live','token_datas')->where('date_live', '>=', $date_limite)->get();
            $name_lists = json_encode($name_l);
             $name_li = json_decode($name_l,true);

             // suprimer toutes ligne de la table mois de deux mois.
             $data_ids_expire =[];
             $date = date('Y-m-d H:i:s');
             $date_cours   = date("Y-m-d", strtotime($date.'+ 60 days'));
             $data_donnees =[];// Accepté....
              // recupérer le code live de l'ambassadrice
               // recupérer tous les data de la table
               $data =  DB::table('codelives')->select('code_live')->where('id_ambassadrice','=',$id_ambassadrice)->get();
               $name_list = json_encode($data);
               $name_list = json_decode($data,true);

               $code_live="";
              foreach($name_list as $val){
                 $code_live = $val['code_live'];
              }

                //live 
                $name_lis = DB::table('historique_panier_lives')->select('id','id_live','date_live','code_live','token_datas')->where('code_live','=',$code_live)->get();
                $name_lists = json_encode($name_lis);
                $name_lists = json_decode($name_lis,true);
                // recupérer les données des paniers choisir par les emabassadrice
                $datas = DB::table('panier_lives')->select('id_product','pseudo','token','libelle','mont_mini')->get();
                $lis = json_encode($datas);
                $lists = json_decode($datas,true);
                $donnees =[];
                $donnes = [];
               foreach($lists as $key => $valc) {
                  $chaine1 = $valc['id_product'].'%A'.$valc['token'].'%A'.$valc['pseudo'].'%A'.$valc['libelle'].'%A'.$valc['mont_mini'];
                   $donnees[$chaine1] = $valc['token'];
               }
               
                 // recupérer les données a afficher .
                 $donnes_live = [];
                 $list_product = [];
               
                foreach($name_lists as $ks => $vals){
                   $chaine_token_produit =  explode(',',$vals['token_datas']);
                   
                   foreach($chaine_token_produit as $val){
                         // $chaine token pour ids product
                      $id_products = array_search($val,$donnees);
                      if($id_products){
                            $ids_var_ps = explode('%A',$id_products);
                            $libelle = $ids_var_ps[3];
                            $pseudo = $ids_var_ps[2];
                            $montant = $ids_var_ps[4].'€';
                            // date courante
                             $date_actuel =date('Y-m-d');
                             $date_live  = explode(' ',$vals['date_live']);
                             $date_live_true = $date_live[0];
                        
                              $date_francais = explode('-',$date_live_true);
                              $date_fr = $date_francais[2].'/'.$date_francais[1].'/'.$date_francais[0];
                              $x_heure = $date_fr.' '.$date_live[1];
                        
                          if($date_live_true < $date_actuel){
                                $action ="falsecss";
                           }
                           else{
                            
                            $action ="yepcss";
                        }
                        
                           // recupérer le pseudo et le group...
                            $list_product[] =[
                            
                            'id_live'=>'N° de live : '.$vals['id_live'].' efffectué le '.$x_heure,
                            'pseudo'=>$pseudo,
                            'libelle'=>$libelle,
                            'montant' => $montant
                           
                            ];
                      }
                    
                   }
                   
               }
               
                function groupByTile($list_product){
                 $final_array =[];
               foreach($list_product as $key=>$valc){
                $final_array[$valc['id_live']][] = $valc;
                
              }
     
                return $final_array;  
            }
     
              $data_panier_uniques = groupBytile($list_product);
               return $data_panier_uniques;

         }

         public function gethistorique()
         {
            
              $name_list = DB::table('users')
             ->join('historique_panier_lives', 'users.code_live', '=', 'historique_panier_lives.code_live')
             ->select('historique_panier_lives.*','users.*')
             ->orderBy('historique_panier_lives.date_live','desc')
             ->get();

             $name_lists = json_encode($name_list);
             $name_lists = json_decode($name_list,true);
             // créer le tableau à afficher.
            $resut_data =[];
            $stag="";
            foreach($name_lists as $val){
               // verifier si le live est effectué un mardi.
               $name_of_the_day = date('l', strtotime($val['date_live']));
               $date_live = date('d/m/Y',strtotime($val['date_live']));
               $date_live_recette =  date("d/m/Y", strtotime($val['date_live'].'+ 1 days'));// recupérer les date facturer dans dolibar au lendemain des lives...
               $date_x = $name_of_the_day;
              if($date_x =="Tuesday"){
                  $pseudo_css = "buttooncss";
                  $ext =" Mardi";
                }else{
                 $pseudo_css = "buttonone";
                 $ext="";
              }

                 $ref = $val['code_live'].','.$val['date_live'].','.$val['id_live'];
                 $result_data[] =[
                 'ref_live'=> $val['id_live'],
                 'stag' => $stag,
                 'ambassadrice'=> $val['name'],
                 'date_live' => $date_live,
                 'ref_jour'=> $ext,
                 'rapport' => $ref,
                 'code_live'=>$val['code_live'],
                 'ext'=> $ext,
                 'css' => $pseudo_css,
                  ];
                
              
                   // recupérer un array avec index name amabssadrice key code live.
                   $array_data[$val['code_live']] = $val['name'];
                   // liée id du user à l'ambassadrice.
                   $array_name_id[$val['id']] = $val['name'];
                   // recuperer le tableau
                   $this->setDataid($array_name_id);
                   $this->setData($array_data);
                   // recupérer les date....
                   $result_date[] = $date_live_recette;
                   $result_date_true =  array_unique($result_date);
                   $this->setDates($result_date_true);
                   // recupérer les code live de l'ensemble des ambassadrice.
                   $code_lives[] = $val['code_live'];
                   $code_live_tab =  array_unique($code_lives);
                   $this->setCodelive($code_live_tab);
                  
               }

                 return $result_data;

         }

         public function  gethistoriques($code_live,$mois,$annee)
         {
             
            //$this->gethistoriquesommelive();
          
            $name_list = DB::table('users')
            ->join('historique_panier_lives', 'users.code_live', '=', 'historique_panier_lives.code_live')
            ->select('historique_panier_lives.*','users.*')
            ->where('users.code_live','=',$code_live)
            ->orderBy('historique_panier_lives.date_live','desc')
            ->get();

              // traiter l'histoique des lives ..par ambassadrice  via le code live..
              $name_lists = json_encode($name_list);
              $name_lists = json_decode($name_list,true);
            

              $array_group =[]; // recupérer les dates associé à l'id_live en prenant en compte le nombre suivant.
              $list_detail = [];// recupérer la date ou le live a ete effectué
            foreach($name_lists as $val){
                  
                $dat = date("d/m/Y", strtotime($val['date_live']));
                $datex = date("d/m/Y", strtotime($val['date_live'].'+ 1 days'));
                $chaine = $dat.','.$val['id_live'];
                $chaine2 = $datex.','.$val['id_live'];
                $chaine3 = $val['name'].','.$val['id_live'];
                $array_group[$chaine] = $dat;
                $array_group[$chaine2] = $datex;
                $list_detail[$dat] = $val['id_live'];
                $list_name[$chaine3] = $val['id_live'];

                  // recupérer toutes les date de live +1 qui va servir de facturer dans dolibar et recupérer les somme de live dans les recette
                
              }

                // recupérer les commande et les associés...
                 $data =  DB::table('ordersambassadricecustoms')->select('datet','somme','id_ambassadrice')->where('code_promo','=',$code_live)->get();
                 $name_list = json_encode($data);
                 $name_list = json_decode($data,true);
                 // recupérer 
                 $array_result_data =[];// crée un jeu de données qui va regrouper tous les id live et somme
                 foreach($name_list as $key => $vals){
                   $date_value =  date("Y-m-d", strtotime($vals['datet']));
                   $chaine_data  = array_search($vals['datet'],$array_group);

                     if($mois=="" OR $annee==""){
                            if($chaine_data!=false){
                               $chaine_datas = explode(',',$chaine_data);
                               $array_result_data[]= [
                               'id_live'=>$chaine_datas[1],
                               'somme' => $vals['somme'],
                               'date' => $vals['datet']

                             ];
                       }

                     }

                     if($mois!="" && $annee!=""){
                        $data_r = explode('/',$vals['datet']);
                       if($mois==$data_r[1] && $annee==$data_r[2]){
                        if($chaine_data!=false){
                           $chaine_datas = explode(',',$chaine_data);
                            $array_result_data[]= [
                            'id_live'=>$chaine_datas[1],
                            'somme' => $vals['somme'],
                            'date' => $vals['datet']
                          ];

                        }

                       }
                    }
                 }

                     // insert statlives..
                    DB::table('statlives')->truncate(); // vider la table
                    DB::table('statlives')->insert($array_result_data);  // la remplir a nouveau
                     // grouper les donées en fonction des id_live et compter 
                     $sum_vente = DB::table('statlives')
                    ->select('id_live' ,DB::raw('SUM(somme) as total'))
                     ->groupBy('id_live')
                     ->orderBy('date','desc')
                     ->get();
                     $sum_data = json_encode($sum_vente);
                     $sum_data = json_decode($sum_vente,true);
                    
                      // compter le nombre de id_live 
                      $sum_ventes = DB::table('statlives')
                      ->select('id_live' ,DB::raw('COUNT(id_live) as nombre_vente'))
                      ->groupBy('id_live')
                      ->orderBy('date','desc')
                      ->get();
                      
                      $sum_datas = json_encode($sum_ventes);
                      $sum_datas = json_decode($sum_ventes,true);

              
                      $array_filtre = []; // créer un jeu de donnée pour identifier les données.
                       foreach($sum_datas as $va){
                            $chainex = $va['id_live'].','.$va['nombre_vente'];
                           $array_filtre[$chainex] = $va['id_live'];
                      }
                       // construire le jeu de données pour le csv

                       $result_data_csv =[];
                       foreach($sum_data as $values){
                           // recupérer la date du live et le nombre de vente +commission
                            $date_live = array_search($values['id_live'],$list_detail);
                            $nombre_vente = array_search($values['id_live'],$array_filtre);
                            $nombre_v = explode(',',$nombre_vente);
                            $nbrs_v = $nombre_v[1];

                             $list_nam = array_search($values['id_live'],$list_name);
                             $nams = explode(',',$list_nam);
                             $nam = $nams[0];

                             if($values['total'] < 600){
                                 $commission = $values['total'];
                             }
                              
                             elseif($values['total']> 600 && $values['total']<680){
                                 $commission = 600;
                             }

                             elseif($values['total']> 680 && $values['total']<750){
                               $commission = 600;
                             }

                             else{
                                  $commission =600;
                             }

                              $result_data_csv[] =[
                               'date_live'=>$date_live,
                               'Ambassadrice'=>$nam,
                               'commission'=> $commission.'€',
                               'nombre_vente'=> $nbrs_v

                           ];
                       }

               $this->csv->csvcreatelive($result_data_csv);
                       // construire un array pour tirer le csv.
              return $name_lists;

         }


       public function gethistoriquesommelive(){
           // fonction ppour afficher chez l'ambassadrice et gere les facture mensuel
           
          $date = date('Y-m-d');
         // constitue une chaine.
          $years = date('Y');
          $mois = date('m');
          $mmt = (int)$mois;
          if($mmt>9){
            $mx = $mmt;
            $mts = $mmt+1;
            $mx = $mts;
          }else{
             $mx ="0$mmt";
             $mts = $mmt+1;
             $mx ="0$mts";
          }
        
           dump($mts);
          $jour = date('d');
          //fixer jour..construire mes bornes
          $date_actuel ="$years-$mois-01 00:00";
          $date_ms = "$years-$mx-01 00:00";

        
           $mlast="2024-01-01 00:00";
           $mlast1 ="2024-02-01 00:00";
           $code ="caroline-amb";
           $id_ambassadrice = 14;
           //$code = Auth->user()->codelive;
           
           $name_list = DB::table('historique_panier_lives')
          ->select('code_live','id_live','date_live')
          ->where('code_live','=',$code)
          ->whereBetween('date_live', [$date_actuel, $date_ms])
          ->orderBy('historique_panier_lives.date_live','desc')
          ->get();

            $name_lists = json_encode($name_list);
            $name_lists = json_decode($name_list,true);

            $array_group =[]; // recupérer les dates associé à l'id_live en prenant en compte le nombre suivant.
            $list_detail = [];// recupérer la date ou le live a ete effectué
            foreach($name_lists as $val){
             $dat = date("d/m/Y", strtotime($val['date_live']));
             $datex = date("d/m/Y", strtotime($val['date_live'].'+ 1 days'));
             $chaine = $dat.','.$val['id_live'];
             $chaine2 = $datex.','.$val['id_live'];
             $array_group[$chaine] = $dat;
             $array_group[$chaine2] = $datex;
             $list_detail[$dat] = $val['id_live'];
                // recupérer toutes les date de live +1 qui va servir de facturer dans dolibar et recupérer les somme de live dans les recette
          }

             // recupérer les commande et les associés...
             $data =  DB::table('ordersambassadricecustoms')->select('datet','somme','id_ambassadrice','code_live')->where('id_ambassadrice','=',$id_ambassadrice)->where('code_mois','=',$mois)->where('annee','=',$years)->get();
             $name_list = json_encode($data);
             $name_list = json_decode($data,true);
             
            $array_result_data =[]; // traiter les sous pour les lives
             $array_result_data =[];// recupérer les sous pour les eléves
            foreach($name_list as $key => $vals){
              if($vals['code_live']==12){
              $date_value =  date("Y-m-d", strtotime($vals['datet']));
              $chaine_data  = array_search($vals['datet'],$array_group);
                $data_r = explode('/',$vals['datet']);
                  
                   $chaine_datas = explode(',',$chaine_data);
                       $array_result_data[]= [
                       'id_live'=>$chaine_datas[1],
                       'somme' => $vals['somme'],
                       'date' => $vals['datet']
                     ];
                  }
                   else{
                    $array_result_data1[] = $vals['somme'];// somme mensuels les codes élève.
                  }

                // faire un group by  et sommer la somme  en fonction de l'id de live.
                 $result = array_reduce($array_result_data,function($carry,$item){
                if(!isset($carry[$item['id_live']])){ 
                    $carry[$item['id_live']] = ['id_live'=>$item['id_live'],'somme'=>$item['somme']]; 
                   } else { 
                    $carry[$item['id_live']]['somme'] += $item['somme']; 
                 } 
                   return $carry; 
                });
                   // traiter les live  pour fixer a 600 euro au cas ou celui ci dépasse.
               }
                // traiter au maxi les 4 live pour les montant.
                   $result_montant_live=[];// montant des lives généré au cours du mois.
                    foreach($result as $values){
                       if($values['somme']< 600){
                         $val_x = $values['somme'];
                     }else{
                         $val_x = 600;
                     }

                     $result_montant_live[] = $val_x;

                 }

                 $somme_live = array_sum($result_montant_live);
                 $somme_eleve = array_sum($array_result_data1);
                 $this->setSomeleve($somme_eleve);
                 $this->setSomelive($somme_live);
                  // recupere la somme ici.
                 $resultat_somme = number_format($somme_live+$somme_eleve,2,".","");// renvoie la valeur.
                 return $resultat_somme;
            
          }
        


         public function gethistoriqueventes($id,$annee)
         {
              $is_admin =2;
             $code_live =12;
             // point live
             $orders = DB::table('ordersambassadricecustoms')
            ->select('code_mois',DB::raw('SUM(somme) as total'))
            ->where('id_ambassadrice','=',$id)
            ->where('code_live','=',$code_live)
            ->where('annee','=',$annee)
            ->groupBy('code_mois')
            ->get();

              $name_list = json_encode($orders);
              $name_list = json_decode($orders,true);


              $result_data =[];
              $result_mois =[];

             foreach($name_list as $value){
                $chaine = $id.','.$value['total'].','.$value['code_mois'];
                $chainex = $value['total'].','.$value['code_mois'];
                $result_mois[$chainex] = $value['code_mois'];
            
            }

            // rapport vente eleve ambassadrice.
             // point eleve
              $code_lives =11;
             $order = DB::table('ordersambassadricecustoms')
             ->select('code_mois',DB::raw('SUM(somme) as total'))
             ->where('id_ambassadrice','=',$id)
             ->where('code_live','=',$code_lives)
             ->where('annee','=',$annee)
             ->groupBy('code_mois')
              ->get();
             // recupéerer un array user
             $name_lists = json_encode($order);
             $name_lists = json_decode($order,true);

            

             // recupérer les users.
             $is_admin =2;
             $users = DB::table('users')
            ->select('id','name','is_admin')
            ->where('is_admin','=',$is_admin)
             ->get();

           $name_lis = json_encode($users);
           $name_lis = json_decode($users,true);

           $list_users =[];

           foreach($name_lis as $val){
              if($val['is_admin']==2){
                  $list_users[$val['name']] = $val['id'];
                }
           }


           $result_data_final=[];

           foreach($name_lists as $values){
               $chaine_y = array_search($values['code_mois'],$result_mois);
               if($chaine_y!==false){
                 $montant_live = explode(',',$chaine_y);
                 $mont_live = $montant_live[0];
                 $montant_true = $mont_live + $values['total'];
                 $gain_pourcent_live =   number_format($mont_live*100/$montant_true,2,".","");
                 $gain_pourcent_eleve =   number_format($values['total']*100/$montant_true,2,".","");
                 $montant_live = number_format($mont_live,2,".","");
                 $montant_eleve = number_format($values['total'],2,".","");
                 // regarde le chiffre affaire genere
                $chiffre_genere = $montant_true*80/20;
                $montant_genere = number_format($chiffre_genere,2,".","");
               
                 // recupérer le array plus haut
                 $result_data_final[]=[
                 'Ambassadrice'=> array_search($id,$list_users),
                 'periode' => $this->getmois($values['code_mois']).' '.$annee,
                 'commission_live' =>'xxxx',
                 'commission_eleve'=>'xxxx',
                 'commission_total (€)' => 'xxxxx',
                 'chiffre_affaire_generé (HT)'=>$montant_genere.'€.',
                 'live(%)'   =>  $gain_pourcent_live.'%',
                 'eleve(%)' =>   $gain_pourcent_eleve.'%'

               ];
             }

           }

              // générer un csv
              $this->csv->createcsvrapports($result_data_final);
          }

         public function gethistoriquevente($annee)
         {
             // traitement des données de rapport %
             // rapport vente live  commission 
            
              $is_admin =2;
              $code_live =12;
              $orders = DB::table('ordersambassadricecustoms')
             ->select('id_ambassadrice',DB::raw('SUM(somme) as total'))
             ->where('is_admin','=',$is_admin)
             ->where('code_live','=',$code_live)
             ->where('annee','=',$annee)
             ->groupBy('id_ambassadrice')
             ->get();

              $name_list = json_encode($orders);
              $name_list = json_decode($orders,true);

              $result_data =[];
              $result_mois =[];

              foreach($name_list as $value){
                   $chaine = $value['id_ambassadrice'].','.$value['total'];
                   $result_data[$chaine] = $value['id_ambassadrice'];
                
              }

             // rapport vente eleve ambassadrice.
              $code_lives =11;
              $order = DB::table('ordersambassadricecustoms')
              ->select('id_ambassadrice',DB::raw('SUM(somme) as total'))
              ->where('is_admin','=',$is_admin)
              ->where('code_live','=',$code_lives)
              ->where('annee','=',$annee)
              ->groupBy('id_ambassadrice')
              ->get();

               // recupéerer un array user
               $name_lists = json_encode($order);
               $name_lists = json_decode($order,true);

               // recupérer les users.
               $is_admin =2;
               $users = DB::table('users')
              ->select('id','name','is_admin')
              ->where('is_admin','=',$is_admin)
              ->get();

               $name_lis = json_encode($users);
               $name_lis = json_decode($users,true);

               $list_users =[];

               foreach($name_lis as $val){
                  if($val['is_admin']==2){
                      $list_users[$val['name']] = $val['id'];
                    }
               }



                $result_data_final=[];

                foreach($name_lists as $values){
                    $chaine_x = array_search($values['id_ambassadrice'],$result_data);
                    if($chaine_x!==false){
                    $montant_live = explode(',',$chaine_x);
                    $mont_live = $montant_live[1];
                    $montant_true = $mont_live + $values['total'];
                    $gain_pourcent_live =   number_format($mont_live*100/$montant_true,2,".","");
                    $gain_pourcent_eleve =   number_format($values['total']*100/$montant_true,2,".","");
                    $montant_live = number_format($mont_live,2,".","");
                    $montant_eleve = number_format($values['total'],2,".","");

                    // regarde le chiffre affaire genere
                     $chiffre_genere = $montant_true*80/20;
                     $montant_genere = number_format($chiffre_genere,2,".","");
                    
                    // recupérer le array plus haut
                      $result_data_final[]=[
                      'Ambassadrice'=> array_search($values['id_ambassadrice'],$list_users),
                      'commission_live' => $montant_live,
                      'commission_eleve'=>$montant_eleve,
                      'commission_total (€)' => $mont_live+$values['total'],
                      'chiffre_affaire_generé (HT)'=>$montant_genere.'€.',
                      'live(%)'   =>  $gain_pourcent_live.'%',
                      'eleve(%)' =>   $gain_pourcent_eleve.'%'

                    ];
                  }

                }
                
                // générer un csv
                $this->csv->createcsvrapport($result_data_final);

             
         }

         

         public function getdatelivecode($id)
         {
             $data =  DB::table('historique_panier_lives')->select('id_live','code_live','date_live')->where('id_live','=',$id)->get();
             $name_list = json_encode($data);
             $name_list = json_decode($data,true);
             // recupérer les valeurs souhaité...
             $code_live = $name_list[0]['code_live'];
             $date_live = $name_list[0]['date_live'];

            // recupérer la date dans un setter
             $this->setDate($date_live);

             return $code_live;

         }

          



         public function getorderlist($code_live){

             $data =  DB::table('ordersambassadricecustoms')->select('datet','somme','id_ambassadrice')->where('code_promo','=',$code_live)->get();
             $name_list = json_encode($data);
             $name_list = json_decode($data,true);
             // recupérer ..
             // recupérer les dates.
              return $name_list;

         }


         public function getSommelive($id)
         {
              // recupérer le live .......
              $code_live = $this->getdatelivecode($id);
              // recupérer la date
              $date_live = $this->getDate();
              // recupérer les borne de recupération du montant.
              $date1 = $date_live;
              $date2 = date("Y-m-d H:i:s", strtotime($date1.'+ 1 days'));

              $dat = date("d/m/Y", strtotime($date1));

              $datex = date("d/m/Y", strtotime($date1.'+ 1 days'));

              $array_date[] = $dat;
              $array_date[] =$datex;

               $orders = DB::table('ordersambassadricecustoms')
               ->select('datet','somme',DB::raw('SUM(somme) as total'))
               ->where('code_promo','=',$code_live)
               ->whereIn('datet',$array_date)
               ->groupBy('datet','somme')
               ->get();

              // recupérer les montant de ce intervalle.
              //$orders = Ordersambassadricecustom::where('code_promo','=',$code_live)->whereBetween('created_at', [$date1, $date2])->get();
              $name_list = json_encode($orders);
              $name_lists = json_decode($orders,true);
              $data_montant = [];

              foreach($name_lists as $val){
                $data_montant[] =$val['total'];
              }
              // 
              $commission = array_sum($data_montant);// somme des montants.
               
              $id="";
              $date="";
              if($commission > 600){
                $reste_montant = $commission - 600;
                // chercher le dernier id de la table ordercustom et forcer ce dernier à 600.
              
                $posts = Ordersambassadricecustom::where('code_promo','=',$code_live)->whereBetween('created_at', [$date1, $date2])->get();
                $name_list = json_encode($posts);
                $name_lists = json_decode($posts,true);
            
                foreach($name_lists as $val){
                  $array_somme[] = $val['somme'];
                 $array_ids[] =$val['id'];
               }

                 $last_montant[] =  end($array_somme);
                 $diff_aff = array_diff($array_somme,$last_montant);
                 $sommes =  600.0000000000 - array_sum($diff_aff);// forcer a 600 euro.
                  $somme = $sommes;
                  // forcer la dernier ligne à cette valeur.......
                 if($somme < 0){
                   $somme=0.0000000000000;
                 }
                  $last_id = end($array_ids);
                  
                 Ordersambassadricecustom::where('id', $last_id)->update(['somme'=>$somme]);

               }

               // si le montant est supérieur à 600 euro aller chercher le dernier id de la table et faire un update sur la difference
               $commission_montant = number_format($commission,2,".","");
               // nombre de vente réalisé 
               $nombre = count($name_lists);
               // nombre....
               $this->setNombre($nombre);

              return $commission_montant;
            

         }


         public function getdatelivesomme()
         {
            // recupérer la somme en groupant la date et les code live.
            // recupérer les dates et code live
             $this->gethistorique();
             $date_recette = $this->getDates();// les dates du lendemain qui ont composé la recette.
             $array_live = $this->getCodelive();

             $code_eleve =  Ambassadricecustomer::select('code_promo')->get()->toArray();
             $data_code =[];

             foreach($code_eleve as $vals){
               $data_code[] = $vals['code_promo'];
             }

              // recupérer les lives...
              $orders = DB::table('ordersambassadricecustoms')
             ->select('datet',DB::raw('SUM(total_ht) as total'))
             ->whereIn('code_promo',$array_live)
             ->whereIn('datet',$date_recette)
             ->groupBy('datet')
             ->get();

             
               $name_list = json_encode($orders);
               $name_list = json_decode($orders,true);
              // recupeére dans l'autre tableau de restriction 
              $orders_bis = DB::table('orderrestrictions')
              ->select('datet',DB::raw('SUM(total_ht) as total'))
              ->whereIn('code_promo',$array_live)
              ->whereIn('datet',$date_recette)
              ->groupBy('datet')
              ->get();

              $name_liss = json_encode($orders_bis);
              $name_liss = json_decode($orders_bis,true);
              
               $y = array_merge($name_list,$name_liss);

              // recupérer dans la table de restriction
              $result = array_reduce($y,function($carry,$item){
                if(!isset($carry[$item['datet']])){ 
                  $carry[$item['datet']] = ['datet'=>$item['datet'],'total'=>$item['total']]; 
              } else { 
                  $carry[$item['datet']]['total'] += $item['total']; 
              } 
              return $carry; 
          });

              // recupérer les lives...
              $orders_eleve = DB::table('ordersambassadricecustoms')
             ->select('datet',DB::raw('SUM(total_ht) as total'))
             ->whereIn('code_promo',$data_code)
             ->whereIn('datet',$date_recette)
             ->groupBy('datet')
             ->get();

             
              $name_lists = json_encode($orders_eleve);
              $name_lists = json_decode($orders_eleve,true);

               $array_result = [];// crée un jeu de donné  format de date souhaité pour les lives
               $array_code_result =[];// crée de jeu de données  pour les codes élèves.

             foreach($result as $values){
                $chaine_date  = $values['datet'];
                $chaine =  explode('/',$values['datet']);
                $date_true =  $chaine[2].'-'.$chaine[1].'-'.$chaine[0];
                $chaine_key  = $values['total'].','.$date_true;
                $array_result[$chaine_key] = $date_true;
             }

             foreach($name_lists as $valu){
                 $chaines = explode('/',$valu['datet']);
                 $date_trues =  $chaines[2].'-'.$chaines[1].'-'.$chaines[0];
                 $chaine_keys  = $valu['total'].','.$date_trues;
                 $array_code_result[$chaine_keys] = $date_trues;
             }

              // recupérer des données codes........
               $this->setCodes($array_code_result);
               return $array_result;

         }

         public function getdatechecklive($date)
         {
              // recupérer les ambassadrice qui ont produit le live.
              $code=12;
              $data =  DB::table('ordersambassadricecustoms')->select('code_promo','total_ht')->where('datet','=',$date)->where('code_live','=',$code)->get();
              $name_list = json_encode($data);
              $name_list = json_decode($data,true);
              // recupérer ..
              // recupérer les dates.
              // regrouper la somme avec les codes live.
               $result = array_reduce($name_list,function($carry,$item){
                if(!isset($carry[$item['code_promo']])){ 
                  $carry[$item['code_promo']] = ['code_promo'=>$item['code_promo'],'total_ht'=>$item['total_ht']]; 
              } else { 
                  $carry[$item['code_promo']]['total_ht'] += $item['total_ht']; 
              } 
              return $carry; 
          });

              // créer un tableau de données....
              $array_result =[];
              foreach($result as $valu){
                  $array_result[] =[
                   'data'=> $valu['code_promo'].' : '.$valu['total_ht'].' €'
                 ];
              }

              return $array_result;

              //return $name_list;
          }

         public function getdatecheckcode($date){
             // recupérer les ambassadrice qui ont produit le code .
             $code=11;
             $data =  DB::table('ordersambassadricecustoms')->select('code_promo','somme')->where('datet','=',$date)->where('code_live','=',$code)->get();
             $name_list = json_encode($data);
             $name_list = json_decode($data,true);
             // recupérer ..
             // recupérer les dates.
            
              return $name_list;

         }


         public function getcustomers($id,$code){
             
             $data =  DB::table('ordersambassadricecustoms')->select('email')->where('id_ambassadrice','=',$id)->where('code_live','=',$code)->get();
             $name_list = json_encode($data);
             $name_list = json_decode($data,true);
             $list_email =[];

              foreach($name_list as $valu){
              $list_email[] =$valu['email'];

            }

           // recupérer toutes les codes postaux de ces clients dans la table tiers.
            $datas =  DB::table('tiers')->select('zip_code')
            ->whereIn('email',$list_email)
            ->get();
             $name_lists = json_encode($datas);
             $name_lists = json_decode($datas,true);
             $zip_code =[];

             foreach($name_lists as $val){
              if($val['zip_code']!=""){
                $replaced = str_replace(' ', '', $val['zip_code']);
                $zip_code[] = $replaced;
              }
             }
           
               // compter les valeurs.
                $array_zip = array_count_values($zip_code);
                // construire un table;au de données de code postaux avec departement.
                $result_zip_code =[];
                $code_zip_result =[];

               foreach($array_zip as $key => $valu){
                    $chaine = $valu.','.$key;
                    $result_zip_code[$chaine] = $key;
                    $code_zip_result[] = $key;
               }

               // ciblés les codes promo d'ou proviennt les client de l'ambassadrice.
               $donnees =  DB::table('cities')->select('department_code','zip_code')
               ->whereIn('zip_code',$code_zip_result)
               ->get();
               $name_liss = json_encode($donnees);
               $name_liss = json_decode($donnees,true);
                
               // crée des données et les formater 
               $result_departement =[];
               foreach($name_liss as $valis){
                     $result_departement[] = (int)$valis['department_code'];
               }
                // grouper en fonction des codes postaux pour les departement
                $resultat_final_departement= array_count_values($result_departement);
                 $array_depart_search = array_flip($resultat_final_departement);// remplacer les key par la valeur.
                
                //dump($array_depart_search);
                // recupérer le code
                 // recupérer les departement est les liée
                  // ciblés les codes promo d'ou proviennt les client de l'ambassadrice.
                 $donnes =  DB::table('departments')->select('code','name')->get();
                 $name_li = json_encode($donnes);
                 $name_li = json_decode($donnes,true);

                 $array_deparments = [];

                 foreach($name_li as $valc){
                    $array_deparments[$valc['name']] = (int)$valc['code'];

                 }

                // dd($array_deparments);
                 $result_csv =[];
                   foreach($array_deparments as $key =>$valus){
                        $name_departement = array_search($valus,$array_deparments);
                        $nombre_client = array_search($valus,$array_depart_search);
                        if($nombre_client!=false)
                          $result_csv[] =[
                              'Departements' => $key,
                              'nombre_ventes' => $nombre_client
                            ];
                  }
                
                    $this->csv->createcsvcustomers($result_csv);
 
         }




         public function getpointeleve()
         {
              // recupérer le nombre de code eléve créer par mois 
              $is_admin =2;
              $code_live =11;
              $orders = DB::table('ordersambassadricecustoms')
             ->select('id_ambassadrice',DB::raw('SUM(code_live) as total'))
             ->where('is_admin','=',$is_admin)
             ->where('code_live','=',$code_live)
             ->groupBy('id_ambassadrice','code_mois','annee')
             ->get();

         }

         public function getId(){
             // recupérer
             $years = date('Y');
             $mois = date('m');
             $jour = date('d');
             //fixer jour..construire mes bornes
             $date_actuel ="$years-$mois-$jour 08:00:00";
             $resultats = DB::table('historique_panier_lives')->select('code_live','date_live')->where('date_live', '>', $date_actuel)->get();
             //
             $name_list = json_encode($resultats);
             $name_list = json_decode($name_list,true);

             dd($resultats);

             // 
               return $name_list;
          
          }

         public function getmois($moi)
         {
    
             if($moi=="1"){
               $mo ="Janvier";
             }
    
              if($moi=="2"){
                 $mo="février";
    
             }
    
              if($moi=="3"){
                 $mo ="Mars";
              }
    
             if($moi=="4"){
                  $mo="Avril";
    
             }
    
              if($moi=="5"){
                $mo ="Mai";
    
             }
    
              if($moi=="6"){
                  $mo="Juin";
    
             }
    
             if($moi=="7"){
                $mo="Juillet";
    
             }
    
              if($moi=="8"){
                $mo="Aout";
    
             }
    
             if($moi=="9"){
                 $mo="septembre";
              }
    
              if($moi=="10"){
                  $mo="Octobre";
               }
    
             if($moi=="11") {
                $mo="Novembre";
    
             }
    
              if($moi=="12"){
                $mo="Déc";
    
             }
    
             return $mo;
    
         }
      
    }
    
    