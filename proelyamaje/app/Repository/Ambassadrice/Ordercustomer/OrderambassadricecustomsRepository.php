<?php

namespace App\Repository\Ambassadrice\Ordercustomer;

use Hash;
use Exception;
use Carbon\Carbon;
use App\Models\Orderrefunded;
use App\Models\Productpromotion;
use Illuminate\Support\Facades\DB;
use App\Models\Ambassadrice\Notification;
use App\Models\Ambassadrice\Promotionsum;
use App\Http\Service\CallApi\AmbassadriceCustoms;
use App\Models\Ambassadrice\Cardscustomercontrol;
use App\Models\Ambassadrice\Ordersambassadricecustom;
use App\Models\Ambassadrice\Orderrestriction;
use App\Repository\Ambassadrice\CardscustomercontrolsRepository;

class OrderambassadricecustomsRepository implements OrderambassadricecustomsInterface
{
     
     private $model;
    private $apiamba;
    private $data =[];
    private $some =[];
    private $charts =[];
    private $chart = [];
    private $listpdf = [];
    private $countlive =[];
    private $counteleve =[];
    private $ids= [];
    private $code; // restriction le code live pendant les mardis code live.
    private $idlive; 
    private $codes =[]; // restriction des codes live a restreintre sur les 600 euros.
    private $cards;

    private $totalsum;// somme total généré(chiffre d'affaire total)

    private $totalsumanne;// somme total generé en fonction de l'année.
    private $someleve;// montant somme.
    private $somelive;// montant live.
    private $nombrelive;
    private $nombreleve;

    public function __construct(Ordersambassadricecustom $model, 
    AmbassadriceCustoms $apiamba,
     CardscustomercontrolsRepository $cards)
    {
      $this->model = $model;
      $this->apiamba = $apiamba;
       $this->cards = $cards;
    }
    
     public function getdataAll($id)
     {
        $date = date('Y-m-d');
         $datet = explode('-',$date);
         $code_mois = (int)$datet[1];
         $code_annee = (int)$datet[0];
        // recupérer id_commande conteant un code promo amabassadrice dans un tableau
         $name_list = DB::table('ordersambassadricecustoms')->select('code_live')->where('id_ambassadrice','=',$id)->where('code_mois','=',$code_mois)->where('annee','=',$code_annee)->get();
         // transformer les retour objets en tableau
        $name_list = json_encode($name_list);
        $name_list = json_decode($name_list,true);
        
        $array_live =[];
        $array_eleve =[];
        
        foreach($name_list as $values) {
            if($values['code_live']==12) {
              $array_live[] = $values['code_live'];
            }
            
            if($values['code_live']==11){
                $array_eleve[]= $values['code_live'];
            }
        }
        // recupérer les données des ventes live et ventes code élève
        $this->setCountlive($array_live);
        $this->setCounteleve($array_eleve);
        
        return $name_list;
        
    }
    
    public function getCustomerAll(){
     return Ordersambassadricecustom::orderBy('id', 'desc')->get();
    }
    
    public function getCustomerId($id){
        $code_live =12;
        $mini =0;
        return DB::table('ordersambassadricecustoms')->where('id_ambassadrice', '=', $id)->where('code_live','=',$code_live)->where('somme','>',$mini)->orderBy('id', 'desc')->paginate(100);
     }
     
     
     public function getCustomerIdsame($id,$customer){
         $code_live =12;
         return DB::table('ordersambassadricecustoms')->where('id_ambassadrice', '=', $id)->where('code_live','=',$code_live)->where('somme','>',$mini)->where('customer', 'like','%'.$customer.'%')->orderBy('id', 'desc')->paginate(100);;
       }
     
     
     public function getAlllistorders($id){
         $date = date('Y-m-d');
         $datet = explode('-',$date);
         $code_mois = (int)$datet[1];
         $code_annee = (int)$datet[0];
         return DB::table('ordersambassadricecustoms')->where('id_ambassadrice', '=', $id)->where('code_mois','=',$code_mois)->orderBy('id', 'desc')->paginate(70);
     }

     public function getAlllistordersThisMonth($id)  {
         $date = date('Y-m-d');
         $datet = explode('-',$date);
         $code_mois = (int)$datet[1];
         $code_annee = (int)$datet[0];
         return DB::table('ordersambassadricecustoms')->where('id_ambassadrice', '=', $id)->where('id_ambassadrice','=',$id)->where('code_mois','=',$code_mois)->where('annee','=',$code_annee)->get();
     }
     
     
      public function getCustomerIds($id)
      {
        $code_live =11;
        $date = date('Y-m-d');
         $datet = explode('-',$date);
         $code_mois = (int)$datet[1];
        return Ordersambassadricecustom::where('id_ambassadrice', '=', $id)->where('code_live','=',$code_live)->orderBy('id', 'desc')->paginate(50);
     }
     
     
     public function getCodepromoorders(string $code) {
        $result = DB::table('ordersamabassadricecustoms')->where('code_promo', 'like','%'.$code.'%')->get();
        // transformer les retour objets en tableau
        $name_list = json_encode($result);
        $name_lists = json_decode($result,true);
         return $name_lists;
         
     }
     
