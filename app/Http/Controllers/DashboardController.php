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
        $user = auth()->user();

        // Define dynamic menu items based on role
        if ($user->role === 'admin') {
            $menuItems = [
                ['name' => 'Dashboard', 'route' => 'adminDashboard'],
                ['name' => 'Manage Users', 'route' => 'users.index'],
                ['name' => 'Reports', 'route' => 'reports.index'],
            ];
        } else {
            $menuItems = [
                ['name' => 'Dashboard', 'route' => 'userDashboard'],
                ['name' => 'Transactions', 'route' => 'transactions.index'],
                ['name' => 'Profile', 'route' => 'profile.index'],
            ];
        }

        return view('dashboard.userDash', compact('user', 'menuItems'));
    }


}