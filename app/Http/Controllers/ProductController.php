<?php

namespace App\Http\Controllers;


use App\Http\Requests\ProductRequiredRequest;
use App\Http\Requests\ProductRequest;
use App\Http\Requests\RateProductRequest;
use App\Models\Image;
use App\Models\Product;
use App\Models\Rating;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function getProduct(ProductRequiredRequest $request): JsonResponse
    {
        $products = Product::with('brands', 'color', 'categories', 'sizes', 'images','rating')->find($request->id);
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

    private function storeImage(Request $request, Product $product)
    {
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $image) {
                $imageName = $image->hashName();
                $image->storeAs('products', $imageName);
                $product->images()->create([
                    'name' => $imageName,
                    'product_id' => $product->id
                ]);
            }
        }
    }

    public function addProduct(ProductRequest $request): JsonResponse
    {

        $product = Product::create([
            'name' => $request->name,
            'price' => $request->price,
            'gender' => $request->gender,
            'description' => $request->description,
            'brand_id' => $request->brand_id,
            'color_id' => $request->color_id,
        ]);

        $this->storeImage($request, $product);
        $product->categories()->sync($request->categories);
        $product->sizes()->sync($request->sizes);
        return response()->json(['message' => 'Product added successfully'], 200);
    }

    public function updateProduct(ProductRequest $request)
    {
        $product = Product::find($request->id);
        if (!$product) {
            return response()->json(['message' => 'No product was found with id: ' . $request->id], 400);
        }
        $product->update([
            'name' => $request->name,
            'price' => $request->price,
            'gender' => $request->gender,
            'description' => $request->description,
            'brand_id' => $request->brand_id,
            'color_id' => $request->color_id,
        ]);
        if ($request->hasFile('images')) {
            $this->storeImage($request, $product);
        }
        $product->categories()->sync($request->categories);
        $product->sizes()->sync($request->sizes);
        return response()->json(['message' => 'Product updated successfully'], 200);
    }

    public function deleteProduct(ProductRequiredRequest $request)
    {
        $product = Product::find($request->id);
        if (!$product) {
            return response()->json(['message' => 'Product not found'], 404);
        }
        $product->images()->delete();
        $product->categories()->detach();
        $product->sizes()->detach();
        $product->delete();
        return response()->json(['message' => "Product was successfully deleted"], 200);
    }

    public function rateProduct(RateProductRequest $request)
    {
        $user = Auth::user();
        $rating = Rating::create([
            'value' => $request->value,
            'product_id' => $request->product_id,
            'user_id' => $user->id
        ]);
        return response()->json(['message' => 'Rating saved successfully.'], 200);
    }

    public function deleteImage(Request $request)
    {
        if (empty($request->id)) {
            return response()->json(['message' => 'Field is required'], 400);
        }
        $image = Image::find($request->id);
        if (!$image) {
            return response()->json(['message' => 'Image not found'], 404);
        }
        $product_id = $image->product_id;
        $number = Image::where('product_id', $product_id)->count();
        if ($number == 1) {
            return response()->json(['message' => 'Cannot delete the last image'], 403);
        }
        $image->delete();
        return response()->json(['message' => "Image successfully deleted"], 200);
    }

    public function editRateProduct(Request $request)
    {
        if (empty($request->id)) {
            return response()->json(['message' => 'Field is required'], 400);
        }
        $rating = Rating::find($request->id);
        if (!$rating) {
            return response()->json(['message' => 'No rating was found with id: ' . $request->id], 400);
        }
        $rating->update([
            'id' => $request->id,
            'value' => $request->value,
            'description' => $request->descripton
        ]);
        return response()->json(['message' => 'Rating updated successfully'], 200);

    }
}
