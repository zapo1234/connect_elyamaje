<?php

namespace App\Models\Ambassadrice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductDolibar extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable...
     *
     * @var array<int, string>
     */
    protected $fillable = [
     'id',
      'id_product',
      'libelle',

     ];
    

}