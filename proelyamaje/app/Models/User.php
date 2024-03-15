<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'type_account',
        'account_societe',
        'siret',
        'actif',
        'attribut',
        'img_select',
        'email',
        'addresse',
        'code_postal',
        'ville',
        'telephone',
        'is_admin',
        'code_live',
        'code_reduction',
        'code_giftcards',
        'acces_account',
        'password',
        'date',
        'remember_token',

    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'date',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        
    ];
    
    
    /**
 * Get the column name for the "remember me" token.
 *
 * @return string
 */
   public function getRememberTokenName()
   {
     return '';
   }
    
    
    public function ambassadrice() {

        return $this->hasMany(Ambassadricecustomer::class);
    }
}
