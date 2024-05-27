<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use App\Models\Color;

class ColorController extends Controller
{
    public function colors()
    {
        $colors= Color::all();
        return response()->json($colors,200);
    }



}
