<?php

namespace App\Models\Ambassadrice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Accountambassadrice extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'nom',
      'id_commande',
      'code_mois',
      'annee',
      'montant',
      
    ];
    
    
    
}
