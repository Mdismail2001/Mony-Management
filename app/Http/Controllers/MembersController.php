<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\User;
use App\Models\Community;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class MembersController extends Controller
{
    // Show the create member form
    public function createMemberForm($id)
    {
        $community = Community::findOrFail($id);
        return view('members.createMember', [
            'showHeader' => false,
            'showSidebar' => false,
            'community' => $community,
        ]);
    }

    // Create a new member
    public function storeMember(Request $request)
    {
        $request->validate([
            'mobile' => 'required',
            'role' => 'required',
            'community_id' => 'required|exists:communities,id',
        ]);

        // Check mobile exists in users table
        $user = User::where('phone_number', $request->mobile)->first();
        $community_id = $request->input('community_id');

        if (!$user) {
            // Create encrypted invite data
            $inviteData = [
                'community_id' => $community_id,
                'phone_number' => $request->mobile,
                'role' => $request->role,
                'expires_at' => now()->addDays(7)->timestamp, // Link expires in 7 days
            ];

            // Encrypt the data
            $encryptedData = Crypt::encryptString(json_encode($inviteData));

            // Generate invite link
            $inviteLink = route('invite.show', ['token' => $encryptedData]);

            // Show the invite link page
            return view('members.inviteLink', [
                'showHeader' => false,
                'showSidebar' => false,
                'inviteLink' => $inviteLink,
                'community' => Community::find($community_id),
                'phoneNumber' => $request->mobile,
            ]);
        }

        // Check if user already exists in the same community
        $existingMember = Member::where('community_id', $community_id)
                                ->where('user_id', $user->id)
                                ->first();

        if ($existingMember) {
            return back()->withErrors(['mobile' => 'This user is already a member of this community.']);
        }

        // Save member
        Member::create([
            'community_id' => $community_id,
            'user_id'      => $user->id,
            'phone_number' => $request->mobile,
            'role'         => $request->role ?? 'member',
        ]);

        return redirect()->route('communities', $community_id)
                        ->with('success', 'Member added successfully!');
    }

    // Show invite registration form
    public function showInviteForm($token)
    {
        try {
            // Decrypt the token
            $decryptedData = json_decode(Crypt::decryptString($token), true);

            // Check if link has expired
            if (now()->timestamp > $decryptedData['expires_at']) {
                return redirect()->route('loginForm')
                    ->withErrors(['error' => 'This invite link has expired.']);
            }

            // Check if user already exists
            $existingUser = User::where('phone_number', $decryptedData['phone_number'])->first();
            
            if ($existingUser) {
                return redirect()->route('loginForm')
                    ->withErrors(['error' => 'An account with this phone number already exists. Please login.']);
            }

            $community = Community::find($decryptedData['community_id']);

            return view('auth.inviteRegister', [
                'showHeader' => false,
                'showSidebar' => false,
                'phoneNumber' => $decryptedData['phone_number'],
                'communityId' => $decryptedData['community_id'],
                'role' => $decryptedData['role'],
                'community' => $community,
                'token' => $token,
            ]);
        } catch (\Exception $e) {
            return redirect()->route('loginForm')
                ->withErrors(['error' => 'Invalid or corrupted invite link.']);
        }
    }

    // Process invite registration
    public function processInviteRegistration(Request $request)
    {
        try {
            // Decrypt and validate token again
            $decryptedData = json_decode(Crypt::decryptString($request->token), true);

            // Check if link has expired
            if (now()->timestamp > $decryptedData['expires_at']) {
                return back()->withErrors(['error' => 'This invite link has expired.']);
            }

            // Validate the form
            $validated = $request->validate([
                'name' => 'required|string|max:255',
                'email' => 'required|email|unique:users,email',
                'password' => 'required|string|min:6|confirmed',
                'token' => 'required',
            ], [
                'name.required' => 'The name field is required.',
                'email.required' => 'The email field is required.',
                'email.unique' => 'This email is already registered.',
                'password.required' => 'The password field is required.',
                'password.min' => 'Password must be at least 6 characters.',
                'password.confirmed' => 'Password confirmation does not match.',
            ]);

            // Create the user
            $user = User::create([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'phone_number' => $decryptedData['phone_number'],
                'role' => 'user', // Always user role for invited members
                'password' => Hash::make($validated['password']),
            ]);

            // Check if user already exists in the community
            $existingMember = Member::where('community_id', $decryptedData['community_id'])
                                    ->where('user_id', $user->id)
                                    ->first();

            if (!$existingMember) {
                // Add user to the community
                Member::create([
                    'community_id' => $decryptedData['community_id'],
                    'user_id' => $user->id,
                    'phone_number' => $decryptedData['phone_number'],
                    'role' => $decryptedData['role'],
                ]);
            }

            // Auto-login the user
            Auth::login($user);

            return redirect()->route('userDashboard')
                ->with('success', 'Account created successfully! You have been added to the community.');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'An error occurred. Please try again.']);
        }
    }


    // Show user details in a community
        public function userDetails($id)
        {
            $member = Member::with(['user', 'community'])->findOrFail($id);
            // dd($member);
            return view('members.userDetails', [
                // 'showHeader' => true,
                // 'showSidebar' => true,
                'member' => $member,
            ]);
        }
}