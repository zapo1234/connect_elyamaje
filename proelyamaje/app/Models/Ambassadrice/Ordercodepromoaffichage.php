<?php

namespace App\Models\Ambassadrice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ordercodepromoaffichage extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'id_ambassadrice',
      'id_commande',
      'nom',
      'prenom',
      'telephone',
      'code_promo',
      'datet',
      'notification',
      'css',
      'csss',
      'cssss',
      'montant',
      
      
    ];
    
    
    public function User() {

     return $this->belongsTo(Users::class);
    }
    
}