<?php

namespace App\Repository\Codespeciale;

use App\Models\Codespeciale;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class CodespecialeRepository implements CodespecialeInterface
{
     
     private $model;
     
     private $listemail = [];
     
     private $listecode = [];
     
      private $arrayid =[];    // tableau associative  entre le code specifique et id_ambassadrice
     
     
      public function __construct(Codespeciale $model)
     {
        $this->model = $model;
        
     }
    
    
     /**
   * @return array
    */
   public function getArrayid(): array
   {
      return $this->arrayid;
   }
   
   
   public function setArrayid(array $arrayid)
   {
     $this->arrayid = $arrayid;
     return $this;
   }
   
    
    
    
        /**
   * @return array
    */
   public function getListemail(): array
   {
      return $this->listemail;
   }
   
   
   public function setListemail(array $listemail)
   {
     $this->listemail = $listemail;
    return $this;
   }
   
   
          /**
   * @return array
    */
   public function getListecode(): array
   {
      return $this->listecode;
   }
   
   
   public function setListEcode(array $listecode)
   {
     $this->listEcode = $listecode;
    return $this;
   }
   
   
         /**
   * @return array
   */
    public function dataemail(): array
    {
     //recupérer un array de email
       return $this->getListemail();
    }
    
    
        /**
   * @return array
   */
    public function datacode(): array
    {
     //recupérer un array de email
       return $this->getListecode();
    }

   
   public function getAllcodes()
   {
       return codespeciale::orderBy('id', 'desc')->paginate(25);
   }
    
   public function getAllcode()
   {
        $data =  DB::table('codespeciales')->select('id_user', 'is_admin','name','code_promos','nom_eleve','email','pourcentage','commission')->get();
        // transformer les retour objets en tableau
        $list = json_encode($data);
        $lists = json_decode($data,true);
        
        $list_email = [];//liste des email
        $list_code = []; // list des codes spéfique 
        $list_arrayid =[];// créer un tableau associative entre les id_user et code spécifique
        
        foreach($lists as $km => $values){
            $list_email[] = $values['email'];
            $list_code[] = $values['code_promos'];
            $list_arrayid[] = [
                                 $values['code_promos'] =>$values['code_promos'].','.$values['id_user'].','.$values['is_admin'].','.$values['commission']
                                 
                            ];
            
        }
        
         $this->setListemail($list_email);
         $this->setListecode($list_code);
        
        // recupérer les tableau dans les varibles
        $this->setArrayid($list_arrayid);
    
        
        return $lists;
   }
    
    
  
    
    public function insert()
    {
       
      
    }
    
    
    public function getIdcodepromo($id)
    {
        
        return Codespeciale::find($id);
        
    }
    
    
    public function getdatacodespecifique($code)
    {
        $data =  DB::table('codespeciales')->select('code_promos','commission','pourcentage')->where('code_promos',$code)->first();
        
        return $data;
    }
    
    
    public function updatecodespecifique($code,$commission,$reduction,$nom_eleve,$email)
    {
        
         DB::table('codespeciales')->where('code_promos', $code)->update([
            'nom_eleve'=>$nom_eleve,
            'email'=>$email,
            'commission'=>$commission,
            'pourcentage'=>$reduction,
            
           ]);
    }
    
    
}
     
    