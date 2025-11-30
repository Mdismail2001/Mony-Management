@extends('layouts.base')

@section('content')
<div class="min-h-screen flex justify-center items-center bg-slate-100 p-6">

    <div class="bg-white rounded-2xl shadow-xl p-8 w-full max-w-lg relative">
        <!-- Back / Close button inside form -->
        <a href="{{ url()->previous() }}"
            class="absolute top-4 right-4 text-slate-600 hover:text-red-500 text-2xl font-bold transition">
            ✕
        </a>

        <h2 class="text-xl font-semibold text-slate-800 mb-6 text-center">Update Profile</h2>

        <form action="#" method="POST" enctype="multipart/form-data">
            @csrf

            <!-- Circle Photo Upload -->
            <div class="flex flex-col items-center mb-6">
                <label for="photoUpload" class="cursor-pointer">
                    <div id="imagePreview"
                        class="w-36 h-36 rounded-full bg-gray-200 border-4 border-emerald-500 flex items-center justify-center overflow-hidden relative shadow-md">

                        <!-- Default image or uploaded photo -->
                        <img id="previewImg"
                             src="{{ auth()->user()->image ? asset('storage/' . auth()->user()->image) : '' }}"
                             class="w-full h-full object-cover {{ auth()->user()->image ? '' : 'hidden' }}">

                        <!-- Show "Upload" text if no photo -->
                        @if(!auth()->user()->image)
                        <span id="uploadText" class="text-gray-600 text-sm absolute">Upload</span>
                        @endif
                    </div>
                </label>

                <!-- Hidden input -->
                <input type="file" id="photoUpload" name="profile_photo" class="hidden"
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

<!-- JS for Preview -->
<script>
    const fileInput = document.getElementById('photoUpload');
    const previewImg = document.getElementById('previewImg');
    const uploadText = document.getElementById('uploadText');

    fileInput.addEventListener('change', function () {
        const file = this.files[0];
        if (!file) return;

        const reader = new FileReader();
        reader.onload = function () {
            previewImg.src = reader.result;
            previewImg.classList.remove('hidden');
            if (uploadText) uploadText.classList.add('hidden');
        };
        reader.readAsDataURL(file);
    });
</script>
@endsection
