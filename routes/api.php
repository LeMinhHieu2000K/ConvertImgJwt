<?php

use App\Http\Controllers\ImgController;
use Illuminate\Http\Request;
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

Route::post("register", [ImgController::class, "postRegister"]);

Route::post("login", [ImgController::class, "postLogin"]);

Route::group(["middleware" => ["auth:api"]], function () {
    
    Route::get("logout", [ImgController::class, "getLogout"]);

    Route::post('upload', [ImgController::class, "postUploadImg"]);

    Route::get('image-data', [ImgController::class, "getImageData"]);

    Route::post('convert', [ImgController::class, "convertImageData"]);

    Route::get('download', [ImgController::class, "download_img"]);

    Route::delete('delete/{id}', [ImgController::class, "getImageData"]);
});




Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
