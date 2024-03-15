<?php

namespace App\Models\Ambassadrice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'id',
      'id_amabassadrice',
      'id_commande',
      
      
    ];
    
    
    public function User() {

     return $this->belongsTo(Users::class);
    }
}