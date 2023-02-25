<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;
use Illuminate\Auth\Events\PasswordReset;

class AccountController extends Controller
{
    //

    public function requestPassword(Request $request){
        $request->validate(["email" => ["required","email"]]);
        $status = Password::sendResetLink(
            $request->only('email')
        );
        // return $status === Password::RESET_LINK_SENT ? response()->json([
        //     "message" => "email sent verify you inbox"
        // ]) : response()->json([
        //     "message" => "there is no user with the corresponded email"
        // ]);

        return $status === Password::RESET_LINK_SENT
                    ? response()->json(["message" => "Email sent please verify you inbox"])
                    : response()->json(["message" => "something went wrong"]);
        
    }
    public function resetPassword(Request $request){
        
    }
}
