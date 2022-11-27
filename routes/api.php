<?php

use App\Http\Controllers\ImgController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\CheckoutController;
use Illuminate\Support\Facades\Route;
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

Route::post("register", [UserController::class, "postRegister"]);

Route::post("login", [UserController::class, "postLogin"]);

// Route::group(["middleware" => ["auth:api"]], function () {

//     Route::get("profile", [UserController::class, "getProfile"]);

//     Route::get("myFile", [ImgController::class, "getmyFile"])->name('myFile');
    
//     Route::get("logout", [UserController::class, "getLogout"]);

//     Route::post('upload', [ImgController::class, "postUploadImg"]);

//     Route::get('image-data', [ImgController::class, "getImageData"]);

//     Route::post('convert', [ImgController::class, "convertImageData"]);

//     Route::get('download', [ImgController::class, "download_img"]);

//     Route::delete('delete/{id}', [ImgController::class, "getImageData"]);

//     // OTP
//     Route::post('otp-generate', [AuthOtpController::class, "generate"])->name('otp.generate');
//     Route::get('otp-verification/{user_id}', [AuthOtpController::class, "verification"])->name('otp.verification');
//     Route::post('otp-login', [AuthOtpController::class, "loginWithOtp"])->name('otp.getlogin');

//     Route::post('create-thumbnail' , [ImgController::class, "postCreateThumbnail"]);
//     Route::post('remove-background' ,  [ImgController::class, "postRemoveBackground"]);


// });

// Route::middleware('auth:api')->get('/user', function (Request $request) {
//     return $request->user();
// });

// branch duck
Route::group(["middleware" => ["auth:api"]], function () {

    Route::get("profile", [UserController::class, "getProfile"]);

    Route::get("files", [UserController::class, "getmyFile"]);
    
    Route::get("logout", [UserController::class, "getLogout"]);

    Route::post('upload', [ImgController::class, "postUploadImg"]);

    Route::get('image-data', [ImgController::class, "getImageData"]);

    Route::post('convert', [ImgController::class, "convertImage"]);

    Route::post('remove-background', [ImgController::class, "removeBackground"]);

    Route::post('resize', [ImgController::class, "resizeImage"]);

    Route::get('download', [ImgController::class, "downloadImage"]);

    Route::post('checkout', [CheckoutController::class, "createCheckout"]);
});