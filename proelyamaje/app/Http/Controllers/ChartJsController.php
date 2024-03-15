<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use DB;
use Carbon\Carbon;

class ChartJsController extends Controller
{
    public function chartjs()
    {   
        if(Auth::check())
        {
          $x = Auth::user()->id;
          dd($x);
        }
        
    }
}
