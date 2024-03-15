<?php

namespace App\Repository\Event;

use App\Models\Ambassadrice\Event;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class EventRepository implements EventInterface
{
     
    

    public function __construct()
    {
     
      
    }
    
    
   public function getAll()
   {
       
   }
    
    
   public function insert($title,$start,$end,$status,$id_ambassadrice)
   {
       $event  = new Event();
       $event->id_ambassadrice = $id_ambassadrice;
       $event->title = $title;
       $event->start = $start;
       $event->end = $end;
       $event->status = $status;
       $event->save();
   }
   
   
   public function updateaction($title,$start,$end,$status,$id_ambassadrice)
   {
       // faire un update
          DB::table('events')
                   ->where('id_ambassadrice', $id_ambassadrice)
                    ->update(array('title' =>$title,
                                  'start'=>$start,
                                  'end'=>$end,
                                  'status'=>$status
                    ));
       
       
   }
    
}
     
    
    