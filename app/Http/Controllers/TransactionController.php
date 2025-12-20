<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // For current user info
use Illuminate\Support\Facades\DB;   //  For DB::table queries

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
        $request->validate([
            'status' => 'required|in:1,2',
            'reason' => 'nullable|string|max:500',
        ]);

        $transaction = Transaction::findOrFail($id);

        if ($transaction->status != 0) {
            return redirect()->back()->with('error', 'This transaction has already been verified.');
        }

        // Update transaction status first
        $transaction->status = $request->status;
        $transaction->reason_for_rejection = $request->status == 2 ? $request->reason : null;
        $transaction->verified_by = Auth::id();
        $transaction->verified_at = now();
        $transaction->save();

        // ONLY RUN WHEN APPROVED
        if ($request->status == 1) {

            // Update Member table
            $member = $transaction->member; // Relationship must exist (belongsTo)
            $member->last_payment = $transaction->amount;
            $member->total_amount += $transaction->amount;
            $member->save();

            // Update Community table
            $community = $transaction->community; // Relationship must exist (belongsTo)
            $community->total_amount += $transaction->amount;
            $community->save();
        }

        return redirect()
            ->route('communities', $transaction->community->id)
            ->with('success', 'Transaction status updated successfully.');
    }

    // All Transacition function 
    // public function allTransactions(Request $request)
    // {
    //     $user = auth()->user();

    //     if (!$user) {
    //         return redirect()->route('login')->with('error', 'Session expired. Please login again.');
    //     }

    //     // Get IDs of communities where the user is a member
    //     $userCommunityIds = $user->communities()->pluck('communities.id');

    //     // Fetch transactions only for those communities
    //     $transactions = DB::table('transactions')
    //         ->join('members', 'transactions.member_id', '=', 'members.id')
    //         ->join('users', 'members.user_id', '=', 'users.id')
    //         ->join('communities', 'members.community_id', '=', 'communities.id')
    //         ->select(
    //             'users.name as member_name',
    //             'members.last_payment as last_deposit',
    //             'members.total_amount as member_total',
    //             // 'transactions.type as deposit_type',
    //             'communities.name as community_name',
    //             'communities.total_amount as community_total',

    //         )
    //         ->whereIn('members.community_id', $userCommunityIds)
    //         ->orderBy('transactions.created_at', 'desc')
    //         ->get();
    //         // dd($transactions);

    //     return view('transactions.allTransaction', [
    //         'showHeader' => true,
    //         'showSidebar' => true,
    //         'transactions' => $transactions,
    //     ]);
    // }
    public function allTransactions(Request $request)
{
    $user = auth()->user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Session expired. Please login again.');
    }

    // Get community IDs where current user is a member
    $userCommunityIds = $user->communities()->pluck('communities.id');

    // Subquery: latest transaction per member
    $latestTransactions = DB::table('transactions')
        ->select('member_id', DB::raw('MAX(updated_at) as latest_date'))
        ->groupBy('member_id');

    // Main query
    $transactions = DB::table('transactions as t')
        ->joinSub($latestTransactions, 'latest', function ($join) {
            $join->on('t.member_id', '=', 'latest.member_id')
                 ->on('t.updated_at', '=', 'latest.latest_date');
        })
        ->join('members as m', 't.member_id', '=', 'm.id')
        ->join('users as u', 'm.user_id', '=', 'u.id')
        ->join('communities as c', 'm.community_id', '=', 'c.id')
        ->select(
            'u.name as member_name',
            'm.last_payment as last_deposit',
            'm.total_amount as member_total',
            'c.name as community_name',
            'c.total_amount as community_total',
            't.updated_at as latest_transaction_date'
        )
        ->whereIn('m.community_id', $userCommunityIds)
         //  THIS IS THE FILTER PART
        ->when($request->search, function ($query) use ($request) {
            $query->where(function ($q) use ($request) {
                $q->where('u.name', 'LIKE', '%' . $request->search . '%')
                ->orWhere('c.name', 'LIKE', '%' . $request->search . '%');
            });
        })
        
        ->orderBy('t.updated_at', 'desc')
        ->get();

    return view('transactions.allTransaction', [
        'showHeader' => true,
        'showSidebar' => true,
        'transactions' => $transactions,
    ]);
}

}
