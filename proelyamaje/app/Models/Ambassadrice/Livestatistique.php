<?php

namespace App\Models\Ambassadrice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Livestatistique extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'id_amabassadrice',
      'name',
      'email',
      'date',
     
      
      
    ];
    
    
    public function User() {

     return $this->belongsTo(Users::class);
    }
}