<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('superadmin.home');
    }

    public function homes()
    {
        return view('ambassadrice.user');
    }

    public function compta()
    {
        return view('comptable.comptas');
    }
    
    public function admins()
    
    {
        return view('superadmin.admin');
    }
    
    
    public function utilisateurs()
    {
        return view('utilisateurs.utilisateur');
    }
    
     public function getsuspend()
    {
        return view('ambassadrice.suspend');
    }
    
    

    
}
