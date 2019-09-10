<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index($id)
    {
        $product = Product::with(['attributes', 'attributes.getChildren'])->find($id)->get()->first();
        return view('welcome', compact('product'));
    }
}
