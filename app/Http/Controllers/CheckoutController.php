<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Checkout;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function createCheckout(Request $request){
        $request->validate([
            "amount" => "required",
            "bank_name" => "required",
            "checkout_date" => "required"
        ]);

        $checkout = new Checkout();
        $checkout->amount = $request->amount;
        $checkout->user_id = Auth::user()->id;
        $checkout->bank_name = $request->bank_name;
        $checkout->checkout_date = date('Y-m-d H:i:s', $request->checkout_date);
        $checkout->save();

        return response()->json([
            "status" => 201,
            "message" => "Create checkout successfully"
        ], 201);
    }
}
