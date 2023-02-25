<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Http\Requests\ResetPasswordRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Illuminate\Support\Str;
use Illuminate\Auth\Events\PasswordReset;

class AccountController extends Controller
{
    public function requestPassword(Request $request){
        $request->validate(["email" => ["required","email"]]);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        return response()->json(["message" => __($status)]);
        
    }
    public function resetPassword(ResetPasswordRequest $request){
        $status = Password::reset(
            $request->only('token','email','password'),
            function (User $user , string $password){
                $user->forceFill([
                    "password" => Hash::make($password)
                ])->setRememberToken(Str::random(50));
                $user->save();
            }
        );
        return response()->json(["message" => __($status)]);
    }
}
