<!doctype html>
<html lang="ar" dir="rtl">
<head>
<title>تسجيل الدخول — Cartiify</title>
@include('partials.head')
</head>
<body class="auth">
<header class="auth-top"><a href="{{ route('landing') }}" class="logo"><span class="logo-mark">C</span> Cartiify</a><span>ليس لديك حساب؟ <a class="lnk" href="{{ route('signup') }}">ابدأ مجاناً</a></span></header>
<main class="wiz narrow">
  <h1>أهلاً بعودتك 👋</h1><p class="sub">سجّل الدخول للوصول إلى لوحة التحكم.</p>
  <form class="form" id="f-login" novalidate>
    <label>البريد الإلكتروني<input class="input" type="email" name="email" required></label>
    <label>كلمة المرور<input class="input" type="password" name="password" required></label>
    <p class="err" id="e-login" hidden></p>
    <button class="btn btn-primary block">دخول</button>
  </form>
</main>
<script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
