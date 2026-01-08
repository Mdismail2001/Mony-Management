<?php

namespace App\Http\Controllers;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Support\Facades\DB;   

class TransactionController extends Controller
{
    //  Show transaction submission form
    public function showForm(Request $request)
    {
        $memberId = $request->input('member_id');
        $communityId = $request->input('community_id');
        // dd($memberId, $communityId);
        return view('transactions.depositForm', compact('memberId', 'communityId'));
    }

    //  store transaction
    public function store(Request $request)
    {
        
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

    //  transaction edit function
    public function transactionEditForm(Request $request, $id)
    {
        $transaction = Transaction::findOrFail($id);
        // dd($transaction);
        return  view('transactions.transactionEdit', compact('transaction'));
    }

    //  transaction update submit 
    public function transactionUpdate(Request $request, $id)
    {
        // dd($request->all());

        $transaction = Transaction::findOrFail($id);
        
        $transaction->update([
            'amount' => $request->amount,
            'date' => $request->date,
            'month' => $request->month,
            'proof' => $request->proof,
        ]);
        
        return redirect()->route('communities', $transaction->community_id)->with('success', 'Transaction updated successfully.');
    }

    //  view transaction details
    public function view(Request $request, $id)
    {
        $transaction = Transaction::with(['member', 'community', 'verifiedBy'])->findOrFail($id);
        return view('transactions.view', compact('transaction'));
    }

    //  status uptadate function
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

    //  all transaction function
    // public function allTransactions(Request $request)
    // {
    //     dd($request->all());
    //     $user = auth()->user();

    //     if (!$user) {
    //         return redirect()->route('login')->with('error', 'Session expired. Please login again.');
    //     }

    //     $now = now();

    //     $search = $request->input('search'); // member name
    //     $year   = $request->input('year',$now->year );   // YYYY
    //     $month  = $request->input('month',$now->format('F'));  // January, February, etc.

    //     // Get community IDs where current user is a member
    //     $userCommunityIds = $user->communities()->pluck('communities.id');

    //     // Subquery: latest transaction per member
    //     $latestTransactions = DB::table('transactions')
    //         ->select('member_id', DB::raw('MAX(updated_at) as latest_date'))
    //         ->groupBy('member_id');

    //     // Main query
    //     $transactions = DB::table('transactions as t')
    //         ->joinSub($latestTransactions, 'latest', function ($join) {
    //             $join->on('t.member_id', '=', 'latest.member_id')
    //                 ->on('t.updated_at', '=', 'latest.latest_date');
    //         })
    //         ->join('members as m', 't.member_id', '=', 'm.id')
    //         ->join('users as u', 'm.user_id', '=', 'u.id')
    //         ->join('communities as c', 'm.community_id', '=', 'c.id')
    //         ->select(
    //             'u.name as member_name',
    //             'm.last_payment as last_deposit',
    //             'm.total_amount as member_total',
    //             'c.name as community_name',
    //             'c.total_amount as community_total',
    //             't.updated_at as latest_transaction_date'
    //         )
    //         ->whereIn('m.community_id', $userCommunityIds)
    //         //  THIS IS THE FILTER PART
    //         ->when($request->search, function ($query) use ($request) {
    //             $query->where(function ($q) use ($request) {
    //                 $q->where('u.name', 'LIKE', '%' . $request->search . '%')
    //                 ->orWhere('c.name', 'LIKE', '%' . $request->search . '%');
    //             });
    //         })
            
    //         ->orderBy('t.updated_at', 'desc')
    //         ->get();

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
            return redirect()->route('login')
                ->with('error', 'Session expired. Please login again.');
        }

        // Current year and month defaults
        // $now = now();
        $search = $request->input('search'); // member/community name
        $year   = $request->input('year');       // default current year
        $month  = $request->input('month'); // default current month name (January, February...)

        // Community IDs where user is a member
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
            // Filter by member or community name
            ->when($search, function ($query) use ($search) {
                $query->where(function ($q) use ($search) {
                    $q->where('u.name', 'LIKE', '%' . $search . '%')
                    ->orWhere('c.name', 'LIKE', '%' . $search . '%');
                });
            })
            // Filter by year
            ->when($year, function ($query) use ($year) {
                $query->whereYear('t.updated_at', $year);
            })
            // Filter by month name
            ->when($month, function ($query) use ($month) {
                $query->whereRaw("DATE_FORMAT(t.updated_at, '%M') = ?", [$month]);
            })
            ->orderBy('t.updated_at', 'desc')
            ->get();

        return view('transactions.allTransaction', [
            'showHeader' => true,
            'showSidebar' => true,
            'transactions' => $transactions,
            'search' => $search,
            'year' => $year,
            'month' => $month,
        ]);
    }


}
