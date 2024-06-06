<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use App\Repository\Users\UserRepository;
use App\Repository\Ambassadrice\CodeliveRepository;
use App\Repository\Bilandate\BilandateRepository;
use App\Repository\Pointbilan\PointbilanRepository;
use App\Http\Service\CallApi\Apicall;
use App\Http\Service\Mailer\ServiceMailer;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use DateTime;
use App\Models\User;

class CreateAccountController
{
    private $userRepository;
    
    private $api;
    
    private $mailer;
    
    private $codelive;
    
    public function __construct(UserRepository $userRepository, 
    Apicall $api,
    ServiceMailer $mailer,
    CodeliveRepository $codelive,
    BilandateRepository $bilan,
    PointbilanRepository $point )
    {
        $this->userRepository = $userRepository;
        $this->api = $api;
        $this->mailer = $mailer;
        $this->codelive = $codelive;
        $this->bilan = $bilan;
        $this->point = $point;
        
        
    }
   
   
   public function create()
   {
       if(Auth::check()) {
        if(Auth::user()->is_admin==1){
            return view('account.users');
         }
      }
   }

   public function create_ambassadrice()
   {
       if(Auth::check()) {
        if(Auth::user()->is_admin==1){
            return view('account.create_ambassadrice');
         }
      }
   }

   public function create_partenaire()
   {
       if(Auth::check()){
        if(Auth::user()->is_admin==1){
            return view('account.create_partenaire');
         }
      }
   }
   
