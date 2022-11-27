<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \Illuminate\Support\Facades\File;
use App\Models\ImgClient;
use App\Models\User;

class UserController extends Controller
{
    // Đăng ký tài khoản
    public function postRegister(Request $request)
    {
        $request->validate([
            "name" => "required",
            "email" => "required|email|unique:users",
            "phone" => "required",
            "password" => "required|confirmed|min:6",
            "role" => "required|integer"
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = bcrypt($request->password);
        $user->role = $request->role;
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

        $path = public_path().'/source/convert/' . $user->id;
        File::makeDirectory($path, 0777, true, true);

        return response()->json([
            "status" => 200,
            "message" => "user registered successfully"
        ], 200);
    }

    // Danh sách ảnh
    public function getmyFile()
    {
        $ImgClient = ImgClient::where('user_id', Auth::user()->id)->get();
        return response()->json([
            "status" => 200,
            "data" => $ImgClient
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
                "status" => 404,
                "message" => "Invalid credentials"
            ], 404);
        }

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
    public function getLogout(Request $request)
    {
        auth()->logout();

        return response()->json([
            "status" => 200,
            "message" => "User logged out"
        ], 200);
    }
}