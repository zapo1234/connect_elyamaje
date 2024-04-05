<?php

namespace App\Repository\Dashboardtiers;
use App\Models\Dashboardtier;
use App\Http\Service\CallApi\Apicall;
use Illuminate\Support\Facades\DB;
use DateTime;

class DashboardtiersRepository implements DashboardtiersInterface
{
  private $api;

   private $datas =[];

  public function __construct(Apicall $api)
  {
    $this->api = $api;
  }



    public function getDatas()
    {
       return $this->datas;
    }
    
    
    public function setDatas(array $datas)
    {
      $this->datas = $datas;
      return $this;
    }


  
  public function Insert($date,$mois,$annee,$number,$nombre_marseille,$nombre_nice,$nombre_internet,$jour)
  {
     $data = new Dashboardtier();
     $data->date = $date;
     $data->mois = $mois;
     $data->annee = $annee;
     $data->nombre = $number;
     $data->nombre_marseille = $nombre_marseille;
     $data->nombre_nice = $nombre_nice;
     $data->nombre_internet = $nombre_internet;
     $data->jour = $jour;
    
      // insert 
      $data->save();
    
   }

/**
 * 
 *@return array
 */

   public function getjour(): array
   {
       
    }
    
    
    public function getalldate($date)
    {
        // recupérer le nombre via la date dans la table
          $data = DB::table('dashboardtiers')->select('nombre','nombre_marseille','nombre_nice','nombre_internet')->where('date','=',$date)->get();
          $list = json_encode($data);
          $lists = json_decode($data,true);
          
          return $lists;
    }
    
    
    public function updatenumber($date,$number,$number_marseille,$number_nice,$number_internet)
    {
         DB::table('dashboardtiers')
          ->where('date', $date)
          ->update(array('nombre' => $number,
                         'nombre_marseille'=>$number_marseille,
                         'nombre_nice'=>$number_nice,
                         'nombre_internet'=>$number_internet,
                    
          ));
    }
    
    
    
    public function getallsdate()
    {
        $date =date('Y-m-d');
        $dates = date('Y/m/d');
        // exploser les dates 
         $dat = explode('-',$date);
          $annee = $dat[0];
          $jour = (int)$dat[2];
          $mois = (int)$dat[1];
          
         // recupérer les données de la date courante actuel.
          $data = DB::table('dashboardtiers')->select('date','nombre','nombre_marseille','nombre_nice','nombre_internet')->where('date','=',$date)->get();
          $list = json_encode($data);
          $lists = json_decode($data,true);
          
          return $lists;
    }

    public function selectOldDatadate()
    {
        $date =date('Y-m-d', strtotime('-1 day'));
        // recupérer les données de la date courante actuel.
        $data = DB::table('dashboardtiers')->select('date','nombre','nombre_marseille','nombre_nice','nombre_internet')->where('date', $date)->get();
        $list = json_encode($data);
        $lists = json_decode($data,true);
        
        return $lists;
    }
    
    
    
    public function getallsnow()
    {
         $date =date('Y-m-d');
        $dates = date('Y/m/d');
        // exploser les dates 
         $dat = explode('-',$date);
          $annee = $dat[0];
          $jour = (int)$dat[2];
          $mois = (int)$dat[1];
          
         // recupérer les données de la date courante actuel
          $data = DB::table('dashboardtiers')->select('date','nombre')->where('date','=',$date)->get();
          $list = json_encode($data);
          $lists = json_decode($data,true);
          
            $number ="";
             foreach($lists as $key => $val){
                 $number = $val['nombre'];
             }
          
          return $number;
    }
    
    
    public function getallsdatehier() // renvoi le nombre de nouveaux client now -1 days
    {
        $date = date('Y-m-d');
        // recupérer le nombre de client now -1;
        // recupére la date courate actuel(format date) à ajouter 3h
                $date_jour = date("Y-m-d", strtotime($date.'- 1 days'));
            // recupérer les données de la date courante actuel
              $data = DB::table('dashboardtiers')->select('date','nombre')->where('date','=',$date_jour)->get();
             $list = json_encode($data);
             $lists = json_decode($data,true);
             
             $number ="";
             foreach($lists as $key => $val){
                 $number = $val['nombre'];
             }
          
          return $number;
    }
    
    
    public function getalldatehiers()
    {
        $date =date('Y-m-d');
        // recupére le nombre de client now -2
        // recupére la date courate actuel(format date) à ajouter 3h
        $date_jour = date("Y-m-d", strtotime($date.'- 2 days'));
        
        // recupérer les données de la date courante actuel
          $data = DB::table('dashboardtiers')->select('date','nombre')->where('date','=',$date_jour)->get();
          $list = json_encode($data);
          $lists = json_decode($data,true);
          
           $number ="";
             foreach($lists as $key => $val)
             {
                 $number = $val['nombre'];
             }
          
          return $number;
        
    }
    
    
    public function getdatacharjs($mois,$annee):array
    {
          if($mois && $annee){
            $data = DB::table('dashboardtiers')->select('nombre','jour','mois')->where('mois','=',$mois)->where('annee','=',$annee)->get();
          } else if($mois){
              $data = DB::table('dashboardtiers')->select('nombre','jour','mois')->where('mois','=',$mois)->get();
          } else if ($annee){
              $data = DB::table('dashboardtiers')->select('nombre','jour','mois')->where('annee','=',$annee)->get();
          }
            
          // recupérer les données de la date courante actuel
          $list = json_encode($data);
          $lists = json_decode($data,true);
          
          return $lists;
          
        
    }

