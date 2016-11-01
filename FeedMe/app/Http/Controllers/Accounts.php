<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class Accounts extends Controller
{
    public function login_form() {
        return view('accounts.login');
    }

    public function login(Request $request) {
        return "hi";
    }
}
