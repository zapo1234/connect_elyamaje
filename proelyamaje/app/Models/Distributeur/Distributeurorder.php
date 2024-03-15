<?php

namespace App\Models\Distributeur;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributeurorder extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'id_commande',
      'name',
      'email',
      'status',
      'adresse',
      'telephone',
      'somme'
    ];
}