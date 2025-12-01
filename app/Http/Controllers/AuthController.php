<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AuthController extends Controller
{
    // Show the login form
    public function showLoginForm()
    {
        return view('auth.login',[
            'showHeader' => false,
            'showSidebar' => false,
        ]);
    }
    // Handle login

    public function login(Request $request)
    {
        //  Step 1: Validate input with custom messages
        $credentials = $request->validate([
            'phone_number' => 'required|string',
            'password' => 'required|string',
        ], [
            'phone_number.required' => 'The phone number field is required.',
            'password.required' => 'The password field is required.',
        ]);

        //  Step 2: Attempt login
        if (Auth::attempt([
            'phone_number' => $credentials['phone_number'],
            'password' => $credentials['password'],
        ])) {
            //  Step 3: Regenerate session
            $request->session()->regenerate();

            // Redirect all users to the same dashboard
            return redirect()->route('Dashboard');
            }

        //  Step 5: Invalid credentials
        return back()->withErrors([
            'phone_number' => 'The provided credentials do not match our records.',
        ])->onlyInput('phone_number');
    }

    // logout
    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken(); 
        return redirect()->route('loginForm');

    }


    // Show the registration form
    public function showRegisterForm()
    {
        return view('auth.register',[
            'showHeader' => false,
            'showSidebar' => false,
        ]);
    }

    // Uer registration
    public function createUserByAdmin(Request $request)
    {
        if (Auth::user()->role != 'admin') {
            abort(403, 'Unauthorized action.');
        }

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:20|unique:users,phone_number',
            'role' => 'required|string',
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.unique' => 'This email is already registered.',
            'phone_number.required' => 'The phone number field is required.',
            'phone_number.unique' => 'This phone number is already registered.',
            'role.required' => 'Please select a user role.',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'role' => $validated['role'],
            'password' => Hash::make('12345'), // default password
        ]);

        return redirect()->back()->with('success', 'User created successfully with default password (12345).');
    }

    // Profile 
    public function profile(Request $request)
    {
        return view ('auth.profile');
    }

}

