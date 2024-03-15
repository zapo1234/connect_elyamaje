<?php

namespace App\Repository\Caissenice;
use App\Models\Caissenice;
use App\Models\Caissemarseille;
use App\Models\Caisseinternet;
use App\Models\TresorerieInternet;
use App\Models\TresorerieMarseille;
use App\Models\TresorerieNice;
use App\Http\Service\CallApi\Apicall;
use Illuminate\Support\Facades\DB;

class CaisseniceRepository implements CaisseniceInterface
{
  private $api;
  
  private $datanice =[];
  
  private $datanices =[];
  
  private $datainternet =[];

  private $getref =[];

  private $getrefs =[];

  private $getsref =[];

  public function __construct(Apicall $api)
  {
    $this->api = $api;
  }
  
  
  public function getDatanice()
  {
      return $this->datanice;
  }
  
  public function setDatanice(array $datanice)
  {
      $this->datanice = $datanice;
      
      return $this;
  }
  
  
  public function getDatanices()
  {
      return $this->datanices;
  }
  
  public function setDatanices(array $datanices)
  {
      $this->datanices = $datanices;
      
      return $this;
  }
  
  
   public function getDatainternet()
  {
      return $this->datainternet;
  }
  
  public function setDatainternet(array $datainternet)
  {
      $this->datainternet = $datainternet;
      
      return $this;
  }
  
  
  
  public function getGetref()
  {
      return $this->getref;
  }
  
  public function setGetref(array $getref)
  {
      $this->getref = $getref;
      
      return $this;
  }


  public function getGetrefs()
  {
      return $this->getrefs;
  }
  
  public function setGetrefs(array $getrefs)
  {
      $this->getrefs = $getrefs;
      
      return $this;
  }
  
  
  public function getGetsref()
  {
      return $this->getsref;
  }
  
  public function setGetsref(array $getsref)
  {
      $this->getsref = $getsref;
      
      return $this;
  }
  
  


  

  public function getAll():array
  {
     // recupérer les names dans la base de données 
        $ref = DB::table('caissenices')->select('ref_facture')->get();
        // transformer les retour objets en tableau
        $name_list = json_encode($ref);
        $ref_facture_nice = json_decode($ref,true);
        
        $data_ref_nice =[];
        $array_key_ref =[];
        
        foreach($ref_facture_nice as $k =>$valus)
        {
             $data_ref_nice[] = $valus['ref_facture'];
             $array_key_ref[$valus['ref_facture']] = $k;
            
        }
        
       // $this->setGetref($array_key_ref);
        return $array_key_ref;
    
  }
  
  
   public function getAlls():array
   {
     // recupérer les names dans la base de données.
        $ref = DB::table('caissemarseilles')->select('ref_facture')->get();
        // transformer les retour objets en tableau
        $name_list = json_encode($ref);
        $ref_facture_marseille = json_decode($ref,true);
        
        $data_ref_marseille =[];
        $array_key_ref =[];
        
        foreach($ref_facture_marseille as $k =>$valus){
             $data_ref_marseille[] = $valus['ref_facture'];
             $array_key_ref[$valus['ref_facture']] = $k;
            
        }
        
        //$this->setGetrefs($array_key_ref);
         return $array_key_ref;
    
  }
  
  
  
  
   public function getAllinternet():array
   {
     // recupérer les names dans la base de données 
        $ref = DB::table('caisseinternets')->select('ref_facture')->get();
        // transformer les retour objets en tableau
        $name_list = json_encode($ref);
        $ref_facture_internet = json_decode($ref,true);
        
        $data_ref_internet =[];
        $array_key_ref =[];
        
        foreach($ref_facture_internet as $k =>$valus){
             $data_ref_internet[] = $valus['ref_facture'];
             $array_key_ref[$valus['ref_facture']] = $k;
        }
        
        $this->setGetsref($array_key_ref);
        return $data_ref_internet;
    
  }
  
  
  
  

  public function Insert($ref_fecture,$montant,$date)
  {
     
     $caisse = new Caissenice();
     $caisse->ref_facture = $ref_fecture;
     $caisse->montant = $montant;
     $caisse->date = $date;
     // insert in bdd
     $caisse->save();
    
   }
   
   
   public function Inserts($ref_fecture,$montant,$date)
   {
     
     $caisse = new Caissemarseille();
     $caisse->ref_facture = $ref_fecture;
     $caisse->montant = $montant;
     $caisse->date = $date;
     // insert in bdd
     $caisse->save();
    
   }
   
   
    public function Insertnet($ref_fecture,$montant,$date)
   {
     
     $caisse = new Caisseinternet();
     $caisse->ref_facture = $ref_fecture;
     $caisse->montant = $montant;
     $caisse->date = $date;
     // insert in bdd
     $caisse->save();
    
   }


