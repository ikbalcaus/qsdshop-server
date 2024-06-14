<?php

namespace App\Http\Controllers;


use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class CategoryController extends Controller
{
    public function categories()
    {
        $categories = Category::all();
        return response()->json($categories, 200);
    }

    public function addCategory(Request $request)
    {
        if (!$request->has('name') || empty($request->name)) {
            return response()->json(['message' => 'Name field is required'], 400);
        }

        if (Category::where('name', $request->name)->exists()) {
            return response()->json(['message' => 'Category already exists in the database'], 400);
        }

        $category = Category::create([
            'name' => $request->name,
        ]);
        return response()->json(['message' => 'Category added successfully'], 200);
    }

    public function updateCategory(Request $request)
    {
        if (!$request->has('name') || empty($request->name) || empty($request->id)) {
            return response()->json(['message' => 'Fields are required'], 400);
        }
        $category = Category::find($request->id);
        if (!$category) {
            return response()->json(['message' => 'No category was found with id: ' . $request->id], 400);
        }
        $category->update([
            'name' => $request->name]);
        return response()->json(['message' => 'Category updated successfully'], 200);
    }

    public function deleteCategory(Request $request)
    {
        $category = Category::find($request->id);
        if (!$category) {
            return response()->json(['message' => 'No categories was found in the database with id: ' . $request->id], 404);
        }
        $category->delete();
        return response()->json(['message' => 'The category has been successfully deleted'], 200);
    }
}
