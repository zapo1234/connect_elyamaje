<?php

namespace App\Repository\Ambassadrice;
use App\Models\Partenaire\Accountpartenaire;
use App\Repository\Ambassadrice\AmbassadriceRepository;
use App\Repository\Ambassadrice\Ordercustomer\OrderambassadricecustomsRepository;
use App\Models\Ambassadrice\Ordersambassadricecustom;
use App\Repository\Users\UserRepository;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Hash;

class AccountpartenaireRepository implements AccountpartenaireInterface
{
     
     private $model;
    
    private $lists;
    
    private $users;
    
    private $data = [];
    
    private $datas = [];
    

    public function __construct(
    Accountpartenaire $model,
    AmbassadriceRepository $lists,
    UserRepository $users,
    OrderambassadricecustomsRepository $order)
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
  

  public function  getMensuel($mois_cours, $date_yearss)
  {
    
        $data =  Accountpartenaire::selectRaw("name,SUM(montant) as total_montant")
         ->where('code_mois','=',$mois_cours)
          ->where('annee','=',$date_yearss)
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

        $data =  Accountpartenaire::selectRaw("name,SUM(montant) as total_montant")
        ->groupBy('name')
         ->orderByDesc("montant")
        ->get();
     
          // transformer les retour objets en tableau
         $name_list = json_encode($data);
         $name_lists = json_decode($data,true);
         
         $array_class =[];
         
         foreach($name_lists as $key => $val)
         {
             $array_class[$key] = $val['total_montant'];
         }
         
         array_multisort($array_class, SORT_DESC, $name_lists);
         
          return $name_lists;
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

        $data = DB::table('accountpartenaires')
                       ->select(DB::raw('accountpartenaires.name, count(*) as ventes_count'))  
                       ->where('code_mois','=',$code_mois)
                       ->where('annee','=',$annee)      
                       ->groupBy('accountpartenaires.name')
                       ->get();

        $counts = json_encode($data);
        $counts = json_decode($data,true);


        
    if(count($counts)!=0)
    {
        
        $total_vente = [];
        foreach($counts as $ks => $vals)
        {
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
       array_multisort($total_vente, SORT_DESC, $unique_arrs);

       
       return($unique_arrs);
    }
    else{
            return [];
        }
    }
    
    
    public function getPeriode($date_from,$date_after,$date_years)
    {
        
        $date = date('Y-m-d');
        $datet = explode('-', $date);
        $annee = $datet[0];
        if($date_from < $date_after){
            $array_id = [];
            
        for($i=$date_from; $i< $date_after+1; $i++){
        
            $array_id[] = $i;
        }
            $data =  Accountpartenaire::selectRaw("name,SUM(montant) as total_montant")
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
    
    
    public function getData(): array
    {
        
        $account_data = [];
        
        // recupérer les données pour les traiter
        $data = $this->getList();
        $coun =$this->getcounnum();
        
        foreach($data as $k => $values){
            if($values['name']== "3jfnmyuv"){
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
    
    
    
   
    
    
}
    
    
    
   

    
    