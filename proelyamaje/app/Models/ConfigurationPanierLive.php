<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ConfigurationPanierLive extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'panier_title',
      'libelle',
      'ids_product',
      'ids_variation',
      'ids_categories',
      'libelle_categoris',
      'mont_mini',
      'mont_max',
      
    
    ];
}