      public function getPointdata($id){
         $data = DB::table('ordersambassadricecustoms')
                 ->select('somme', DB::raw('count(*) as total'))
                 ->groupBy('id_ambssadrice')
                 ->get();
              // transformer les retour objets en tableau
           $name_list = json_encode($data);
            $name_lists = json_decode($data,true);
        
        return $name_lists;    
            
      }
      
       public function getDataPdf($id,$code,$annee){
          $moyen_somme =0;
          $customer = DB::table('ordersambassadricecustoms')
                 ->join('users', 'users.id', '=', 'ordersambassadricecustoms.id_ambassadrice')
                 ->where('ordersambassadricecustoms.somme','>' ,$moyen_somme)
                  ->where('ordersambassadricecustoms.code_mois', $code)
                   ->where('ordersambassadricecustoms.annee', $annee)
                  
                 ->where('users.id', $id)
                ->get();
                
           // transformer les retour objets en tableau
          $list = json_encode($customer);
          $lists = json_decode($customer,true);
        
        
         return $lists;
      }


      public function getchiffreamba($mois,$annee)
      {
           $date = date('Y-m-d');
            // recupérer id_commande conteant un code promo amabassadrice dans un tableau
           $name_list = DB::table('ordersambassadricecustoms')->select('total_ht')->where('code_mois','=',$mois)->where('annee','=',$annee)->get();
           // transformer les retour objets en tableau
           $name_list = json_encode($name_list);
           $name_list = json_decode($name_list,true);
           $somme_1 =[];
          foreach($name_list as $val){
             $somme_1[] = $val['total_ht'];
          }

          $name_lis = DB::table('orderrestrictions')->select('total_ht')->where('code_mois','=',$mois)->where('annee','=',$annee)->get();
          // transformer les retour objets en tableau
           $name_lists = json_encode($name_lis);
           $name_lists = json_decode($name_lis,true);
           $somme_2 =[];

           foreach($name_lists as $vals){
             $somme_2[] = $vals['total_ht'];
           }

              $array_result = array_merge($somme_1,$somme_2);
              $total_ht = array_sum($array_result);
              $total = number_format($total_ht, 2,',', '');

              return $total;
        }
     
    
   /**
   * @return array
    */
   public function getIds(): array
   {
      return $this->ids;
   }
   
   
   public function setIds(array $ids)
   {
     $this->ids = $ids;
     return $this;
   }
 
  
  
    public function getTotalsum()
    {
       return $this->totalsum;
    }
    
    
    public function setTotalsum($totalsum)
    {
      $this->totalsum = $totalsum;
      return $this;
    }
  

