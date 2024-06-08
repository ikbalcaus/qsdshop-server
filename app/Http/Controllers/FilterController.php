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

        $result = Product::whereRaw("MATCH(name) AGAINST(? IN NATURAL LANGUAGE MODE)", [$name])
            ->orWhereIn('brand_id', function ($query) use ($name) {
                $query->select('id')
                    ->from('brands')
                    ->whereRaw("MATCH(name) AGAINST(? IN NATURAL LANGUAGE MODE)", [$name]);
            })
            ->orWhereIn('color_id', function ($query) use ($name) {
                $query->select('id')
                    ->from('colors')
                    ->whereRaw("MATCH(name) AGAINST(? IN NATURAL LANGUAGE MODE)", [$name]);
            })
            ->orWhereIn('id', function ($query) use ($name) {
                $query->select('product_id')
                    ->from('product_categories')
                    ->whereIn('category_id', function ($query) use ($name) {
                        $query->select('id')
                            ->from('category')
                            ->whereRaw("MATCH(name) AGAINST(? IN NATURAL LANGUAGE MODE)", [$name]);
                    });
            })
            ->orWhereIn('id', function ($query) use ($name) {
                $query->select('product_id')
                    ->from('product_sizes')
                    ->whereIn('size_id', function ($query) use ($name) {
                        $query->select('id')
                            ->from('size')
                            ->whereRaw("MATCH(name) AGAINST(? IN NATURAL LANGUAGE MODE)", [$name]);
                    });
            })
            ->with('brands', 'color', 'categories', 'sizes')
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
                } elseif ($filter === 'genders') {
                    $query->where($column, $request->$filter);
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
