<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\FilmCategory;
class RegisterFilmController extends Controller
{


    public function show()
    {
        $categories = FilmCategory::all();

        foreach ($categories as $category) {
            $category->filmCount = $category->films->count();
            
            //Do not show to user after getting the counts
            unset($category->films);
        }
        return view('final.register.register', [
            'categories' => $categories->toArray(),
        ]);
    }

    public function getCategoryTickets()
    {
        return response()->json([
            'success' => true,
            'categoryTickets' => FilmCategory::with('tickets')->get()->toArray(),
        ]);
    }
}
