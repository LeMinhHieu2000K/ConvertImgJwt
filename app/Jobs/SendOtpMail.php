<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendOtpMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $name;
    public $email;
    public $otp;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($name, $email, $otp)
    {
        $this->name = $name;
        $this->email = $email;
        $this->otp = $otp;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $emailTarget = $this->email;
        Mail::send(
            'testMail',
            ['name' => $this->name, 'otp' => $this->otp],
            function ($email) use ($emailTarget) {
                // phải dùng phương thức use mới dùng được biến $emailTarget
                $email->subject('Mã xác nhận đăng nhập');
                $email->to($emailTarget);
            }
        );
    }
}
