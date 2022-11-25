<?php

namespace App\Http\Controllers;
use App\Models\User;
use App\Models\VerificationCode;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Twilio\Exceptions\TwilioException;
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

        $CodeOtp = $verificationCode->otp;
        $phone = $request->phone;
        $receiverNumber = '+84'.$phone;
        $message = "Your OTP is :".$CodeOtp;
        $this->index($receiverNumber,$message);

         // send response
         return response()->json([
            "status" => 200,
            "message" => "Create OTP successfully",
            'user_id' => $verificationCode->user_id,
            'message'=>$message

        ]);
    }

    public function index($receiverNumber,$message) // hàm này để gửi sms 
    {
        $account_sid = env("TWILIO_SID");
        $auth_token = env("TWILIO_TOKEN");
        $twilio_number = env("TWILIO_FROM");
        $to = $receiverNumber;
       
        $client = new Client($account_sid, $auth_token);
        try {
            $client->messages->create(
                $to,
                [
                    "body" => $message,
                    "from" => $twilio_number
                ]
            );
            Log::info('Message sent to ' . $twilio_number);
        } catch (Exception $e) {
            Log::error(
                'Could not send SMS notification.' .
                ' Twilio replied with: ' . $e
            );
        }
    }
    public function generateOtp($phone) // hàm tạo mã OTP
    {
        $user = User::where('phone', $phone)->first();

        # User Does not Have Any Existing OTP
        $verificationCode = VerificationCode::where('user_id', $user->id)->latest()->first();

        $now = Carbon::now();

        if ($verificationCode && $now->isBefore($verificationCode->expire_at)) {
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
    //     return response()->json([
    //         "status" => 200,
    //         'user_id' => $user_id
    //     ]);
    // }

    public function loginWithOtp(Request $request)
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
            return redirect()->back()->with('error', 'Your OTP is not correct');
            return response()->json([
                // "status" => 200,
                "message" => 'Your OTP is not correct',
              
            ]);
        } elseif ($verificationCode && $now->isAfter($verificationCode->expire_at)) {
            return redirect()->route('otp.login')->with('error', 'Your OTP has been expired');
            return response()->json([
                // "status" => 200,
                "message" => 'Your OTP has been expired',
              
            ]);
        }

        $user = User::whereId($request->user_id)->first();

        if ($user) {
            // Expire The OTP
            $verificationCode->update([
                'expire_at' => Carbon::now()
            ]);

            Auth::login($user);

            return response()->json([
                // "status" => 200,
                "message" => 'user login successfully',
              
            ]);
        }

        // return redirect()->route('otp.login')->with('error', 'Your Otp is not correct');
        return response()->json([
            // "status" => 200,
            "message" => 'Your Otp is not correct',
          
        ]);
    }
}
