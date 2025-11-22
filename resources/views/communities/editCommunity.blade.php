@extends('layouts.base')

@section('title', 'Edit Community')

@section('content')
<div class="min-h-screen bg-slate-950 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('communities', $community->id) }}"
               class="inline-flex items-center gap-2 text-slate-400 hover:text-emerald-400 transition-colors group">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="text-sm font-medium">Back to Community Details</span>
            </a>
        </div>

        {{-- Card --}}
        <div class="bg-slate-900/80 backdrop-blur-lg shadow-xl rounded-2xl p-8 border border-slate-800/50">
            <h2 class="text-3xl font-bold bg-gradient-to-r from-emerald-400 to-teal-400 bg-clip-text text-transparent mb-8">
                Edit Community
            </h2>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-emerald-500/10 border border-emerald-500/30 text-emerald-400 p-4 rounded-lg mb-6 flex items-start gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- Error Messages --}}
            @if($errors->any())
                <div class="bg-red-500/10 border border-red-500/30 text-red-400 p-4 rounded-lg mb-6">
                    <ul class="list-disc pl-5 space-y-1">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('edit', $community->id) }}" method="POST" class="space-y-6">
                @csrf

                {{-- Community Name --}}
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">
                        Community Name <span class="text-red-400">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name', $community->name) }}" 
                           required
                           class="w-full bg-slate-800/50 border border-slate-700 text-slate-100 px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all placeholder-slate-500">
                </div>

                {{-- Minimum Amount --}}
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">
                        Minimum Amount <span class="text-red-400">*</span>
                    </label>
                    <input type="number" 
                           name="min_amount" 
                           value="{{ old('min_amount', $community->min_amount) }}" 
                           step="0.01"
                           required
                           class="w-full bg-slate-800/50 border border-slate-700 text-slate-100 px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all placeholder-slate-500">
                </div>

                {{-- Banking Info --}}
                <div>
                    <label class="block text-sm font-medium text-slate-300 mb-2">Banking Info</label>
                    <div id="banking-info-wrapper" class="space-y-4">
                        @php
                            $bankingInfos = old('banking_info', $community->banking_info ?? []);
                        @endphp

                        @foreach($bankingInfos as $index => $bank)
                        <div class="bg-slate-800/30 border border-slate-700/50 rounded-xl p-4 space-y-2 relative">
                            <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">Remove</button>

                            <select name="banking_info[{{ $index }}][type]" class="w-full bg-slate-800/50 border border-slate-700 text-slate-100 px-4 py-3 rounded-lg" onchange="toggleBankFields(this)">
                                <option value="">Select Type</option>
                                <option value="Bank" {{ ($bank['type'] ?? '') == 'Bank' ? 'selected' : '' }}>Bank</option>
                                <option value="Mobile Bank" {{ ($bank['type'] ?? '') == 'Mobile Bank' ? 'selected' : '' }}>Mobile Bank</option>
                            </select>

                            {{-- Bank Fields --}}
                            <div class="bank-fields mt-2" style="{{ ($bank['type'] ?? '') == 'Bank' ? '' : 'display:none;' }}">
                                <input type="text" name="banking_info[{{ $index }}][account_no]" value="{{ $bank['account_no'] ?? '' }}" placeholder="Account No" class="w-full bg-slate-800/50 border border-slate-700 text-slate-100 px-4 py-3 rounded-lg mb-2">
                                <input type="text" name="banking_info[{{ $index }}][bank_name]" value="{{ $bank['bank_name'] ?? '' }}" placeholder="Bank Name" class="w-full bg-slate-800/50 border border-slate-700 text-slate-100 px-4 py-3 rounded-lg mb-2">
                                <input type="text" name="banking_info[{{ $index }}][holder_name]" value="{{ $bank['holder_name'] ?? '' }}" placeholder="Holder Name" class="w-full bg-slate-800/50 border border-slate-700 text-slate-100 px-4 py-3 rounded-lg mb-2">
                                <input type="text" name="banking_info[{{ $index }}][branch]" value="{{ $bank['branch'] ?? '' }}" placeholder="Branch" class="w-full bg-slate-800/50 border border-slate-700 text-slate-100 px-4 py-3 rounded-lg">
                            </div>

                            {{-- Mobile Bank Fields --}}
                            <div class="mobile-bank-fields mt-2" style="{{ ($bank['type'] ?? '') == 'Mobile Bank' ? '' : 'display:none;' }}">
                                <input type="text" name="banking_info[{{ $index }}][account_no]" value="{{ $bank['account_no'] ?? '' }}" placeholder="Account No" class="w-full bg-slate-800/50 border border-slate-700 text-slate-100 px-4 py-3 rounded-lg mb-2">
                                <input type="text" name="banking_info[{{ $index }}][mobile_type]" value="{{ $bank['mobile_type'] ?? '' }}" placeholder="Type (Bkash/Nagad)" class="w-full bg-slate-800/50 border border-slate-700 text-slate-100 px-4 py-3 rounded-lg mb-2">
                                <input type="text" name="banking_info[{{ $index }}][holder_name]" value="{{ $bank['holder_name'] ?? '' }}" placeholder="Holder Name" class="w-full bg-slate-800/50 border border-slate-700 text-slate-100 px-4 py-3 rounded-lg">
                            </div>
                        </div>
                        @endforeach
                    </div>

                    <button type="button" onclick="addBankField()" class="mt-2 px-4 py-2 bg-emerald-500 text-white rounded-lg hover:bg-emerald-600 transition">Add Bank/Mobile Bank</button>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-4 pt-6 border-t border-slate-800">
                    <button type="submit"
                            class="flex-1 bg-gradient-to-r from-emerald-500 to-teal-500 text-white font-semibold py-3 rounded-lg hover:from-emerald-600 hover:to-teal-600 transition-all duration-200 shadow-lg shadow-emerald-500/20 hover:shadow-emerald-500/30">
                        Update Community
                    </button>
                    <a href="{{ route('communities', $community->id) }}"
                       class="px-6 py-3 bg-slate-800/50 text-slate-300 font-medium rounded-lg hover:bg-slate-800 transition-all border border-slate-700">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleBankFields(select) {
    const parent = select.parentElement;
    parent.querySelector('.bank-fields').style.display = select.value === 'Bank' ? 'block' : 'none';
    parent.querySelector('.mobile-bank-fields').style.display = select.value === 'Mobile Bank' ? 'block' : 'none';
}

