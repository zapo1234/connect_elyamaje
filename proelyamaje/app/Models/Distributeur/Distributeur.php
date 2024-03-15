<?php

namespace App\Models\Distributeur;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Distributeur extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'socid',
      'customer_id',
      'nom',
      'prenom',
      'email',
      'adresse',
      'code_postal',
      'phone',
      'country'
    ];
}