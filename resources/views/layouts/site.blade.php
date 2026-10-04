<!doctype html>
<html lang="ar" dir="rtl">
<head>
<title>@yield('title', 'Cartiify — ابنِ متجرك وأطلقه في دقائق')</title>
@include('partials.head')
<link rel="stylesheet" href="{{ asset('css/landing.css') }}">
</head>
<body class="lp">
<a class="lp-ann" href="{{ route('signup') }}">✨ جديد: مساعد الذكاء الاصطناعي يبني صفحات متجرك بجملة واحدة <b>جرّبه الآن ←</b></a>
<header class="lp-nav">
  <div class="wrap lp-nav-in">
    <a href="{{ route('landing') }}" class="logo"><span class="logo-mark">C</span> Cartiify</a>
    <nav class="lp-links">
      <a href="{{ route('landing') }}#features">المميزات</a>
      <a href="{{ route('landing') }}#showcase">المنتج</a>
      <a href="{{ route('landing') }}#pricing">الأسعار</a>
      <a href="{{ route('landing') }}#faq">الأسئلة الشائعة</a>
    </nav>
    <div class="lp-nav-cta"><a href="{{ route('login') }}" class="btn btn-ghost btn-sm">تسجيل الدخول</a><a href="{{ route('signup') }}" class="btn btn-primary btn-sm">ابدأ مجاناً</a></div>
  </div>
</header>

@yield('content')

<footer class="lp-foot">
  <div class="wrap lp-foot-in">
    <div class="lp-foot-brand">
      <a href="{{ route('landing') }}" class="logo"><span class="logo-mark">C</span> Cartiify</a>
      <p>منصة متكاملة لإنشاء وإدارة المتاجر الإلكترونية، مصممة للتاجر العربي.</p>
      <p class="lp-foot-mail">hello@cartiify.com</p>
    </div>
    <div><h5>المنتج</h5><a href="{{ route('landing') }}#features">المميزات</a><a href="{{ route('landing') }}#pricing">الأسعار</a><a href="{{ route('landing') }}#faq">الأسئلة الشائعة</a><a href="{{ route('signup') }}">ابدأ مجاناً</a></div>
    <div><h5>الشركة</h5><a href="{{ route('contact') }}">تواصل معنا</a><a href="{{ route('login') }}">تسجيل الدخول</a></div>
    <div><h5>قانوني</h5><a href="{{ route('terms') }}">شروط الاستخدام</a><a href="{{ route('privacy') }}">سياسة الخصوصية</a></div>
  </div>
  <div class="wrap lp-copy"><span>© {{ date('Y') }} Cartiify. جميع الحقوق محفوظة.</span><span>cartiify.com</span></div>
</footer>
<script src="{{ asset('js/landing.js') }}"></script>
</body>
</html>