    public function getTotalsumannee()
    {
       return $this->totalsumannee;
    }
    
    
    public function setTotalsumannee($totalsumannee)
    {
      $this->totalsumannee = $totalsumannee;
      return $this;
    }
  

 
  /**
   * @return array
    */
   public function getCountlive(): array
   {
      return $this->countlive;
   }
   
   
   public function setCountlive(array $countlive)
   {
     $this->countlive = $countlive;
    return $this;
   }
 
 
  /**
   * @return array
    */
   public function getCounteleve(): array
   {
      return $this->counteleve;
   }
   
   
   public function setCounteleve(array $counteleve)
   {
     $this->counteleve = $counteleve;
    return $this;
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
   public function getSome(): array
   {
      return $this->some;
   }
   
   
   public function setSome(array $some)
   {
     $this->some = $some;
    return $this;
   }
   
   
  
      /**
   * @return array
    */
   public function getCharts(): array
   {
      return $this->charts;
   }
   
   
   public function setCharts(array $charts)
   {
     $this->charts = $charts;
    return $this;
   }
  
  
       /**
   * @return array
    */
   public function getChart(): array
   {
      return $this->chart;
   }
   
   
   public function setChart(array $chart)
   {
     $this->chart = $chart;
    return $this;
   }


    
    public function getCode()
    {
       return $this->code;
    }
    
    
    public function setCode($code)
    {
      $this->code = $code;
       return $this;
    }


    public function getIdlive()
    {
       return $this->idlive;
    }
    
    
    public function setIdlive($idlive)
    {
       $this->idlive = $idlive;
       return $this;
    }

    public function getNombrelive()
    {
       return $this->nombrelive;
    }
    
    
    public function setNombrelive($nombrelive)
    {
        $this->nombrelive = $nombrelive;
        return $this;
    }


    public function getNombreleve()
    {
       return $this->nombreleve;
    }
    
    
    public function setNombreleve($nombreleve)
    {
        $this->nombreleve = $nombreleve;
        return $this;
    }



    /**
   * @return array
    */
   public function getCodes(): array
   {
      return $this->codes;
   }
   
   
   public function setCodes(array $codes)
   {
     $this->codes = $codes;
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
   

    public function create(array $attribute)
    {
       return $this->model->create($attribute);
    }

    public function getSomme()
    {
    
    
    }
    
    
    public function getDataorder($id_commande)
    {
          $name_list =  DB::table('ordersambassadricecustoms')->select('id_commande','code_promo','somme','id_ambassadrice','code_mois','annee','customer','datet','email','telephone')->where('id_commande',$id_commande)->first();
          $name_list = json_encode($name_list);
          $name_list = json_decode($name_list,true);
           return $name_list;
         
    }

    public function getchiffreannee($annee)
    {
           
           // recupérer les chiffres d'affaire selon l'année.......
            $name_list =  DB::table('ordersambassadricecustoms')->select('somme','is_admin','status','total_ht')->where('annee','=',$annee)->get();
            $name_list = json_encode($name_list);
            $name_list = json_decode($name_list,true);
             $somme_choix =[];
             foreach($name_list as $values){
              if($values['is_admin']==2){
                if($values['status']!="refunded"){
                $somme_choix[] = $values['total_ht'];
              }
           }
            
        }
        


        $name_lists =  DB::table('orderrestrictions')->select('somme','is_admin','status','total_ht')->where('annee','=',$annee)->get();
        $name_list = json_encode($name_lists);
        $name_listss = json_decode($name_list,true);
         $somme_choix1 =[];
         foreach($name_listss as $valus){
           if($valus['status']!="refunded"){
            $somme_choix1[] = $valus['total_ht'];
          }
         }
         
         $somme1 = array_sum($somme_choix1);
         
             
            $list_somme = array_merge($somme_choix+$somme_choix1);
            $somme = array_sum($list_somme);
            
            $somme_final = $somme1+$somme;
            
             $somme_t = number_format($somme_final,2,".","");
           
            return $somme_t;
    }


    public function getrestriction()
    {
        $actif =2; // faut que le live sois activé...
        $name_list =  DB::table('choix_panier_lives')->select('ext','date_live','code_live','date_fix_live','id_live')->get();
        $name_list = json_encode($name_list);
        $name_list = json_decode($name_list,true);
        $data_txt = [];// pendant le les bornes du live.
        $data_date =[];// restreinte des dates de recupération
        $code_restriction =[];
        $data_commission =[];
        
        $date_day = date('Y-m-d H:i:s');
        $lot_date = [];// recupérer toutes les date susceptible d'excuter un live en format d/m/Y;
         foreach($name_list as $valu){
           
           if($valu['date_fix_live']!=""){
             $date_add_day  = date("Y-m-d H:i:s", strtotime($valu['date_fix_live'].'+ 1 days'));
             // recupérer les live declenché et qui continue.
              $date_add_day1  = date("Y-m-d H:i:s", strtotime($valu['date_fix_live'].'+ 4 days')); // INTERVALLE recupération des orders dans le service fixé au borne -2 +2

              // recupérer des intervalles de bornes utiles pour les live à restreinte.
              // lorsque la date courant est inférieur à celle du live .// utile .
              if($date_day < $date_add_day1){
                   $chaine_date = explode(' ',$valu['date_fix_live']);
                   // les bornes de recupération de commision des live logique.
                   $date_add = date("d/m/Y", strtotime($chaine_date[0]));
                   $date_add1 = date("d/m/Y", strtotime($chaine_date[0].'+ 1 days'));
                   $lot_date[] = $date_add;
                   $lot_date[] = $date_add1;
                   $code_restriction[] = $valu['code_live'];
                }
            }

            // recupérer idlive
              $this->setIdlive($valu['id_live']);

         }
             
                 $date_lot = array_unique($lot_date); // les dates d'excution de live susceptible de gérer les commission.
                  // vider la petite table flottante
                 DB::table('commissions')->truncate();
                // recupérer les commission des codes concernée lives...
                $orders = DB::table('ordersambassadricecustoms')
               ->select('datet','code_promo',DB::raw('SUM(somme) as total'))
               ->whereIn('code_promo',$code_restriction)
               ->whereIn('datet',$date_lot)
               ->groupBy('datet','code_promo')
               ->get();
               // recupérer les commisison provenant de ce jeu de données de codelive et date.
                 $order_list = json_encode($orders);
                $order_lists = json_decode($orders,true);
                if(count($order_lists)!=0){
                foreach($order_lists as $values){
                    
                  $data_commission[] =[
                     'datet' => $values['datet'].','.$values['code_promo'],// un index pour unicité.
                     'code_promo'=> $values['code_promo'],
                     'total'=> $values['total']
                  ];
                }
                

                 // insert dans la bdd flottante qui calculer la somme de commisison liée au code.
                DB::table('commissions')->insert($data_commission);

              }
                 // recupérer les montant liée au code promo pour gérer la restriction sur le panel de date.
                 $data = DB::table('commissions')
                 ->select('code_promo', DB::raw('SUM(total) as totals'))
                 ->groupBy('code_promo')
                 ->get();

                 $order_list = json_encode($data);
                 $order_list = json_decode($data,true);

                 // ecrire les restriction d'intervalle de montant et recupérer le retours des réponses.
                  // recupérer les codes live selon elles.
                  $codelives = [];
                 foreach($order_list as $val){
                     if($val['totals'] > 599) {
                       // intervalle de restricition de zone.
                       $codelives[] = $val['code_promo'];
                       // création du'une zone tampon à forcer dans historique 600...
                       // bloquer  l'insert des commande à ce niveau.
                        $this->setCodes($codelives);
                   }
             }
                 
              $result = $this->getCodes();
             return $result;
      }
    
    
    
    public function getDataIdcodeorders(): array
    {
        // recupérer id_commande conteant un code promo amabassadrice dans un tableau
         $name_list = DB::table('ordersambassadricecustoms')->select('id_commande','code_promo','somme','total_ht','id_ambassadrice','code_mois','annee','status','is_admin')->get();
         // transformer les retour objets en tableau
         $name_list = json_encode($name_list);
         $name_list = json_decode($name_list,true);
         // recupérer dans unn tableau les données pour id_commande
         // recupérer la somme des commande bloquer les mardi pendant les live.
         $sum = Orderrestriction::sum('somme');
         $donnees = [];
         $array_codepromo = [];
         $array_somme = [];
         $array_id = [];
         $array_ids =[];
         $somme_total =[];

        foreach($name_list as $key => $values) {
             $donnees[] = $values['id_commande'];
              $array_codepromo[] = $values['code_promo'];
              $array_somme [] = $values['somme'];
              $array_ids[$values['id_commande']] = $key;
              
              $array_id []= array(
                     $values['id_ambassadrice']=>$values['somme'].','.$values['id_commande'].','.$values['code_mois'].','.$values['annee']
                  );
              
                   if($values['is_admin']==2){
                       $somme_total[] = $values['total_ht'];

                   }
        }
        
        $somme_t = array_sum($somme_total)+$sum;
        $somme_tx =  $somme_t + $somme_t*20/100;
        // renvoi un tableau array de valeurs
         $this->setChart($array_id);
         $this->setData($array_codepromo);
         $this->setSome($array_somme);
         $this->setIds($array_ids);
         //
         $this->setTotalsum($somme_t);
         
         return $donnees;
         
    }
    
    
    public function getcountordersyears()
    {
        // recupérer id_commande conteant un code promo amabassadrice dans un tableau
         $date = date('Y-m-d');// date courante
         $datet = explode('-',$date);
         $datet1 = $datet[1];
         $code_mois = $datet1;
         $code_annee = $datet[0];
         $name_list = DB::table('ordersambassadricecustoms')->select('code_promo')->where('annee','=',$code_annee)->get();
         // transformer les retour objets en tableau
        $name_list = json_encode($name_list);
        $name_list = json_decode($name_list,true);
        
        
        return $name_list;
        
    }
    
    
    public function getSommemois($is_admin)
    {
        // recupérer id_commande conteant un code promo amabassadrice dans un tableau
        // recupérer la somme des en cours pour ambassadrice du mois en cours
        $date = date('Y-m-d');// date courante
        $datet = explode('-',$date);
        $datet1 = $datet[1];
        $code_mois = $datet1;
        $code_annee = $datet[0];
    
         $code_mois = (int)$code_mois;
         $name_list = Ordersambassadricecustom::select('status','somme')->where('code_mois','=',$code_mois)->where('annee','=',$code_annee)->where('is_admin','=',$is_admin)->get();
         // transformer les retour objets en tableau
        $name_list = json_encode($name_list);
        $name_list = json_decode($name_list,true);
        // recupérer dans unn tableau les données pour id_commande
        return $name_list;
        
        
    }
    
    
    
    public function getSommeannee($is_admin)
    {
        // recupérer id_commande conteant un code promo amabassadrice dans un tableau
        // recupérer la somme des en cours pour ambassadrice du mois en cours..
           $date = date('Y-m-d');// date courante
           $datet = explode('-',$date);
           $datet1 = $datet[1];
           $code_mois = $datet1;
           $code_annee = $datet[0];
    
           $code_mois = (int)$code_mois;
           $name_list = Ordersambassadricecustom::select('status','somme')->where('annee','=',$code_annee)->where('is_admin','=',$is_admin)->get();
            // transformer les retour objets en tableau
           $name_list = json_encode($name_list);
           $name_list = json_decode($name_list,true);
            // recupérer dans unn tableau les données pour id_commande
            $array_somme = [];
          foreach($name_list as $k => $values) {
           // recupérer les somme different du status refunded
           if($values['status']!="refunded"){
             $array_somme[]= $values['somme'];
             }
        }
          $nombre = array_sum($array_somme);
          return $nombre;
        
    }
    
    
    
    public function getCountAll($id)
    {
        // recupérer toutes les enregsitrements 
        //obtenir le nombre de ventes réalisées par une amabadrice
        $datas =  DB::table('ordersambassadricecustoms')->where('id_ambassadrice', '=', $id)->get();
        // transformer les retour objets en tableau
        $name_list = json_encode($datas);
        $name_list = json_decode($datas,true);
        
        return $name_list;
    }
    
    
    public function getCountorders($id)
    {
        
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
     
        $jour = date('d');
       //fixer jour..construire mes bornes
        $date_actuel ="$years-$mois-01 00:00";
        $date_ms = "$years-$mx-01 00:00";
        
   

        $code = Auth()->user()->code_live;
        $id = Auth()->user()->id;
        
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
          $datexs = date("d/m/Y", strtotime($val['date_live'].'+ 2 days'));
          $chaine = $dat.','.$val['id_live'];
          $chaine2 = $datex.','.$val['id_live'];
          $array_group[$chaine] = $dat;
          $array_group[$chaine2] = $datex;
          $array_group[$chaine] = $dat;
         
          $list_detail[$dat] = $val['id_live'];
             // recupérer toutes les date de live +1 qui va servir de facturer dans dolibar et recupérer les somme de live dans les recette
       }
       
         
          // recupérer les commande et les associés...
          $data =  DB::table('ordersambassadricecustoms')->select('id','datet','somme','id_ambassadrice','code_live')->where('id_ambassadrice','=',$id)->where('code_mois','=',$mois)->where('annee','=',$years)->get();
          $name_list = json_encode($data);
          $name_list = json_decode($data,true);

        
         

         $nombre_vente = count($name_list);
          
         $array_result_data =[]; // traiter les sous pour les lives
          $array_result_data1 =[];// recupérer les sous pour les eléves
          $result= [];
         foreach($name_list as $key => $vals){
           if($vals['code_live']==12){
             
           $date_value =  date("Y-m-d", strtotime($vals['datet']));
           if(count($array_group)!=0){
           $chaine_data  = array_search($vals['datet'],$array_group);
           
           if($chaine_data!=false){
             $data_r = explode('/',$vals['datet']);
               
                $chaine_datas = explode(',',$chaine_data);
                    $array_result_data[]= [
                    'id_live'=>$chaine_datas[1],
                    'somme' => $vals['somme'],
                    'date' => $vals['datet']
                  ];
               }
              
           }
              
               
              }
                else{
                 $array_result_data1[] = $vals['somme'];// somme mensuels les codes élève.
               }


             // faire un group by  et sommer la somme  en fonction de l'id de live.
              if(count($array_result_data)!=0){
                $result = array_reduce($array_result_data,function($carry,$item){
               if(!isset($carry[$item['id_live']])){ 
                 $carry[$item['id_live']] = ['id_live'=>$item['id_live'],'somme'=>$item['somme']]; 
                } else { 
                 $carry[$item['id_live']]['somme'] += $item['somme']; 
              } 
                return $carry; 
               });
            }
                // traiter les live  pour fixer a 600 euro au cas ou celui ci dépasse.
            }
             // traiter au maxi les 4 live pour les montant.
                $result_montant_live=[];// montant des lives généré au cours du mois.
               
                if(count($array_result_data)!=0){
                 foreach($result as $values){
                    if($values['somme']< 600){
                      $val_x = $values['somme'];
                   }else{
                      $val_x = 600;
                  }
                   $result_montant_live[] = $val_x;
               }
             }
             else{
               $result_montant_live =[];
            }

              // nombre de vente eleve
              $nombre_v_eleve = count($array_result_data1);
              $this->setNombreleve($nombre_v_eleve);

              // nombre de live
              $nombre_v_live = count($array_result_data);
              $this->setNombrelive($nombre_v_live);

              $somme_live = array_sum($result_montant_live);
              $somme_eleve = array_sum($array_result_data1);
              $this->setSomeleve($somme_eleve);
              $this->setSomelive($somme_live);
               // recupere la somme ici.
               $resultat_somme = number_format($somme_live+$somme_eleve,2,".","");// renvoie la valeur.
              return $resultat_somme;
            
     }

     public function getChiffreambamonths($id,$code_live,$mois,$years){

       // construire les bornes souhaites.. 
       if($mois==12){
          $years1 = $years+1;
          $mois_true = "01";
       }
       else{
           $years1 = $years;
           $mois1 = $mois+1;
        }
       
        $mmt = (int)$mois;
        if($mois!=12) {
            if($mmt > 9){
            $mois_true = $mois;
           }else{
             $mts = $mmt+1;
              $mois_true ="0$mts";
          }
        }

       
       $borne_inf = "$years-$mois-01 00:00";
       $borne_sup ="$years1-$mois_true-01 00:00";
      
        //$code = Auth->user()->codelive;
        $name_list = DB::table('historique_panier_lives')
       ->select('code_live','id_live','date_live')
      ->where('code_live','=',$code_live)
      ->whereBetween('date_live', [$borne_inf, $borne_sup])
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
        $data =  DB::table('ordersambassadricecustoms')->select('datet','somme','id_ambassadrice','code_live')->where('id_ambassadrice','=',$id)->where('code_mois','=',$mois)->where('annee','=',$years)->get();
        $name_list = json_encode($data);
        $name_list = json_decode($data,true);

        $nombre_vente = count($name_list);
        $array_result_data =[]; // traiter les sous pour les lives
        $array_result_data1 =[];// recupérer les sous pour les eléves
        $result= [];
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
            if(count($array_result_data)!=0){
              $result = array_reduce($array_result_data,function($carry,$item){
             if(!isset($carry[$item['id_live']])){ 
               $carry[$item['id_live']] = ['id_live'=>$item['id_live'],'somme'=>$item['somme']]; 
              } else { 
               $carry[$item['id_live']]['somme'] += $item['somme']; 
            } 
              return $carry; 
             });
          }
              // traiter les live  pour fixer a 600 euro au cas ou celui ci dépasse.
          }
           // traiter au maxi les 4 live pour les montant.
              $result_montant_live=[];// montant des lives généré au cours du mois.
             
              if(count($array_result_data)!=0){
               foreach($result as $values){
                  if($values['somme']< 600){
                    $val_x = $values['somme'];
                 }else{
                    $val_x = 600;
                }
                 $result_montant_live[] = $val_x;
             }
           }
           else{
             $result_montant_live =[];
          }

            // nombre de vente eleve
            $nombre_v_eleve = count($array_result_data1);
            $this->setNombreleve($nombre_v_eleve);

            // nombre de live
            $nombre_v_live = count($array_result_data);
            $this->setNombrelive($nombre_v_live);

            $somme_live = array_sum($result_montant_live);
            $somme_eleve = array_sum($array_result_data1);
            $this->setSomeleve($somme_eleve);
            $this->setSomelive($somme_live);
             // recupere la somme ici.
             $resultat_somme = number_format($somme_live+$somme_eleve,2,".","");// renvoie la valeur.
            return $resultat_somme;

      }
     

