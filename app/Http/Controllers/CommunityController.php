<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Community;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\GenericExport;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;


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

    
    //Store a newly created community.
    
    public function store(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'min_amount' => 'required|numeric|min:0',
            'banking_info' => 'nullable|array',

            // Type
            'banking_info.*.type' => 'required|string|in:Bank,Mobile Bank',

            // Bank validation
            'banking_info.*.bank_account_no' => 'required_if:banking_info.*.type,Bank|nullable|string|max:255',
            'banking_info.*.bank_holder_name' => 'required_if:banking_info.*.type,Bank|nullable|string|max:255',
            'banking_info.*.bank_name' => 'required_if:banking_info.*.type,Bank|nullable|string|max:255',
            'banking_info.*.branch' => 'required_if:banking_info.*.type,Bank|nullable|string|max:255',

            // Mobile Bank validation
            'banking_info.*.mobile_account_no' => 'required_if:banking_info.*.type,Mobile Bank|nullable|string|max:255',
            'banking_info.*.mobile_holder_name' => 'required_if:banking_info.*.type,Mobile Bank|nullable|string|max:255',
            'banking_info.*.mobile_type' => 'required_if:banking_info.*.type,Mobile Bank|nullable|string|max:255',
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
        $community = Community::with([
            'members.user',
            'transactions' => function ($query) {
                $query->whereIn('id', function ($sub) {
                    $sub->select(DB::raw('MAX(id)'))
                        ->from('transactions')
                        ->groupBy('member_id');
                });
            },
            'transactions.member.user'
        ])->findOrFail($id);
        // Decode notices
        $notices = $community->notice
            ? json_decode($community->notice, true)
            : [];

        $showNotices = []; //  THIS is what blade will use

        if (!auth()->check() || empty($notices)) {
            return view('communities.show', compact('community', 'showNotices'));
        }

        $user = auth()->user();

        $member = $community->members
            ->where('user_id', $user->id)
            ->first();

        if (!$member) {
            return view('communities.show', compact('community', 'showNotices'));
        }

        // -------------------------
        // Loop all notices
        // -------------------------
        foreach ($notices as $notice) {

            $type = $notice['type'] ?? null;

            /*
            |--------------------------------------------------------------------------
            | DEPOSIT NOTICE
            |--------------------------------------------------------------------------
            */
            if ($type === 'deposit') {

                $noticeMonth = $notice['month'] ?? null;
                if (!$noticeMonth) {
                    continue;
                }

                $paymentForMonth = $community->transactions
                    ->where('member_id', $member->id)
                    ->where('month', $noticeMonth)
                    ->sortByDesc('created_at')
                    ->first();

                //  Not paid OR wrong amount OR not approved
                if (
                    !$paymentForMonth ||
                    $paymentForMonth->month !== $noticeMonth ||
                    $paymentForMonth->amount != $community->min_amount ||
                    $paymentForMonth->status != 1
                ) {
                    $showNotices[] = $notice;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | INFO / WARNING NOTICE
            |--------------------------------------------------------------------------
            */
            if (in_array($type, ['info', 'warning'])) {

                if (!empty($notice['due_date'])) {
                    $dueDate = Carbon::parse($notice['due_date']);

                    if (now()->lte($dueDate)) {
                        $showNotices[] = $notice;
                    }
                }
            }
        }
        return view('communities.show', compact('community', 'showNotices'));
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
        // dd($request->all());
        $request->validate([
            'name' => 'required|string|max:255',
            'min_amount' => 'required|numeric|min:0',
            'banking_info' => 'nullable|array',

            // Type
            'banking_info.*.type' => 'required|string|in:Bank,Mobile Bank',

            // Bank validation
            'banking_info.*.bank_account_no' => 'required_if:banking_info.*.type,Bank|nullable|string|max:255',
            'banking_info.*.bank_holder_name' => 'required_if:banking_info.*.type,Bank|nullable|string|max:255',
            'banking_info.*.bank_name' => 'required_if:banking_info.*.type,Bank|nullable|string|max:255',
            'banking_info.*.branch' => 'required_if:banking_info.*.type,Bank|nullable|string|max:255',

            // Mobile Bank validation
            'banking_info.*.mobile_account_no' => 'required_if:banking_info.*.type,Mobile Bank|nullable|string|max:255',
            'banking_info.*.mobile_holder_name' => 'required_if:banking_info.*.type,Mobile Bank|nullable|string|max:255',
            'banking_info.*.mobile_type' => 'required_if:banking_info.*.type,Mobile Bank|nullable|string|max:255',
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

    // community notice function 
    public function noticeForm($id)
    {  
        $community = Community::findOrFail($id);
        return view('communities.noticeCommunity', compact('community'));
    }

    // notice store function
    public function noticeStore(Request $request, $id)
    {
        $request->validate([
            'notice_type'     => 'required|in:deposit,info,warning',
            'notice'          => 'required|string|max:1000',
            'notice_due_date' => 'required|date',
            'notice_month'    => 'nullable|string',
        ]);

        $community = Community::findOrFail($id);

        // Decode existing notices
        $notices = json_decode($community->notice, true) ?? [];

        // Convert old single notice into array
        if (!empty($notices) && isset($notices['type'])) {
            $notices = [$notices];
        }

        // Remove previous notice of the same type
        $notices = collect($notices)
            ->reject(fn($n) => $n['type'] === $request->notice_type)
            ->values()
            ->toArray();

        // Add the new notice
        $notices[] = [
            'type'       => $request->notice_type,
            'month'      => $request->notice_month,
            'message'    => $request->notice,
            'due_date'   => Carbon::parse($request->notice_due_date)->format('Y-m-d'),
            'created_at' => now()->toDateTimeString(),
        ];

        // Save back
        $community->notice = json_encode($notices);
        $community->save();

        return redirect()
            ->route('communities', $community->id)
            ->with('success', 'Notice published successfully.');
    }

    // each community all members
    public function eachAllMembers(Request $request, $id)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Session expired. Please login again.');
        }

        $search = $request->input('search');

        $community = Community::with([
            'members' => function ($query) use ($search) {
                $query->when($search, function ($q) use ($search) {
                    $q->whereHas('user', function ($u) use ($search) {
                        $u->where('name', 'LIKE', "%{$search}%");
                    });
                })
                ->orderBy('updated_at', 'desc');
            },
            'members.user',
            'transactions' => function ($query) {
                $query->whereIn('id', function ($sub) {
                    $sub->select(DB::raw('MAX(id)'))
                        ->from('transactions')
                        ->groupBy('member_id');
                });
            },
            'transactions.member.user'
        ])->findOrFail($id);

        // --- EXCEL DOWNLOAD LOGIC ---
        if ($request->has('excelfile')) {
            $headings = ['No', ' Name','Mobile', 'Email', 'Community', 'Last Deposit', 'Total Amount', 'Joined Date', ];

            $exportData = $community->members->map(function ($member, $index) use ($community) {
                return [
                    'No'          => $index + 1,
                    'Name' => $member->user->name ?? 'N/A',
                    'Mobile'      => $member->user->phone_number ?? 'N/A',
                    'Email'       => $member->user->email ?? 'N/A',
                    'Community'   => $community->name ?? 'N/A',
                    'Last Deposit'=> $member->last_payment ? number_format($member->last_payment, 2) : '0.00',
                    'Total Amount' => $member->total_amount ? number_format($member->total_amount, 2) : '0.00',
                    'Joined Date' => $member->created_at->format('d M Y'),
                ];
            });
            $filename = ($community->name) . '_Members list_' . now()->format('Y-m-d') . '.xlsx';

            return Excel::download(new GenericExport($headings, $exportData), $filename);
        }

        return view('members.eachAllmem', compact('community'));
    }

    // each community all transaction
    public function eachAllTransactions(Request $request, $id)
    {
        $user = auth()->user();

        if (!$user) {
            return redirect()->route('login')
                ->with('error', 'Session expired. Please login again.');
        }
        //  DEFINE NOW FIRST
        // $now = Carbon::now();

        $search = $request->input('search'); // member name
        $year   = $request->input('year' );   // YYYY
        $month  = $request->input('month');  // January, February, etc.

        $community = Community::with([
            'transactions' => function ($query) use ($search, $year, $month) {

                // 🔍 Filter by member name
                $query->when($search, function ($q) use ($search) {
                    $q->whereHas('member.user', function ($u) use ($search) {
                        $u->where('name', 'LIKE', "%{$search}%");
                    });
                });

                // 📅 Filter by year
                $query->when($year, function ($q) use ($year) {
                    $q->whereYear('date', $year);
                });

                // 📆 Filter by month
                $query->when($month, function ($q) use ($month) {
                    $monthNumber = \Carbon\Carbon::parse($month)->month;
                    $q->whereMonth('date', $monthNumber);
                });

                // Latest transaction per member
                $query->whereIn('id', function ($sub) {
                    $sub->select(DB::raw('MAX(id)'))
                        ->from('transactions')
                        ->groupBy('member_id');
                });

                $query->orderBy('date', 'desc');
            },

            'transactions.member.user',
        ])->findOrFail($id);

        // 2. CHECK FOR EXCEL PLUG HERE
        if ($request->has('excelfile')) {
            // 1. Define your headings
            $headings = ['Name', 'Amount', 'Month', 'Date', 'Status'];

            // 2. Map your data into a clean collection of arrays
            $exportData = $community->transactions->map(function ($t) {
                $formattedMonth = \Carbon\Carbon::parse($t->month)->format('F, Y');
                return [
                    'Name'   => $t->member->user->name ?? 'N/A',
                    'Amount' => number_format($t->amount, 2),
                    'Month'  => $formattedMonth,
                    'Date'   => \Carbon\Carbon::parse($t->date)->format('d M Y'),
                    'Status' => $t->status == 1 ? 'Approved' : ($t->status == 2 ? 'Rejected' : 'Pending'),
                ];
            });
            // 3. Pass both to the GenericExport
            $filename = $community->name . '_Transactions_' . now()->format('Y-m-d') . '.xlsx';
            // 4. Download
            return Excel::download(
                new GenericExport($headings, $exportData), 
                $filename
            );
        }   

       return view('transactions.eachAllTransation', compact('community'));
    }

}
