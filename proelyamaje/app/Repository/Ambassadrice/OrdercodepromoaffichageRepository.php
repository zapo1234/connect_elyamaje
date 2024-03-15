<?php

namespace App\Repository\Ambassadrice;

use App\Models\User;
use App\Models\Ambassadrice\Ordercodepromoaffichage;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Hash;

class OrdercodepromoaffichageRepository implements OrdercodepromoaffichageInterface
{
     
     private $model;
     
     private $data = [];
     
    public function __construct(Ordercodepromoaffichage $model)
    {
      $this->model = $model;

    }
    
    public function getAll()
    {
        return Ordercodepromoaffichage::orderBy('id', 'desc')->get();
    }
   
    
    public function insert(array $datas)
    {
        
       // insert les données dans la table
      DB::table('ordercodepromoaffichages')->insert($datas);
        
        
    }
    
    public function getallid($id_ambassadrice)
    {
        return DB::table('ordercodepromoaffichages')->where('id_ambassadrice', '=', $id_ambassadrice)->orderBy('datet','desc')->get();
    }
    
    
     public function getallidmobile($id_ambassadrice)
     {
         return DB::table('ordercodepromoaffichages')->where('id_ambassadrice', '=', $id_ambassadrice)->orderBy('datet','desc')->paginate(100);
     }
    
    
    public function getsearch($search,$id_ambassadrice)
    {
       return  DB::table('ordercodepromoaffichages')->where('id_ambassadrice','=',$id_ambassadrice)->where('nom','LIKE','%'.$search.'%')->paginate(100);
    }
    
    
     public function getsearchs($search)
    {
       return  DB::table('ordercodepromoaffichages')->where('nom','LIKE','%'.$search.'%')->orWhere('code_promo', 'LIKE', '%'. $search .'%')->get();
    }
    
    
    public function getdatapromo()
    {
        $code_promos = User::join('ordercodepromoaffichages', 'ordercodepromoaffichages.id_ambassadrice', '=', 'users.id')->orderBy('datet', 'desc')->limit(200)
            ->get();
                
         // transformer les retour objets en tableau
        $list = json_encode($code_promos);
        $lists = json_decode($code_promos,true);
        
        
         return $lists;
        
    }
    
    
    
     public function getdatapromos($id)
    {
        $code_promos = User::join('ordercodepromoaffichages', 'ordercodepromoaffichages.id_ambassadrice', '=', 'users.id')->where('users.id', $id)->orderBy('datet', 'desc')->limit(200)
            ->get();
                
         // transformer les retour objets en tableau
        $list = json_encode($code_promos);
        $lists = json_decode($code_promos,true);
        
        
         return $lists;
        
    }
    
    
}
    
    