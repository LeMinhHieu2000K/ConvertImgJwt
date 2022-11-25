<?php

namespace App\Http\Controllers;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\VerificationCode;
use Exception;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;

class AuthOtpController extends Controller
{
 
    // Generate OTP
    public function generate(Request $request)
    {
        # Validate Data
        $request->validate([
            'phone' => 'required|exists:users,phone'
        ]);

        # Generate An OTP
        $verificationCode = $this->generateOtp($request->phone);

        $message = "Your OTP To Login is - ".$verificationCode->otp;
        # Return With OTP 


        $receiverNumber = "+84". ltrim($request->phone, "0"); // Gửi OTP đến số điện thoại
        try {
            $account_sid = getenv("TWILIO_SID");
            $auth_token = getenv("TWILIO_TOKEN");
            $twilio_number = getenv("TWILIO_FROM");
  
            $client = new Client($account_sid, $auth_token);
            $client->messages->create($receiverNumber, [
                'from' => $twilio_number, 
                'body' => $message]);
    
        } catch (Exception $e) {
            dd("Error: ". $e->getMessage());
        }

        // return redirect()->route('otp.verification', ['user_id' => $verificationCode->user_id,'message'=>$message])->with('success'); 
        return response()->json([
            "status" => 200,
            "message" => "Create OTP CODE successfully",
            "user_id" => $verificationCode->user_id
        ]);
    }

    public function generateOtp($phone) // hàm tạo mã OTP
    {
        $user = User::where('phone', $phone)->first();

        # User Does not Have Any Existing OTP
        $verificationCode = VerificationCode::where('user_id', $user->id)->latest()->first();

        $now = Carbon::now();

        if($verificationCode && $now->isBefore($verificationCode->expire_at)){
            return $verificationCode;
        }

        // Create a New OTP
        return VerificationCode::create([
            'user_id' => $user->id,
            'otp' => rand(123456, 999999),
            'expire_at' => Carbon::now()->addMinutes(10)
        ]);
    }

    // public function verification($user_id)
    // {
    //     return view('auth.otp-verification')->with([
    //         'user_id' => $user_id
    //     ]);
    // }

    public function loginWithOtp(Request $request)// hàm đăng nhập với mã OTP
    {
        #Validation
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'otp' => 'required'
        ]);

        #Validation Logic
        $verificationCode   = VerificationCode::where('user_id', $request->user_id)->where('otp', $request->otp)->first();

        $now = Carbon::now();
        if (!$verificationCode) {
            // return redirect()->back()->with('error', 'Your OTP is not correct');
            return response()->json([
                // "status" => 200,
                "message" => 'Your OTP is not correct',
            ]);
        }elseif($verificationCode && $now->isAfter($verificationCode->expire_at)){
            // return redirect()->route('otp.login')->with('error', 'Your OTP has been expired');
            return response()->json([
                // "status" => 200,
                "message" => 'Your OTP has been expired',
            ]);
        }

        $user = User::whereId($request->user_id)->first();

        if($user){
            // Expire The OTP
            $verificationCode->update([
                'expire_at' => Carbon::now()
            ]);

            Auth::login($user);
            return response()->json([
                "status" => 200,
                "message" => 'Login Success',
            ]);
        }
        return response()->json([
            "message" => 'Your Otp is not correct',
        ]);
    }
}
