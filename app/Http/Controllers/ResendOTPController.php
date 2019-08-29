<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResendOTPController extends Controller
{
    public function resend(Request $request) {

        return response(null,201);
    }
}
