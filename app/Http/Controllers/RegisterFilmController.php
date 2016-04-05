<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;

class RegisterFilmController extends Controller
{


    public function show()
    {
        return view('register.final');
    }
}
