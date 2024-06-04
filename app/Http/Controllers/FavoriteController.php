<?php

namespace App\Http\Controllers;

use App\Http\Requests\FavoriteRequest;
use App\Models\Favorite;
use App\Models\Product;
use Illuminate\Routing\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function getFavorites()
    {
        $user = Auth::user();
        $favorites = Favorite::with('products.brands','products.images')->where('user_id', $user->id)->get();
        return response()->json([$favorites]);
    }

    public function handleFavorite(FavoriteRequest $request)
    {
        $user = Auth::user();
        $product_id = $request->product_id;
        $product = Product::find($product_id);

        $existingFavorite = Favorite::where('user_id', $user->id)->where('product_id', $product_id)->first();
        if ($existingFavorite) {
            $existingFavorite->delete();
            return response()->json(['message' => 'Favorite deleted successfully']);
        }
        $favorite = new Favorite();
        $favorite->user_id = $user->id;
        $favorite->product_id = $product_id;
        $favorite->is_favorite = 1;
        $favorite->save();
        return response()->json(['message' => 'Favorite added successfully']);
    }
}
