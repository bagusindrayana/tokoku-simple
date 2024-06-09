<?php

namespace App\Http\Controllers\MyPanel;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        $countUsers = User::count();
        $countProducts = Product::count();
        return view('my-panel.home',compact('countUsers','countProducts'));
    }
}
