<?php

namespace App\Models\Ambassadrice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambassadricecustomer extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'id_ambassadrice',
      'is_admin',
      'nom',
      'prenom',
      'email',
      'adresse',
      'telephone',
     'code_postal',
     'code_promo',
     'date'
      
    ];
    
    
    public function User() {

     return $this->belongsTo(Users::class);
    }
}
