<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\PasswordOtp;
use App\Models\Member;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;

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

    // Email  form
    public function emailVerifyForm()
    {
        return view('auth.emailVerifyForm',[
            'showHeader' => false,
            'showSidebar' => false,
        ]);
    
    }

    // Otp submit function
    public function sendOtpForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
        ]);

        $email = $request->email;
        // 1️⃣ Check if email already exists
        $userExists = User::where('email', $email)->exists();

        if ($userExists) {
            return redirect()->route('login')
                ->with('error', 'This email is already registered. Please login.');
        }

        // 2️⃣ Generate 6 digit OTP
        $otp = rand(100000, 999999);

        // 3️⃣ Delete old OTPs for this email (important)
        PasswordOtp::where('email', $email)->delete();

        // 4️⃣ Save OTP
        PasswordOtp::create([
            'email' => $email,
            'otp' => $otp,
            'expires_at' => Carbon::now()->addMinutes(10),
        ]);

        // 5️⃣ Send OTP Email
        Mail::raw("Your verification OTP is: $otp", function ($message) use ($email) {
            $message->to($email)
                    ->subject('Email Verification OTP');
        });

        // 6️⃣ Show OTP form
        return view('auth.otpForm', [
            'email' => $email,
            'showHeader' => false,
            'showSidebar' => false,
        ]);
    }    

    // otp verify function
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'otp'   => 'required|digits:6',
        ]);

        $email = $request->email;

        $otpRecord = PasswordOtp::where('email', $email)
            ->where('otp', $request->otp)
            ->where('expires_at', '>', now())
            ->first();

        if (!$otpRecord) {
            return back()->with('error', 'Invalid or expired OTP.');
        }

        $otpRecord->delete();

        return view('auth.register', [
            'email' => $email,
            'showHeader' => false,
            'showSidebar' => false,
        ]);
    }

    // Uer registration
    public function createUser(Request $request)
    {
        // ✅ Validate input
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone_number' => 'required|string|max:20|unique:users,phone_number',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'name.required' => 'The name field is required.',
            'email.required' => 'The email field is required.',
            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email is already registered.',
            'phone_number.required' => 'The phone number field is required.',
            'phone_number.unique' => 'This phone number is already registered.',
            'password.required' => 'The password field is required.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        // ✅ Create user
        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone_number' => $validated['phone_number'],
            'password' => Hash::make($validated['password']),
        ]);

        // ✅ Redirect with success
        return redirect()
            ->route('login')
            ->with('success', 'Account created successfully. You can now log in.');
    }

    // Profile 
    public function profile(Request $request)
    {
        return view ('auth.profile');
    }

    // profile update
    public function profileUpdate(Request $request)
    {
        // dd($request ->all);
        $user = Auth::user(); // get currently logged-in user

        // Validate input
        $request->validate([
            'name'  => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048', // optional
        ]);

        // Update name and email
        $user->name = $request->name;
        $user->email = $request->email;

        // If a new profile photo is uploaded
        if ($request->hasFile('photo')) {
            // Delete old photo if exists
            if ($user->profile_photo_path) {
                Storage::delete('public/' . $user->profile_photo_path);
            }

            // Store new photo
            $path = $request->file('photo')->store('profile-photos', 'public');
            $user->photo = $path;
        }

        $user->save();

        return redirect()->route('Dashboard')->with('success', 'Profile updated successfully!');
    }

}

