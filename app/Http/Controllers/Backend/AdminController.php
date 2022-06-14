<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use function view;

class AdminController extends Controller
{
    public function logout()
    {
        Auth::logout();
        return view('auth.login');
    }
}
