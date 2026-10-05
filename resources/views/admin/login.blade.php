<!doctype html>
<html lang="en">
<head>
  <meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1"><meta name="theme-color" content="#092b42">
  <title>Administrator sign in · Tazan Global</title><link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:wght@400;500;600;700&family=Manrope:wght@400;500;600;700;800&display=swap" rel="stylesheet"><link rel="stylesheet" href="{{ asset('admin.css') }}">
</head>
<body class="login-body">
  <main class="login-shell"><div class="login-image"><div class="login-mark">TG</div><span>TAZAN GLOBAL <i>·</i> NAIROBI</span><div class="login-image-copy"><p>EDITORIAL STUDIO</p><h1>Good ideas<br>move <em>markets.</em></h1><span>Stories, perspectives and a clear view of what’s ahead.</span></div><div class="login-orbit"></div></div>
  <div class="login-panel"><a class="login-home" href="{{ route('home') }}">← <span>Back to website</span></a><div class="login-form-wrap"><span class="login-kicker">ADMINISTRATOR ACCESS</span><h2>Welcome back.</h2><p>Sign in to shape the Tazan Global website.</p>
    <form method="post" action="{{ route('admin.login.store') }}" class="login-form">@csrf
      <label for="email">Email address</label><input id="email" type="email" name="email" value="{{ old('email') }}" autocomplete="username" required autofocus>@error('email')<span class="field-error">{{ $message }}</span>@enderror
      <label for="password">Password</label><input id="password" type="password" name="password" autocomplete="current-password" required>@error('password')<span class="field-error">{{ $message }}</span>@enderror
      <label class="remember-label"><input type="checkbox" name="remember" value="1"> Keep me signed in</label>
      <button class="studio-button studio-button-dark" type="submit">Enter the studio <span>↗</span></button>
    </form><div class="login-note"><span>◈</span> This is a private workspace. Access is managed by your administrator.</div></div><span class="login-foot">© {{ date('Y') }} Tazan Global Ltd.</span></div></main>
</body></html>
