<?php

namespace App\Repository\Ambassadrice;

use App\Models\Ambassadrice\Ambassadricecustomer;
use App\Repository\Ambassadrice\OrdercodepromoaffichageRepository;
use App\Models\FraudeCodePromo;
use App\Http\Service\CallApi\TransfertOrderdol;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Hash;



class AmbassadricecustomerRepository implements AmbassadricecustomerInterface

{

     

     private $model;
     private $counts; // nombre de client créer
     private $data =[];
     private $datas = [];
     private $dataemail = [];
     private $dataphone = [];// recuprer les phones
     private $list = []; // recupérer un tableau associative date et email;
     private $countcustomer =[];// récupérer la variable tableau associative
     private $codepromo = [];
     private $arrayall;// recupérer un array.

     public function __construct(Ambassadricecustomer $model, 
     OrdercodepromoaffichageRepository $orders,
     TransfertOrderdol $order
     )
      {
        $this->model = $model;
        $this->orders = $orders;
        $this->order =$order;
      }

     public function getAllcustoms()
     {
            $status_id=0;
           $name_list = DB::table('ambassadricecustomers')->select('id','id_ambassadrice','code_promo','is_admin','email','telephone')->where('status','=',$status_id)->get();
           $name_lists = json_encode($name_list);
           $name_lists = json_decode($name_list,true);
            $arr =[];
            $list_email =[];
            $list_phone = [];
          foreach($name_lists as $values){

               $arrs =  array(
                $values['id_ambassadrice']=> $values['id_ambassadrice'].','.$values['code_promo'].','.$values['is_admin']
               );

             $arr[] = $arrs;
             $list_email[] = $values['email'];

            $list_phone[] = $values['telephone'];

        }

          DB::disconnect('mysql');

         return $arr;

    }

    public function getCustomers($id)
    {
       return DB::table('ambassadricecustomers')->where('id_ambassadrice', '=', $id)->paginate(15);
    }


    function getidline($id)
    {

      $data =  DB::table('ambassadricecustomers')->select('nom','email','code_promo')->where('id', '=', $id)->get();
      $name_list = json_encode($data);
      $name_list = json_decode($data,true);

      return $name_list;

    }

    public function getCustomerId($id)
    {
      return DB::table('ambassadricecustomers')->where('id_ambassadrice', '=', $id)->get();
    }

    public function getEmail($id)
    {
        $data =  DB::table('ambassadricecustomers')->select('email','code_promo','nom','prenom','telephone')->where('id', '=', $id)->get();
        $name_list = json_encode($data);
        $name_list = json_decode($data,true);
        return $name_list;
   }

    public function getcountcodeeleve()

    { // nombre de code promo créer en cours du mois 

        // recupérer la date et mois en cours
          $date = date('Y-m-d');
          $datet = explode('-',$date);
          $code_mois = (int)$datet[1];
          $code_annee = (int)$datet[0];
          $compt_mot =$datet[0].'-'.$datet[1];
          $data =  DB::table('ambassadricecustomers')->select('date')->get();
          $name_list = json_encode($data);
          $name_list = json_decode($data,true);
          // recupérer les dates 
          $array_date =[];// recupérer la valeur souhaite dans un array
          $array_all =[];
         foreach($name_list as $values){
             $dat = explode('-',$values['date']);
             $date_syntaxe = $dat[0].'-'.$dat[1];
             if($compt_mot == $date_syntaxe) {
                 $array_date[] = $date_syntaxe;
               }
              
               // recupérer ici le mot de pass .
                $array_all[] = $values['date'];
         }
          
         $nombre_code_create = count($array_all);
         // recupérer le nombre
         $this->setArrayall($nombre_code_create);
          $count_array = count($array_date);
          return $count_array;

    }

    public function getDatacount($id)
    {

        $data =  DB::table('ambassadricecustomers')->select('date')->where('id_ambassadrice', '=', $id)->get();
         $name_list = json_encode($data);
         $name_list = json_decode($data,true);
        // recupérer la date et mois en cours
         $date = date('Y-m-d');
         $datet = explode('-',$date);
         $code_mois = (int)$datet[1];
         $code_annee = $datet[0];
          // recupérer tous les codes promo créer en cours du mois.
          $array_count_month = [];

          foreach($name_list as $values) {
              $date = explode('-',$values['date']);
               $date_mois = $date[1];
               if($date_mois == $code_mois && $code_annee == $datet[0]) {
                    $array_count_month[] = $values['date'];
                 }

          }
          // recupérer le tableau du nombre de customer mois en cours
            $this->setCountcustomer($array_count_month);
             return $name_list;
    }


