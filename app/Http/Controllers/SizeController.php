<?php

namespace App\Http\Controllers;

use App\Http\Requests\SizeRequest;
use Illuminate\Routing\Controller;
use App\Models\Size;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;

class SizeController extends Controller
{
    public function sizes()
    {
        $sizes = Size::all();
        return response()->json($sizes, 200);
    }

    public function addSize(SizeRequest $request)
    {
        if (!$request->has('name') || empty($request->name)) {
            return response()->json(['message' => 'Name field is required'], 400);
        }
        $size = Size::create([
            'name' => $request->name]);
        return response()->json(['message' => 'Size added successfully'], 200);

    }

    public function updateSize(Request $request)
    {
        if (!$request->has('name') || empty($request->name) || empty($request->id)) {
            return response()->json(['message' => 'Fields are required'], 400);
        }
        $size = Size::find($request->id);
        if (!$size) {
            return response()->json(['message' => 'No size was found with id: ' . $request->id], 400);
        }
        $size->update([
            'name' => $request->name]);
        return response()->json(['message' => 'Size updated successfully'], 200);
    }

    public function deleteSize(Request $request): JsonResponse
    {
        $size = Size::find($request->id);
        if (!$size) {
            return response()->json(['message' => 'No sizes was found in the database with id: ' . $request->id], 404);
        }
        $size->delete();
        return response()->json(['message' => 'The size has been successfully deleted'], 200);
    }
}
