@extends('layouts.base')

@section('title', 'Edit Community')

@section('content')
{{-- Main Background Container --}}
<div class="relative min-h-screen w-full flex items-center justify-center bg-gray-900 overflow-hidden py-12 px-4">
    
    {{-- Background Image Overlay (Consistent with system theme) --}}
    <div class="absolute inset-0 z-0">
        <img src="https://static.vecteezy.com/system/resources/thumbnails/014/403/884/small/us-dollar-bills-and-candlestick-chart-showing-changes-in-price-of-money-photo.jpg" 
             class="w-full h-full object-cover opacity-20" 
             alt="Background">
        <div class="absolute inset-0 bg-gradient-to-t from-emerald-900/60 to-gray-900/40"></div>
    </div>

    {{-- Form Wrapper --}}
    <div class="relative z-10 w-full max-w-3xl">
        
        {{-- Back Button --}}
        <div class="mb-4">
            <a href="{{ route('communities', $community->id) }}"
               class="inline-flex items-center gap-2 text-emerald-300 hover:text-white transition-colors group">
                <svg class="w-5 h-5 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/>
                </svg>
                <span class="text-sm font-medium">Back to Details</span>
            </a>
        </div>

        {{-- Solid White Card --}}
        <div class="bg-white shadow-2xl rounded-3xl p-6 md:p-10 border border-white/20">
            <div class="text-center mb-10">
                <div class="w-16 h-16 bg-emerald-100 rounded-2xl flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                    </svg>
                </div>
                <h2 class="text-3xl font-bold bg-gradient-to-r from-emerald-600 to-teal-600 bg-clip-text text-transparent">
                    Edit Community
                </h2>
                <p class="text-slate-500 mt-2">Update configuration for {{ $community->name }}</p>
            </div>

            {{-- Alerts --}}
            @if(session('success'))
                <div class="bg-emerald-50 border border-emerald-100 text-emerald-700 p-4 rounded-xl mb-6 flex items-center gap-3">
                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"/></svg>
                    <span class="font-medium">{{ session('success') }}</span>
                </div>
            @endif

            <form action="{{ route('edit', $community->id) }}" method="POST" class="space-y-6">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    {{-- Community Name --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2 px-1">Community Name *</label>
                        <input type="text" name="name" value="{{ old('name', $community->name) }}" required
                               class="w-full bg-slate-50 border border-slate-200 text-slate-900 px-4 py-3 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white transition-all outline-none shadow-sm">
                    </div>

                    {{-- Minimum Amount --}}
                    <div>
                        <label class="block text-sm font-semibold text-slate-700 mb-2 px-1">Min. Deposit Amount *</label>
                        <input type="number" name="min_amount" value="{{ old('min_amount', $community->min_amount) }}" step="0.01" required
                               class="w-full bg-slate-50 border border-slate-200 text-slate-900 px-4 py-3 rounded-xl focus:ring-2 focus:ring-emerald-500/20 focus:border-emerald-500 focus:bg-white transition-all outline-none shadow-sm">
                    </div>
                </div>

                <hr class="border-slate-100">

                {{-- Banking Info --}}
                <div>
                    <label class="block text-sm font-bold text-slate-800 mb-4 px-1 flex items-center gap-2">
                        <svg class="w-4 h-4 text-emerald-600" fill="currentColor" viewBox="0 0 20 20"><path d="M4 4a2 2 0 00-2 2v1h16V6a2 2 0 00-2-2H4zM18 9H2v5a2 2 0 002 2h12a2 2 0 002-2V9zM4 13a1 1 0 011-1h1a1 1 0 110 2H5a1 1 0 01-1-1zm5-1a1 1 0 100 2h1a1 1 0 100-2H9z"/></svg>
                        Update Payment Methods
                    </label>
                    
                    <div id="banking-info-wrapper" class="space-y-4">
                        @php $bankingInfos = old('banking_info', $community->banking_info ?? []); @endphp
                        @foreach($bankingInfos as $index => $bank)
                        <div class="bank-item p-5 bg-slate-50 rounded-2xl border border-slate-100 relative group">
                            <div class="flex flex-col md:flex-row gap-4">
                                <div class="w-full md:w-1/3">
                                    <select name="banking_info[{{ $index }}][type]" class="w-full bg-white border border-slate-200 px-4 py-2.5 rounded-xl focus:ring-2 focus:ring-emerald-500/20 outline-none" onchange="toggleFields(this)">
                                        <option value="Bank" {{ ($bank['type'] ?? '') == 'Bank' ? 'selected' : '' }}>General Bank</option>
                                        <option value="Mobile Bank" {{ ($bank['type'] ?? '') == 'Mobile Bank' ? 'selected' : '' }}>Mobile Banking</option>
                                    </select>
                                </div>
                                <div class="flex-1">
                                    {{-- Bank Fields --}}
                                    <div class="bank-fields grid grid-cols-1 sm:grid-cols-2 gap-3 {{ ($bank['type'] ?? '') == 'Mobile Bank' ? 'hidden' : '' }}">
                                        <input type="text" name="banking_info[{{ $index }}][bank_name]" value="{{ $bank['bank_name'] ?? '' }}" placeholder="Bank Name" class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 w-full outline-none">
                                        <input type="text" name="banking_info[{{ $index }}][bank_account_no]" value="{{ $bank['bank_account_no'] ?? '' }}" placeholder="Account No" class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 w-full outline-none">
                                        <input type="text" name="banking_info[{{ $index }}][bank_holder_name]" value="{{ $bank['bank_holder_name'] ?? '' }}" placeholder="Holder Name" class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 w-full outline-none">
                                        <input type="text" name="banking_info[{{ $index }}][branch]" value="{{ $bank['branch'] ?? '' }}" placeholder="Branch" class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 w-full outline-none">
                                    </div>
                                    {{-- Mobile Fields --}}
                                    <div class="mobile-bank-fields grid grid-cols-1 sm:grid-cols-2 gap-3 {{ ($bank['type'] ?? '') != 'Mobile Bank' ? 'hidden' : '' }}">
                                        <input type="text" name="banking_info[{{ $index }}][mobile_type]" value="{{ $bank['mobile_type'] ?? '' }}" placeholder="e.g. bKash / Nagad" class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 w-full outline-none">
                                        <input type="text" name="banking_info[{{ $index }}][mobile_account_no]" value="{{ $bank['mobile_account_no'] ?? '' }}" placeholder="Mobile Number" class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 w-full outline-none">
                                        <input type="text" name="banking_info[{{ $index }}][mobile_holder_name]" value="{{ $bank['mobile_holder_name'] ?? '' }}" placeholder="Holder Name" class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 w-full outline-none">
                                    </div>
                                </div>
                            </div>
                            <button type="button" onclick="this.parentElement.remove()" class="absolute -top-2 -right-2 bg-white text-red-500 p-1.5 rounded-full border border-slate-100 shadow-sm hover:bg-red-50 transition-colors">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
                            </button>
                        </div>
                        @endforeach
                    </div>

                    <button type="button" onclick="addBankField()" 
                            class="mt-4 w-full md:w-auto px-6 py-2 border-2 border-dashed border-emerald-200 text-emerald-600 rounded-xl hover:bg-emerald-50 hover:border-emerald-300 transition-all font-medium flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
                        Add Banking Info
                    </button>
                </div>

                <div class="flex items-center gap-4 pt-4">
                    <button type="submit"
                            class="flex-1 bg-gradient-to-r from-emerald-600 to-teal-600 text-white font-bold py-4 rounded-xl hover:shadow-lg hover:shadow-emerald-200 transition-all transform active:scale-[0.98]">
                        Update Community
                    </button>
                    <a href="{{ route('communities', $community->id) }}"
                       class="px-8 py-4 bg-slate-100 text-slate-600 font-bold rounded-xl hover:bg-slate-200 transition-all">
                        Cancel
                    </a>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    function toggleFields(select) {
        const parent = select.closest('.bank-item');
        const bankFields = parent.querySelector('.bank-fields');
        const mobileFields = parent.querySelector('.mobile-bank-fields');
        if(select.value === 'Bank') {
            bankFields.classList.remove('hidden');
            mobileFields.classList.add('hidden');
        } else {
            bankFields.classList.add('hidden');
            mobileFields.classList.remove('hidden');
        }
    }

    function addBankField() {
        const wrapper = document.getElementById('banking-info-wrapper');
        const index = wrapper.children.length;
        const div = document.createElement('div');
        div.className = 'bank-item p-5 bg-slate-50 rounded-2xl border border-slate-100 relative group mt-4';
        div.innerHTML = `
            <div class="flex flex-col md:flex-row gap-4">
                <div class="w-full md:w-1/3">
                    <select name="banking_info[${index}][type]" class="w-full bg-white border border-slate-200 px-4 py-2.5 rounded-xl focus:ring-2 focus:ring-emerald-500/20 outline-none" onchange="toggleFields(this)">
                        <option value="Bank">General Bank</option>
                        <option value="Mobile Bank">Mobile Banking</option>
                    </select>
                </div>
                <div class="flex-1">
                    <div class="bank-fields grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <input type="text" name="banking_info[${index}][bank_name]" placeholder="Bank Name" class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 w-full outline-none">
                        <input type="text" name="banking_info[${index}][bank_account_no]" placeholder="Account No" class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 w-full outline-none">
                        <input type="text" name="banking_info[${index}][bank_holder_name]" placeholder="Holder Name" class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 w-full outline-none">
                        <input type="text" name="banking_info[${index}][branch]" placeholder="Branch" class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 w-full outline-none">
                    </div>
                    <div class="mobile-bank-fields hidden grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <input type="text" name="banking_info[${index}][mobile_type]" placeholder="e.g. bKash / Nagad" class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 w-full outline-none">
                        <input type="text" name="banking_info[${index}][mobile_account_no]" placeholder="Mobile Number" class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 w-full outline-none">
                        <input type="text" name="banking_info[${index}][mobile_holder_name]" placeholder="Holder Name" class="px-4 py-2.5 rounded-xl bg-white border border-slate-200 w-full outline-none">
                    </div>
                </div>
            </div>
            <button type="button" onclick="this.parentElement.remove()" class="absolute -top-2 -right-2 bg-white text-red-500 p-1.5 rounded-full border border-slate-100 shadow-sm hover:bg-red-50 transition-colors">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        `;
        wrapper.appendChild(div);
    }
</script>
@endsection