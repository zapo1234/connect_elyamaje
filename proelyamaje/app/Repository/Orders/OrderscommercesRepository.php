<?php

namespace App\Repository\Orders;
use App\Models\Orderscommerce;
use Carbon\Carbon;
use Hash;
use Mail;

class OrderscommercesRepository implements OrderscommercesInterface
{
    public function countOrder(){
        $orders = Orderscommerce::all()->groupBy('id_commande');
        return $orders->count();
    }
}