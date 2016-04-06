<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\Events\AccountRegistered;
use Carbon\Carbon;
use Auth;
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
            'confirmation_expire' => Carbon::now()->addDays(3)->toDateTimeString(),
        ]);
        
        event(new AccountRegistered($user));
        
        return response()->json([
            'success' => true,
        ]);
    }

    public function checkConfirmation(Requests\CheckConfirmationRequest $request)
    {
        $user = User::where('confirmation', $request->confirmation)->first();

        if($user){
            if(Carbon::now()->gte($user->confirmation_expire)){
                $user->delete();
                $user = null; 
            }
            else{
                $user->confirmation = null;
                $user->confirmation_expire = null;
                $user->save();
                Auth::login($user);
            }
        }

        
        
        return response()->json([
            'success' => boolval($user),
            'user' => $user
        ]);
    }
}
