@extends('layouts.base')

@section('title', 'Edit Community')

@section('content')
<div class="min-h-screen bg-slate-50 py-8 px-4">
    <div class="max-w-4xl mx-auto">
        {{-- Back Button --}}
        <div class="mb-6">
            <a href="{{ route('communities', $community->id) }}"
               class="inline-flex items-center gap-2 text-slate-500 hover:text-emerald-600 transition-colors group">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="text-sm font-medium">Back to Community Details</span>
            </a>
        </div>

        {{-- Card --}}
        <div class="bg-white shadow-xl rounded-2xl p-8 border border-slate-200">
            <h2 class="text-3xl font-bold text-slate-900 mb-8">
                Edit Community
            </h2>

            {{-- Success Message --}}
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 p-4 rounded-lg mb-6 flex items-start gap-3">
                    <svg class="w-5 h-5 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                    </svg>
                    <span>{{ session('success') }}</span>
                </div>
            @endif

            {{-- Error Messages --}}
            @if($errors->any())
                <div class="bg-red-50 border border-red-200 text-red-600 p-4 rounded-lg mb-6">
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
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Community Name <span class="text-red-500">*</span>
                    </label>
                    <input type="text" 
                           name="name" 
                           value="{{ old('name', $community->name) }}" 
                           required
                           class="w-full bg-white border border-slate-300 text-slate-900 px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all placeholder-slate-400 shadow-sm">
                </div>

                {{-- Minimum Amount --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">
                        Minimum Amount <span class="text-red-500">*</span>
                    </label>
                    <input type="number" 
                           name="min_amount" 
                           value="{{ old('min_amount', $community->min_amount) }}" 
                           step="0.01"
                           required
                           class="w-full bg-white border border-slate-300 text-slate-900 px-4 py-3 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500 focus:border-transparent transition-all placeholder-slate-400 shadow-sm">
                </div>

                {{-- Banking Info --}}
                <div>
                    <label class="block text-sm font-medium text-slate-700 mb-2">Banking Info</label>
                    <div id="banking-info-wrapper" class="space-y-4">
                        @php
                            $bankingInfos = old('banking_info', $community->banking_info ?? []);
                        @endphp

                        @foreach($bankingInfos as $index => $bank)
                        <div class="flex flex-col gap-2 p-4 bg-slate-50 rounded-lg border border-slate-200">
                            <select name="banking_info[{{ $index }}][type]" class="bg-white border border-slate-300 text-slate-900 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" onchange="toggleFields(this)">
                                <option value="Bank" {{ ($bank['type'] ?? '') == 'Bank' ? 'selected' : '' }}>Bank</option>
                                <option value="Mobile Bank" {{ ($bank['type'] ?? '') == 'Mobile Bank' ? 'selected' : '' }}>Mobile Bank</option>
                            </select>

                            {{-- Bank Fields --}}
                            <div class="bank-fields" style="{{ ($bank['type'] ?? '') == 'Bank' ? 'display:block;' : 'display:none;' }}">
                                <input type="text" name="banking_info[{{ $index }}][bank_account_no]" value="{{ $bank['bank_account_no'] ?? '' }}" placeholder="Account No" class="w-full px-4 py-3 rounded-lg bg-white border border-slate-300 text-slate-900 mt-2">
                                <input type="text" name="banking_info[{{ $index }}][bank_name]" value="{{ $bank['bank_name'] ?? '' }}" placeholder="Bank Name" class="w-full px-4 py-3 rounded-lg bg-white border border-slate-300 text-slate-900 mt-2">
                                <input type="text" name="banking_info[{{ $index }}][bank_holder_name]" value="{{ $bank['bank_holder_name'] ?? '' }}" placeholder="Holder Name" class="w-full px-4 py-3 rounded-lg bg-white border border-slate-300 text-slate-900 mt-2">
                                <input type="text" name="banking_info[{{ $index }}][branch]" value="{{ $bank['branch'] ?? '' }}" placeholder="Branch" class="w-full px-4 py-3 rounded-lg bg-white border border-slate-300 text-slate-900 mt-2">
                            </div>

                            {{-- Mobile Bank Fields --}}
                            <div class="mobile-bank-fields" style="{{ ($bank['type'] ?? '') == 'Mobile Bank' ? 'display:block;' : 'display:none;' }}">
                                <input type="text" name="banking_info[{{ $index }}][mobile_account_no]" value="{{ $bank['mobile_account_no'] ?? '' }}" placeholder="Account Number" class="w-full px-4 py-3 rounded-lg bg-white border border-slate-300 text-slate-900 mt-2">
                                <input type="text" name="banking_info[{{ $index }}][mobile_type]" value="{{ $bank['mobile_type'] ?? '' }}" placeholder="Type (bKash / Nagad)" class="w-full px-4 py-3 rounded-lg bg-white border border-slate-300 text-slate-900 mt-2">
                                <input type="text" name="banking_info[{{ $index }}][mobile_holder_name]" value="{{ $bank['mobile_holder_name'] ?? '' }}" placeholder="Holder Name" class="w-full px-4 py-3 rounded-lg bg-white border border-slate-300 text-slate-900 mt-2">
                            </div>

                            <button type="button" onclick="this.parentElement.remove()" class="px-3 py-2 bg-red-50 text-red-600 border border-red-200 rounded-lg hover:bg-red-100 transition mt-2 w-full sm:w-auto">Remove</button>
                        </div>
                        @endforeach
                    </div>

                    <button type="button" onclick="addBankField()" class="mt-2 px-4 py-2 bg-emerald-600 text-white rounded-lg hover:bg-emerald-700 transition shadow-sm">Add Banking Info</button>
                </div>

                {{-- Action Buttons --}}
                <div class="flex items-center gap-4 pt-6 border-t border-slate-200">
                    <button type="submit"
                            class="flex-1 bg-emerald-600 text-white font-semibold py-3 rounded-lg hover:bg-emerald-700 transition-all duration-200 shadow hover:shadow-lg">
                        Update Community
                    </button>
                    <a href="{{ route('communities', $community->id) }}"
                       class="px-6 py-3 bg-white text-slate-700 font-medium rounded-lg hover:bg-slate-50 transition-all border border-slate-300 shadow-sm hover:shadow">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function toggleFields(select) {
    const parent = select.parentElement;
    const bankFields = parent.querySelector('.bank-fields');
    const mobileFields = parent.querySelector('.mobile-bank-fields');
    if(select.value === 'Bank') {
        bankFields.style.display = 'block';
        mobileFields.style.display = 'none';
    } else {
        bankFields.style.display = 'none';
        mobileFields.style.display = 'block';
    }
}

function addBankField() {
    const wrapper = document.getElementById('banking-info-wrapper');
    const index = wrapper.children.length;
    const div = document.createElement('div');
    div.className = 'flex flex-col gap-2 p-4 bg-slate-50 rounded-lg border border-slate-200';
    div.innerHTML = `
        <select name="banking_info[${index}][type]" class="bg-white border border-slate-300 text-slate-900 px-4 py-2 rounded-lg focus:outline-none focus:ring-2 focus:ring-emerald-500" onchange="toggleFields(this)">
            <option value="Bank">Bank</option>
            <option value="Mobile Bank">Mobile Bank</option>
        </select>
        <div class="bank-fields">
            <input type="text" name="banking_info[${index}][bank_account_no]" placeholder="Account No" class="w-full px-4 py-3 rounded-lg bg-white border border-slate-300 text-slate-900 mt-2">
            <input type="text" name="banking_info[${index}][bank_name]" placeholder="Bank Name" class="w-full px-4 py-3 rounded-lg bg-white border border-slate-300 text-slate-900 mt-2">
            <input type="text" name="banking_info[${index}][bank_holder_name]" placeholder="Holder Name" class="w-full px-4 py-3 rounded-lg bg-white border border-slate-300 text-slate-900 mt-2">
            <input type="text" name="banking_info[${index}][branch]" placeholder="Branch" class="w-full px-4 py-3 rounded-lg bg-white border border-slate-300 text-slate-900 mt-2">
        </div>
        <div class="mobile-bank-fields" style="display:none;">
            <input type="text" name="banking_info[${index}][mobile_account_no]" placeholder="Account Number" class="w-full px-4 py-3 rounded-lg bg-white border border-slate-300 text-slate-900 mt-2">
            <input type="text" name="banking_info[${index}][mobile_type]" placeholder="Type (bKash / Nagad)" class="w-full px-4 py-3 rounded-lg bg-white border border-slate-300 text-slate-900 mt-2">
            <input type="text" name="banking_info[${index}][mobile_holder_name]" placeholder="Holder Name" class="w-full px-4 py-3 rounded-lg bg-white border border-slate-300 text-slate-900 mt-2">
        </div>
        <button type="button" onclick="this.parentElement.remove()" class="px-3 py-2 bg-red-50 text-red-600 border border-red-200 rounded-lg hover:bg-red-100 transition mt-2 w-full sm:w-auto">Remove</button>
    `;
    wrapper.appendChild(div);
}
</script>
@endsection
