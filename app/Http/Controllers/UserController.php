<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

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
    public function loginform(){
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
    public function registerForm(){
        return view('frontend.user.userRegistration');
    }
    public function profile(){
        return view('frontend.profile.profile');
    }
}