    public function getdatacounts($id,$mois,$annee){
         
      $data =  DB::table('ambassadricecustomers')->select('date')->where('id_ambassadrice', '=', $id)->get();
      $name_list = json_encode($data);
      $name_list = json_decode($data,true);

      
       if(count($name_list)==0){
          $count_nombre =0;
       }

        $array_count_month = [];
        foreach($name_list as $values) {
         $date = explode('-',$values['date']);
          $date_mois = $date[1];
          if($date[1] == $mois && $date[0] == $annee) {
               $array_count_month[] = $values['date'];
            }
          }

          $count_nombre = count($array_count_month);
          return $count_nombre;
      }

    public function getemaildate($email,$id)
    {
        $data =  DB::table('ambassadricecustomers')->select('email','date')->where('email', '=', $email)->where('id_ambassadrice','=',$id)->get();
        $name_list = json_encode($data);
        $name_list = json_decode($data,true);
        return $name_list;
   }
  
   public function getbetwen($email,$date1,$date2,$id)
   {
         $posts = Ambassadricecustomer::where('email','=',$email)->where('id_ambassadrice','=',$id)->whereBetween('date', [$date1, $date2])->get();
         return $posts;
    }
    
     public function getCsutomsambassadrice($id)
     {
         $list  = $this->getCustomerId($id);
         // transformer les retour objets en tableau
          $lists = json_encode($list);
         $lists = json_decode($list,true);
         $ids = Auth()->user()->id;
          $data = DB::table('ordersambassadricecustoms')->select('id_commande','code_promo', 'notification')->where('id_ambassadrice', '=', $ids)->get();
          // tranformer les données dans un tableau 
         // transformer les retour objets en tableau
         $name_list = json_encode($data);
         $name_list = json_decode($data,true);
         // initilisaliser des tableau normale avec clé code_promo
         $tab = [];
         $tabs = [];

         if(count($name_list) ==0){
              $num =0;
              $csss ="nos";
               $cssss ="";
          }
           else{
               $csss ='code1';
               $cssss ='<i class="fa fa-eye" style="font-size:16px;color:black;margin-left:-6%"></i>';

         }

         foreach($name_list as $key => $values){
             // créer un tableau associative pour recupérer les bonnes valuers
               $tab[$values['notification']]= $values['code_promo'];
               $tabs[$values['id_commande']] = $values['code_promo'];
         }

          if(count($lists) > 0){

              foreach($lists as $donns){

               if (array_search($donns['code_promo'],$tab)) {
                     $notification= array_search($donns['code_promo'],$tab);
                     $css= substr($notification,0,3);
                     $mt1 = explode(',',$notification);
                     $montant1 = explode('.',$notification);
                      $montant = $montant1[1];
                      $mm = "commission générée + $montant";
               }
                else{
                       $notification ="no";
                       $css ="no";
                       $montant ="";
                  }

               if(array_search($donns['code_promo'], $tabs)){
                   $id_commande  = array_search($donns['code_promo'], $tabs);
                }
                else{
                     $id_commande ="";
                 }

                // créer un tableau associative de données

                $datas[] =[

                     'id'=>$donns['id'],
                     'id_ambassadrice'=>$donns['id_ambassadrice'],
                     'id_commande'=>$id_commande,
                      'nom' => $donns['nom'],
                      'prenom' => $donns['prenom'],
                      'email' => $donns['email'],
                      'telephone' => $donns['telephone'],
                       'adresse' => $donns['adresse'],
                       'code_promo' => $donns['code_promo'],
                       'datet' => $donns['date'],
                        'notification' =>$notification,
                         'css' => $css,
                        'csss' => $csss,
                       'cssss' =>$cssss,
                         'montant' =>$montant

                 ];

            }

             $id = Auth()->user()->id;
            // MISE à jour suprimer les entrées actuel
             DB::table('ordercodepromoaffichages')->where('id_ambassadrice','=',$id)->delete();
              // insert databse 
              $this->orders->insert($datas);
              return $datas;
          }
           else{

             return false;

          }

    }

    
    /**

   * @return array

    */

   public function getCountcustomer(): array
   {
       return $this->countcustomer;

   }

