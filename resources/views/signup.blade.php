<!doctype html>
<html lang="ar" dir="rtl">
<head>
<title>أنشئ متجرك — Cartiify</title>
@include('partials.head')
</head>
<body class="auth">
<header class="auth-top"><a href="{{ route('landing') }}" class="logo"><span class="logo-mark">C</span> Cartiify</a><span>لديك حساب؟ <a class="lnk" href="{{ route('login') }}">سجّل الدخول</a></span></header>

<main class="wiz">
  <ol class="wiz-steps" id="wiz-steps"><li class="on">الباقة</li><li>الحساب</li><li>المتجر</li><li>الإنشاء</li></ol>

  <section class="wstep" data-step="1">
    <h1>اختر الباقة المناسبة</h1><p class="sub">14 يوم مجاناً — بدون بطاقة ائتمان. غيّر الباقة في أي وقت.</p>
    <div class="grid g3 plans" id="plan-cards"></div>
  </section>

  <section class="wstep" data-step="2" hidden>
    <h1>أنشئ حسابك</h1><p class="sub">باقة <b id="sel-plan"></b> · تجربة مجانية 14 يوم</p>
    <form class="form" id="f-account" novalidate>
      <label>الاسم الكامل<input class="input" name="name" required></label>
      <label>البريد الإلكتروني<input class="input" type="email" name="email" required></label>
      <label>كلمة المرور<input class="input" type="password" name="password" minlength="6" required></label>
      <p class="err" id="e-account" hidden></p>
      <div class="actions"><button type="button" class="btn btn-ghost back">رجوع</button><button class="btn btn-primary">التالي</button></div>
    </form>
  </section>

  <section class="wstep" data-step="3" hidden>
    <h1>جهّز متجرك</h1><p class="sub">تقدر تغيّر كل ده لاحقاً من لوحة التحكم.</p>
    <form class="form" id="f-site" novalidate>
      <label>اسم المتجر<input class="input" name="sname" placeholder="مثال: متجر الأمل" required></label>
      <label>رابط المتجر
        <div class="sub-in"><input class="input" name="sub" dir="ltr" placeholder="alamal" required><span dir="ltr">.cartiify.com</span></div>
        <small id="sub-hint"></small>
      </label>
      <label>العملة<select class="input" name="currency"><option value="EGP">جنيه مصري (ج.م)</option><option value="SAR">ريال سعودي (ر.س)</option><option value="AED">درهم إماراتي (د.إ)</option><option value="USD">دولار ($)</option></select></label>
      <div class="lbl-t">اختر القالب</div>
      <div class="tpls" id="tpls"></div>
      <p class="err" id="e-site" hidden></p>
      <div class="actions"><button type="button" class="btn btn-ghost back">رجوع</button><button class="btn btn-primary">إنشاء المتجر</button></div>
    </form>
  </section>

  <section class="wstep" data-step="4" hidden>
    <div class="making"><div class="spin"></div><h1>نجهّز متجرك...</h1>
      <ul id="tasks"><li>إنشاء الحساب</li><li>حجز الرابط <b id="t-url" dir="ltr"></b></li><li>تطبيق القالب وإضافة منتجات تجريبية</li><li>ضبط بوابات الدفع والشحن</li><li>تجهيز لوحة التحكم</li></ul>
    </div>
  </section>
</main>
<script src="{{ asset('js/signup.js') }}"></script>
</body>
</html>
