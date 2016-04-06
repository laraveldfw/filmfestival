<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\FilmCategory;
class RegisterFilmController extends Controller
{


    public function show()
    {
        
        return view('final.register.register', [
            'categories' => FilmCategory::all()->toArray(),
        ]);
    }
}