   public function setCountcustomer(array $countcustomer)
   {
       $this->countcustomer = $countcustomer;
       return $this;
   }

    /**

   * @return array

    */

   public function getList(): array
   {
       return $this->list;

   }

   public function setList(array $list)
   {

     $this->list = $list;

     return $this;

  }

  /**

   * @return array

    */

   public function getDataemail(): array
   {

      return $this->dataemail;

   }

   public function setDataemail(array $data)
   {
       $this->dataemail = $data;
         return $this;
   }

   /**

   * @return array

    */

   public function getDataphone(): array
   {

      return $this->dataphone;

   }

   public function setDataphone(array $data)
   {
     $this->dataphone = $data;
      return $this;
    }

    /**

   * @return array

    */

   public function getDatas(): array
   {
       return $this->datas;

   }

   public function setDatas(array $data)
   {
      $this->datas = $data;
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


   public function getArrayall()
   {
      return $this->arrayall;

   }

   public function setArrayall($arrayall)
   {
       $this->arrayall = $arrayall;
        return $this;
   }

   public function setCounts($counts)
   {
      $this->counts = $counts;
      return $this;
   }



   
   /**

   * @return int

    */

   public function getCounts()
   {
     return $this->counts;

   }

   public function getCustomersId(int $id)
   {
       return Ambassadricecustomer::find($id);
   }
   public function create(array $attribute)
   {
      return $this->model->create($attribute);
   }
  
   public function update($id, array $attribute)
   {
        $users = $this->model->findOrFail($id);
        $users->update($attribues);
   }

    
    public function getCode_promo(): array
    {

        // recupérer les names dans la base de données 
        $name_list = DB::table('ambassadricecustomers')->select('code_promo')->get();
        // transformer les retour objets en tableau
        $name_list = json_encode($name_list);
        $name_list = json_decode($name_list,true);
        // recupérer dans unn tableau les données email
         $donnees = [];
         foreach($name_list as $key => $values){
            foreach($values as $val){
               $donnees[] = $val;
             } 
          }

         // renvoi un tableau array de valeurs
          return $donnees;

    }

     public function getCountData($id)
     {
          $data =  $this->getCustomerId($id);
        // transformer les retour objets en tableau
         $name_list = json_encode($data);
         $name_lists = json_decode($data,true);
          // recupérer dans unn tableau les données email
         // defini la date 
           // créer compte client amabassadrice
           $current = Carbon::now();
           $dateToday = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current)->format('Y-m-d',$current);
           // array associative pour count les valeur date now par amabassadrice
          $donnees = [];
          $donneess =[];
          // recupérer tous les email des clients généres par l'ambassasrice
           foreach($name_lists as  $values) {
                 // recupérer dans un tableau associative les id Auth ambassadrice correspondat à la date courante
                 //convertir la date en date
                 $oldDate = strtotime($values['date']);
                 $newDate = date('Y-m-d',$oldDate);
                 // recupérer
                 $date_m = date('m');
                 $annee = date('Y');
                 $chaine_date = explode('-',$values['date']);
               
                if($newDate == $dateToday){
                      $donnees[] = [
                     'id'=>$values['id_ambassadrice'],
                      'date'=>$values['date'],
                      ];

                  }

                  if($chaine_date[0]==$annee && $chaine_date[1]==$date_m){
                  // recupérer les codes crée pendant le mois en cours.
                     $donneess[] =[
                         'id'=>$values['id_ambassadrice'],
                         'date'=>$values['date'],
                       ];
                  }

                    // creér un tableau email et date
                    $list_data[] = [
                     $values['date']=>$values['email'],
                    ];
                 // recupéer les email correspondant au client d'une amabassadrice
            }

          $email_array =[];
          $phone_array =[];
          $list_data = [];

          foreach($name_lists as $valx){
              $email_array[] = $valx['email'];
               $phone_array[] = $valx['telephone'];

          }

           // recupérer les tableau dans les variables 
            $this->setData($email_array);
            $this->setDatas($phone_array);
             $this->setList($list_data);
             return(count($donneess));

   }

   /**

   * @return array

   */

    public function donnsemail(): array
    {
         //recupérer les données sous forme de tableau des emails customer
          return $this->getDataemail();
    }

    /**

   * @return array

   */

    public function donnsphone(): array
    {
       //recupérer les données sous forme de tableau tous les numéro de téléphone customer
       return $this->getDataphone();
    }
   /**

   * @return array

   */

