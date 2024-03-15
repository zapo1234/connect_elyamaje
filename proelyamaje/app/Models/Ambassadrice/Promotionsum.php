<?php
namespace App\Models\Ambassadrice;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotionsum extends Model
{
    use HasFactory;
    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
      'datet',
      'id_commande',
      'label_product',
      'id_product',
      'code_promo',
      'sku',
       'somme',
       'quantite',
      'id_ambassadrice',

     ];
    
    
    
}