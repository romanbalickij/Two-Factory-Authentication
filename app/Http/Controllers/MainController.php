<?php

namespace App\Http\Controllers;

use App\Product;
use Illuminate\Http\Request;

class MainController extends Controller
{
    public function index($id)
    {
       // $product = Product::with(['attributes', 'attributes.getChildren'])->find($id)->get()->first();
       // return view('welcome', compact('product'));

        $product = Product::with(['attributes', 'attributes.getChildren'])->find($id)->get()->first();


        foreach ($product->attributes as $attribute) {

            dump($attribute->attribute,$attribute->getChildren->first()->child_value );
        }
    }
}