    public function getcountorderss($id){
          
          // recupère la date actuel en cours
           $date = date('Y-m-d');
           // recupérer le mot en cours
           $date1 = explode('-',$date);
           $code_mois  = $date1[1];
           $code_annee = (int)$date1[0];
           $code_mois1 = (int)$code_mois;
           //obtenir le nombre de ventes réalisées par une amabadrice
           $data =  DB::table('ordersambassadricecustoms')->where('id_ambassadrice', '=', $id)
           ->where('code_mois', '=', $code_mois1)->where('annee','=',$code_annee)
           ->get();
            // transformer les retour objets en tableau
            $name_list = json_encode($data);
            $name_list = json_decode($data,true);
            // recupére les code_promo
            $array_somme = [];
           //cout de gain pour l'ambassadrice
            $array_montant = [];
           foreach($name_list as $valx){
            // recupérer la somme exclus le status refunded
            if($valx['status']!="refunded"){
               $array_somme[] = $valx['somme'];
            }
        }
         // renvoyer de la somme
          $sommes = array_sum($array_somme);
          // return un nombre
         return $array_somme;
        
      }
    



    
    
     public function updatefacture($id,$mois,$annee)
     {
        
         // recupérer les données des montant 
         //obtenir le nombre de ventes réalisées par une amabadrice
         $data =  DB::table('ordersambassadricecustoms')->where('id_ambassadrice', '=', $id)
        ->where('code_mois', '=', $mois)
        ->where('annee', '=', $annee)
        ->get();
         // transformer les retour objets en tableau
         $name_list = json_encode($data);
         $name_list = json_decode($data,true);
         // somme de la toutes les commabdes
    
         $datas = [];
         foreach($name_list as  $valc){
            if($valc['status']!="refunded") {
              if($valc['status']!="cancelled"){
                $datas[] = $valc['somme'];
                
              }
            }
        }
        
        if(count($datas)==0) {
            $message ="error";
        }
        
        else{
        
            // mettre à jour le montant  la tablea point bilan
             $somme = array_sum($datas);
           DB::table('pointbilans')->where('id_ambassadrice', $id)
           ->where('id_mois','=',$mois)
           ->where('annee','=',$annee)
            ->update(array('somme' => $somme
          
                ));
        
             $message ="success";
            
          } 
          
          return $message;
        
    }
    
    
    
    
    public function updatecodespecifique($code,$somme,$commission)
    {
        DB::table('ordersambassadricecustoms')->where('code_promo', $code)->update([
            'total_ht'=>$somme,
            'commission'=>$commission,
            
           ]);
    }
    
    
    public function getcountcodeleve()
    {
        
        // recuperer les code promo permettant de faire les recherches.
        $code=11;
        $datas =  DB::table('ordersambassadricecustoms')->select('code_promo')->where('code_live','=',$code)->get();
        // recupérer les codes promo créer dans le système
        $terms ="-10";// les code se terminant par 10
        $couns = json_encode($datas);
        $couns = json_decode($datas,true);
        
        // tableau pour recupéerer les code promo souhaiter
        $array_codepromo =[];
        
        foreach($couns as $keys=>$vals){
            $code_promo = substr($vals['code_promo'],-3);
             if($code_promo==$terms) {
                $array_codepromo[]=$vals['code_promo'];
            }
        }
        
        $code_live =11;
         $data = DB::table('ordersambassadricecustoms')
                       ->select(DB::raw('id_ambassadrice, count(*) as ordercode_count'))
                       ->whereIn('code_promo', $array_codepromo)
                       ->where('code_live','=',$code_live)
                       ->groupBy('id_ambassadrice')
                       ->get();
    
        $counts = json_encode($data);
        $counts = json_decode($data,true);
         return $counts;
        
    }
    
    
     public function getdatacodespecifique($code){
        $data =  DB::table('ordersambassadricecustoms')->select('total_ht','commission')->where('code_promo',$code)->get();
         $name_list = json_encode($data);
         $name_lists = json_decode($data,true);
        return $name_lists;
        
    }
    
    
     /**
   * @return array
   */
    public function getSoms(): array
    {
     //recupérer le tableau des somme acquise pour l\'ambassadrice'
       return $this->getSome();
    }
    
    
    
