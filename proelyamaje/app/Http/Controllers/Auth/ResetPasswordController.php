<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Repository\Users\UserRepository;
use App\Http\Service\Mailer\ServiceMailer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Hash;
use Illuminate\Support\Str;
use Mail; 
use Illuminate\Support\Facades\Validator;

class ResetPasswordController extends Controller
{
    
    private $userRepository;
    private $serviceMailer;
     private $mailer;
    
    public function __construct(UserRepository $userRepository, ServiceMailer $mailer)
    {
        $this->userRepository = $userRepository;
         $this->mailer = $mailer;
        
    }
    
    
    public function reset_pass()
    {
        return view('auth.passwords.reset');
    }
    
    public function createpass($token,$email)
    {
        return view('auth.passwords.confirmaccount',['token' => $token ,'email'=>$email]);
    }
    
    public function sendEmail(Request $request)
    {
       // ckeck email (récupérer l'email de user et verifier si existe)
        $email = $request->get('email');
        $user_email = $this->userRepository->getEmail($email);
        if(!$user_email)
        {
             return redirect()->route('auth.passwords.reset')->with('error','cette adresse e-mail n\'est pas identifié !');
        }
        
        else
        {
               $token = Str::random(64);
               $sql = $request;
               $email = $request->get('email');
               
               $token_user = $this->userRepository->getToken($email,$token);
               //insert data dans password reset
                $this->userRepository->insertTokenresetPassword($email,$token);
                // Recupere le nom de l'utilisateur
                $name= $this->userRepository->getEmail($email);
                $name1 = $name->name;
               // send email
               Mail::send('email.resetpassword', ['token' => $token, 'email' =>$email, 'name1'=> $name1], function($message) use($request){
               $message->to($request->get('email'));
               $message->from('no-reply@elyamaje.com');
               $message->subject('Reinitialiser votre mot de passe !');
               });
              // redirect to route
              
               return redirect()->route('auth.passwords.reset')->with('success','Un mail a été envoyé à cette adresse !');
         }
     }
     
     
     public function updatepass($token)
     {
         // afficher view pour reset password
          return view('auth.passwords.resetpassword',['token' => $token]);
     }
     
     
     public function newpass()
     {
         return view('auth.passwords.confirm');
     }
     
     public function updatepassword(Request $request)
     {
              // traiter la reinitialisation du password
         
              //modifier le password et delete dans la table password-reset
		           $email = $request->get('emails');
	               $token = $request->get('tokens');
		
		           $token_user = $this->userRepository->getToken($email,$token);
		           // recupérer les deux password
		           $pass = $request->get('password');
		           $pass1 = $request->get('password-confirm');
		           
		           if(!$token_user){
                      return redirect()->route('auth.passwords.resetpassword',['token'=>$token])->with('errors','permission invalide !');
                    }
                    elseif($pass!=$pass1){
                       return redirect()->route('auth.passwords.resetpassword',['token'=>$token])->with('errors','les mots de passes ne sont pas identiques !');
                    }
                    elseif(!preg_match('/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)[a-zA-Z\d]{8,12}$/', $pass)) {
                       return redirect()->route('auth.passwords.resetpassword',['token'=>$token])->with('errors','le mot de passe doit contenir 1 nombre, une lettre majuscule et minuscule');
                   }
                   
                   else{
                   
                         // faire les modifications 
                         $email = $request->get('emails');
                         $password = $request->get('password');
                         //udapte password
                         $this->userRepository->newPassword($email,$password);
                         // delete data password rest
                         $this->userRepository->deletepassword_reset($email);
                         //redirect login

                         Mail::send('email.newrestpassword', ['pass' => $pass], function($message) use($request){
                            $message->to($request->get('emails'));
                            $message->from('no-reply@elyamaje.com');
                            $message->subject('Vos nouveaux accès Connect Elyamaje!');
                            });
                           // redirect to route ...
                          return redirect()->route('auth.passwords.resetpassword',['token'=>$token])->with('success','Votre mot de pass est bien actualisé,un mail vous a été envoyé merci de le consulter !');
                   
		        }
	   }

        
        
        
        public function createpassword(Request $request)
        {
            
            
            
        }
        
     
    }
    
 
