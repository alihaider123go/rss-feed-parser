<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Facades\Services\UserService;
use App\Models\User;

class AdminController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function allUsers(): View
    {
        return view('admin.users.index', [
            'users' => UserService::getAllUsers(),
        ]);
    }
}