    public function donnees(): array
    {
         //recupérer les données sous forme de tableau dans la vairable array appartenant à l'utilisateur ou ambassadrice pateneaire
        return $this->getData();
    }

   /**

   * @return array

   */

    public function donees(): array
    {
          //recupérer les données sous forme de tableau dans les contact télephonique appartenant à l'utilisateur amabssadrice ou partenaire
          return $this->getDatas();
     }

    /**

   * @return array

   */

    public function listdatas(): array{
       //recupérer les données sous forme de tableau dans email et date  customer date
       return $this->getList();
     }

   public function numbers(){
      return $this->getCounts();
   }

    public function  getAmbassadricedata($id_ambassadrice){
            $customer = DB::table('users')
           ->join('ordersambassadricecustoms', 'users.id', '=', 'ordersambassadricecustoms.id_ambassadrice')
            ->where('users.id', $id_ambassadrice)
             ->get();

          // transformer les retour objets en tableau
           $list = json_encode($customer);
          $lists = json_decode($customer,true);

        return $lists;

    }

    // recpueérer les infos creéation client code promo (dont l'email et le montant inférieur à 2)

    public function getCustomsambassadrice($id,$email,$phone)
    {

       $data =  DB::table('ambassadricecustomers')->where('id_ambassadrice','=',$id)
      ->whereIn('email', $email)
      ->orWhereIn('telephone', $phone)->get();
       // transformer les retour objets en tableau
       $list = json_encode($data);
       $list = json_decode($data,true);

      return $list;

    }

    // recpueérer les infos creéation client code promo (dont l'email et le montant inférieur à 2)

    public function getCustomseleve($id,$email,$phone){
         $data =  DB::table('ambassadricecustomers')->where('id_ambassadrice','=',$id)
         ->where('email', $email)
         ->orWhere('telephone', $phone)->get();
         // transformer les retour objets en tableau
         $list = json_encode($data);
         $list = json_decode($data,true);

         return $list;
    }

    public function getdatacodepromo(){
        // recupérer le nombre de code élève créer via group by id_ambassadrice
        $data = DB::table('ambassadricecustomers')
         ->select(DB::raw('id_ambassadrice, count(*) as codeleve_count'))
         ->groupBy('id_ambassadrice')
         ->get();
          $counts = json_encode($data);
          $counts = json_decode($data,true);

       return $counts;

    }


