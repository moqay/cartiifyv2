<!doctype html>
<html lang="ar" dir="rtl">
<head>
<title>تسجيل الدخول — Cartiify</title>
@include('partials.head')
<link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body class="auth">
<div class="auth-wrap">
<aside class="auth-side"><a href="{{ route('landing') }}" class="logo"><span class="logo-mark">C</span> Cartiify</a>
  <div><h2>متجرك الإلكتروني جاهز في دقائق</h2><ul><li>بيلدر مرئي بالسحب والإفلات</li><li>9 بوابات دفع محلية</li><li>مساعد ذكاء اصطناعي</li><li>14 يوم تجربة مجانية بدون بطاقة</li></ul></div>
  <small>© {{ date('Y') }} Cartiify</small></aside>
<div class="auth-main"><div class="auth-top"><span></span><span>ليس لديك حساب؟ <a class="lnk" href="{{ route('signup') }}">ابدأ مجاناً</a></span></div>
<main class="wiz narrow">
  <h1>أهلاً بعودتك 👋</h1><p class="sub">سجّل الدخول للوصول إلى لوحة التحكم.</p>
  <form class="form" id="f-login" novalidate>
    <label>البريد الإلكتروني<input class="input" type="email" name="email" required></label>
    <label>كلمة المرور<input class="input" type="password" name="password" required></label>
    <p class="err" id="e-login" hidden></p>
    <button class="btn btn-primary block">دخول</button>
  </form>
</main>
</div></div>
<script src="{{ asset('js/login.js') }}"></script>
</body>
</html>
