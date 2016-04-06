<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
class FilmAuthController extends Controller
{
    public function isEmailUnique(Requests\EmailUniqueRequest $request)
    {
        return response()->json([
            'success' => true,
        ]);
    }

    public function register(Requests\RegisterAccountRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'confirmation' => str_random(32),
        ]);
        
        
    }
}