    function deleteByCode($code){
        return Ambassadricecustomer::where('code_promo', $code)->delete();
    }
    
    
    public function  getcodeleve($id,$annee)
    {
        
         $data =  DB::table('ambassadricecustomers')->select('email','date','code_promo')->where('id_ambassadrice','=',$id)->get();
         $name_list = json_encode($data);
         $name_list = json_decode($data,true);
          $result_data =[];
        
          foreach($name_list as $val){
             $dat = explode('-',$val['date']);
             $result_data[] =[
                'id_ambassadrice'=> $id,
                'code_promo'=> $val['code_promo'],
                'mois'=> $dat[1],
                'annee'=> $dat[0],
    
                ];
        }
        
          // insert dans table fflottante
          DB::table('amba_eleves')->truncate();
          // insert dans la table
          DB::table('amba_eleves')->insert($result_data);
          // recupérer un count groupy by selons les annees, et mois code crée
          $code_creates = DB::table('amba_eleves')
                       ->select('mois','annee' ,DB::raw('COUNT(code_promo) as nombre_create'))
                      ->where('annee',$annee)
                      ->groupBy('mois','annee')
                       ->get();
                      
              $count_code = json_encode($code_creates);
              $count_codes = json_decode($count_code,true);

              // le nombre de code utilisé pendant l'annnée....
              $code_live =11;// code éléve
              $code_use = DB::table('ordersambassadricecustoms')
                      ->select('code_mois','annee' ,DB::raw('COUNT(code_promo) as nombre_use'))
                      ->where('annee','=',$annee)
                      ->where('id_ambassadrice','=',$id)
                      ->where('code_live','=',$code_live)
                      ->groupBy('code_mois','annee')
                      ->get();
                      
                 $count_uses = json_encode($code_use);
                 $count_used = json_decode($count_uses,true);    
                 
                 $mois_create =[];
                 $mois_no_sta =[];

                 foreach($count_used as $van){
                    $mois_create[] = $van['code_mois'];
                 }
                
                 $mois_used =[];
                 $result_code_create =[];
                 foreach($count_codes as $values){
                    $chaine_data = $values['mois'].','.$values['nombre_create'];
                     $result_code_create[$chaine_data] = $values['mois'];
                     $mois_used[] = $values['mois'];
                  }
               

                  foreach($mois_used as $value){
                     if(!in_array($value,$mois_create)){
                         $mois_no_sta[] = $value;
                     }
                  }

                  // créer des données pour affiché 
                  $resultat_data =[];
                  // recupérer les users.
                 $users = DB::table('users')
                 ->select('id','name','is_admin')
                 ->get();

                 $name_lis = json_encode($users);
                 $name_lis = json_decode($users,true);
                 $list_users =[];

                 foreach($name_lis as $val){
                   $list_users[$val['name']] = $val['id'];
                  }
               
                 $result_datas =[];
                 $result_datax =[];
                 $mois_no =[];
                 foreach($count_used as $val){
                     $nombre_create = array_search($val['code_mois'],$result_code_create);
                     //
                      if($nombre_create!=false){
                        $nombre_c = explode(',',$nombre_create);
                        $name = array_search($id,$list_users);
                        $result_datas[] =[
                        'Période'=> $this->getmois($val['code_mois']).' '.$annee,
                        'Ambassadrice'=>$name,
                        'Nombre code crée(s)'=>$nombre_c[1],
                        'Nombre code utilisé(s)'=>$val['nombre_use']
                    
                    ];
                 }

                   // recupérer les 
                   if($nombre_create==false){
                       $name = array_search($id,$list_users);
                        $result_datax[] =[
                        'Période'=> $this->getmois($val['code_mois']).' '.$annee,
                        'Ambassadrice'=>$name,
                        'Nombre code crée(s)'=>'0',
                        'Nombre code utilisé(s)'=>$val['nombre_use']
                 
                      ];
                  }

                  // traiter.. les données pour les mois ou y'au eu création de code.
                 }
                  
                 $result_datac=[];
                 foreach($mois_no_sta as $vlu){
                     //
                     $nombre_create = array_search($vlu,$result_code_create);
                     $nombre_c = explode(',',$nombre_create);
                      $name = array_search($id,$list_users);
                      $result_datac[] =[
                      'Période'=> $this->getmois($vlu).' '.$annee,
                      'Ambassadrice'=>$name,
                      'Nombre code crée(s)'=>$nombre_c[1],
                      'Nombre code utilisé(s)'=>0
                   ];
               }
               
                  
                 $result_final = array_merge($result_datas,$result_datac,$result_datax);//merge les deux.
                 return $result_final;
                      
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


    public function doublonscreate()
    {
         
      
      // Algo de control 
      
         $data =  DB::table('ambassadricecustomers')->select('nom','prenom','id_ambassadrice','email','date','code_promo')->get();
         $name_list = json_encode($data);
         $name_list = json_decode($data,true);
         // recupérer les données user 
         $datas =  DB::table('users')->select('id','name','username')->get();
         $name_lists = json_encode($datas);
         $name_lists = json_decode($datas,true);

         $datas_user =[];
         $data_user2 =[];
         $data_user3 =[];

         foreach($name_lists as $valc){
            $chaine = $valc['id'].','.$valc['name'].','.$valc['username'];
            $data_user[$chaine] = $valc['id'];
         }
    
         $array_email_doublons =[];
         $array_id_amba =[];
         $array_date =[];
         $chaine_data =[];// 1 niveau de controle 
         $chaine_data1 =[];// 2eme niveau controle
         $chaine_data2 = [];// 2eme niveau critère 1
         $data_promo =[];
         $data_promo1 =[];

         //vérifer dans un 1 er cas les code créer le meme jour par la meme ambassadrice ayant le meme(exception)
         // aller chercher tous les nom et prénom commençant par les 5 première caractère créer dans le meme mois (2ème cas)
         // 3eme cas posssible compter le nombre de code créer par l'ambassadrice en une seul journée.
         foreach($name_list as $val){
              // 1er cas crée une chaine de catractère entre id_ambassadrice,le jour,email
               $date = $val['date'];
               // recupérer le jour mois et annné.
               $mois_actuel = date('m');// le mois actuel
               
               $mois_m = (int)$mois_actuel;
               if($mois_m==1){
                 $mois_true =12;
                 $mois_true1 = 11;
               } else{
                  $mois_true = $mois_m-1;
                  $mois_true1 = $mois_m-2;
               }

                $date_chaine = explode('-',$date);
                $jour = $date_chaine[2];
                $mois = $date_chaine[1];
                $annee = $date_chaine[0];
                 //formater une chaine de caractère suivante
                $chaine_data[]= $val['email'].','.$val['id_ambassadrice'].','.$jour.','.$mois.','.$annee;
                // 2 èeme cas de controle 
                // recupére à partir de 3 première lettre du nom et prenom
               if(strlen($val['nom']) <= 5){
                 $chaine_data1[] = $val['id_ambassadrice'].','.$val['nom'].','.$mois.','.$annee;
                 $data_promo[] =  $val['id_ambassadrice'].','.$val['nom'].','.$mois.','.$annee.','.$val['code_promo'];
              }
               if(strlen($val['nom'])> 5 && strlen($val['prenom'])> 5){
                  // recupérer les 5 première lettre du nom et du prénom
                  $name_s = substr($val['nom'],0,5);
                  $prenom_s = substr($val['prenom'],0,5);
                  $chaine_data2[] = $val['id_ambassadrice'].','.$name_s.','.$prenom_s.','.$mois.','.$annee;
                   $data_promo1[] =  $val['id_ambassadrice'].','.$name_s.','.$prenom_s.','.$mois.','.$annee.','.$val['code_promo'];
             }
               $array_email[] = $val['email'];
               
                  $name_s = substr($val['nom'],0,5);
                  $prenom_s = substr($val['prenom'],0,5);
                  $chaine_promo =$val['id_ambassadrice'].','.$val['code_promo'].','.$name_s.','.$prenom_s;
                  $code = $val['code_promo'];
                  // $array_id_amba [] = $val['id_ambassadrice'].','.$val['email'];
                  //$date = $val['date'].','.$val['email'].','.$val['id_ambassadrice'];
                   // $array_date[$date] = $val['email'];
          }

              // recupérer les doublons nécéssaire vi la valeur des array. 
               $doublons_cas =  array_count_values($chaine_data);
               $doublons_cas1 =  array_count_values($chaine_data1);
               $doublons_cas2 = array_count_values($chaine_data2);
               // recupérer les cibles détecter au cas ou.
               //recupérer le cas ou il y'a plus de 2 index similaire.
               $result_data =[];// cas 1
               $result_data1 =[];// cas 2
               $result_data2 =[];// cas 3

              foreach($doublons_cas as $key => $value){
                 if($value > 1){
                   $result_data[] = $key;
                 }
              } 

              foreach($doublons_cas1 as $keys => $valu){
                    if($valu > 1) {
                   $result_data1[] = $keys;
                }
             }

              foreach($doublons_cas2 as $kys => $valus){
              if($valus > 1) {
               $result_data2[] = $kys;
              }
            }

            // recupérer les données
            // construire des doonnées.
            $result_statistique =[];
            $result_statistique1 =[];
            $result_statistique2 =[];
            // traiter le cas 1
            $data_code =[];
            foreach($result_data as $value) {

                    $chaine_regex = explode(',',$value);
                    $id_amba = $chaine_regex[1];
                    $name_amba = array_search($id_amba,$data_user);
                    if($name_amba !=false){

                    $name_ambassadrice = explode(',',$name_amba);
                    $name_true = $name_ambassadrice[1].' '.$name_ambassadrice[2];
                     
                    // recupérer le code_promo 
                    foreach($data_promo as $key => $donnees){ 
                           $chaine_code = explode(',',$donnees);
                           if($id_amba == $chaine_code[1])
                           {
                              $data_code[$id_amba] = $key;
                           }
                    }
                    // construire mon tableau
                    $result_statistique[] = [
                          'name_ambassadrice'=>$name_true,
                         
                    ];

             }

          }


          
          foreach($result_data1 as $value) {

               $chaine_regex = explode(',',$value);
               $id_amba = $chaine_regex[0];
               $name_regex = $chaine_regex[1];
            
                $name_amba = array_search($id_amba,$data_user);
               if($name_amba !=false){
                  $name_ambassadrice = explode(',',$name_amba);
                  $name_true = $name_ambassadrice[1].' '.$name_ambassadrice[2];
                 // recupérer le code_promo 
                foreach($data_promo as $key => $donnees){ 
                   $chaine_code = explode(',',$donnees);


                   if($id_amba == $chaine_code[0] && $name_regex==$chaine_code[1])
                   {
                      $data_code1[] = $chaine_code[4];
                   }
                  
               }
              // construire mon tableau
             $result_statistique1[] = [
                  'name_ambassadrice'=>$name_true,
                 
            ];

      }

      foreach($result_data2 as $value) {

          $chaine_regex = explode(',',$value);
          $id_amba = $chaine_regex[0];
          $name_regex = $chaine_regex[1];
          $prenom_regex = $chaine_regex[2];
      
          $name_amba = array_search($id_amba,$data_user);
          if($name_amba !=false){
            $name_ambassadrice = explode(',',$name_amba);
            $name_true = $name_ambassadrice[1].' '.$name_ambassadrice[2];
           // recupérer le code_promo 
          foreach($data_promo1 as $key => $donnees){ 
             $chaine_code = explode(',',$donnees);
             if($id_amba == $chaine_code[0] && $name_regex==$chaine_code[1] && $prenom_regex==$chaine_code[2]) {
                $data_code2[] = $chaine_code[5];
             }
            
         }
         // construire mon tableau
         $result_statistique1[] = [
            'name_ambassadrice'=>$name_true,
           ];

    }

    }
   }

      // recupérer tous les codes dans la table orderambassadrices.
      $donnees =  DB::table('ordersambassadricecustoms')->select('code_promo','id_commande','customer','username','total_ht','somme','datet')->get();
      $name_list = json_encode($donnees);
      $name_list = json_decode($donnees,true);
   
      $result_doublons =[];
      $data_result =[];
      $data_result_code =[];
      foreach($name_list as $kl => $valuc){
         $chaine = $valuc['id_commande'].','.$valuc['code_promo'].','.$valuc['customer'].','.$valuc['username'].','.$valuc['datet'].','.$valuc['somme'];
         $data_result[$chaine] = $valuc['code_promo'];
         $data_result_code[$valuc['id_commande']] = $valuc['code_promo'];
      }
     
        // recupérer les données user 
        // recupérer les correspondace souhaite
        // boucler sur le code deux..
        $array_doublons_code_use =[];
        foreach($data_code2 as $val) {
                 $true_data = array_search($val,$data_result);
                if(isset($data_result_code[$val])==true){
                    $array_doublons_code_use[]=$val;
                }
                 if($true_data==false){
                 $name = explode('-',$val);
                 $etat ="non utilisé";
                 $data_stat1[] =[
                'id_commande'=>'',
                'ambassadrice'=>$name[0],
                 'customer'=>'',
                 'etat'=>$etat,
                 'code_promo' => $val,
                   'date'=>'',
                   'commission'=>''
               ];
            }
            else{
                    $etat="à reçu une commission";
                    $chaine_index_data = explode(',',$true_data);
                    $name = explode('-',$chaine_index_data[1]);
                    // adjourner
                    if(isset($data_result_code[$chaine_index_data[1]])==true){
                        $array_doublons_code_use[]=$chaine_index_data[1];
                    }

                    $data_stat2[] =[
                    'id_commande'=>$chaine_index_data[0],
                    'ambassadrice'=>$name[0],
                    'customer'=>$chaine_index_data[2].''.$chaine_index_data[3],
                    'etat'=>$etat,
                    'code_promo' =>$chaine_index_data[1],
                    'date'=> $chaine_index_data[4],
                    'commission'=>$chaine_index_data[5],
                ];
          }
      }


         //DB::table('fraude_code_promos')->insert($data_stat2);
         //DB::table('fraude_code_promos')->insert($data_stat1);
         // insert dans la bdd
         // filtrer en fonction de la commande ....
          dump($array_doublons_code_use);
         dump($data_stat1);
         dd($data_stat2);
     
}


  public function getmodelmessage($id)
   {
         // recupérer 
         $data =  DB::table('models_message')->select('id','titre','sujet','message','date')->where('id_ambassadrice','=',$id)->get();
         $name_list = json_encode($data);
         $name_list = json_decode($data,true);
         // recupérer les données user 
          return $name_list;

   }
   
   
   public function getmodelmessages($id)
   {
        // recupérer 
         $data =  DB::table('models_message')->select('id','titre','sujet','message','date')->where('id','=',$id)->get();
         $name_list = json_encode($data);
         $name_list = json_decode($data,true);
         // recupérer les données user 
          return $name_list;
       
   }
    
    
    
}

    

    