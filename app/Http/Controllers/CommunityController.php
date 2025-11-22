<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Community;
use App\Models\Member;

class CommunityController extends Controller
{
    /**
     * Show the community creation form.
     */
    public function createShowForm()
    {
        return view('communities.createCommunity', [
            'showHeader' => false,
            'showSidebar' => false,
        ]);
    }

    /**
     * Store a newly created community.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'min_amount' => 'required|numeric|min:0',
            'banking_info' => 'nullable|array',
            'banking_info.*.type' => 'required_with:banking_info|string|in:Bank,Mobile Bank',
            'banking_info.*.account_no' => 'required_with:banking_info|string|max:255',
            // Only validate as string if type is Bank
            'banking_info.*.bank_name' => 'nullable|string|required_if:banking_info.*.type,Bank|max:255',
            'banking_info.*.branch' => 'nullable|string|required_if:banking_info.*.type,Bank|max:255',
            // Only validate as string if type is Mobile Bank
            'banking_info.*.mobile_type' => 'nullable|string|required_if:banking_info.*.type,Mobile Bank|max:255',
            'banking_info.*.holder_name' => 'required|string|max:255',
        ]);


        // Create the community
        $community = Community::create([
            'name' => $request->input('name'),
            'min_amount' => $request->input('min_amount'),
            'total_amount' => 0,
            'banking_info' => $request->input('banking_info', []),
        ]);

        // Assign the creator as the leader
        Member::create([
            'community_id' => $community->id,
            'user_id' => auth()->id(),
            'role' => 'leader',
            'total_amount' => 0,
            'last_payment' => null,
        ]);

        return redirect()->route('Dashboard')
                         ->with('success', 'Community created successfully.');
    }

    /**
     * Display a specific community's details.
     */
    public function show($id)
    {
        $community = Community::with('members.user')->findOrFail($id);
        return view('communities.show', compact('community'));
    }

    /**
     * Show the community edit form.
     */
    public function editForm($id)
    {
        $community = Community::findOrFail($id);
        return view('communities.editCommunity', compact('community'));
    }

    /**
     * Update an existing community.
     */
    public function edit(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'min_amount' => 'required|numeric|min:0',
            'banking_info' => 'nullable|array',
            'banking_info.*.type' => 'required_with:banking_info|string|in:Bank,Mobile Bank',
            'banking_info.*.account_no' => 'required_with:banking_info|string|max:255',
            // Only validate as string if type is Bank
            'banking_info.*.bank_name' => 'nullable|string|required_if:banking_info.*.type,Bank|max:255',
            'banking_info.*.branch' => 'nullable|string|required_if:banking_info.*.type,Bank|max:255',
            // Only validate as string if type is Mobile Bank
            'banking_info.*.mobile_type' => 'nullable|string|required_if:banking_info.*.type,Mobile Bank|max:255',
            'banking_info.*.holder_name' => 'required|string|max:255',
        ]);


        $community = Community::findOrFail($id);

        $community->update([
            'name' => $request->input('name'),
            'min_amount' => $request->input('min_amount'),
            'banking_info' => $request->input('banking_info', []),
        ]);

        return redirect()->route('communities', $community->id)
                         ->with('success', 'Community updated successfully.');
    }

    /**
     * Delete a community.
     */
    public function delete($id)
    {
        $community = Community::findOrFail($id);
        $community->delete();

        return redirect()->route('Dashboard')
                         ->with('success', 'Community deleted successfully.');
    }
}
