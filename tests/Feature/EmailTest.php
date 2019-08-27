<?php

namespace Tests\Feature;

use App\Mail\OTPMail;
use App\User;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class EmailTest extends TestCase
{
    use DatabaseMigrations;
    /**
     * A basic feature test example.
     *
     * @return void
     */

    /** @test */
    public function an_otp_email_is_send_when_user_is_logged_in()
    {
        Mail::fake();
        $this->withExceptionHandling();
        $user = factory(User::class)->create();
        $res  = $this->post('/login',['email' => $user->email, 'password'=>'secret']);
        Mail::send(OTPMail::class);
    }

    /** @test */
    public function an_otp_email_is_not_send_credentials_are_incorrect()
    {
        $user = factory(User::class)->create();
        $res  = $this->post('/login',['email' => $user->email, 'password'=>'secret']);
        Mail::send(OTPMail::class);
    }
}
