<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\DuckImage;
use App\Models\User;
use App\Jobs\CreateUserFolder;
use App\Models\Token;

class UserController extends Controller
{
    // Đăng ký tài khoản
    public function postRegister(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "phone" => "required",
            "password" => "required|confirmed|min:10|regex:/[a-z]/|regex:/[A-Z]/|regex:/[0-9]/|regex:/[@$!%*#?&]/",
            "company" => "required"
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->company = $request->company;
        $user->save();

        // $emailTarget = $request->email; // email thằng nhận

        // gửi email thông báo đăng ký thành công
        // Mail::send(
        //     'testMail',
        //     ['name' => $request->name, 'email' => $request->email, 'password' => $request->password],
        //     function ($email) use ($emailTarget) { // phải dùng phương thức use mới dùng được biến $emailTarget
        //         $email->subject('Chúc mừng bạn đã đăng ký thành công');
        //         $email->to($emailTarget);
        //     }
        // );

        // create user folder
        CreateUserFolder::dispatch($user->id);

        return response()->json([
            "status" => 201,
            "message" => "user registered successfully"
        ], 201);
    }

    // Danh sách ảnh
    public function getMyFile()
    {
        $duckImage = DuckImage::where('user_id', Auth::user()->id)->get();
        return response()->json([
            "status" => 200,
            "message" => "Images list",
            "data" => $duckImage
        ], 200);
    }

    // Đăng nhập
    public function postLogin(Request $request)
    {
        // validation
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        // verify user + token
        if (!$token = auth('api')->attempt(["email" => $request->email, "password" => $request->password])) {

            return response()->json([
                "status" => 403,
                "message" => "Invalid credentials"
            ], 403);
        }

        $user = User::where('email', $request->email)->first();
        $tokens = Token::where('user_id', $user->id)->get();

        // delete the oldest token if tokens greater than 2
        if($tokens->count() >= 2){
            $tokens->first()->delete();
        }

        // save new token to db
        $tokenData = new Token;
        $tokenData->user_id = $user->id;
        $tokenData->token = $token;
        $tokenData->save();

        // send response
        return response()->json([
            "status" => 200,
            "message" => "Logged in successfully",
            "access_token" => $token
        ], 200);
    }

    // Thông tin user hiện tại
    public function getProfile()
    {
        $userLogin = User::where('id', Auth::user()->id)->first();
        // send response
        return response()->json([
            "status" => 200,
            "message" => "Get data successfully",
            "data" => $userLogin
        ], 200);
    }

    // Đăng xuất
    public function getLogout()
    {
        auth()->logout();

        return response()->json([
            "status" => 200,
            "message" => "User logged out"
        ], 200);
    }
}