<?php

namespace App\Models\Ambassadrice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderrestriction extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'datet',
      'code_promo',
      'id_commande',
      'id_ambassadrice',
      'is_admin',
      'status',
      'customer',
      'username',
      'email',
      'telephone',
      'adresse',
      'total_ht',
      'sommme',
      'commission',
      'some_tva',
      'notifcation',
      'code_mois',
      'annee',
      'code_live',
      
    ];
    
    
    public function User() {

     return $this->belongsTo(Users::class);
    }
}