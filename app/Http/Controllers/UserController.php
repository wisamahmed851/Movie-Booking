<?php

namespace App\Http\Controllers;

use App\Mail\SendOtpMail;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;


class UserController extends Controller
{
    //
    public function index(Request $request)
    {
        $users = User::all();
        return view('admin.user.index', compact('users'));
    }
    public function create()
    {
        return view('admin.user.create');
    }
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors(),
                'data' => null
            ]);
        }



        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return response()->json([
            'status' => 'success',
            'message' => 'User Registered in successfully!',
            'data' => null
        ]);
    }
    public function toggleStatus(Request $request, $user)
    {
        $user = User::find($user);
        $user->status = ($user->status == '1') ? '0' : '1';
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => $user->status == '1' ? "user is activated" : "user is deactivated",
            'data' => [
                'newStatus' => $user->status,
            ]
        ]);
    }
    public function togglerole(User $user)
    {
        $user->role = ($user->role == '1') ? '0' : '1';
        $user->save();

        return response()->json([
            'status' => 'success',
            'message' => $user->role == '1' ? "user is promoted to admin" : "user is demoted to user",
            'data' => [
                'newRole' => $user->role,
            ]
        ]);
    }
    public function loginform()
    {
        return view('frontend.user.userlogin');
    }
    public function login(Request $request)
    {
        // Validate incoming request
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email', // added 'exists' rule
            'password' => 'required|min:6',
        ]);
        if ($validator->fails()) {
            return response()->json([
                'status' => 'warning',
                'message' => 'Validation error.',
                'errors' => $validator->errors() // Include all validation errors
            ]); // 422 Unprocessable Entity
        }

        // Get credentials from the request
        $credentials = $request->only('email', 'password');

        // Attempt login with the given credentials
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->status === 0) {
                Auth::logout(); // Log the user out immediately
                return response()->json([
                    'status' => 'error',
                    'message' => 'Your account is inactive. Please contact support.',
                    'data' => null
                ]);
                /* return redirect(route('auth.login'))
                ->withErrors(['email' => 'Your account is inactive. Please contact support.']); */
            }

            // Redirect the user to the dashboard if they are active
            return response()->json([
                'status' => 'success',
                'message' => 'User logged in successfully!',
                'data' => null
            ]);
        }


        // If authentication fails, return to login with an error message
        return response()->json([
            'status' => 'error',
            'message' => 'Invalid credentials. Please try again.',
            'data' => null
        ]);
    }
    public function registerForm()
    {
        return view('frontend.user.userRegistration');
    }
    public function profile()
    {

        $user = Auth::user();
        return view('frontend.profile.profile', compact('user'));
    }
    public function forgotpassword()
    {
        return view('frontend.user.forgotpassword');
    }
    public function sendOTP(Request $request)
    {
        // Validate email input
        $validator = Validator::make($request->all(), [
            'email' => 'required|email|exists:users,email',
        ]);

        if ($validator->fails()) {
            return response()->json(['status' => 'error', 'message' => $validator->errors()->first()], 400);
        }

        // Generate OTP
        $otp = rand(100000, 999999);

        // Store OTP in session or database
        session([
            'otp' => $otp,
            'email' => $request->email
        ]); // Option 1: Store in session (temporary)
        Mail::to($request->email)->send(new SendOtpMail($otp));

        return response()->json(['status' => 'success', 'message' => 'OTP sent to your email']);
    }
    public function showVerifyOTPForm()
    {
        return view('frontend.user.verify-otp');
    }
    public function verifyOTP(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);

        if ($request->otp == session('otp')) {
       session()->forget('otp'); // Clear OTP after verification
        return response()->json([
        'status' => 'success',
        'message' => 'OTP verified! Set a new password.',
        'redirect' => route('user.password.reset', ['token' => Str::random(60)]) // Now it will work
       ]);
       }


        return response()->json([
            'status' => 'error',
            'message' => 'Invalid OTP!'
        ]);
    }
    public function resendOTP()
    {
        $otp = rand(100000, 999999); // Generate a random 6-digit OTP
        session(['otp' => $otp]);

        // Ensure email exists in session
        if (!session('email')) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email session expired. Please start the reset process again.'
            ]);
        }

        Mail::raw("Your new OTP for password reset is: $otp", function ($message) {
            $message->to(session('email'))->subject('New Password Reset OTP');
        });

        return response()->json([
            'status' => 'success',
            'message' => 'New OTP sent to your email!'
        ]);
    }

    public function resetpasswordForm($token)
{
    if (!session()->has('email')) {
        return redirect()->route('user.forgotpassword')->withErrors(['email' => 'Email session expired. Please request a new reset link.']);
    }
    return view('frontend.user.resetPin', compact('token'));
}
    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
            'email' => 'required|email|exists:users,email',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user) {
            return response()->json([
                'status' => 'error',
                'message' => 'User not found!'
            ]);
        }

        $user->password = Hash::make($request->password);
        $user->save();

        session()->forget(['otp', 'email']);

        return response()->json([
            'status' => 'success',
            'message' => 'Password updated successfully!',
            'redirect' => route('user.login')
        ]);
    }
    public function updateInfo(Request $request)
    {
        $user = Auth::user(); // Get the logged-in user

        $field = $request->input('infoType'); // Determine which field to update
        $allowedFields = ['phone', 'address', 'image']; // Allowed fields to update

        if (!in_array($field, $allowedFields)) {
            return response()->json(['message' => 'Invalid field type.'], 400);
        }

        // Handle file upload separately if updating the image
        if ($field === 'image' && $request->hasFile('image')) {
            $file = $request->file('image');
            $filename = time() . '_' . $file->getClientOriginalName();
            $filePath = $file->storeAs('public/user_images', $filename);
            $user->image = 'storage/user_images/' . $filename; // Save path in DB
        } else {
            $user->$field = $request->$field; // Update normal fields
        }

        $user->save();

        return response()->json(['message' => ucfirst($field) . ' updated successfully!']);
    }


}
