<?php

namespace App\Models\Utilisateurs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Orderutilisateur extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'datet',
      'id_ambassadrice',
      'code_promo',
      'user_account',
      'nom',
      'email',
      'somme',
      'ref_facture',
      'utilisateur',
      
      
      
      
    ];
    
}
    