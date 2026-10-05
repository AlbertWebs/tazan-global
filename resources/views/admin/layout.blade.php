<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
  <meta name="theme-color" content="#092b42"><title>@yield('title', 'Studio') · Tazan Global</title>
  <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="{{ asset('admin.css') }}">
  @stack('head')
</head>
<body class="studio-body">
  <aside class="studio-sidebar">
    <a class="studio-brand" href="{{ route('admin.dashboard') }}"><span class="studio-monogram">TG</span><span>TAZAN GLOBAL<small>EDITORIAL STUDIO</small></span></a>
    <span class="studio-nav-label">WORKSPACE</span>
    <nav class="studio-nav" aria-label="Studio navigation">
      <a class="{{ request()->routeIs('admin.dashboard', 'admin.insights.*') ? 'active' : '' }}" href="{{ route('admin.dashboard') }}"><span>◫</span> Insights <i>{{ \App\Models\Insight::query()->count() }}</i></a>
      <a class="{{ request()->routeIs('admin.content.*') ? 'active' : '' }}" href="{{ route('admin.content.edit') }}"><span>✳</span> Website copy</a>
    </nav>
    <div class="studio-sidebar-foot"><a href="{{ route('home') }}" target="_blank" rel="noopener">View live website <span>↗</span></a><div class="studio-user"><span class="studio-avatar">{{ strtoupper(substr(auth()->user()->name, 0, 1)) }}</span><span>{{ auth()->user()->name }}<small>Administrator</small></span><form method="post" action="{{ route('admin.logout') }}">@csrf<button type="submit" aria-label="Sign out">↗</button></form></div></div>
  </aside>
  <main class="studio-main">
    <header class="studio-topbar"><a class="studio-mobile-brand" href="{{ route('admin.dashboard') }}">TG <span>Studio</span></a><span>TAZAN GLOBAL <i>/</i> @yield('crumb', 'OVERVIEW')</span><a href="{{ route('home') }}" target="_blank" rel="noopener">Open website ↗</a></header>
    <div class="studio-content">
      @if (session('status'))<div class="studio-flash">{{ session('status') }}<span>✓</span></div>@endif
      @if ($errors->any())<div class="studio-errors">Please review the highlighted fields and try again.</div>@endif
      @yield('content')
    </div>
  </main>
  @stack('scripts')
</body>
</html>
