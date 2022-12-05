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

// branch duck
Route::group(["middleware" => ["auth:api"]], function () {
    Route::group(["middleware" => ["jwt.verify"]], function () {

        Route::post("otp", [UserController::class, "postOtp"]);

        Route::group(["middleware" => ["otp.verify"]], function () {
            Route::get("profile", [UserController::class, "getProfile"]);

            Route::get("files", [UserController::class, "getMyFile"]);

            Route::delete("files", [ImgController::class, "deleteAllFile"]);

            Route::get("logout", [UserController::class, "getLogout"]);

            Route::get('image-data', [ImgController::class, "getImageData"]);

            Route::post('convert', [ImgController::class, "convertImage"]);

            Route::post('remove-background', [ImgController::class, "removeBackground"]);

            Route::post('resize', [ImgController::class, "resizeImage"]);

            Route::post('thumbnail', [ImgController::class, "createThumbnail"]);

            Route::post('banner', [ImgController::class, "createBanner"]);

            Route::post('download', [ImgController::class, "downloadImage"]);

            Route::post('checkout', [CheckoutController::class, "createCheckout"]);

            Route::get("driver", [ImgController::class, "getGoogleDriveFile"]);

            Route::post("driver", [ImgController::class, "convertGoogleDriveFile"]);
        });
    });
});