   public function insertmensuel($data)
   {
      DB::table('tresorerie_internets')->insert($data);

   }
   
   public function insertmensuel1($data)
   {
      DB::table('tresorerie_marseilles')->insert($data);

   }
   
   public function insertmensuel2($data)
   {
      DB::table('tresorerie_nices')->insert($data);

   }
   
   
   
   public function getAlldata(): array
   {
        $data_donnes = DB::table('caissenices')->select('montant','date')->get();
        // transformer les retour objets en tableau
        $name_list = json_encode($data_donnes);
        $data = json_decode($data_donnes,true);
        
        
        // recupérer les données de la date actuel
        $date = date('Y-m-d');
        $datet = explode('-',$date);
        
        $jour = $datet[2];// le jour en cour actuel
        $mois = $datet[1]; // le mois actuel
        $annee = $datet[0]; // année en cours...
        
        // recupérer les données de la date
        $data_array_cours =[];
        $data_mens_cours =[];// recupérer les données du mois en cours
        
        foreach($data as $values){
            $datet1 = explode('-',$values['date']);// date
            
            if($datet1[0]==$annee && $datet1[1]==$mois && $datet1[2]==$jour){
                $data_array_cours[] = $values['montant'];
            }
            
            if($datet1[1]==$mois && $datet1[0]==$annee){
                $data_mens_cours[] = $values['montant'];
            }
        }
        
         // recupérer dans le tableau souhaitez
         $this->setDatanice($data_mens_cours);
        
        
        return $data_array_cours;
   }
   
   
   
   public function getAlldatas(): array
   {
        $data_donnes = DB::table('caissemarseilles')->select('montant','date')->get();
        // transformer les retour objets en tableau
        $name_list = json_encode($data_donnes);
        $datas = json_decode($data_donnes,true);
        
        
        // recupérer les données de la date actuel
        $date = date('Y-m-d');
        $datet = explode('-',$date);
        
        $jour = $datet[2];// le jour en cour actuel
        $mois = $datet[1]; // le mois actuel
        $annee = $datet[0]; // année en cours...
        
        // recupérer les données de la date
        $datas_array_cours =[];
        $datas_mens_cours =[];// recupérer les données du mois en cours
        
        foreach($datas as $valus)
        {
            $datet1 = explode('-',$valus['date']);// date
            
            if($datet1[0]==$annee && $datet1[1]==$mois && $datet1[2]==$jour){
                $datas_array_cours[] = $valus['montant'];
            }
            
            if($datet1[1]==$mois && $datet1[0]==$annee) {
                $datas_mens_cours[] = $valus['montant'];
            }
        }
        
        
         // recupérer dans le tableau souhaitez
         $this->setDatanices($datas_mens_cours);
        
        
        return $datas_array_cours;
   }



    public function getAllinternets(): array
    {
        $data_donnes = DB::table('caisseinternets')->select('montant','date')->get();
        // transformer les retour objets en tableau
        $name_list = json_encode($data_donnes);
        $datas_internet = json_decode($data_donnes,true);
        
        
        // recupérer les données de la date actuel
        $date = date('Y-m-d');
        $datet = explode('-',$date);
        
        $jour = $datet[2];// le jour en cour actuel
        $mois = $datet[1]; // le mois actuel
        $annee = $datet[0]; // année en cours...
        
        // recupérer les données de la date
        $datas_array_internet =[];
        $datas_mens_internet =[];// recupérer les données du mois en cours
        
        foreach($datas_internet as $vals){
            $datet1 = explode('-',$vals['date']);// date
            
            if($datet1[0]==$annee && $datet1[1]==$mois && $datet1[2]==$jour) {
                $datas_array_internet[] = $vals['montant'];
                
            }
            
            if($datet1[1]==$mois && $datet1[0]==$annee){
                $datas_mens_internet[] = $vals['montant'];
            }
        }
        
         // recupérer dans le tableau souhaiter
         $this->setDatainternet($datas_mens_internet);
        
        
        return $datas_array_internet;
   }
   
   
    // créer des recupération de recette
    
