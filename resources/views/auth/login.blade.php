<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'JP-Note') }} - 登入</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900">
        <div class="mx-auto flex min-h-screen max-w-md items-center px-4">
            <div class="w-full rounded-2xl bg-white p-8 shadow-lg">
                <h1 class="mb-2 text-2xl font-semibold">會員登入</h1>
                <p class="mb-6 text-sm text-slate-500">使用 Supabase 帳號登入 JP-Note。</p>

                @if (session('status'))
                    <div class="mb-4 rounded-lg border border-emerald-200 bg-emerald-50 px-4 py-3 text-sm text-emerald-700">
                        {{ session('status') }}
                    </div>
                @endif

                <form method="POST" action="{{ route('login.store') }}" class="space-y-4">
                    @csrf
                    <div>
                        <label class="text-sm font-medium" for="email">Email</label>
                        <input
                            class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                            id="email"
                            name="email"
                            type="email"
                            value="{{ old('email') }}"
                            required
                        >
                        @error('email')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="text-sm font-medium" for="password">密碼</label>
                        <input
                            class="mt-1 w-full rounded-lg border border-slate-200 px-3 py-2 text-sm focus:border-indigo-500 focus:outline-none focus:ring-2 focus:ring-indigo-200"
                            id="password"
                            name="password"
                            type="password"
                            required
                        >
                        @error('password')
                            <p class="mt-1 text-xs text-rose-600">{{ $message }}</p>
                        @enderror
                    </div>
                    <button
                        class="w-full rounded-lg bg-indigo-600 px-4 py-2 text-sm font-semibold text-white transition hover:bg-indigo-500"
                        type="submit"
                    >
                        登入
                    </button>
                </form>

                <p class="mt-6 text-center text-sm text-slate-500">
                    還沒有帳號？
                    <a class="font-semibold text-indigo-600 hover:text-indigo-500" href="{{ route('register') }}">
                        立即註冊
                    </a>
                </p>
            </div>
        </div>
    </body>
</html>
