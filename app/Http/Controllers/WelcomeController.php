<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function index()
    {   
        $products = Product::orderBy('created_at','DESC')->limit(10)->get();
        return view('welcome',compact('products'));
    }
}
