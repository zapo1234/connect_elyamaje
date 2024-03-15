<?php

namespace App\Repository\Ambassadrice;

use App\Models\Ambassadrice\Accountambassadrice;
use App\Models\Partenaire\Accountpartenaire;
use App\Models\Ambassadrice\Orderambassadricecustom;
use App\Repository\Ambassadrice\Ordercustomer\OrderambassadricecustomsRepository;
use App\Repository\Ambassadrice\AccountpartenaireRepository;
use App\Models\Ambassadrice\Ordersambassadricecustom;
use App\Repository\Users\UserRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Hash;

class AccountambassadriceRepository implements AccountambassadriceInterface
{
     
     private $model;
    
    private $lists;
    
    private $users;
    
    private $data = [];
    
    private $datas = [];
    
    private $part;

    private $totalmensuel;

    public function __construct(
    Accountambassadrice $model,
    AmbassadriceRepository $lists,
    UserRepository $users,
    OrderambassadricecustomsRepository $order
    )
    {
      $this->model = $model;
      $this->lists = $lists;
      $this->users = $users;
      $this->order = $order;
      
      
    }
    
    
    /**
   * @return array
    */
   public function getDatas(): array
   {
      return $this->datas;
   }
   
   
   public function setDatas(array $datas)
  {
     $this->datas = $datas;
    return $this;
  }
  
  public function getTotalmensuel()
  {
       return $this->totalmensuel;
  }

  public function setTotalmensuel($totalmensuel)
  {
      $this->totalmensuel = $totalmensuel;
      return $this;
  }
  

  public function getAllid()
  {
      $data = DB::table('accountambassadrices')->select('id_commande')->get();
      $list = json_encode($data);
      $lists = json_decode($data,true);
      
      // recuperer dans un tableau les id_commande.
      $list_idcommande =[];
      
      foreach($lists as $k =>$vb)
      {
          $list_idcommande[] = $vb['id_commande'];
      }
      
      return $list_idcommande;
  }
  
  
   public function getAllids()
  {
      $data = DB::table('accountpartenaires')->select('id_commande')->get();
      $list = json_encode($data);
      $lists = json_decode($data,true);
      
      // recuperer dans un tableau les id_commande
      $list_idcommande =[];
      
      foreach($lists as $k =>$vb)
      {
          $list_idcommande[] = $vb['id_commande'];
      }
      
      return $list_idcommande;
  }


    
    public function getLists($code)
    {
        
      Orderambassadricecustom::Where('code_promo',$code)
    ->selectRaw("SUM(somme) as total")
    ->groupBy($code)
    ->get();
    }
    
    public function getList(): array
    {

        $data =  Accountambassadrice::selectRaw("name,SUM(montant) as total_montant")
       ->groupBy('name')
        ->orderByDesc("total_montant")
        ->get();
    
         // transformer les retour objets en tableau
        $name_list = json_encode($data);
        $name_lists = json_decode($data,true);
        
    
           return $name_lists;
    }
    
