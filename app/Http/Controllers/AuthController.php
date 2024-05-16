<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function register()
    {
        request()->validate(
            [
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users,email',
                'username' => 'required|string|unique:users,username|min:8|max:15',
                'password' => [
                    'required',
                    'string',
                    'regex:/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*#?&])[A-Za-z\d@$!%*#?&]{8,15}$/',
                ],
                'phone_number' => 'required|string|unique:users,phone_number|regex:/^601\d{8,9}$/'
            ], 
            [
                'password.regex' => 'The password must be between 8 and 15 characters in length and contain at least one uppercase letter, one lowercase letter, one digit, and one special character.',
                'phone_number.regex' => 'The phone number must be in the format 601 followed by 8 or 9 digits. E.g. 60123456789'
            ]
        );

        $user = User::create([
            'name' => request()->name,
            'email' => request()->email,
            'username' => request()->username,
            'password' => bcrypt(request()->password),
            'phone_number' => request()->phone_number,
        ]);

        $token = $user->createToken('AuthToken')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

    public function login()
    {
        $credentials = request()->only('username', 'password');
        $remember = request()->has('remember');

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::user();

            // Check if the user's account is active
            if (!$user->is_active) {
                Auth::logout(); // Log out the user
                return response()->json(['error' => 'Your account is not active. Please contact the administrator to activate your account.'], 401);
            }

            $token = $user->createToken('AuthToken')->plainTextToken;
            return response()->json(['token' => $token], 200);
        }

        return response()->json(['error' => 'Incorrect username or password.'], 401);
    }

    public function not_admin_page()
    {
        return view('not_admin');
    }
}