function addBankField() {
    const wrapper = document.getElementById('banking-info-wrapper');
    const index = wrapper.children.length;
    const div = document.createElement('div');
    div.className = 'bg-slate-800/30 border border-slate-700/50 rounded-xl p-4 space-y-2 relative';
    div.innerHTML = `
        <button type="button" onclick="this.parentElement.remove()" class="absolute top-2 right-2 px-3 py-1 bg-red-500 text-white rounded-lg hover:bg-red-600 transition">Remove</button>
        <select name="banking_info[${index}][type]" class="w-full bg-slate-800/50 border border-slate-700 text-slate-100 px-4 py-3 rounded-lg" onchange="toggleBankFields(this)">
            <option value="">Select Type</option>
            <option value="Bank">Bank</option>
            <option value="Mobile Bank">Mobile Bank</option>
        </select>
        <div class="bank-fields mt-2" style="display:none;">
            <input type="text" name="banking_info[${index}][account_no]" placeholder="Account No" class="w-full bg-slate-800/50 border border-slate-700 text-slate-100 px-4 py-3 rounded-lg mb-2">
            <input type="text" name="banking_info[${index}][bank_name]" placeholder="Bank Name" class="w-full bg-slate-800/50 border border-slate-700 text-slate-100 px-4 py-3 rounded-lg mb-2">
            <input type="text" name="banking_info[${index}][holder_name]" placeholder="Holder Name" class="w-full bg-slate-800/50 border border-slate-700 text-slate-100 px-4 py-3 rounded-lg mb-2">
            <input type="text" name="banking_info[${index}][branch]" placeholder="Branch" class="w-full bg-slate-800/50 border border-slate-700 text-slate-100 px-4 py-3 rounded-lg">
        </div>
        <div class="mobile-bank-fields mt-2" style="display:none;">
            <input type="text" name="banking_info[${index}][account_no]" placeholder="Account No" class="w-full bg-slate-800/50 border border-slate-700 text-slate-100 px-4 py-3 rounded-lg mb-2">
            <input type="text" name="banking_info[${index}][mobile_type]" placeholder="Type (Bkash/Nagad)" class="w-full bg-slate-800/50 border border-slate-700 text-slate-100 px-4 py-3 rounded-lg mb-2">
            <input type="text" name="banking_info[${index}][holder_name]" placeholder="Holder Name" class="w-full bg-slate-800/50 border border-slate-700 text-slate-100 px-4 py-3 rounded-lg">
        </div>
    `;
    wrapper.appendChild(div);
}
</script>
@endsection
