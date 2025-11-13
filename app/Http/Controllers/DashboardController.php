<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;




class DashboardController extends Controller
{
    // Show the admin dashboard
    public function adminDash()
    {
        return view('dashboard.adminDash');
    }

    // Show the user dashboard
    public function userDash()
    {
        return view('dashboard.userDash');
    }
}