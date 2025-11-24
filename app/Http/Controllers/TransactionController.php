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

    // view transaction details
    public function view(Request $request, $id)
    {
        // Find the transaction by ID
        $transaction = Transaction::with(['member', 'community', 'verifiedBy'])->findOrFail($id);
        // Pass it to the Blade view
        return view('transactions.view', compact('transaction'));
    }

    //status uptadate function

    public function status(Request $request, $id)
    {
        // Validate the input
        $request->validate([
            'status' => 'required|in:1,2', // 1=Approved, 2=Rejected
            'reason' => 'nullable|string|max:500',
        ]);

        // Find the transaction
        $transaction = Transaction::findOrFail($id);

        // Only update if status is pending (0)
        if ($transaction->status != 0) {
            return redirect()->back()->with('error', 'This transaction has already been verified.');
        }

        // Update the transaction
        $transaction->status = $request->status;
        $transaction->reason_for_rejection = $request->status == 2 ? $request->reason : null;
        $transaction->verified_by = Auth::id();
        $transaction->verified_at = now();
        $transaction->save();

        // Redirect back with success message
        return redirect()-> route('communities',$transaction->community->id)->with('success', 'Transaction status updated successfully.');
    }


}
