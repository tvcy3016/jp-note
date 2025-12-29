<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    public function showLogin()
    {
        if (session()->has('supabase_user')) {
            return redirect()->route('notes.index');
        }

        return view('auth.login');
    }

    public function login(Request $request)
    {
        // 👉 目前先不接 Supabase，先用「假 user」
        $user = [
            'id' => 'local-dev-user',
            'email' => $request->input('email'),
        ];

        session(['supabase_user' => $user]);

        return redirect()->route('notes.index');
    }

    public function logout()
    {
        Session::forget('supabase_user');

        return redirect()->route('login');
    }
}
