<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Repository\Users\UserRepository;
use Carbon\Carbon;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;
    
    private $userRepository;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->middleware('guest')->except('logout');
        
        $this->userRepository = $userRepository;
    }

    /**
     * login Auth
     * @return 
     */

    public function login(Request $request)
    {
       $input = $request->all();
       $this->validate($request, [
        'email' => 'required|email',
        'password' => 'required',
       ]);
       
        

        if(auth()->attempt(array('email' =>$input['email'], 'password' =>$input['password'])))
        {
             $date ="en ligne actuelement";
             // recupérer les temps precis de déconnexion
             $email = $request->get('email');
             //Update recupérer le temps de l'exécution
             $this->userRepository->accescompte($email,$date);
              // superadmin
                if(auth()->user()->is_admin == 1 OR auth()->user()->is_admin == 11){
                    if(auth()->user()->rib=="xx11"){
                      return redirect()->route('gestion.home');
                    }
                    else{
                        return redirect()->route('account.list');
                    }
                    
                }
             // ambassadrice
                 elseif(auth()->user()->is_admin == 2 OR auth()->user()->is_admin == 4){
                       
                       return redirect()->route('ambassadrice.user');
                }
             
                 // utilisateur
                 elseif(auth()->user()->is_admin == 3){
                   return redirect()->route('utilisateurs.utilisateur');
                }
                
                 elseif(auth()->user()->is_admin == 5) {
                   return redirect()->route('ambassadrice.suspend');
                }
                
                else {
                 return redirect()->route('other');
               }
           
            // si le compte est descativé
        
         }
        else{
           return redirect()->route('login')->with('error','Identifiants incorrectes !');
        }
        
       
    }
    
    
    public function createpassword(Request $request)
    {
         $password = $request->get('password');
         $email = $request->get('email');
            
            //mise à jour du mot de pass
            $this->userRepository->newPassword($email,$password);
            
            // redirecto route login
           return redirect()->route('login');
        
    }

    /**
     * Create a new controller instance.
     * redirigé user après logout vers la route login
     * @return void
     */
    public function logout(Request $request)
    {
        
         $current = Carbon::now();
         $current1 = $current->addHours(2);
         $current2 = \Carbon\Carbon::createFromFormat('Y-m-d H:i:s',$current1)->format('d/m/Y H:i:s',$current1);
         
         $date ="vue depuis le .$current2";
         // recupérer les temps precis de déconnexion
        $email = Auth()->user()->email;
        //Update recupérer le temps de l'exécution
        $this->userRepository->accescompte($email,$date);
        
        $this->guard()->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();
      
        // detruire toutes les session
         $request->session()->flush();
      
        //  return back();

       if ($response = $this->loggedOut($request)) {
        return $response;
        }

       return $request->wantsJson()
        ? new Response('', 204)
        : redirect('/login');
    }
}
