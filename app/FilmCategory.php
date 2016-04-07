<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FilmCategory extends Model
{
    protected $guarded = ['id'];

    public function films()
    {
        return $this->belongsToMany('App\Film', 'category_film', 'category_id', 'film_id')->withTimestamps();
    }

    public function tickets()
    {
        return $this->hasMany('App\Ticket', 'category_id');
    }
}
