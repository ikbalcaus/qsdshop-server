<?php

namespace App\Http\Controllers;

use App\Http\Requests\ColorRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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
    public function addColor(ColorRequest $request)
    {
        $colorName = $request->input('name');
        $hexCode=Color::getHexCodeByColorName($colorName);
        if (!$hexCode) {
            return response()->json(['error' => 'Color not found.'], 404);
        }
        $color=Color::create([
          'name'=>$colorName,
            'hex_code'=>$hexCode,
        ]);
        return response()->json($color,200);
    }
    public function updateColor(ColorRequest $request,$id)
    {
        try {
            $colorName=$request->input('name');
            $hexCode=Color::getHexCodeByColorName($colorName);
            if (!$hexCode) {
                return response()->json(['error' => 'Color not found.'], 404);
            }
            $color=Color::findOrFail($id);
            $color->Update([
                'name'=>$colorName,
                'hex_code'=>$hexCode,
            ]);
            return response()->json($color,200);
        }catch(ModelNotFoundException $exception){
            return response()->json(['message'=>'Color not found.'],404);
        }
    }
    public function deleteColor($id){
        try {
            $color=Color::findOrFail($id);
            $color->delete();
            return response()->json(['message'=>'Color successfully deleted.'],200);
        }catch(ModelNotFoundException $exception){
            return response()->json(['message'=>'Color not found.'],404);
        }
    }


}
