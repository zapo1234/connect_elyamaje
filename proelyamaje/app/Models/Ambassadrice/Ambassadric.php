<?php

namespace App\Models\Ambassadrice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ambassadric extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'code',
      'id_commande',
      'nom',
      'status'
      
    ];
    
    
    public function User() {

     return $this->belongsTo(Users::class);
    }
}
