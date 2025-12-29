<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Community;
use App\Models\Member;
use Carbon\Carbon;


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
            'transactions.member.user'
        ])->findOrFail($id);

        // Decode notices
        $notices = $community->notice
            ? json_decode($community->notice, true)
            : [];

        $showNotices = []; // 👈 THIS is what blade will use

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

                // ❌ Not paid OR wrong amount OR not approved
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
    // public function noticeStore(Request $request, $id)
    // {
    //     $request->validate([
    //         'notice_type'     => 'required|in:deposit,info,warning',
    //         'notice'          => 'required|string|max:1000',
    //         'notice_due_date' => 'required|date',
    //     ]);

    //     $community = Community::findOrFail($id);

    //     $community->notice = json_encode([
    //         'type'       => $request->notice_type,
    //         'month'      => $request->notice_month,
    //         'message'    => $request->notice,
    //         'due_date'   => Carbon::parse($request->notice_due_date)->format('Y-m-d'),
    //         'created_at'=> now()->toDateTimeString(),
    //     ]);

    //     $community->save();

    //     return redirect()
    //         ->route('communities', $community->id)
    //         ->with('success', 'Notice published successfully.');
    // }
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


}