   public function createaccount(Request $request)
   {   
                $request->validate([
                    'account_name' => 'required',
                    'account_username' => 'required',
                    'account_email' => 'required',
                    'account_codep' => 'required'
                ]);
            
		          if(Auth::check())  {
                    if(Auth::user()->is_admin==1){  
                         // verifié si le mail existant existe
		                 // recupérer des emails
		                $email_account = $request->get('account_email');
		                $code_live = $request->get('code_live');
		                $email = $this->userRepository->getEmail($email_account);
		                 // recupere les code livers existant
		                $codes = $this->codelive->getAllcodelive();
		                $codes = $this->codelive->donnees();
		            
	      	       if($email){
			          return redirect()->route('account.users')->with('error_email','échec e-mail  utilisé sur un autre compte !');
			           
		           }
		           
		           
		           else
		           {
		              // on enregsitre l'utilisateur et on l'envoi un lien pour activé son mot de pass
		              // on récupere le type de compte
		              // recupere dans un array les variable
		              // recuperation des données
                       $data = $request->input();
                       
		                 if($data['account_type'] =='Admin'){
		                      $role = 11;
		                      $attribute = "Admin";
                              $code_live="";
		                  }
		           
		                  elseif($data['account_type'] =='Ambassadrice') {
		                     $role = 2;
		                     $attribute="Ambassadrice";
                             $code_live = $data['code_live'];
		                 }
		                 
		                 elseif($data['account_type']=="Partenaire"){
		                     $role = 4;
		                     $attribute="Partenaire";
                             $code_live ="";
		                 }
		                 
		                 elseif($data['account_type']=='rien'){
		                     $role = 3;
		                     $attribute = 'utilisateur';
                             $code_live="";
		                 }
		           
		                 else
		                 {
		                     $role = 3;
		                     $attribute ="utilisateur";
                             $code_live="";
		                 }
		                 
		                 $acces ="compte activé";
		                 
		                // upload picture
		                 $file = $request->file('file');
		                 if($file){
		                 $extension = $file->getClientOriginalExtension();
		                  $name = $file->getClientOriginalName();
                            $filename = time().'.'.$extension;
		                 }
		                 
		                 else{
		                     $filename="";
		                     $extension="";
		                 }
		                 $filename = time().'.'.$extension;
		                 $datas = $this->api->store($file,$filename);
		                 
		                 if($datas =="succes" OR $datas =="") {
		                      //nommmer les variable
		                     $date = Carbon::now();
                             $token = Str::random(40);
                             $password ="null";
                            $active ="actif";
                             $img ='<i class="fa fa-circle" style="font-size:24px; style="color:green"></i>';
                           // insert data user
                           // insert into dd
                           // créer des password généré
                           // génerer un mot de pass
                             $rand_pass = rand(136,50000);
                            $password_creat = "elyamaje@$rand_pass";
                           // crypter l'email.
                             $password_creat1 = Hash::make($password_creat);
                           
                               $user =  $this->userRepository->create([
                               'name'=>$data['account_name'],
                              'username'=>$data['account_username'],
                              'type_account'=>$data['account_type'],
                              'account_societe'=>$data['account_societe'],
                              'siret'=>$data['siret'],
                              'actif' => $active,
                              'attribut' => $attribute,
                              'img_select' => $filename,
                              'email' => $data['account_email'],
                              'addresse' => $data['account_address'],
                              'code_postal'=> $data['account_codep'],
                              'ville' => $data['account_ville'],
                              'telephone' => $data['account_phone'],
                              'email_verified_at'=> $password,
                              'is_admin' => $role,
                              'code_live'=>$code_live,
                             'code_reduction'=>$data['reduction'],
                             'acces_account' => $acces,
                              'dates' => $date,
                              'password' => $password_creat1,
                               'remember_token' => $token,
                     
                      ]);
                      
                      // insert dans la table code live
                      $code_live = $request->get('code_live');
                      $id_ambassadrice = $user->id;
                      $is_admin = $role;
                      
                      if($code_live!="") {
                          $this->codelive->insert($code_live,$id_ambassadrice,$is_admin);
                           $som=0;
                           $a="";
                          $current = Carbon::now();
                         // ajouter un intervale plus un jour !
                           $current1 = $current->subDays(2);
                           $current2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current1)->format('Y-m-d\TH:i:s',$current1);
                          $data_donnes = [
                          'code' => $code_live,
                          'amount' => $som,
                          'date_created' => $current,
                          'date_created_gmt'=> $current,
                          'date_modified' => $current,
                         'date_modified_gmt' => $current,
                          'date_expires' => $current2,
                          'discount_type' => 'percent',
                           'individual_use' => true,
                
                          ];
                        
                          // insert dans Api woocomerce
                          $urls="https://www.elyamaje.com/wp-json/wc/v3/coupons";
                          $code_return = $this->api->InsertPost($urls, $data_donnes);
                          $id_coupons = $code_return[0]['id'];
                         // insert dans la table codelives 
                         $array_code_live[] = [
                            'is_admin'=>$role,
                            'code_live'=>$code_live,
                             'id_ambassadrice' => $id_ambassadrice,
                             'id_coupons' => '',
                             'status'=>'',
                             'css'=>'',
                             'nombre_fois'=>0,
                             'nbres_live'=>0,
                             'date_after'=> '2023-01-01 20:00:00',
                             'date_expire'=>'2023-01-01 20:00:00',
                             'updated_at'=>'2023-01-01 20:00:00',
                             'created_at'=>'2023-01-01 20:00:00'

                         ];

                           DB::table('codelives')->insert($array_code_live);
                           


                      }
                         
                      $mois = date('m');
                      $id_mois = (int)$mois;
                      $date_jour ='';
                      $date_annee = date('Y');
                      $name = $data['account_name'].' '.$data['account_username'];
                      $type_compte = $data['account_type'];
                      $account_societe = $data['account_societe'];
                      $email =  $data['account_email'];
                      $array_societe = array('EI');
                       $array_societe1 = array('SAS','SARL','SASU');

                       if(in_array($account_societe,$array_societe)){
                          $tva =0;
                       }
                       elseif(in_array($account_societe,$array_societe1)){
                          $tva =20;
                       }else{
                          $tva =0;
                       }
                     // insert dans la table pointbilan et bilandate...
                     if($role==2 OR $role==4){
                        $this->bilan->insertdata($id_ambassadrice,$id_mois,$date_jour,$date_annee);
                        $this->point->insertpoint($id_ambassadrice,$is_admin,$account_societe,$tva,$email,$name,$type_compte);
                     }
                      // redirect list account..
                      // envoi du mail pour initilisation du mot de pass !
                      // send email
                        $sql = $request;
                        $email = $request->get('account_email');
                        $name = $request->get('account_name');
                      
                        if($role==2){
                            Mail::send('email.messagecompt', ['token' => $token, 'email' =>$email, 'password_creat'=>$password_creat, 'password_creat1'=>$password_creat1], function($message) use($request){
                            $message->to($request->get('account_email'));
                            $message->from('no-reply@elyamaje.com');
                            $message->subject('Confirmation de création de compte Elyamaje !');
                          });
                      
                      }


                      elseif($role==3){
                        Mail::send('email.messageusercompt', ['token' => $token, 'email' =>$email, 'password_creat'=>$password_creat, 'password_creat1'=>$password_creat1], function($message) use($request){
                            $message->to($request->get('account_email'));
                            $message->from('no-reply@elyamaje.com');
                            $message->subject('Confirmation de création de compte Elyamaje !');
                          });
                       }
                      
                      else{
                          
                            Mail::send('email.messagecompts', ['token' => $token, 'email' =>$email, 'password_creat'=>$password_creat, 'password_creat1'=>$password_creat1], function($message) use($request){
                          $message->to($request->get('account_email'));
                          $message->from('no-reply@elyamaje.com');
                           $message->subject('Confirmation de création de compte Elyamaje !');
                        });
                          
                      }
                      
                     // retun sur la same page
                     
                      // $from = "no-reply@prodev.elyamaje.com";
                       // $subject="Service Elyamaje ,Confirmation de Création de compte ";
                     
                       //$lien ='<a style="color:white;text-decoration:none;" href="https://prodev.elyamaje.com/create/password/'.$token.'/'.$email.'">Confirmer votre compte</a>';
                     //$message='<div style="text align:center; font-size:18px;margin-top:20px;"><h1> Bonjour '.$name.'</h1>
                     //votre compte Elyamaje à été crée veuillez cliquer sur le lien ci dessous !<br/><button style="background-color:black;color:white;font-size:16px;font-family:arial;border-radius:15px;width:200px;height:50px;">'.$lien.'</button></div>';
            
                     // appel du service Mailer
                     // $this->mailer->SendMail($email,$from,$subject,$message);
                      return redirect()->route('account.confirm');
		      }
		      
		      if($datas =="denie")
		      {
		          return redirect()->route('account.users')->with('errors', 'la taille du fichier est moins de 1000 KO!');
		      }
		      
		      if($datas =="denied")
		      {
		          return redirect()->route('account.users')->with('errors', ' l\'extension n\'est pas recommandé !');
		      
		      }
		      
		    
		               
		     }
          
           }
           
        }
               
   }
           
           
            public function confirmaccount()
            {
               return view('account.confirm');
            }
            
           
            public function list()
            {
               if(Auth::check())
               {
                 if(Auth::user()->is_admin==1)
                 {
               // recupérer la liste des utilisateurs
                $users = $this->userRepository->getAllUsers();
               
                return view('account.list', ['users'=>$users]);
               }
               
               
               else{
                   return('<div style="margin-auto;color:black;font-size:20px;font-weight:bold"> No access definied 404 </div>');
                  }
               
               }
            }
         
        
           public function updateacces(Request $request, $id)
           {
               // recupere id passé en paramètre post
               
             
               
        }
        
        
        public function edit($id, $token, Request $request)
        {
           
          if(Auth::check())
             {
               if(Auth::user()->is_admin==1)
                 {
          $user = $this->userRepository->getUserId($id);
           
           return view('account.edit',['user'=>$user, 'id' => $id, 'token'=> $token]);
           
                 }
                 
               }
            
        }
        
        public function editaction(Request $request,$id,$token)
        
        {
            
            $data = $request->input();
                       
		              
		                  if($data['account_type'] =='Admin')
		                  {
		                      $role = 11;
		                      $attribute = "Admin";
		                  }
		           
		                  elseif($data['account_type'] =='Ambassadrice')
		                 {
		                     $role = 2;
		                     $attribute="Ambassadrice";
		                 }
		                 
		                 elseif($data['account_type']=="Partenaire")
		                 {
		                     $role = 2;
		                     $attribute="Partenaire";
		                 }
		                 
		                 elseif($data['account_type']=='rien')
		                 {
		                     $role = 3;
		                     $attribute = 'utilisateur';
		                 }
		           
		                 else
		                 {
		                     $role = 3;
		                     $attribute ="utilisateur";
		                 }
		                 
		                 $acces ="compte activé";
            
            
            
            
            
            if($request->input('compte')=="" OR $request->input('compte')=='actif'){
                $compte = "actif";
                 $img_active ='<i class="fa fa-circle" style="font-size:24px; style="color:green"></i>';
                 // definit les roles
                 if($request->input('account_type') =='Admin'){
		                      $role = 11;
		                      $attribute = "Admin";
		                  }
		           
		                  elseif($request->input('account_type') =='Ambassadrice'){
		                     $role = 2;
		                     $attribute="Ambassadrice";
		                 }
		                 
		                 elseif($request->input('account->type')=="Partenaire") {
		                     $role = 4;
		                     $attribute="Partenaire";
		                 }
		                 
		                 elseif($request->input('account_type')=='rien'){
		                     $role = 3;
		                     $attribute = 'utilisateur';
		                 }
		           
		                 else{
		                     $role = 3;
		                     $attribute ="utilisateur";
		                 }
		                 
		                 // modifier le role 
		                
                 
            }
            
            else{
                $compte = $request->input('compte');
                
                 $img_active ='<i class="fa fa-circle" style="font-size:24px; style="color:red"></i>';
                 // definir le role permission adapte
                 
                 $is_invite=1;
                 
                 
            }
            
            if($request->input('account_address')) {
                $adresse="non défini";
            }
            
            else{
                
                $request->get('account_adress');
            }
            
            if($request->input('account_ville')=="") {
                $ville="";
            }
            
            else{
                
               $ville = $request->input('account_ville');
            }
            
            
            // upload picture
		        $file = $request->file('file');
		        // recupérer les infos du user
		       $user = $this->userRepository->getUserId($id);
		        // upload picture
		                 $file = $request->file('file');
		                 if($file){
		                 $extension = $file->getClientOriginalExtension();
		                  $name = $file->getClientOriginalName();
                            $filename = time().'.'.$extension;
		                 }
		                 
		                 else{
		                     $filename= $user->img_select;
		                     $extension="";
		                 }
		                 $filename = time().'.'.$extension;
		                 // upload image if existe
		                $datas = $this->api->store($file,$filename);
		                
		                
		                
		               
		                
		       if($datas =="succes" OR $datas =="") {
            
                    $accounts = User::findOrFail($id);
	       	        $accounts->name = $request->input('account_name');
	     	        $accounts->username = $request->input('account_username');
		            $accounts->type_account = $request->input('account_type');
		            $accounts->account_societe = $request->input('account_societe');
		            $accounts->siret = $request->input('siret');
		            $accounts->attribut = $attribute;
		            $accounts->actif = $compte;
		            $accounts->img_select = $filename;
		            $accounts->email = $request->input('account_email');
		            $accounts->addresse = $request->input('account_address');
		            $accounts->ville = $request->input('account_ville');
		            $accounts->telephone = $request->input('account_phone');
		            //$accounts->is_admin = $role;
                    $accounts->is_invite = $is_invite;
		            $accounts->code_live = $request->input('code_live');
		     
		            //insert
	                $accounts->save($request->all());
	             
	               // modifier le code_live
                   // modifier le code promo dans la table
	               DB::table('codelives')->where('id_ambassadrice', $id)->update([
                   'code_live' => $request->input('code_live')
                   ]);
                   //renvoyer sur la liste des comptes utilisateurs
                  return redirect()->route('account.list');
             
		       }
		       
		      if($datas =="denie"){
		          return redirect()->route('account.users')->with('errors', 'la taille du fichier est moins de 1000 KO!');
		      }
		      
		      if($datas =="denied"){
		          return redirect()->route('account.users')->with('errors', ' l\'extension n\'est pas recommandé !');
		      
		      }
		       
		       
		      
			           
        }
        
        public function destroy($id)
        {
            // renvoi la fonction ai delete
            User::find($id)->delete($id);
            
             
        }
        
         
  }

