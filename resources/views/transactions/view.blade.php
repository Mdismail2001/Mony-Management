@extends('layouts.base')

@section('title', 'Transaction Details')

@section('content')

<div class="max-w-5xl mx-auto p-6">

    <!-- Back Button -->
    <a href="{{ route('communities',$transaction->community->id) }}" 
       class="inline-flex items-center gap-2 text-sm mb-4 text-slate-600 hover:text-slate-800 transition">
        ⬅ Back
    </a>

    <!-- Header -->
    <div class="mb-6">
        <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">Transaction Details</h1>
        <p class="text-slate-500 text-sm mt-1">Review transaction information and verification status</p>
    </div>

    <!-- Main Card -->
    <div class="bg-gradient-to-br from-white via-slate-50 to-slate-100 shadow-xl rounded-2xl p-8 space-y-8 border border-slate-200 relative overflow-hidden">

        <!-- Status Badge -->
        <div class="absolute top-6 right-6">
            <span class="text-sm px-4 py-1 rounded-full font-semibold
                @if($transaction->status == 1) bg-emerald-100 text-emerald-700 border border-emerald-300
                @elseif($transaction->status == 2) bg-red-100 text-red-700 border border-red-300
                @else bg-yellow-100 text-yellow-700 border border-yellow-300
                @endif">
                @if($transaction->status == 1)
                    ● Approved
                @elseif($transaction->status == 2)
                    ● Rejected
                @else
                    ● Pending
                @endif
            </span>
        </div>

        <!-- Section 1: Basic Info -->
        <div class="grid md:grid-cols-2 gap-6">
            <div class="space-y-2">
                <h2 class="font-semibold text-sm text-slate-500 uppercase">Transaction</h2>
                <p class="text-lg font-bold">{{ $transaction->id }}</p>
            </div>
            <div class="space-y-2">
                <h2 class="font-semibold text-sm text-slate-500 uppercase">Amount</h2>
                <p class="text-lg font-bold text-emerald-700">RM {{ number_format($transaction->amount, 2) }}</p>
            </div>
            <div class="space-y-2">
                <h2 class="font-semibold text-sm text-slate-500 uppercase">Member</h2>
                <p>{{ $transaction->member->id ?? 'N/A' }}</p>
            </div>
            <div class="space-y-2">
                <h2 class="font-semibold text-sm text-slate-500 uppercase">Community</h2>
                <p>{{ $transaction->community->name ?? 'N/A' }}</p>
            </div>
            <div class="space-y-2">
                <h2 class="font-semibold text-sm text-slate-500 uppercase">Payment Date</h2>
                <p>{{ \Carbon\Carbon::parse($transaction->date)->format('d M Y') }}</p>
            </div>
            <div class="space-y-2">
                <h2 class="font-semibold text-sm text-slate-500 uppercase">Month</h2>
                <p>{{ \Carbon\Carbon::parse($transaction->date)->format('F Y') }}</p>
            </div>
        </div>

        <!-- Section 2: Proof -->
        <div class="pt-4 border-t">
            <h2 class="font-semibold text-sm text-slate-500 uppercase mb-3">Proof of Payment</h2>
            @if($transaction->proof)
                @php $ext = pathinfo($transaction->proof, PATHINFO_EXTENSION); @endphp
                <div class="bg-white border rounded-lg p-4 shadow-sm">
                    @if(in_array(strtolower($ext), ['jpg','jpeg','png','gif']))
                        <img src="{{ asset('storage/' . $transaction->proof) }}" 
                             alt="Proof Image" 
                             class="max-h-72 rounded mx-auto shadow-lg">
                    @elseif(strtolower($ext) === 'pdf')
                        <a href="{{ asset('storage/' . $transaction->proof) }}" target="_blank"
                           class="text-blue-600 hover:underline font-semibold">📄 View PDF</a>
                    @else
                        <a href="{{ asset('storage/' . $transaction->proof) }}" target="_blank"
                           class="text-blue-600 hover:underline font-semibold">⬇ Download File</a>
                    @endif
                </div>
            @else
                <p class="text-slate-500 italic">No proof uploaded.</p>
            @endif
        </div>

        <!-- Section 3: Verification Timeline -->
        <div class="pt-4 border-t">
            <h2 class="font-semibold text-sm text-slate-500 uppercase mb-3">Verification</h2>
            <div class="space-y-2">
                <p><span class="font-semibold text-slate-700">Verified By:</span> {{ $transaction->verified_by ? $transaction->verifiedBy->name : 'Not Verified' }}</p>
                <p><span class="font-semibold text-slate-700">Verified At:</span> {{ $transaction->verified_at ? \Carbon\Carbon::parse($transaction->verified_at)->format('d M Y H:i') : 'Not Verified' }}</p>
                <p><span class="font-semibold text-slate-700">Reason for Rejection:</span> {{ $transaction->reason_for_rejection ?? '-' }}</p>
            </div>
        </div>
    </div>

    <!-- Section 4: Actions -->
    @if($transaction->status == 0)
    <div class="mt-6 bg-white border border-slate-200 p-6 rounded-2xl shadow-lg">
        <form action="{{ route('status-update', $transaction->id) }}" method="POST">
            @csrf
            @method('PUT')

            <label class="font-semibold text-sm text-slate-700">Reason (Only if Rejecting)</label>
            <textarea name="reason" class="w-full mt-2 border rounded-lg p-3" placeholder="Enter rejection reason..."></textarea>

            <div class="flex gap-3 justify-end mt-5">
                <button type="submit" name="status" value="2"
                    class="px-6 py-2 rounded-lg bg-red-600 hover:bg-red-700 text-white font-semibold shadow">
                    Reject
                </button>

                <button type="submit" name="status" value="1"
                    class="px-6 py-2 rounded-lg bg-emerald-600 hover:bg-emerald-700 text-white font-semibold shadow">
                    Approve
                </button>
            </div>
        </form>
    </div>
    @endif

</div>

@endsection
