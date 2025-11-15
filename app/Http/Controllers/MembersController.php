<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;

class MembersController extends Controller
{
    // // Show all members
    // public function index()
    // {
    //     $members = Member::all();
    //     return view('members.index', compact('members'));
    // }

    //  Show form to create a new member
    public function createMemberForm()
    {
        return view('members.createMember', [
            'showHeader' => false,
            'showSidebar' => false,
        ]);
    }
    // Create a new member
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'community_id' => 'required|exists:communities,id',
            'role' => 'required|string',
            'last_payment' => 'nullable|date',
            'total_amount' => 'required|numeric',
        ]);

        Member::create($request->all());

        return redirect()->back()->with('success', 'Member created successfully!');
    }

    // Show a single member
    public function show($id)
    {
        $member = Member::findOrFail($id);
        return view('members.show', compact('member'));
    }

    // Update a member
    public function update(Request $request, $id)
    {
        $member = Member::findOrFail($id);

        $request->validate([
            'role' => 'sometimes|required|string',
            'last_payment' => 'nullable|date',
            'total_amount' => 'sometimes|required|numeric',
        ]);

        $member->update($request->all());

        return redirect()->back()->with('success', 'Member updated successfully!');
    }

    // Delete a member
    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();

        return redirect()->back()->with('success', 'Member deleted successfully!');
    }
}
