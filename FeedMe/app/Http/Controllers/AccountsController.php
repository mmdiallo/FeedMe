<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\AccountType;
use DB;

class AccountsController extends Controller
{
    public function types() {
        $accountTypes = AccountType::all();
        return $accountTypes;
    }
}
