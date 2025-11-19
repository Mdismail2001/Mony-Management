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
        return redirect()->route('Dashboard')->with('success', 'Community created successfully.');
    } 


    // Show community details
    public function show($id)
    {   
        $community = Community::with('members.user')->findOrFail($id);
        return view('communities.show' , compact('community'));
    }

    // Show the community edit form
    public function editForm($id)
    {
        $community = Community::findOrFail($id);
        return view('communities.editCommunity', compact('community'));
    }
    // Restore community
    public function edit(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'min_amount' => 'required|numeric|min:0',
        ]); 
        $community = Community::findOrFail($id);
        $community->name = $request->input('name');
        $community->min_amount = $request->input('min_amount');
        $community->save(); 
        return redirect()->route('communities', $community->id)->with('success', 'Community updated successfully.');

    }


}
