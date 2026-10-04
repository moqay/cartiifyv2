<!doctype html>
<html lang="ar" dir="rtl">
<head>
<title>Cartiify — ابنِ متجرك وأطلقه في دقائق</title>
@include('partials.head')
</head>
<body class="landing">

<header class="nav">
  <div class="wrap nav-in">
    <a href="#top" class="logo"><span class="logo-mark">C</span> Cartiify</a>
    <nav class="nav-links">
      <a href="#features">المميزات</a>
      <a href="#how">كيف يعمل</a>
      <a href="#ecosystem">الإضافات</a>
      <a href="#pricing">الباقات</a>
      <a href="#roadmap">خارطة الطريق</a>
    </nav>
    <div class="nav-cta"><a href="{{ route('login') }}" class="btn btn-ghost btn-sm">تسجيل الدخول</a><a href="{{ route('signup') }}" class="btn btn-primary btn-sm">ابدأ مجاناً</a></div>
  </div>
</header>

<section class="hero" id="top">
  <div class="wrap hero-in">
    <div class="hero-text">
      <span class="pill">14 يوم تجربة مجانية · بدون بطاقة ائتمان</span>
      <h1>ابنِ متجرك الإلكتروني <em>وأطلقه في دقائق</em></h1>
      <p>Cartiify منصة SaaS متكاملة لإنشاء المتاجر والمواقع: بيلدر مرئي بالسحب والإفلات، بوابات دفع محلية، شحن، تسويق، ومساعد ذكاء اصطناعي — كل ذلك في مكان واحد وبالعربية.</p>
      <div class="hero-cta">
        <a href="{{ route('signup') }}" class="btn btn-primary">أنشئ متجرك الآن ←</a>
        <a href="{{ route('login') }}" class="btn btn-ghost">لدي حساب</a>
      </div>
      <ul class="hero-stats">
        <li><b>+50</b><span>إضافة جاهزة</span></li>
        <li><b>9</b><span>بوابات دفع محلية</span></li>
        <li><b>5 دقائق</b><span>من الصفر لمتجر شغال</span></li>
      </ul>
    </div>
    <div class="hero-visual">
      <div class="mock">
        <div class="mock-bar"><i></i><i></i><i></i><span>mystore.cartiify.com</span></div>
        <div class="mock-body">
          <div class="mock-side"><b></b><b></b><b></b><b></b></div>
          <div class="mock-main">
            <div class="mock-hero"></div>
            <div class="mock-grid"><div></div><div></div><div></div></div>
          </div>
        </div>
      </div>
      <div class="float f1">🛒 طلب جديد · 1,250 ج.م</div>
      <div class="float f2">✨ المساعد كتب وصف 12 منتج</div>
    </div>
  </div>
</section>

<section class="strip">
  <div class="wrap strip-in">
    <span>يدعم</span><b>Paymob</b><b>Fawry</b><b>Tap</b><b>Paytabs</b><b>Hyperpay</b><b>Opay</b><b>Kashier</b><b>Thawani</b>
  </div>
</section>

<section class="sec" id="features">
  <div class="wrap">
    <div class="sec-head"><span class="pill">المميزات</span><h2>كل ما يحتاجه التاجر في منصة واحدة</h2><p>بدل ما تجمّع 8 أدوات مختلفة، Cartiify يديك الكل جاهز ومتكامل.</p></div>
    <div class="grid g3">
      <article class="card"><div class="ico">🎨</div><h3>بيلدر مرئي</h3><p>اسحب وأفلت أقسام جاهزة، عدّل الألوان والخطوط، وشاهد التغيير مباشرة على الموبايل والديسكتوب.</p></article>
      <article class="card"><div class="ico">🛍️</div><h3>إيكوميرس كامل</h3><p>منتجات بمتغيّرات، مخزون، كوبونات، سلة متروكة، فواتير، وعملات متعددة.</p></article>
      <article class="card"><div class="ico">💳</div><h3>مدفوعات محلية</h3><p>9 بوابات دفع للسوق العربي مع الدفع عند الاستلام وإعدادات شحن شرطية.</p></article>
      <article class="card"><div class="ico">🤖</div><h3>مساعد ذكاء اصطناعي</h3><p>يبني الصفحات، يكتب أوصاف المنتجات، ويقترح تحسينات SEO بجملة واحدة.</p></article>
      <article class="card"><div class="ico">📣</div><h3>تسويق ونمو</h3><p>Pixels، نظام عمولات Affiliates، نشرة بريدية، رسائل WhatsApp، وبوب أب ذكي.</p></article>
      <article class="card"><div class="ico">🌍</div><h3>متعدد اللغات والعملات</h3><p>اعرض متجرك بالعربية والإنجليزية واقبل الدفع بعملة عميلك.</p></article>
    </div>
  </div>
</section>

