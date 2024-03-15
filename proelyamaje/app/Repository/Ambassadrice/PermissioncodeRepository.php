<?php

namespace App\Repository\Ambassadrice;

use App\Models\Permissioncode;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Hash;

class PermissionRepository implements PermissioncodeInterface
{
     
     private $model;
     
     private $data = [];
     
    public function __construct(Permissioncode $model)
    {
      $this->model = $model;

    }
    
    public function getAll()
    {
        
        
    }
    
    public function getIdambassadrice($id,$email)
    {
        
        // recupérer les id_ambassadrice 
         $name_list = DB::table('permissioncodes')->where('id_ambassadrice','=',$id)
         ->where('email','=',$email)
         ->get();
         $name_lists = json_encode($name_list);
        $name_lists = json_decode($name_list,true);
    }
    
    public function insert($id,$email,$date,$total)
    {
        
        $data = new Permissioncode();
        $data->id_ambassadrice = $id;
        $data->email = $email;
        $data->datet = $date;
        $data->total = $total;
        $data->save();
        
        
    }
}
    
    