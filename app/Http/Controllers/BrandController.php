<?php

namespace App\Http\Controllers;

use App\Http\Requests\BrandRequest;
use App\Models\Brand;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;

class BrandController extends Controller
{
    public function brands(){
        $brands= Brand::all();
        return response()->json($brands,200);
    }

    public function addBrand(BrandRequest $request){
        $brand=Brand::create([
           'name'=>$request->name,
        ]);
        return response()->json($brand,200);
    }

    public function updateBrand(BrandRequest $request,$id){
       try{
           $brand= Brand::findOrFail($id);
           $brand-> update([
               'name'=>$request->name,
           ]);
                return response()->json($brand,200);
       }catch (ModelNotFoundException $exception) {
                return response()->json(['message' => 'Brand not found'], 404);
       }
    }

    public function deleteBrand($id){

        try {
            $brand=Brand::findOrFail($id);
            $brand->delete();
            return response()->json(['message'=>'Brand successfully deleted.'],200);
        }catch(ModelNotFoundException $exception){
            return response()->json(['message' => 'Brand not found'], 404);
        }
    }

}


