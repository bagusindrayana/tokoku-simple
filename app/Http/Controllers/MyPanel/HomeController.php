<?php

namespace App\Http\Controllers\MyPanel;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(){
        return view('my-panel.home');
    }
}
