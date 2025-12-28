<?php

namespace App\Http\Controllers;

use App\Services\SupabaseAuthService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use RuntimeException;

class AuthController extends Controller
{
    public function showLogin(Request $request): View|RedirectResponse
    {
        if ($request->session()->has('supabase.access_token')) {
            return redirect()->route('home');
        }

        return view('auth.login');
    }

    public function showRegister(Request $request): View|RedirectResponse
    {
        if ($request->session()->has('supabase.access_token')) {
            return redirect()->route('home');
        }

        return view('auth.register');
    }

    public function login(Request $request, SupabaseAuthService $auth): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8'],
        ]);

        try {
            $payload = $auth->signIn($credentials['email'], $credentials['password']);
        } catch (RuntimeException $exception) {
            return back()
                ->withErrors(['email' => $exception->getMessage()])
                ->withInput();
        }

        $request->session()->put('supabase.user', $payload['user'] ?? []);
        $request->session()->put('supabase.access_token', $payload['access_token'] ?? null);
        $request->session()->put('supabase.refresh_token', $payload['refresh_token'] ?? null);

        return redirect()->route('home');
    }

    public function register(Request $request, SupabaseAuthService $auth): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required', 'min:8', 'confirmed'],
        ]);

        try {
            $payload = $auth->signUp($credentials['email'], $credentials['password']);
        } catch (RuntimeException $exception) {
            return back()
                ->withErrors(['email' => $exception->getMessage()])
                ->withInput();
        }

        $sessionToken = $payload['access_token'] ?? null;

        if ($sessionToken) {
            $request->session()->put('supabase.user', $payload['user'] ?? []);
            $request->session()->put('supabase.access_token', $sessionToken);
            $request->session()->put('supabase.refresh_token', $payload['refresh_token'] ?? null);

            return redirect()->route('home');
        }

        return redirect()
            ->route('login')
            ->with('status', '註冊成功，請至信箱完成驗證後登入。');
    }

    public function logout(Request $request, SupabaseAuthService $auth): RedirectResponse
    {
        $accessToken = $request->session()->get('supabase.access_token');

        if ($accessToken) {
            $auth->signOut($accessToken);
        }

        $request->session()->forget([
            'supabase.user',
            'supabase.access_token',
            'supabase.refresh_token',
        ]);

        return redirect()->route('login');
    }
}
