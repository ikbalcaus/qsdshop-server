<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Routing\Controller;

class UserController extends Controller
{
    public function getUser($id)
    {
            $user=User::find($id);
            if(!$user){
                return response()->json(['error'=>'User Not Found'],404);
            }
            return response()->json($user,200);
    }
    public function users()
    {
            $user=User::all();
            return response()->json($user,200);
     }
     public function updateUser(UserRequest $request)
     {
         $user=User::find($request->id);
         if(!$user){
             return response()->json(['error'=>'User Not Found'],404);
         }
         $user->update([
             'first_name'=>$request->input('first_name',$user->first_name),
             'last_name'=>$request->input('last_name',$user->last_name),
             'email'=>$request->input('email',$user->email),
             'city'=>$request->input('city',$user->city),
             'address'=>$request->input('address',$user->address),
             'zip_code'=>$request->input('zip_code',$user->zip_code),
             'phone'=>$request->input('phone',$user->phone)
         ]);
         return response()->json($user,200);
     }
     public function deleteUser(UserRequest $request){
        $id=$request->id;
        $user=User::find($id);
        if(!$user){
            return response()->json(['error'=>'User Not Found'],404);
        }
        $user->delete();
        return response()->json(['message'=>'User deleted successfully.'],200);
     }
}
