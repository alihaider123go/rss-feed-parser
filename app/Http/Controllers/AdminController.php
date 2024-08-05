<?php

namespace App\Http\Controllers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AdminController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function allUsers(): View
    {
        return view('admin.users.index', [
            'users' => User::all(),
        ]);
    }

        public function create(): View
    {
        return view('admin.users.create');
    }

    public function edit($id): View
    {
        return view('admin.users.edit',['user'=>User::find($id)]);
    }



    public function showPasswordForm($id): View
    {
        return view('admin.users.update_password',['user'=>User::find($id)]);
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'max:255', 'unique:'.User::class],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        event(new Registered($user));

        return redirect()->route('users')->with('success', 'User created successfully!');
    }


    public function updatePassword(Request $request, $id)
    {
        $validatedData = $request->validate([
            'password' => 'required',
        ]);

        $user = User::find($id);
        if(isset($user)){
            $user->update([
                'password' => Hash::make($request->password),
            ]);
        }

        return redirect()->route('users')->with('success', 'Password updated successfully!');
    }


    public function destroy($id)
    {
        $user = User::find($id);
        if(isset($user)){
            $user->delete();
        }
        return redirect()->route('users')->with('success', 'User deleted successfully!');
    }



}