<section class="sec alt" id="how">
  <div class="wrap">
    <div class="sec-head"><span class="pill">كيف يعمل</span><h2>من الفكرة للمبيعات في 4 خطوات</h2></div>
    <ol class="steps">
      <li><b>1</b><h3>سجّل متجرك</h3><p>اختر الاسم والنطاق والقالب المناسب لنشاطك.</p></li>
      <li><b>2</b><h3>صمّم بالبيلدر</h3><p>خصّص الصفحات والأقسام بدون كتابة كود.</p></li>
      <li><b>3</b><h3>أضف منتجاتك</h3><p>استورد أو أضف منتجاتك واربط الدفع والشحن.</p></li>
      <li><b>4</b><h3>أطلق وانمُ</h3><p>انشر بضغطة واحدة وتابع المبيعات من لوحة التحكم.</p></li>
    </ol>
    <div class="center"><a href="{{ route('signup') }}" class="btn btn-primary">جرّبها بنفسك الآن</a></div>
  </div>
</section>

<section class="sec" id="ecosystem">
  <div class="wrap">
    <div class="sec-head"><span class="pill">متجر الإضافات</span><h2>نظام إضافات يكبر مع نشاطك</h2><p>فعّل ما تحتاجه فقط — كل ميزة إضافة مستقلة بضغطة تثبيت.</p></div>
    <div class="chips">
      <span>حجوزات</span><span>عضويات</span><span>بطاقات هدايا</span><span>طلب عرض سعر</span><span>نقاط ولاء</span><span>محفظة</span><span>اشتراكات</span><span>Checkout بصفحة واحدة</span><span>مراجعات</span><span>SEO</span><span>سلايدر</span><span>بريد إلكتروني</span><span>صلاحيات</span><span>مصادقة ثنائية</span><span>موافقة الكوكيز</span><span>سجل النشاط</span>
    </div>
  </div>
</section>

<section class="sec alt" id="pricing">
  <div class="wrap">
    <div class="sec-head"><span class="pill">الباقات</span><h2>أسعار بسيطة وشفافة</h2><p>كل الباقات تبدأ بتجربة مجانية 14 يوم.</p></div>
    <div class="grid g3 plans">
      <article class="card plan"><h3>Starter</h3><div class="price">$9<small>/شهر</small></div><ul><li>متجر واحد</li><li>100 منتج</li><li>نطاق فرعي</li><li>دعم بالبريد</li></ul><a href="{{ route('signup') }}?plan=starter" class="btn btn-ghost">ابدأ</a></article>
      <article class="card plan hot"><span class="badge">الأكثر طلباً</span><h3>Growth</h3><div class="price">$29<small>/شهر</small></div><ul><li>منتجات غير محدودة</li><li>نطاق خاص</li><li>كل بوابات الدفع</li><li>مساعد الذكاء الاصطناعي</li></ul><a href="{{ route('signup') }}?plan=growth" class="btn btn-primary">ابدأ</a></article>
      <article class="card plan"><h3>Scale</h3><div class="price">$79<small>/شهر</small></div><ul><li>متاجر متعددة</li><li>عمولات Affiliates</li><li>أدوار وصلاحيات</li><li>دعم أولوية</li></ul><a href="{{ route('signup') }}?plan=scale" class="btn btn-ghost">ابدأ</a></article>
    </div>
  </div>
</section>

<section class="sec" id="roadmap">
  <div class="wrap">
    <div class="sec-head"><span class="pill">للمستثمرين</span><h2>أين نحن وإلى أين نتجه</h2></div>
    <div class="timeline">
      <div class="tl done"><b>المرحلة 1</b><h3>المنتج الأساسي</h3><p>بيلدر، إيكوميرس، نظام الإضافات، متعدد المواقع.</p></div>
      <div class="tl done"><b>المرحلة 2</b><h3>النسخة التفاعلية</h3><p>تجربة كاملة من التسجيل حتى لوحة التحكم والمتجر.</p></div>
      <div class="tl now"><b>الآن</b><h3>الإطلاق التجريبي</h3><p>قائمة انتظار وشركاء أوائل من التجار في مصر والخليج.</p></div>
      <div class="tl"><b>المرحلة 3</b><h3>الإطلاق العام</h3><p>فتح التسجيل، متجر إضافات للمطورين، وتوسع إقليمي.</p></div>
    </div>
  </div>
</section>

<section class="cta" id="waitlist">
  <div class="wrap cta-in">
    <h2>جاهز تبدأ تجارتك الإلكترونية؟</h2>
    <p>أنشئ متجرك في دقائق — 14 يوم مجاناً وبدون بطاقة ائتمان.</p>
    <a href="{{ route('signup') }}" class="btn btn-light">ابدأ تجربتك المجانية</a>
  </div>
</section>

<footer class="foot"><div class="wrap foot-in"><a href="#top" class="logo"><span class="logo-mark">C</span> Cartiify</a><span>© {{ date('Y') }} Cartiify.com — جميع الحقوق محفوظة</span></div></footer>

<script src="{{ asset('js/landing.js') }}"></script>
</body>
</html>
