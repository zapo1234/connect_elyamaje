<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stocksmouvement extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'id_product',
      'wharehouse_id',
      'quantite',
      'pmp',
      'label',
      'inventorycode',
      'ref',
     'fk_author_user',
      
    ];
}
