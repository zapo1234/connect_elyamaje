<?php

namespace App\Models\Ambassadrice\Ordercustomer;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordersambassadricecustom extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'code_promo',
      'id_commande',
      'id_ambassadrice',
      'customer',
      'username',
      'telephone',
      'sommme',
      'some_tva',
      
    ];
    
    
    public function User() {

     return $this->belongsTo(Users::class);
    }
}