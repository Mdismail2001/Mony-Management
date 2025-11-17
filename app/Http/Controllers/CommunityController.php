<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Community;

class CommunityController extends Controller
{
    // Show the community creation form
    public function createShowForm()
    {
        return view('communities.createCommunity', [
            'showHeader' => false,
            'showSidebar' => false,
        ]);
    }

    // Store a new community
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'min_amount' => 'required|numeric|min:0',
        ]); 
        // Create the community
        Community::create([
            'name' => $request->input('name'),
            'min_amount' => $request->input('min_amount'),
            'total_amount' => 0, // Initialize total amount to 0
        ]);
        return redirect()->route('adminDashboard')->with('success', 'Community created successfully.');
    } 


    // Show community details
    public function show($id)
    {
        
        $community = Community::with('members.user')->findOrFail($id);
        return view('communities.show' , compact('community'));
    }


}
