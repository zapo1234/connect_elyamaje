<?php

namespace App\Http\Controllers\Ambassadrice;

use Illuminate\Http\Request;
use App\Http\Service\CallApi\Apicall;
use App\Http\Service\CallApi\NotificationLive;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

use Mail;

use Carbon\Carbon;

use DateTime;



class NotificationController 
{
     private $notif;

    public function __construct(NotificationLive $notif){
          $this->notif = $notif;
    }


    
    public function notiflive($user){
          
    if($user=="67934854968e6ee06568847ead22132f608bf4ec1997265491df0efb"){
        $this->notif->getLives();
         
      }
    }


    }

    