<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name', 'JP-Note') }}</title>
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="min-h-screen bg-slate-50 text-slate-900">
        <div class="mx-auto max-w-5xl px-6 py-10">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-semibold">歡迎回來</h1>
                    <p class="mt-1 text-sm text-slate-500">
                        你已登入 JP-Note，所有功能將在此提供。
                    </p>
                </div>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="rounded-lg border border-slate-200 px-4 py-2 text-sm font-semibold text-slate-600 hover:border-slate-300">
                        登出
                    </button>
                </form>
            </div>

            <div class="mt-8 rounded-2xl bg-white p-6 shadow">
                <h2 class="text-lg font-semibold">帳號資訊</h2>
                <dl class="mt-4 space-y-2 text-sm text-slate-600">
                    <div class="flex flex-wrap items-center gap-2">
                        <dt class="font-medium text-slate-900">Email</dt>
                        <dd>{{ data_get(session('supabase.user'), 'email', '尚未載入') }}</dd>
                    </div>
                    <div class="flex flex-wrap items-center gap-2">
                        <dt class="font-medium text-slate-900">User ID</dt>
                        <dd>{{ data_get(session('supabase.user'), 'id', '尚未載入') }}</dd>
                    </div>
                </dl>
            </div>
        </div>
    </body>
</html>
