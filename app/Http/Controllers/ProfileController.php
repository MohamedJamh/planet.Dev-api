<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateUserDetails;
use App\Http\Requests\UpdateUserPassword;
use Illuminate\Http\Request;
use App\Models\User;
use App\Http\Resources\UserResource;
use Auth;
use Hash;

class ProfileController extends Controller
{
    public function __construct(){
        $this->middleware(['auth:api','verified']);
    }
    //
    public function index(){
        //retriving user profile info
        $user = User::find(auth()->user()->id);
        return response()->json(new UserResource($user),200);
    }

    public function updateDetails(UpdateUserDetails $request): \Illuminate\Http\JsonResponse{
        //update user first name or last name or email
        $user = auth()->user();
        $user->update($request->only('first_name','last_name','email'));
        return response()->json([
            "status" => "succes",
            "message" => "Profile details has been updated",
            "user" => new UserResource($user)
        ]);
    }
    public function updatePassword(UpdateUserPassword $request){
        //update user password | request password
        if(Hash::check($request->input('current_password'),Auth::user()->password)){
            $hashedPassword = Hash::make($request->input('password'));
            Auth::user()->update([
                'password' => $hashedPassword
            ]);
            return response()->json([
                "status" => "succes",
                "message" => "Your password has been updated"
            ]);
        }
        return response()->json([
            "status" => "failed",
            "message" => "Your current password does not match"
        ]);
    }
}
