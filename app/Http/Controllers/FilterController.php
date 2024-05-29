<?php

namespace App\Http\Controllers;

use App\Http\Requests\FilterRequest;
use App\Models\Brand;
use App\Models\Color;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;


class FilterController extends Controller
{
    public function search(FilterRequest $request)
    {
        $name = $request->name;

        if (empty($name)) {
            return response()->json(['message' => 'Field is required'], 400);
        }

        $namePattern = "%$name%";
        $brandIds = Brand::where('name', 'LIKE', $namePattern)->pluck('id');
        $colorIds = Color::where('name', 'LIKE', $namePattern)->pluck('id');

        $categorySubquery = function ($query) use ($namePattern) {
            $query->select('product_id')->from('product_categories')
                ->whereIn('category_id', function ($query) use ($namePattern) {
                    $query->select('id')->from('category')->where('name', 'LIKE', $namePattern);
                });
        };

        $sizeSubquery = function ($query) use ($namePattern) {
            $query->select('product_id')->from('product_sizes')
                ->whereIn('size_id', function ($query) use ($namePattern) {
                    $query->select('id')->from('size')->where('name', 'LIKE', $namePattern);
                });
        };

        $result = Product::where('name', 'LIKE', $namePattern)
            ->orWhereIn('brand_id', $brandIds)
            ->orWhereIn('color_id', $colorIds)
            ->orWhereIn('id', $categorySubquery)
            ->orWhereIn('id', $sizeSubquery)
            ->with('categories', 'brands', 'color', 'sizes')
            ->get();

        return response()->json($result);
    }

    public function filterProducts()
    {

    }
}
