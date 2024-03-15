<?php

namespace App\Models\Distributeur;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoicedistributeur extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'invoice_id',
      'id_commande',
      'date',
      'status',
    
    ];
}