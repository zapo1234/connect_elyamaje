<?php



namespace App\Repository\Users;



use App\Models\User;

use App\Models\Ambassadrice\Codelive;

use Illuminate\Support\Facades\DB;

use Carbon\Carbon;

use Hash;



class UserRepository implements UserInterface

{

     

     private $model;
     private $data =[]; // ambassadrice
     private $datas = [];// partenaire
     private $listarray = [];
     private $listusers = [];
     private $tokens = [];
     private $array_id_live =[];
     private $usrs = [];

     private $parts =[];

    public function __construct(User $model)
    {

      $this->model = $model;

    }


   /**

   * @return array

    */

    public function getArrayIdLive(): array
    {
       return $this->array_id_live;
  
     }
  
     public function setArrayIdsLive(array $array_id_live)
     {
        $this->array_id_live = $array_id_live;
        return $this;
  
     }


    
  /***

   * @return array

    */

   public function getListusers(): array
   {
     return $this->listusers;

   }

   public function setListusers(array $listusers)
   {

     $this->listusers = $listusers;
     return $this;

   }

  
   public function getParts(): array
   {
     return $this->parts;

   }

   public function setParts(array $parts)
   {

     $this->parts = $parts;
     return $this;

   }




 /**

   * @return array

    */

   public function getListarray(): array

   {

      return $this->listarray;

   }

    public function setListarray(array $listarray)
    {
       $this->listarray = $listarray;
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

   public function getDatas(): array
   {

      return $this->datas;

   }

   public function setDatas(array $datas)
   {
       $this->datas = $datas;
        return $this;

   }

   public function getUsrs(): array
   {
       return $this->usrs;

   }

   public function setUsrs(array $usrs)
   {
        $this->usrs = $usrs;
        return $this;

   }


      /**

   * @return array

    */

   public function getTokens(): array
   {

      return $this->tokens;
   }

   public function setTokens(array $tokens)
   {
     $this->tokens = $tokens;
     return $this;

   }

   public function getdatausercodelive()
   {

       $customer = DB::table('codelives')
        ->join('users', 'users.id', '=', 'codelives.id_ambassadrice')
         ->get();

          // transformer les retour objets en tableau
         $list = json_encode($customer);
          $lists = json_decode($customer,true);

        return $lists;
  }

    public function getUser()
    {

         $listt  = User::all();
         $array_user = [];
          $tabs = [];
          $list_ambassadrice = [];//lister les ambassadrice
          $list_users =[];// lister les users ambassadrice.
         // transformer les retour objets en tableau
          $list_token = [];// recupérer token
          $listsusers = [];// recupérer les ambassadrice et partenaire
          $list = json_encode($listt);
          $lists = json_decode($list,true);
          $array_id_liv =[];

         foreach($lists as $values){
              $array_user[]=$values;

          }

        foreach($array_user as $kl => $val) {
            // recupérer seulement les ambassadrice avec le is_admin 2
            if($val['is_admin']==2){
                 $tab[$val['id']]=$val['name'].','.$val['is_admin'];
                $list_ambassadrice[] = $val;
                $array_id_live[$val['id']] = $val['code_live'];
                $chaine = $val['id'].','.$val['name'];
                $list_users[$chaine] = $val['id'];
             }

            if($val['is_admin']==4){
              $tabs[$val['id']]=$val['name'].','.$val['is_admin'];
              $chaine = $val['id'].','.$val['name'];
              $list_partenaire[$chaine] = $val['id'];
             }

             if($val['is_admin']==2 OR $val['is_admin']==4){
                $listsusers[$val['id']] = $val['name'].','.$val['email'].','.$val['telephone'].','.$val['type_account'];

             }

         }

        // recupérer les arrays dans les variables.
        $this->setListusers($listsusers);
        $this->setParts($list_partenaire);
        $this->setData($tab);
        $this->setDatas($tabs);
        $this->setListarray($list_ambassadrice);
        $this->setUsrs($list_users);

         return $tab;

    }

    

     

    public function getUsers()
    {

        $data = User::paginate(10);
        return $data;

    }


    public function getAllUsers()
    {

        $data = User::all();
        return $data;

    }
    
   /**

   * @return array

   */

    public function listlive(): array
    {
     //recupérer les données sous forme de tableau dans les partenaire
       return $this->getListarray();

    }

     /**

   * @return array

   */

    public function donnes(): array
     {
         //recupérer les données sous forme de tableau dans les partenaire
         return $this->getDatas();
     }

     /**

   * @return array

   */

    public function donnees(): array
     {
       //recupérer les données sous forme de tableau dans les ambassadrice
       return $this->getData();

    }

   public function getUserId(int $id)
   {
         return User::find($id);
   }

    public function create(array $attribute)
    {
        return $this->model->create($attribute);

    }

    public function update($id, array $attribute)
    {
      return User::where('id', $id)->update($attribute);
    }

    public function getEmail(string $email)
    {
          return User::where('email', $email)->first();

    }

    public function insertTokenresetPassword(string $email,string $token)
    {

        DB::table('password_resets')->insert([

            'email' => $email, 

            'token' => $token, 

            'created_at' => Carbon::now()

          ]);



    }

    

    public function getToken($email, $token)
    {

        return  DB::table('password_resets')

                              ->where([

                                'email' => $email, 

                                'token' => $token

                              ])

                              ->first();

     }



    public function newPassword(string $email, string $password)

    {

        $user = User::where('email', $email)

                      ->update(['password' => Hash::make($password)]);

          

    }

    

    public function deletepassword_reset(string $email)
    {

        DB::table('password_resets')->where(['email'=> $email])->delete();

        

    }

    public function updateactive($id)
    {
             $user = User::where('id', $id)
             ->update(['actif' => 'inactif']);
    }

     public function accescompte($email,$date)
     {
             $user = User::where('email', $email)
              ->update(['acces_account' => $date]);
     }

     public function getambassadrice($id)
     {

          return User::where('is_admin', $id)->get();
     }

     public function destroy($id)
     {

       $this->getIdUserId($id)->delete($id);
     }


    public function getAll($fields = '*'){
      return User::select($fields)->get()->toArray();
    }






}























