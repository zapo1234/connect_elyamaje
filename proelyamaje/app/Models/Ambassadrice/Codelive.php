<?php

namespace App\Models\Ambassadrice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Codelive extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'code_live',
      'code_reduction',
      'id_amabassadrice',
      'is_admin',
      'status',
      'css',
      'nombre_fois',
      'nbres_live',
      'date_after',
      'date_expire'
      
      
    ];
    
    
    public function User() {

     return $this->belongsTo(Users::class);
    }
}