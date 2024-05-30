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

    public function filterProducts(Request $request)
    {
        $query = Product::query();
        $filters = [
            'min_price' => 'price',
            'max_price' => 'price',
            'brands' => 'brand_id',
            'colors' => 'color_id',
            'genders' => 'gender',
            'sizes' => 'product_sizes.size_id',
            'categories' => 'product_categories.category_id',
        ];

        foreach ($filters as $filter => $column) {
            if ($request->has($filter)) {
                if ($filter === 'sizes' || $filter === 'categories') {
                    $query->join($filter === 'sizes' ? 'product_sizes' : 'product_categories', 'products.id',
                        '=', $filter === 'sizes' ? 'product_sizes.product_id' : 'product_categories.product_id')
                        ->whereIn($column, $request->$filter);
                } else {
                    $query->where($column, $filter === 'min_price' ? '>=' : '<=', $request->$filter);
                }
            }
        }

        $query->with('categories', 'brands', 'color', 'sizes');
        $products = $query->get();
        return response()->json($products);
    }
}