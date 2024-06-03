<?php

namespace App\Http\Controllers;

use App\Http\Requests\DiscountRequest;
use App\Models\Discount;
use App\Models\Product;
use App\Models\Category;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Size;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class DiscountController extends Controller
{
    public function getDiscounts()
    {
        $discount = Discount::with('products')->paginate(20);
        return response()->json($discount);
    }

    public function getUpcomingDiscounts()
    {
        $upcomingDiscounts = Discount::with('products.images')->where('valid_from', '>', Carbon::now())->get();
        return response()->json($upcomingDiscounts);
    }

    public function addDiscount(DiscountRequest $request)
    {
        $discount = new Discount([
            'name' => $request->input('name'),
            'discount' => $request->input('discount'),
            'valid_from' => $request->input('valid_from'),
            'valid_to' => $request->input('valid_to'),
        ]);
        $discount->save();
        if ($request->has('discount_id')) {
            $discount->discount_id = $request->input('discount_id');
        }

        if ($request->has('products')) {
            $products = Product::find($request->input('products'));
            $discount->products()->attach($products);
        }

        if ($request->has('brands')) {
            $brand = $request->input('brands');
            $discount->brands()->associate($brand);
        }

        if ($request->has('colors')) {
            $color = $request->input('colors');
            $discount->colors()->associate($color);
        }

        if ($request->has('sizes')) {
            $sizes = $request->input('sizes');
            $discount->sizes()->associate($sizes);
        }

        if ($request->has('categories')) {
            $categories = $request->input('categories');
            $discount->categories()->associate($categories);
        }
        return response()->json(['message' => 'Discount successfully added.'], 200);
    }

    public function deleteDiscount($id)
    {
        $discount = Discount::find($id);
        if (!$discount) {
            return response()->json(['message' => 'Discount not found'], 404);
        }
        $discount->delete();
        return response()->json(['message' => 'Discount successfully deleted.'], 200);
    }
}
