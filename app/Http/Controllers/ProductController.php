<?php

namespace App\Http\Controllers;


use App\Models\Product;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class ProductController extends Controller
{
    public function getProduct(Request $request): JsonResponse
    {
        if (empty($request->id)) {
            return response()->json(['message' => 'Fields are required'], 400);
        }
        $products = Product::with('brands', 'color', 'categories', 'sizes', 'images')->find($request->id);
        if (!$products) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        return response()->json($products, 200);
    }

    public function getProducts(): JsonResponse
    {
        $products = Product::with('brands', 'color', 'categories', 'sizes', 'images')->paginate(20);
        return response()->json($products, 200);
    }

    public function addProduct()
    {

    }

    public function updateProduct()
    {

    }

    public function deleteProduct()
    {

    }

    public function rateProduct()
    {

    }

    public function deleteImage()
    {

    }

    public function editRateProduct()
    {

    }
}
