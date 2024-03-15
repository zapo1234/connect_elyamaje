<?php

namespace App\Http\Controllers\Ambassadrice;

use Illuminate\Http\Request;
use App\Repository\Ambassadrice\HistoriquePanierLiveRepository;
use App\Http\Service\CallApi\Apicall;
use App\Http\Service\CallApi\NotificationLive;

use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Auth;

use Mail;

use Carbon\Carbon;

use DateTime;



class NotificationController 
{
     
    private $historique;
    private $notif;

    public function __construct(HistoriquePanierLiveRepository $historique,
    NotificationLive $notif){
          
        $this->historique = $historique;
        $this->notif = $notif;
    }


    
    public function notiflive(){
          
        $this->notif->getLives();
         return view('livewire.calendars');
    }


    }

    