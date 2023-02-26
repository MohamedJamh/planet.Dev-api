<?php

use App\Http\Controllers\AccountController;
use App\Http\Controllers\ArticleController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\TagController;
use App\Http\Controllers\TestController;
use App\Models\Role;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CategoryController;
use Auth;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::apiResource('categories', CategoryController::class);

Route::controller(AuthController::class)->group(function () {
    Route::post('login', 'login');
    Route::post('register', 'register');
    Route::post('logout', 'logout');
    Route::post('refresh', 'refresh');

});

Route::apiResource('articles', ArticleController::class);
Route::apiResource('comments',CommentsController::class);



Route::apiResource('tags', TagController::class);

Route::get('profile',[ProfileController::class,'index']);
Route::patch('profile/details',[ProfileController::class,'updateDetails']);
Route::patch('profile/password',[ProfileController::class,'updatePassword']);

Route::post('request-password',[AccountController::class,'requestPassword']);
Route::post('reset-password',[AccountController::class,'resetPassword'])->name('password.reset');

 
Route::get('/email/verify/{id}/{hash}',[AccountController::class,'verificationVerify'])->middleware(['auth', 'signed'])->name('verification.verify');
 
Route::post('/email/verification-notification',[AccountController::class,'verificationSent'])->middleware(['auth', 'throttle:6,1']);
Route::get('/debug',function(){
    $user = Auth::user();
    if($user->hasVerifiedEmail()){
        return "yes";
    }
    return "no";
});