    /**
   * @return array
   */
    public function donnees(): array
    {
     //recupérer les données sous forme de tableau dans la vairable array data les codes promos
       return $this->getData();
    }
    
    
     /**
   * @return array
   */
    public function chart(): array
    {
     //recupérer les données sous forme de tableau dans la vairable array data les codes promos
       return $this->getChart();
    }
    
    
    
   // traiter les produit en promotion.
   public function getAllproductpromotion()
   {
       $list_promotion = Productpromotion::All();
       // traiter le retour sous forme de tableau 
       $list_promo = json_encode($list_promotion);
       $list_promos = json_decode($list_promo,true);// convertir la chaine json en tableau array.
       // recupérer et créer un tableau associative key product_id et values price sale
       $list_promotions = [];
       $lists_promo = [];// recupérer les id de product mis en promotion
       foreach($list_promos as $kj => $values) {
           $list_promotions[$values['id_product']] = $values['id_product'].' , '.$values['sale_price'];
           
           $lists_promo[] = $values['id_product'];
       }
       
       return $lists_promo;
   }
   
   
    
    
    
    public function insert()
    {

        try{
              // recupération
              $data = $this->apiamba->getDataorder();
               // recupération des id_commande 
              $dons = $this->getDataIdcodeorders();
              
              $donss = $this->getIds();// recupérer les clé des ids commande....
              
              //recupérer des code_promo
              $listcodepromo = $this->donnees();
              // insert dans la base de données
             // listes des status valables à  recupérer
              $data_status = array('chrono-delivered','chronopost-pret','prepared-order','processing','completed','lpc_ready_to_ship','lpc_delivered', 'pret-en-magasin','lpc_transit','lpc_anomaly');
             // status other
              $data_status_refunded= array('refunded','cancelled');
             // list des codes indésirable
              $data_code = array('olnails20','aurelie20', 'lounails30','decleor15','ls30','christina30','lounails30','olnails30','caroline30','melissa30','ludivine20','charlene30','pauline30','morgane30','thalass-sun20',
             'ines30','mercimady50','audreyt15','luciet15','fannyb20','julie30','easy base cado','easybase-cado','efab-sophie-m10','cinthia20','marineu20','claude20','soniat15','oiko20','anyssadjedou50');
        
               $code_fem = "fem";
             // si le code commence par fem. met le dans un tableau.
              $array_fidelite = [];
            
              // restriction à 600 euro.
              $data_restriction = $this->getrestriction();// recupérer les codelive daun tableau qui ont plus de 600 euro pendant les lives
           
              $data_ids = $this->cards->getAllidcommande();
              
              // recupérer le tableau des details produit liée à la commande.
              $list_data = $this->apiamba->getPromoproduct();
              $somme_reduit = [];
              $lines_id="";
              // traiter les codes fidelités.
              // recupérer les codes fidelite dans la table code_fidelite_use...
              $datas_fidelite =  DB::table('code_fidelites_use')->select('code')->get();
              $counns = json_encode($datas_fidelite);
              $counns = json_decode($datas_fidelite,true);
              $array_tab = [];
              $array_commande_restriction =[];
 
              foreach($counns as $kc => $valus){
                $array_tab[$valus['code']] =$kc;
             }
                 
             foreach($data as $key => $values) {

                 if(in_array($values['status'], $data_status)) {

                      if(isset($donss[$values['id_commande']]) == false) {

                          if(!in_array($values['code_promo'], $data_code)) {

                            if(strpos($values['code_promo'],$code_fem)==false){

                              if(!in_array($values['code_promo'],$data_restriction)){

                                 
                              
                                  $ordernew = new Ordersambassadricecustom();
                                  $ordernew->datet = $values['date_created'];
                                  $ordernew->code_promo = $values['code_promo'];
                                  $ordernew->id_commande = $values['id_commande'];
                                  $ordernew->ids_line =  $lines_id;
                                  $ordernew->id_ambassadrice = $values['id_ambassadrice'];
                                  $ordernew->status = $values['status'];
                                  $ordernew->is_admin = $values['is_admin'];
                                  $ordernew->customer = $values['customer'];
                                  $ordernew->username = $values['username'];
                                  $ordernew->email = $values['email'];
                                  $ordernew->telephone = $values['telephone'];
                                  $ordernew->adresse = $values['adresse'];
                                  $ordernew->total_ht = $values['total_ht'];
                                  $ordernew->somme = $values['somme'];
                                  $ordernew->commission = $values['commission'];
                                  $ordernew->some_tva = $values['somme_tva'];
                                  $ordernew->notification = $values['notification'];
                                  $ordernew->code_mois = $values['code_mois'];
                                  $ordernew->annee = $values['nombre_annee'];
                                  $ordernew->code_live = $values['code_live'];
                                  // insert to bdd
                                  $ordernew->save();
                                 
                                  // insert pour notification
                                   $notification = new Notification();
                                   $notification->id_ambassadrice = $values['id_ambassadrice'];
                                   $notification->id_commande = $values['id_commande'];
                                    $notification->save();
                               // inserer les line product details de commande(article ou produits vendus)
                             foreach($values['data_line'] as $line) {
                            
                              $promo = new Promotionsum();
                              $promo->datet = $values['date_created'];
                              $promo->id_commande = $values['id_commande'];
                              $promo->code_promo = $values['code_promo'];
                              $promo->label_product = $line['name'];
                              $promo->id_product = $line['product_id'];
                              $promo->sku = $line['sku'];
                              $promo->id_ambassadrice = $values['id_ambassadrice'];
                              $promo->somme = $line['subtotal'];
                              $promo->quantite = $line['quantity'];
                        
                              // insert bdd...
                              $promo->save();
                
                      }

                     }

                       if(in_array($values['code_promo'],$data_restriction)){
                            $array_commande_restriction[] = $values;
                        }
                  }
                }
              }
         
         }
             
             // recupérer les code fidelite sutiliser dans une commande.
            if(strpos($values['code_promo'],$code_fem)==true){
                  if(isset($array_tab,$values['code_promo'])==false){
                  $array_fidelite[] = [
                      'code'=> $values['code_promo']

                  ];
              }
           }

      }
      
      
      // recupérer lles commande bloquer pendant les lives du mardi...
       foreach($array_commande_restriction as $values){

         if(isset($donss[$values['id_commande']]) == false) {
         $ordernew = new Orderrestriction();
         $ordernew->datet = $values['date_created'];
         $ordernew->code_promo = $values['code_promo'];
         $ordernew->id_commande = $values['id_commande'];
         $ordernew->ids_line =  $lines_id;
         $ordernew->id_ambassadrice = $values['id_ambassadrice'];
         $ordernew->status = $values['status'];
         $ordernew->is_admin = $values['is_admin'];
         $ordernew->customer = $values['customer'];
         $ordernew->username = $values['username'];
         $ordernew->email = $values['email'];
         $ordernew->telephone = $values['telephone'];
         $ordernew->adresse = $values['adresse'];
         $ordernew->total_ht = $values['total_ht'];
         $ordernew->somme = $values['somme'];
         $ordernew->commission = $values['commission'];
         $ordernew->some_tva = $values['somme_tva'];
         $ordernew->notification = $values['notification'];
         $ordernew->code_mois = $values['code_mois'];
          $ordernew->annee = $values['nombre_annee'];
          $ordernew->code_live = $values['code_live'];
          // insert to bdd
          $ordernew->save();
    
          // inserer les line product details de commande(article ou produits vendus)
         foreach($values['data_line'] as $line) {
        
            $promo = new Promotionsum();
            $promo->datet = $values['date_created'];
            $promo->id_commande = $values['id_commande'];
            $promo->code_promo = $values['code_promo'];
            $promo->label_product = $line['name'];
             $promo->id_product = $line['product_id'];
            $promo->sku = $line['sku'];
            $promo->id_ambassadrice = $values['id_ambassadrice'];
            $promo->somme = $line['subtotal'];
             $promo->quantite = $line['quantity'];
             // insert bdd
             $promo->save();

          }

        }

      }
            
        
          
          // recuperer les status refunded ou cancelled .
           // insert dans table
            DB::table('code_fidelites_use')->insert($array_fidelite);

            

            return true;
        
      } catch (Exception $e) {
        return $e->getMessage();
      }
      
        }

        
    
}