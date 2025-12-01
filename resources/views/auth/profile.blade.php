@extends('layouts.base')

@section('content')
<div class="min-h-screen flex justify-center items-center bg-slate-100 p-6">

    <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-lg relative">
        <!-- Back / Close button -->
        <a href="{{ route('Dashboard') }}"
            class="absolute top-4 right-4 text-slate-600 hover:text-red-500 text-2xl font-bold transition">
            ✕
        </a>

        <h2 class="text-xl font-semibold text-slate-800 mb-6 text-center">Update Profile</h2>

        <form action="{{ route('profileUpdate') }}" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Circle Photo Upload -->
            <div class="flex flex-col items-center mb-6">
                <label for="photoUpload" class="cursor-pointer">
                    <div id="imagePreview"
                        class="w-36 h-36 rounded-full bg-gray-200 border-4 border-emerald-500 flex flex-col items-center justify-center overflow-hidden relative shadow-md">

                        <!-- Always include the image -->
                        <img id="previewImg"
                             src="{{ auth()->user()->photo ? asset('storage/' . auth()->user()->photo) : '' }}"
                             class="w-full h-full object-cover {{ auth()->user()->photo ? '' : 'hidden' }}">

                        <!-- Show placeholder + text if no photo -->
                        @if(!auth()->user()->photo)
                            <svg xmlns="http://www.w3.org/2000/svg" 
                                 class="w-12 h-12 text-gray-400 mb-1" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                            <span id="uploadText" class="text-gray-900 text-sm font-semibold absolute bottom-2 left-1/2 transform -translate-x-1/2">
                                Upload
                            </span>
                        @endif

                    </div>
                </label>

                <!-- Hidden input -->
                <input type="file" id="photoUpload" name="photo" class="hidden"
                       accept="image/png,image/jpg,image/jpeg">
            </div>

            <!-- Name -->
            <div class="mb-4">
                <label class="text-sm font-medium text-slate-700">Name</label>
                <input type="text" name="name" value="{{ auth()->user()->name }}"
                       class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500">
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label class="text-sm font-medium text-slate-700">Email</label>
                <input type="email" name="email" value="{{ auth()->user()->email }}"
                       class="mt-1 w-full border rounded-lg px-3 py-2 focus:ring-2 focus:ring-emerald-500">
            </div>

            <!-- Submit -->
            <button type="submit"
                    class="w-full mt-2 bg-gradient-to-r from-emerald-500 to-teal-600 text-white font-semibold py-2 rounded-lg shadow hover:opacity-90 transition">
                Save Changes
            </button>
        </form>
    </div>
</div>

<!-- JS for live preview -->
<script>
    const fileInput = document.getElementById('photoUpload');
    const previewImg = document.getElementById('previewImg');
    const uploadText = document.getElementById('uploadText');

    fileInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function () {
            // Show selected image
            previewImg.src = reader.result;
            previewImg.classList.remove('hidden');

            // Hide placeholder SVG and upload text
            if (uploadText) uploadText.classList.add('hidden');
            const svgIcon = previewImg.previousElementSibling;
            if (svgIcon && svgIcon.tagName === 'svg') svgIcon.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    });
</script>
@endsection
