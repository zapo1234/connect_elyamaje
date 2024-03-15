<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Codespeciale extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'id',
      'nom',
      'id_ambassadrice',
     'code_promos',
     'status',
     'nom_eleve',
     'email',
     'pourcentage',
     'commission',
      
    ];
}