    public function getcountiers()
    {
        $nombre = DB::connection('mysql3')->select("SELECT COUNT(*) as nbtiers FROM prepa_tiers");
         $response = json_encode($nombre);
         $resp = json_decode($response,true);
         $nombre_tiers = $resp[0]['nbtiers'];

        return $nombre_tiers;
    }

    public function getnewcustomers()
    {
        
        $dateActuelle = new DateTime();
        // Soustraire un jour à la date actuelle
        $dateMoins = date('Y-m-d');
        $dtx ="00:00:00";
        $dates = $dateMoins.' '.$dtx;
        $nombre = DB::connection('mysql3')->select("SELECT code_client FROM prepa_tiers WHERE created_at > '$dates'");
         $response = json_encode($nombre);
         $resp = json_decode($response,true);

         
         
         $prefix_boutique="BOU";// client susceptible d'arriver en boutique..
         $prefix_internet ="WC";// client prevenant du site
         $customers_new =[];
         $customers_new_boutique =[];// client isus de la boutique...
          foreach($resp as $values){
            
            if(strpos($values['code_client'],$prefix_internet)!==false) {
               $customers_new[] = $values['code_client'];
           }
            
           if(strpos($values['code_client'],$prefix_boutique)!==false) {
              $customers_new_boutique[] = $values['code_client'];

           }
        }

          $customs = count($customers_new);
          $customs_marseille = count($customers_new_boutique);
          $mois = date('m');
          $annee =date('Y');
          $number = $customs;
          $nombre_marseille = $customs_marseille;
          $number_marseille = $customs_marseille;
          $number_internet = $customs;
          $number_nice = 0;
          $nombre_nice=0;
          $nombre_internet = $customs;
          $jour = date('d');
          $date = date('Y-m-d');
          // si date renvoi un tableau vide
           $nombre_data = count($this->getalldate($date));
           if($nombre_data==0){
              // insert dans la table suivant.
               $this->Insert($date,$mois,$annee,$number,$nombre_marseille,$nombre_nice,$nombre_internet,$jour);
               // recupérer
          }else{
               // sil il existe modifier les données.
               $this->updatenumber($date,$number,$number_marseille,$number_nice,$number_internet);
           }
             $this->setDatac($customs_marseille);
         return $customs;
    }



    public function getcustomerall()
    {
       $lists = DB::connection('mysql3')->select("SELECT zip_code,email FROM prepa_tiers");
       $response = json_encode($lists);
       $resp = json_decode($response,true);
       $data =[];
        // recupérer et regouper les clients en fonction..
       foreach($resp as $val) {
          $data[] =  substr($val['zip_code'],0,2);
       }

        // recupérer la table des departement s et region
        // recupérer les données de la date courante actuel
        $datas = DB::table('departments')->select('region_code','code','name')->get();
        $list = json_encode($datas);
        $lists = json_decode($datas,true);
        $code_departement =[];
        $code_regions =[];

        foreach($lists as $val){
           $chaine = $val['code'].','.$val['name'];
           $chaine_region = $val['code'].','.$val['region_code'];
           $code_departement[$chaine]= $val['code'];
           $code_regions[$chaine_region] =  $val['code'];

        }
       // region 
         $datac = DB::table('regions')->select('code','name')->get();
         $lis = json_encode($datac);
         $lis = json_decode($datac,true);
         $code_region  =[];
        
        foreach($lis as $valus){
          $code_region[$valus['name']]= $valus['code'];

       }

        // compter le nombre de fois que le nombre se repete
        $result_data = array_count_values($data);
        $donnees =  array_flip($result_data);
        krsort($donnees);// trier par ordre decroissante les valeurs 
             // triater le retour des array pour cible les regions.
         $region_cibles =[];

         $array_departement =[]; // construire des departement 

         foreach($donnees as $key => $val){
         
        $dep = array_search($val,$code_departement);
        if($dep!=false){
          $deps = explode(',',$dep);
        
          $count_user = $this->getcountiers();// nombre user.
          $pourcentage = number_format($key*100/$count_user,2,',','');

          $array_departement[] =[
            'departement' => $deps[1],
            'nombre_user' => $key,
            'pourcentage' => $pourcentage.'%'

          ];

        }

           // traiter les regions......
           $data_regions =[];
           foreach($donnees as $keys =>$valu){
                 $code_reg = array_search($valu,$code_regions);

                 if($code_reg!=false){
                 $region_c = explode(',',$code_reg);
                  $data_regions[] =[
                  'nombre_user' => $keys,
                  'code_regions' => $region_c[1],
                  'code_departement'=> $region_c[0]

                 ];
             }
           }

 
            // calculer le nombre des client sur les region...
             $result = array_reduce($data_regions,function($carry,$item){
            if(!isset($carry[$item['code_regions']])){ 
              $carry[$item['code_regions']] = ['code_regions'=>$item['code_regions'],'nombre_user'=>$item['nombre_user']]; 
             } else { 
              $carry[$item['code_regions']]['nombre_user'] += $item['nombre_user']; 
            } 
             return $carry; 
         });

           // cibler les region......
           $result_region_data =[];

           foreach($result as $vals){
             // recupérer la region 
              $count_user = $this->getcountiers();// nombre user...
              $pourcentage = number_format($vals['nombre_user']*100/$count_user,2,',','');

             $name_region = array_search($vals['code_regions'],$code_region);
                if($name_region!=false){
                  $result_region_data[] =[
                  'name_region'=>$name_region,
                  'nombre_customer'=>$vals['nombre_user'],
                  'pourcentage' => $pourcentage.'%'

                 ];

             }
           }

           // recupérer le tableau des regions
           $this->setDatas($result_region_data);
           //.....


       }
       
       return $array_departement;

    }


}