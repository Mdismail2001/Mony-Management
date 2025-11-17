@extends('layouts.base')

@section('content')
<div class="w-full max-w-2xl bg-white shadow-xl rounded-2xl p-8 mx-auto mt-10">
    <div class="text-center mb-6">
        <svg class="w-16 h-16 text-emerald-600 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
        </svg>
        <h1 class="text-2xl font-bold text-emerald-700">Invite Link Generated</h1>
        <p class="text-gray-600 mt-2">User not found in the system</p>
    </div>

    <div class="bg-blue-50 border border-blue-200 rounded-lg p-4 mb-6">
        <h2 class="font-semibold text-blue-900 mb-2">Invitation Details:</h2>
        <ul class="space-y-1 text-sm text-blue-800">
            <li><strong>Community:</strong> {{ $community->name }}</li>
            <li><strong>Phone Number:</strong> {{ $phoneNumber }}</li>
            <li><strong>Link Expires:</strong> 7 days from now</li>
        </ul>
    </div>

    <div class="mb-6">
        <label class="block text-sm font-medium text-gray-700 mb-2">Invite Link:</label>
        <div class="flex gap-2">
            <input type="text" id="inviteLink" value="{{ $inviteLink }}" readonly
                   class="flex-1 border border-gray-300 rounded-lg px-4 py-2 bg-gray-50 text-sm" />
            <button onclick="copyLink()"
                    class="bg-emerald-600 text-white px-6 py-2 rounded-lg hover:bg-emerald-700 transition font-medium">
                Copy
            </button>
        </div>
        <p class="text-xs text-gray-500 mt-2" id="copyStatus"></p>
    </div>

    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 mb-6">
        <h3 class="font-semibold text-yellow-900 mb-2 flex items-center">
            <svg class="w-5 h-5 mr-2" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            Instructions:
        </h3>
        <ul class="list-disc list-inside text-sm text-yellow-800 space-y-1">
            <li>Share this link with the user via SMS, WhatsApp, or Email</li>
            <li>The link is valid for 7 days</li>
            <li>User will register with the pre-filled phone number</li>
            <li>After registration, they will automatically join your community</li>
        </ul>
    </div>

    <div class="flex gap-3">
        <a href="{{ route('communities', $community->id) }}"
           class="flex-1 bg-gray-200 text-gray-700 py-2.5 rounded-lg hover:bg-gray-300 transition font-medium text-center">
            Back to Community
        </a>
        <button onclick="shareViaWhatsApp()"
                class="flex-1 bg-green-500 text-white py-2.5 rounded-lg hover:bg-green-600 transition font-medium">
            Share via WhatsApp
        </button>
    </div>
</div>

<script>
function copyLink() {
    const linkInput = document.getElementById('inviteLink');
    linkInput.select();
    linkInput.setSelectionRange(0, 99999);
    
    navigator.clipboard.writeText(linkInput.value).then(() => {
        document.getElementById('copyStatus').textContent = '✓ Link copied to clipboard!';
        document.getElementById('copyStatus').classList.add('text-green-600');
        
        setTimeout(() => {
            document.getElementById('copyStatus').textContent = '';
        }, 3000);
    });
}

function shareViaWhatsApp() {
    const link = document.getElementById('inviteLink').value;
    const message = `You have been invited to join {{ $community->name }}! Register using this link: ${link}`;
    const whatsappUrl = `https://wa.me/{{ $phoneNumber }}?text=${encodeURIComponent(message)}`;
    window.open(whatsappUrl, '_blank');
}
</script>
@endsection