    public function getrecettenice()
    {
        $data =  Caissenice::selectRaw("date,SUM(montant) as total_montant")
       ->groupBy('date')
        ->orderByDesc("date")
       ->get();
    
         // transformer les retour objets en tableau
        $name_list = json_encode($data);
        $name_lists = json_decode($data,true);
        return $name_lists;
        
    }
    
    
     public function getrecettemarseille()
    {
        $data =  Caissemarseille::selectRaw("date,SUM(montant) as total_montant")
       ->groupBy('date')
        ->orderByDesc("date")
       ->get();
    
         // transformer les retour objets en tableau
        $name_list = json_encode($data);
        $name_lists = json_decode($data,true);
        return $name_lists;
        
    }
    
    
    public function getinternetrecette()
    {
          $data =  Caisseinternet::selectRaw("date,SUM(montant) as total_montant")
         ->groupBy('date')
         ->orderByDesc("date")
         ->get();
        // transformer les retour objets en tableau
         $name_list = json_encode($data);
         $name_lists = json_decode($data,true);

         // recupérer tous les code_live 
          $codes = DB::table('codelives')->select('code_live')->get();
          $name_list = json_encode($codes);
          $name_list = json_decode($codes,true);
          $array_code =[];

          // recupérer et somme les lives total_ht.
          foreach($name_list as $val){
            $array_code[] = $val['code_live'];
          }

            // somme les les live par group datet 
            // grouper les donées en fonction des id_live et compter 
             $sum_vente = DB::table('ordersambassadricecustoms')
              ->select('datet' ,DB::raw('SUM(total_ht) as total'))
              ->whereIn('code_promo',$array_code)
              ->groupBy('datet')
               ->get();
             $sum_data = json_encode($sum_vente);
             $sum_data = json_decode($sum_vente,true);

              // recupérer  les date de live demandé par les ambassadrice.

       // recupérer le mois et l'annee.
        return $name_lists;
        
    }


    public function getinternetmensuel()
    {
          
       
            // gérer l'affichage des recette journalière
            $data =  TresorerieInternet::selectRaw("date_fix,SUM(montant) as total_montant")
            ->groupBy('date_fix')
            ->orderByDesc("date_fix")
            ->get();
             $name_list = json_encode($data);
            $name_lists = json_decode($data,true);
            
            foreach($name_lists as $val) {
                 $date = $val['date_fix'];
                 $months =  explode('-',$date);
                 $mms = $this->getMois($months[1]);// recupérer le mois en francais.
                 $mss = $months[1].'/'.$months[0];
                 $result_array[] =[
                      'mois'=> $mms.' '.$months[0],
                      'mss'=>$mss,
                      'montant'=>$val['total_montant']
                     
                 ];

            }

        
       return $result_array;
         
         
     }

     public function getnicemensuel()
     {

        $data =  TresorerieNice::selectRaw("date_fix,SUM(montant) as total_montant")
        ->groupBy('date_fix')
        ->orderByDesc("date_fix")
        ->get();
         $name_list = json_encode($data);
         $name_lists = json_decode($data,true);
        
         foreach($name_lists as $val) {
            $date = $val['date_fix'];
            $months =  explode('-',$date);
            $mss = $months[1].'/'.$months[0];
            $mms = $this->getMois($months[1]);// recupérer le mois en francais.
            $result_array[] =[
                 'mois'=> $mms.' '.$months[0],
                 'mss'=>$mss,
                 'montant'=>$val['total_montant']
                
            ];

       }


       return $result_array;

     }

     public function getmarseillemenseul()
     {
         
          // gérer l'affichage des recette journalière
           $data =  TresorerieMarseille::selectRaw("date_fix,SUM(montant) as total_montant")
          ->groupBy('date_fix')
          ->orderByDesc("date_fix")
          ->get();
           $name_list = json_encode($data);
           $name_lists = json_decode($data,true);
        
          foreach($name_lists as $val) {
            $date = $val['date_fix'];
            $months =  explode('-',$date);
            $mss = $months[1].'/'.$months[0];
            $mms = $this->getMois($months[1]);// recupérer le mois en francais.
            $result_array[] =[
                 'mois'=> $mms.' '.$months[0],
                 'mss'=>$mss,
                 'montant'=>$val['total_montant']
                
            ];

         }

            return $result_array;
  
     }


    public function getmois($mois)
    {
      
        if($mois =="01"){
            $moi = "Janvier";
        }elseif($mois=="2"){
             $moi ="Février";
        }
       elseif($mois=="3"){
            $moi="Mars";
        }

        elseif($mois=="04"){
            $moi="Avril";
        }
        elseif($mois=="05"){
        $moi ="Mai";
       }
       elseif($mois=="06"){
         $moi="Juin";
       }

      elseif($mois=="07"){
       $moi="Juillet";
      }

       elseif($mois=="08"){
      $moi="Aout";
    }

      elseif($mois=="09"){
        $moi="Septembre";
     }
      elseif($mois=="10"){
      $moi="Octobre";
     }
     elseif($mois=="11"){
        $moi="Novembre";
      }

      else{
        $moi="Décembre";
       }

   return $moi;

}

}
