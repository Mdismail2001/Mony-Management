<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Community;




class DashboardController extends Controller
{
    // Show the admin dashboard
    public function Dashboard()
    {
        $user = auth()->user();


         // Fetch only communities where the logged-in user is a member
        $communities = $user->communities()->withCount('members')->get();


        // Cards for landing page
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

        return view('dashboard.landing', [
            'user' => $user,
            // 'menuItems' => $menuItems,
            'cards' => $cards,
            'showHeader' => true,
            'showSidebar' => true,
        ]);
    }



}