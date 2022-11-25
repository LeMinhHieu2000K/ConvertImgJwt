<?php

use App\Http\Controllers\ImgController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthOtpController;
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

Route::post("register", [ImgController::class, "postRegister"]);

Route::post("login", [ImgController::class, "postLogin"]);

Route::group(["middleware" => ["auth:api"]], function () {

    Route::get("profile-user-login", [ImgController::class, "getProfile"]);

    Route::get("myFile", [ImgController::class, "getmyFile"])->name('myFile');
    
    Route::get("logout", [ImgController::class, "getLogout"]);

    Route::post('upload', [ImgController::class, "postUploadImg"]);

    Route::get('image-data', [ImgController::class, "getImageData"]);

    Route::post('convert', [ImgController::class, "convertImageData"]);

    Route::get('download', [ImgController::class, "download_img"]);

    Route::delete('delete/{id}', [ImgController::class, "getImageData"]);

    // OTP
    Route::post('otp-generate', [AuthOtpController::class, "generate"])->name('otp.generate');// lấy mã OTP
    Route::post('otp-login', [AuthOtpController::class, "loginWithOtp"])->name('otp.getlogin');// đăng nhập với mã otp

    Route::post('create-thumbnail' , [ImgController::class, "postCreateThumbnail"]);
    Route::post('remove-background' ,  [ImgController::class, "postRemoveBackground"]);


});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
