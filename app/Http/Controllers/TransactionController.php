<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TransactionController extends Controller
{
    // Show transaction submission form
    public function showForm(Request $request)
    {
        $memberId = $request->input('member_id');
        $communityId = $request->input('community_id');
        // dd($memberId, $communityId);
        return view('transactions.depositForm', compact('memberId', 'communityId'));
    }

    // store transaction
    public function store(Request $request)
    {
        
        // dd($request->all());
        $request->validate([
            'member_id' => 'required|exists:members,id',
            'community_id' => 'required|exists:communities,id',
            'amount' => 'required|numeric',
            'date' => 'required|date',
            'month' => 'required',
            'proof' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:2048',
        ]);

        $proof = null;  
        if ($request->hasFile('proof')) {
            $proof = $request->file('proof')->store('proofs', 'public');
        }
        Transaction::create([
            'member_id' => $request->member_id,
            'community_id' => $request->community_id,
            'amount' => $request->amount,
            'date' => $request->date,
            'month' => $request->month,
            'proof' => $proof,
            'status' => 0 // submitted
        ]);
        return redirect()->route('communities', $request->community_id)->with('success', 'Transaction submitted for approval.');
    }


}
