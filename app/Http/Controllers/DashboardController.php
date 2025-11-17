<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Community;




class DashboardController extends Controller
{
    // Show the admin dashboard
    public function adminDash()
    {
        $user = auth()->user();

        // fetch communities data
        $communities = Community::withCount('members')->get();
        // Define dynamic header menu items based on role
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

        // Cards for dashboard
        $cards = [];
        
        foreach ($communities as $community) {
            // You can add more community-specific data here if needed
            $cards[] = [
                'title' => $community->name,
                'value_1' => ' Total Members: ' . $community->members_count,
                'value_2' => ' Total Funds: $' . number_format($community->total_amount, 2),
                'description' => 'Manage ' . $community->name . ' community',
                'border' => 'border-blue-500',
                'text_color' => 'text-blue-500',
                'subtitle_color' => 'text-blue-500',
                'route' => route('communities', $community->id),
            ];
        }

        return view('dashboard.adminDash', [
            'user' => $user,
            'menuItems' => $menuItems,
            'cards' => $cards,
            'showHeader' => true,
            'showSidebar' => true,
        ]);
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