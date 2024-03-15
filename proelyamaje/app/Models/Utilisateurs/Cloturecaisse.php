<?php

namespace App\Models\Utilisateurs;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cloturecaisse extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'lieu',
      'description',
      'montant',
      'date',
      'now',
      
      ];
    
}
    