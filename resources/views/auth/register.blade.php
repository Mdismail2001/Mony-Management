@extends('layouts.base')

@section('content')
<div class="w-full max-w-md bg-white shadow-xl rounded-2xl p-8 mx-auto mt-10">
    <h1 class="text-2xl font-bold text-emerald-700 text-center mb-6">Create User (Admin)</h1>

    @if (session('success'))
        <div class="bg-green-100 text-green-700 p-2 mb-4 rounded">
            {{ session('success') }}
        </div>
    @endif

    @if ($errors->any())
        <div class="bg-red-100 text-red-700 p-2 mb-4 rounded">
            <ul class="list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('create-user') }}" method="POST" class="space-y-5">
        @csrf

        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-emerald-500" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Email</label>
            <input type="email" name="email" value="{{ old('email') }}" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-emerald-500" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Phone Number</label>
            <input type="text" name="phone_number" value="{{ old('phone_number') }}" required
                   class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-emerald-500" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-600 mb-1">Role</label>
            <select name="role" required class="w-full border border-gray-300 rounded-lg px-4 py-2 focus:ring-emerald-500">
                <option value="">Select Role</option>
                <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Admin</option>
                <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>User</option>
            </select>
        </div>

        <div class="text-gray-500 text-sm">
            Default password will be <strong>12345</strong>. User can change after first login.
        </div>

        <button type="submit"
                class="w-full bg-emerald-600 text-white py-2.5 rounded-lg hover:bg-emerald-700 transition font-medium">
            Create User
        </button>
    </form>
</div>
@endsection
