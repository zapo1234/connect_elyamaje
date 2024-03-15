<?php
namespace App\Models\Ambassadrice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Pointbilan extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'id',
      'id_mois',
      'id_ambassadrice',
      'email',
      'is_admin',
      'account_societe',
      'tva',
      'name',
      'mois',
      'annee',
      'somme',
      'ligne_note',
      'nbrslive',
      'nbrseleve',
      'nbrsfois',
      'status',
      'type_compte',
      'content',
      'button',
      'css',
      'csss',
      'status_paiement'
      
      ];
    
    
    
}