    public function getPeriode($date_from,$date_after,$date_years)
    {
        
        $date = date('Y-m-d');
        $datet = explode('-', $date);
        $annee = $datet[0];
        if($date_from < $date_after) {
              $array_id = [];
            
             for($i=$date_from; $i< $date_after+1; $i++){
                $array_id[] = $i;
           }
              $data =  Accountambassadrice::selectRaw("name,SUM(montant) as total_montant")
             ->whereIn('code_mois', $array_id)
             ->where('annee','=',$date_years)
            ->groupBy('name')
            ->orderByDesc("montant")
             ->get();
             // transformer les retour objets en tableau
             $name_list = json_encode($data);
             $name_lists = json_decode($data,true);
             $array_class =[];
        
              foreach($name_lists as $key => $val){
               $array_class[$key] = $val['total_montant'];
             }
        
             array_multisort($array_class, SORT_DESC, $name_lists);
             return $name_lists;
        }
    }
    
    
    public function  getMensuel($mois_cours,$date_yearss,$is_admin)
    {
      
          //$datc =  Accountambassadrice::selectRaw("name,SUM(montant) as total_montant");
          $data = Ordersambassadricecustom::selectRaw("id_ambassadrice,SUM(somme) as total_montant")
           ->where('code_mois','=',$mois_cours)
            ->where('annee','=',$date_yearss)
            ->where('is_admin','=',$is_admin)
            ->groupBy('id_ambassadrice')
            ->orderByDesc('total_montant')
            ->get();

            $name_list = json_encode($data);
            $name_lists = json_decode($data,true);

        

            $datas =  DB::table('users')->select('id','name')->get();
              
            $name_list = json_encode($datas);
            $name_list = json_decode($datas,true);
            $data_select =[];
            foreach($name_list as $val){
               $chaine = $val['id'].','.$val['name'];
               $data_select[$chaine] = $val['id'];
            }
        
             $array_class =[];
             $array_total_mensuel =[];// recupérer les montants.
        
           $user_resultat =[];
           foreach($name_lists as $key => $val) {
           // $array_class[$key] = $val['total_montant'];
           $chaine_name =  array_search($val['id_ambassadrice'],$data_select);
           if($chaine_name!=false){
              $name_user = explode(',',$chaine_name);
           }
              $array_total_mensuel[] = $val['total_montant'];
              $user_resultat[] =[
              'name'=> $name_user[1],
              'total_montant'=>$val['total_montant']

          ];
        }

        
       // array_multisort($array_class, SORT_DESC, $name_lists);
        // recupérer le montant
         $somme_montant = array_sum($array_total_mensuel);
         // deux chiffre après la virgule

         // recupérer 
         $somme_montant1 = number_format($somme_montant,2,".","");
      
         $this->setTotalmensuel($somme_montant1);
        
         return $user_resultat;
  
  }
    
    
    public function getPointdata($id)
    {
        $data = DB::table('ordersambassadricecustoms')
                 ->where('code_mois','=',$id)
                 ->select('somme', DB::raw('count(*) as total'))
                 ->groupBy('id_ambassadrice')
                 ->get();
    }
    
    
    public function getcounnum():array
    {
        $date =date('Y-m-d');
        $datet = explode('-',$date);
        $code_mois = $datet[1];
        $annee = $datet[0];
        
        $data = DB::table('accountambassadrices')
                       ->select(DB::raw('accountambassadrices.name, count(*) as ventes_count'))
                       ->where('code_mois','=',$code_mois)
                       ->where('annee','=',$annee)
                       ->groupBy('accountambassadrices.name')
                       ->get();
    
        $counts = json_encode($data);
        $counts = json_decode($data,true);
        
        if(count($counts)!=0) {
        
          $total_vente = [];
          foreach($counts as $ks => $vals){
            $total_vent[$ks] = $vals['ventes_count'];
             // créer le tableau associatve à afficher
             $total_vente[] =[
                
                   'nom'=>$vals['name'],
                   'vente' =>$vals['ventes_count'],
                  ];
           }
        
            // renvoyer un tableau par odre decroissant en fonction des ventes
             // renvoyer un tableau unique par id commande
            $temps = array_unique(array_column($total_vente, 'nom'));
            $unique_arrs = array_intersect_key($total_vente, $temps);
             // sortir du tableau par ordres deccroissant
           array_multisort($total_vent, SORT_DESC, $unique_arrs);
           return($unique_arrs);
        }
        
        else{
            return [];
        }
    }
    
    

    
    
    public function getData(): array
    {
        $account_data = [];
        // recupérer les données pour les traiter
        $data = $this->getList();
        $coun =$this->getcounnum();
        
        foreach($data as $k => $values) {
            if($values['name']== "3jfnmyuv") {
                $name="biotech";
            }
            else{
                $nom = explode('-',$values['name']);
                $name= $nom[0];
            }
            
            $montant = $values['total_montant'];
            $total_montant[$k] = $values['total_montant'];
            $montants = ($montant*20)/100;
             // créer le tableau associatve à afficher
             $account_data[] =[
                   'nom'=>$name,
                   'montants' =>$montants,
                   'montant' => $montant,
                   'code' => $values['name'],
                   
                 ];
                
          }
        
          // renvoyer un tableau unique en fonction du code_promo
          // renvoyer un tableau unique par id commande
            $temp = array_unique(array_column($account_data, 'nom'));
            $unique_arr = array_intersect_key($account_data, $temp);
            array_multisort($total_montant, SORT_DESC, $unique_arr);
        
         return($unique_arr);
    }
    
    
    /**
   * @return array
   */
    public function donnees(): array
   {
    //recupérer les données sous forme de tableau dans la vairable array datas
    // le nombre de ventes
       return $this->getDatas();
   }
    
    
    
