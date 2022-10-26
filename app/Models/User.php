<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
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
        'email',
        'password',
        'tos_agree',
        'email_token',
        'email_confirmed',
        'email_verified_at',
        'firstname',
        'lastname'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function getNickname(){

        $fnameArr = explode(' ',$this->attributes['firstname']);
        
        $nickname = '';

        for($i = 0; $i<=2; $i++){

            if(isset($fnameArr[$i])){
                $nickname .= strtoupper(substr($fnameArr[$i],0,1));
            }
        }

        $nickname .= ' ';
        $nickname .= strtoupper(substr($this->attributes['lastname'],0,1));
        
        return $nickname; 
    }
}
