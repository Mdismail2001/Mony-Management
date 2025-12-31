<?php


namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendOtpMail; 


class ForgotPasswordController extends Controller
{
    
    //Show forget password form
    
    public function forgetPasswordForm()
    {
        return view('auth.forgotPassword', [
            'showHeader'  => false,
            'showSidebar'=> false,
        ]);
    }

    // Send OTP
    public function sendOtp(Request $request)
    {
        $request->validate([
            'type' => 'required|in:email,phone_number',
            'email' => 'nullable|required_if:type,email|email',
            'phone_number' => 'nullable|required_if:type,phone_number|string|max:20',
        ]);

        if ($request->type === 'email') {
            $user = User::where('email', $request->email)->first();
        } else {
            $user = User::where('phone_number', $request->phone_number)->first();
        }

        if (!$user) {
           return back()->withErrors([
                'message' => 'No account found with provided details'
            ]);
        }

        // Generate OTP
        $otp = rand(100000, 999999);

        DB::table('password_otps')->updateOrInsert(
            [$request->type => $request->{$request->type}],
            [
                'user_id' => $user->id,
                'otp' => Hash::make($otp),
                'expires_at' => Carbon::now()->addMinutes(5),
                'created_at' => now(),
                'updated_at' => now(),
            ]
        );
        // EMAIL OTP
        if ($request->type === 'email') {
            Mail::to($user->email)->send(new SendOtpMail($otp,$user->name));
        }

        // SMS OTP (future integration)
        // sendSms($user->mobile, $otp);

        session([
            'otp_type' => $request->type,
            'otp_value' => $request->{$request->type},
            'otp_user_id' => $user->id,  // store user ID
        ]);

        return redirect()->route('otp-verify-from')
            ->with('message', 'OTP sent successfully');
    }

    // OTP Submit Page
    public function verifyForm()
    {
        return view('auth.otpVerifyForm');
    }

    // Verify OTP
    public function verifyOtp(Request $request)
    {
        $request->validate(['otp' => 'required|digits:6']);

        $userId = session('otp_user_id');
        $otpType = session('otp_type');
        $otpValue = session('otp_value');

        $record = DB::table('password_otps')
            ->where(session('otp_type'), session('otp_value'))
            ->first();

        if (
            !$record ||
            !Hash::check($request->otp, $record->otp) ||
            Carbon::now()->gt($record->expires_at)
        ) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP']);
        }

        session(['otp_verified' => true]);

        return redirect()->route('password.reset.form');
    }

    // Reset Password Page
    public function resetPasswordForm()
    {
        abort_if(!session('otp_verified'), 403);
        return view('auth.resetPasswordForm');
    }

    // Reset Password
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed'
        ]);

        // Ensure OTP was verified
        if (!session('otp_verified')) {
            return redirect()->route('password-request')
                ->withErrors(['message' => 'OTP verification required']);
        }

        $userId = session('otp_user_id');

        if (!$userId) {
            return redirect()->route('password-request')
                ->withErrors(['message' => 'Session expired, please try again']);
        }

        $user = User::find($userId);

        if (!$user) {
            return redirect()->route('password-request')
                ->withErrors(['message' => 'User not found']);
        }

        // Update password safely
        $user->password = Hash::make($request->password);
        $user->save();

        // Clean OTP data
        DB::table('password_otps')->where('user_id', $userId)->delete();

        session()->forget([
            'otp_user_id',
            'otp_verified',
            'otp_type',
            'otp_value'
        ]);

        return redirect()->route('login')
            ->with('message', 'Password reset successfully');
    }

}
