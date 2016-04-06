<?php

namespace App;

use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $guarded = ['id'];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token', 'confirmation', 'confirmation_expire'
    ];
    
    protected $casts = [
        'created_at' => 'date',
        'updated_at' => 'date',
        'confirmation_expire' => 'date',
    ];

    public function films()
    {
        return $this->hasMany('App\Film');
    }

    public function tickets()
    {
        return $this->hasMany('App\Ticket');
    }
}
