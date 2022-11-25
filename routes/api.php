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

Route::post('otp-generate', [AuthOtpController::class, "generate"])->name('otp.generate'); // lấy mã OTP
Route::post('otp-login', [AuthOtpController::class, "loginWithOtp"])->name('otp.getlogin'); // đăng nhập với mã otp

Route::group(["middleware" => ["auth:api"]], function () {
    //  *TODO: API GET Profile Login
    Route::get("profile-user-login", [ImgController::class, "getProfile"]);
    // ?Beta: API GET myFile
    Route::get("myFile", [ImgController::class, "getmyFile"])->name('myFile');
    //  ?Beta: API GET Profile Login 
    Route::get("logout", [ImgController::class, "getLogout"]);
    // ?Beta: API POST upload
    Route::post('upload', [ImgController::class, "postUploadImg"]);
    // ?Beta: API GET image data
    Route::get('image-data', [ImgController::class, "getImageData"]);
    // ?Beta: API POST convert image
    Route::post('convert', [ImgController::class, "convertImageData"]);
    // ?Beta: API POST convert image
    Route::get('download', [ImgController::class, "download_img"]);


    //  ?Beta: API GET Profile Login
    // @param {id}   , {page}
    Route::delete('delete/{id}', [ImgController::class, "getImageData"]);

    Route::post('create-thumbnail', [ImgController::class, "postCreateThumbnail"]);// có vẻ sai 
    Route::post('remove-background',  [ImgController::class, "postRemoveBackground"]);// có vẻ sai 
    
    Route::post('create/resize',[ImgController::class, "postCreateImgResize"]);
    Route::post('resize/image',[ImgController::class, "resize"]);



});

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
