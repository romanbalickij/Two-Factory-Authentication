<?php

namespace App;

use App\Mail\OTPMail;
use App\Notifications\OTPnotification;
use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Mail;

class User extends Authenticatable
{
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'isVerified',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function OTP(){

        return Cache::get($this->OTPKey());
    }

    public function OTPKey(){
        return "OTP_for{$this->id}";
    }

    public function cacheTheOtp(){
        $OTP = rand(1000,8000);
        Cache::put([$this->OTPKey() => $OTP], now()->addSecond(15));
        return $OTP;
    }

    public function sendOTP($via){

        $OTP = $this->cacheTheOtp();
        $this->notify(new OTPnotification($via, $OTP));
//        if($via == 'via_sms') {
//
//        } else {
//            Mail::to('roman@gmail.com')->send(new OTPMail($this->cacheTheOtp()));
//        }
    }

    public function routeNotificationForKarix()
    {
        return $this->phone;
    }
}
