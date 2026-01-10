<!DOCTYPE html>
<html lang="zh-TW">
<head>
  <meta charset="UTF-8">
  <title>JP-Note</title>
  <meta name="viewport" content="width=device-width, initial-scale=1">

  {{-- 如果你原本有引 Bootstrap / CSS，可補在這 --}}
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Noto+Serif+JP&family=Noto+Serif+TC&display=swap" rel="stylesheet">
  @vite(['resources/css/app.css', 'resources/js/app.js'])

</head>
<body>

  {{-- 上方導覽（可先留空） --}}
<nav class="navbar navbar-light bg-light mb-4">
  <div class="container d-flex justify-content-between">
    <span class="navbar-brand mb-0 h1">JP-Note</span>

    @if (session()->has('supabase_user'))
      <form method="POST" action="{{ route('logout') }}">
        @csrf
        <button type="submit" class="btn btn-outline-secondary btn-sm">
          登出
        </button>
      </form>
    @endif
  </div>
</nav>


  {{-- 主內容 --}}
  <main>
    @yield('content')
  </main>

</body>
</html>
