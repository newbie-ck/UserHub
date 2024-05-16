<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Jobs\GenerateDummyUsers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class UserController extends Controller
{
    public function profile(User $user = null)
    {
        return view('user.detail', ['user' => $user ?: request()->user()]);
    }

    public function user_list_page()
    {
        return view('admin.user_list');
    }

    public function user_list_index()
    {
        $query = User::query();

        // Sort users based on request parameters
        if (request()->has('sort_by')) {
            $query->orderBy(request()->sort_by, request()->sort_dir ?? 'asc');
        }

        // Paginate users
        $users = $query->paginate(15);

        return response()->json($users);
    }

    public function generate_users_page() 
    {
        return view('admin.user_generate');
    }

    public function update(User $user)
    {
        $validatedData = request()->validate(
            [
                'name' => 'required|string',
                'email' => 'required|string|email|unique:users,email,' . $user->id,
                'phone_number' => 'required|string|unique:users,phone_number,' . $user->id . '|regex:/^601\d{8,9}$/'
            ],
            [
                'phone_number.regex' => 'The phone number must be in the format 601 followed by 8 or 9 digits. E.g. 60123456789'
            ]
        );

        if (!$this->valuesChanged($user, $validatedData)) {
            return response()->json(['message' => 'No changes were made.']);
        }

        $user->update(request()->only('name', 'email', 'phone_number'));

        return response()->json(['message' => 'User details updated successfully']);
    }

    public function deactivate(User $user)
    {
        if ($user->is_active) {
            $user->update(['is_active' => false]);
            
            return response()->json(['message' => 'User deactivated successfully']);
        }
            
        return response()->json(['error' => 'User account is already deactivated'], 400);
        
    }

    public function activate(User $user)
    {
        if (!$user->is_active) {
            $user->update(['is_active' => true]);
            
            return response()->json(['message' => 'User activated successfully']);
        }
            
        return response()->json(['error' => 'User account is already activated'], 400);
    }

    public function generateDummyUsers()
    {
        request()->validate([
            'number' => 'integer|required',
        ]);

        dispatch(new GenerateDummyUsers(request()->number));

        return response()->json(['message' => 'The user generation is being processed.']);
    }

    public function logout()
    {
        Auth::logout();
        Session::flush();

        return redirect('/');
    }

    private function valuesChanged(User $user, array $validatedData): bool
    {
        foreach ($validatedData as $key => $value) {
            if ($user->{$key} !== $value) {
                return true;
            }
        }
        return false;
    }
}