    public function insert()
    {
        //insert data price account ambassadrice
        // best developpement pour chart js 
        $data = $this->lists->getSomme();
         // recupérer les données utilie pour amabssadrice
         $datas = $this->users->getUser();
          // recupérer les données pour les partenaire
          $partenaires  = $this->users->donnes();
          $a =[];// recupérer les nom dans un tableau de user
          $b =[];// recupérer les nom amabssadrice ayant pas fais de order
          $c =[];// recupérer les nom des partenaire ayant pas fais des commandes
          $b2 =[];// recupérer les partenaire ayant généres des orders
         
         foreach($datas as $kj => $vli){
              $va = explode(',', $vli);
             $a[]= $va[0];
         }
         
         
         foreach($partenaires as $kjs => $vlis) {
              $vas = explode(',', $vlis);
             $c[]= $vas[0];
         }
         
         // recupérer les informations des ambassadrice ou partenaire et leur commande et mois et anneee
          $this->order->getDataIdcodeorders();
           $datass = $this->order->chart();
         // recupérer les données dans un tab
         $array_data = [];
         $array_list =[];
         $array_list2 =[];
         $array_list3= [];
         $array_list1 =[];
         
        // traiter les données pour les ambassadrie
         foreach($datass as $key => $values) {
             foreach($values as $k => $val) {
                 foreach($datas as $kl => $vals)  {
                     if($k == $kl) {
                        $valx = explode(',', $vals);
                         $b[] = $valx[0];
                         $array_data[]= $val;
                         $array_list[]=[
                              $vals =>$val
                             ];
                     }
                     
                }
             }
         }
         
         // traiter les données des partenaire
         foreach($datass as $kev => $valus) {
             foreach($valus as $kv => $vale){
                
                 foreach($partenaires as $kvs => $valse)  {
                     
                     if($kv == $kvs) {
                        $valxs = explode(',', $valse);
                         $b2[] = $valxs[0];
                         $array_data[]= $vale;
                         $array_list2[]=[
                             
                               $valse =>$vale
                             ];
                     }
                     
                   }
             }
         }
         
         
         
         $b1 = array_unique($b);
         $b3 = array_unique($b);
         
         // recupérer les ambassadrice ayant pas fais de chiffre
         $array_list_ambassadrice = array_diff($a,$b1);
         
         // recupérer les partenaire ayant pas de faire de chiffre
          $array_list_partenaire = array_diff($c,$b1);
         
         // inserer les données dans la table
         // variable au cas ou l'ambassadrice n'a pas de chiffre affaire
         $nombr = rand(4,20);
         $montant =0;
         $va ="";
         $email="";
         $telephone="";
         $date =date('Y-m-d');
         $dad =  explode('-', $date);
         $dad1 =(int)$dad;
         
         foreach($array_list_ambassadrice as $m){
             $b = $m.',2';
             $id_commande= $m;
             $array_list1[] = [
                 
                $b => $montant.','.$id_commande.','.$dad[1].','.$dad[0]
                      
           ]; 
         }
         
         // recupére dans un tableau les partenaire
         
          foreach($array_list_partenaire as $g){
             $b = $g.',4';
             $id_commande= $g;
             $array_list3[] = [
                 
                $b => $montant.','.$id_commande.','.$dad[1].','.$dad[0]
                      
           ]; 
         }
         
         
         // associe les tableau pour les afficher
         $arr  = array_merge($array_list,$array_list1);
         // lister le tableau partenaire pour les afficher
         $arr1 = array_merge($array_list2,$array_list3);
         // inserer les amabssadeurs ayant pas eu de commande
         $array_idcommande = $this->order->getDataIdcodeorders();
          $dat = $this->getAllid();
       // insert dans la table account pour les ambassadrice
        foreach($arr as $keys =>$values) {
            foreach($values as $ky => $val){
              $valu = explode(',',$val);
              $valx = explode(',', $ky);
             $va ='';
               
               if(!in_array($valu[1],$dat)){
                  $donnes = new Accountambassadrice();
                 $donnes->name = $valx[0];
                 $donnes->id_commande = $valu[1];
                 $donnes->code_mois = $valu[2];
                 $donnes->annee = $valu[3];
                 $donnes->montant = $valu[0];
                
                 $donnes->save();
           
            }
           
          }
        }
        
        // recupérer les données partenaire dans la table account
         $dat1 = $this->getAllids();
         // insert dans la table account pour les ambassadrice
        foreach($arr1 as $keyss =>$valuess) {
            foreach($valuess as $kyy => $vals){
              $valu = explode(',',$vals);
              $valx = explode(',', $kyy);
              $va ='';
               
                  if(!in_array($valu[1],$dat1)){
                 
                   $donnes = new Accountpartenaire();
                   $donnes->name = $valx[0];
                   $donnes->id_commande = $valu[1];
                   $donnes->code_mois = $valu[2];
                  $donnes->annee = $valu[3];
                  $donnes->montant = $valu[0];
                
                 $donnes->save();
           
               }
           
          }
        }
        
        
    }

    
    
    
    
}
    
    
    
   

    
    