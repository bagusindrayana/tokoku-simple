<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class LogoutController extends Controller
{
    public function logout(){
        auth()->logout();
        Session::forget('token');
        return redirect()->route('login');
    }
}
