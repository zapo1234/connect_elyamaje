<?php

namespace App\Models\Ambassadrice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cardscustomercontrol extends Model
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
      'numero_card',
      'mois_expire',
      'annee_expire',
      'numero_forms',
      
     ];
    
    
    public function User() {

     return $this->belongsTo(Users::class);
    }
}