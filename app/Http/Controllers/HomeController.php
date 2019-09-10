<?php

namespace App\Http\Controllers;

use App\Mail\FileDownloaded;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
      //  $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('home');
    }

    public function test()
    {
        return view('test');
    }

    public function upload(Request $request)
    {

        // validate the uploaded file
        $validation = $request->validate([
            'photo' => 'required|file|image|mimes:jpeg,png,gif,webp|max:2048'
            // for multiple file uploads
            // 'photo.*' => 'required|file|image|mimes:jpeg,png,gif,webp|max:2048'
        ]);
        $file      = $validation['photo']; // get the validated file
        $extension = $file->getClientOriginalExtension();
        $filename  = 'profile-photo-' . time() . '.' . $extension;
        $path      = $file->storeAs('photos', $filename);

        $email = 'romanbalickij9@gmail.com';
        Mail::to($email)->send(new FileDownloaded);

    }
}
