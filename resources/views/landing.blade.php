@extends('layouts.site')
@section('content')

<section class="lp-hero">
  <div class="wrap">
    <div class="lp-hero-text">
      <span class="lp-chip"><i></i> منصة التجارة الإلكترونية للتاجر العربي</span>
      <h1>ابنِ متجرك الإلكتروني<br><em>وابدأ البيع في دقائق</em></h1>
      <p>بيلدر مرئي، مدفوعات محلية، شحن، تسويق ومساعد ذكاء اصطناعي — كل ما تحتاجه لتدير تجارتك من مكان واحد وبالعربية.</p>
      <form class="lp-claim" id="claim" action="{{ route('signup') }}" method="get">
        <div class="lp-claim-in" dir="ltr"><input name="store" id="claim-in" placeholder="your-store" autocomplete="off"><span>.cartiify.com</span></div>
        <button class="btn btn-primary">ابدأ مجاناً</button>
      </form>
      <ul class="lp-trust"><li>✔ 14 يوم مجاناً</li><li>✔ بدون بطاقة ائتمان</li><li>✔ إلغاء في أي وقت</li></ul>
    </div>

    <div class="lp-app">
      <div class="lp-glow"></div>
      <div class="lp-win">
        <div class="lp-win-bar"><i></i><i></i><i></i><span dir="ltr">app.cartiify.com/dashboard</span></div>
        <div class="lp-win-body">
          <aside class="lp-w-side"><div class="lp-w-logo">C</div><b class="on"></b><b></b><b></b><b></b><b></b></aside>
          <div class="lp-w-main">
            <div class="lp-w-head"><div><small>مرحباً بعودتك</small><h4>نظرة عامة على المبيعات</h4></div><span class="lp-w-btn">+ منتج جديد</span></div>
            <div class="lp-w-stats">
              <div><small>المبيعات</small><b>84,320 ج.م</b><em>+18%</em></div>
              <div><small>الطلبات</small><b>312</b><em>+9%</em></div>
              <div><small>الزوار</small><b>12.4K</b><em>+24%</em></div>
            </div>
            <div class="lp-w-chart">@foreach([38,52,44,68,59,81,74,92,70,88,96,84,78,100] as $h)<i style="height:{{ $h }}%"></i>@endforeach</div>
            <div class="lp-w-orders">
              <div><span>#1042</span><b>أحمد محمود</b><em class="g">مدفوع</em></div>
              <div><span>#1041</span><b>سارة علي</b><em class="p">تم الشحن</em></div>
            </div>
          </div>
        </div>
      </div>
      <div class="lp-float lf1"><span>🛒</span><div><b>طلب جديد</b><small>1,250 ج.م · الآن</small></div></div>
      <div class="lp-float lf2"><span>✅</span><div><b>تم الدفع بنجاح</b><small>Paymob · بطاقة</small></div></div>
      <div class="lp-float lf3"><span>✨</span><div><b>المساعد الذكي</b><small>كتب وصف 12 منتج</small></div></div>
    </div>
  </div>
</section>

<section class="lp-logos">
  <div class="wrap"><p>تكامل مع بوابات الدفع وشركات الشحن الأكثر استخداماً في المنطقة</p>
    <div class="lp-logo-row"><b>Paymob</b><b>Fawry</b><b>Tap</b><b>PayTabs</b><b>HyperPay</b><b>Opay</b><b>Kashier</b><b>Thawani</b></div></div>
</section>

<section class="lp-sec" id="features">
  <div class="wrap">
    <div class="lp-head"><span class="lp-kicker">المميزات</span><h2>كل ما يحتاجه المتجر الناجح، جاهز من اليوم الأول</h2><p>بدل ما تجمّع 8 أدوات مختلفة وتدفع لكل واحدة، Cartiify يعطيك منظومة كاملة ومتكاملة.</p></div>
    <div class="lp-bento">
      <article class="lp-b big"><div class="lp-b-ico">🎨</div><h3>بيلدر مرئي بالسحب والإفلات</h3><p>صمّم صفحات متجرك بأقسام جاهزة، وعدّل الألوان والنصوص وشاهد التغيير فوراً على الديسكتوب والموبايل.</p>
        <div class="lp-b-vis lp-vis-builder"><div class="vb-hero"></div><div class="vb-row"><i></i><i></i><i></i></div></div></article>
      <article class="lp-b"><div class="lp-b-ico">💳</div><h3>مدفوعات محلية</h3><p>9 بوابات دفع وطرق شحن مرنة مع الدفع عند الاستلام.</p></article>
      <article class="lp-b"><div class="lp-b-ico">🤖</div><h3>ذكاء اصطناعي</h3><p>يكتب أوصاف المنتجات ويقترح تحسينات SEO وينشئ الصفحات.</p></article>
      <article class="lp-b"><div class="lp-b-ico">🧩</div><h3>+50 إضافة</h3><p>فعّل ما تحتاجه فقط: حجوزات، عضويات، بطاقات هدايا والمزيد.</p></article>
      <article class="lp-b"><div class="lp-b-ico">📣</div><h3>تسويق ونمو</h3><p>Pixels، عمولات الأفلييت، نشرات بريدية وواتساب.</p></article>
      <article class="lp-b wide"><div class="lp-b-ico">🌍</div><h3>متعدد اللغات والعملات</h3><p>اعرض متجرك بالعربية والإنجليزية، واقبل الدفع بجنيه، ريال، درهم أو دولار.</p>
        <div class="lp-cur"><span>EGP ج.م</span><span>SAR ر.س</span><span>AED د.إ</span><span>USD $</span></div></article>
    </div>
  </div>
</section>

<section class="lp-sec alt" id="showcase">
  <div class="wrap">
    <div class="lp-head"><span class="lp-kicker">المنتج</span><h2>تحكّم كامل في تجارتك من لوحة واحدة</h2></div>

    <div class="lp-show">
      <div class="lp-show-text"><h3>أضف منتجاتك وأدر طلباتك بسهولة</h3><p>أضف المنتجات بمتغيّراتها ومخزونها، وتابع كل طلب من لحظة الشراء حتى التسليم، مع تنبيهات المخزون المنخفض.</p>
        <ul><li>إدارة منتجات ومخزون وتصنيفات</li><li>حالات الطلب في خطوة واحدة</li><li>كوبونات وسلات متروكة وفواتير</li></ul></div>
      <div class="lp-show-vis"><div class="lp-panel">
        <div class="lp-row"><span class="th">🎧</span><div><b>سماعات لاسلكية Pro</b><small>صوتيات</small></div><em>1,250 ج.م</em><span class="lp-tag g">42 متوفر</span></div>
        <div class="lp-row"><span class="th">⌚</span><div><b>ساعة ذكية Series 5</b><small>ساعات</small></div><em>2,900 ج.م</em><span class="lp-tag g">17 متوفر</span></div>
        <div class="lp-row"><span class="th">👟</span><div><b>حذاء رياضي Air</b><small>أحذية</small></div><em>1,490 ج.م</em><span class="lp-tag r">5 متبقي</span></div>
        <div class="lp-row"><span class="th">👜</span><div><b>حقيبة جلد طبيعي</b><small>إكسسوارات</small></div><em>890 ج.م</em><span class="lp-tag g">63 متوفر</span></div>
      </div></div>
    </div>

    <div class="lp-show rev">
      <div class="lp-show-text"><h3>مساعد ذكاء اصطناعي يعمل معك</h3><p>اطلب بالعربية ما تريد: "أنشئ صفحة عروض"، "اكتب وصف المنتج"، "حسّن SEO" — والمساعد ينفّذ لك.</p>
        <ul><li>إنشاء صفحات وأقسام تلقائياً</li><li>كتابة أوصاف وعناوين مقنعة</li><li>اقتراحات تحسين محركات البحث</li></ul></div>
      <div class="lp-show-vis"><div class="lp-panel lp-chat">
        <div class="m me">أنشئ صفحة عروض الموسم</div>
        <div class="m bot">✅ تم إنشاء صفحة «عروض الموسم»: بانر، عداد تنازلي، شبكة منتجات وزر شراء.</div>
        <div class="m me">اكتب وصف لسماعات لاسلكية</div>
        <div class="m bot">✍️ سماعات لاسلكية بجودة صوت استثنائية وبطارية تدوم 30 ساعة وعزل ضوضاء نشط.</div>
      </div></div>
    </div>
  </div>
</section>

<section class="lp-sec" id="how">
  <div class="wrap">
    <div class="lp-head"><span class="lp-kicker">كيف يعمل</span><h2>من الفكرة للمبيعات في 4 خطوات</h2></div>
    <ol class="lp-steps">
      <li><b>1</b><h3>اختر الباقة</h3><p>ابدأ بتجربة مجانية 14 يوم.</p></li>
      <li><b>2</b><h3>أنشئ حسابك</h3><p>بالبريد وكلمة المرور فقط.</p></li>
      <li><b>3</b><h3>جهّز متجرك</h3><p>اختر الاسم والرابط والقالب.</p></li>
      <li><b>4</b><h3>أطلق وانمُ</h3><p>أضف منتجاتك وابدأ البيع.</p></li>
    </ol>
  </div>
</section>

<section class="lp-numbers">
  <div class="wrap lp-num-grid">
    <div><b>+50</b><span>إضافة جاهزة</span></div>
    <div><b>9</b><span>بوابات دفع محلية</span></div>
    <div><b>4</b><span>عملات مدعومة</span></div>
    <div><b>5 دقائق</b><span>من الصفر لمتجر شغال</span></div>
  </div>
</section>

<section class="lp-sec" id="pricing">
  <div class="wrap">
    <div class="lp-head"><span class="lp-kicker">الأسعار</span><h2>أسعار بسيطة وشفافة</h2><p>كل الباقات تبدأ بتجربة مجانية 14 يوم، بدون بطاقة ائتمان.</p>
      <div class="lp-toggle" id="billing"><button class="on" data-m="1">شهري</button><button data-m="0.8">سنوي <small>وفّر 20%</small></button></div></div>
    <div class="lp-plans">
      @foreach(config('cartiify.plans') as $key => $p)
      <article class="lp-plan {{ $key === 'growth' ? 'hot' : '' }}">
        @if($key === 'growth')<span class="lp-pop">الأكثر طلباً</span>@endif
        <h3>{{ $p['name'] }}</h3>
        <div class="lp-price">$<b data-base="{{ $p['price'] }}">{{ $p['price'] }}</b><small>/شهر</small></div>
        <ul>@foreach($p['features'] as $f)<li>{{ $f }}</li>@endforeach</ul>
        <a href="{{ route('signup') }}?plan={{ $key }}" class="btn {{ $key === 'growth' ? 'btn-primary' : 'btn-ghost' }} block">ابدأ مع {{ $p['name'] }}</a>
      </article>
      @endforeach
    </div>
  </div>
</section>

<section class="lp-sec alt" id="faq">
  <div class="wrap narrow-w">
    <div class="lp-head"><span class="lp-kicker">الأسئلة الشائعة</span><h2>إجابات لأكثر الأسئلة تكراراً</h2></div>
    <div class="lp-faq">
      <div class="q"><button>هل أحتاج بطاقة ائتمان للتجربة المجانية؟</button><p>لا. تبدأ التجربة 14 يوم بدون أي بيانات دفع، ويمكنك الإلغاء في أي وقت.</p></div>
      <div class="q"><button>هل أحتاج خبرة تقنية لبناء متجري؟</button><p>إطلاقاً. البيلدر بالسحب والإفلات والقوالب الجاهزة تتيح لك إطلاق متجرك بدون كتابة كود.</p></div>
      <div class="q"><button>ما بوابات الدفع المدعومة؟</button><p>Paymob وFawry وTap وPayTabs وHyperPay وOpay وKashier وThawani وFawaterak، إضافة للدفع عند الاستلام.</p></div>
      <div class="q"><button>هل يمكنني تغيير الباقة لاحقاً؟</button><p>نعم، يمكنك الترقية أو التخفيض في أي وقت من إعدادات حسابك.</p></div>
      <div class="q"><button>هل يمكنني استخدام نطاق خاص بي؟</button><p>نعم، باقتا Growth وScale تتيحان ربط نطاقك الخاص بدلاً من النطاق الفرعي.</p></div>
      <div class="q"><button>ماذا يحدث لبياناتي إذا أردت الإلغاء؟</button><p>يمكنك حذف حسابك ومتجرك بالكامل من الإعدادات، وتُحذف بياناتك معه.</p></div>
    </div>
  </div>
</section>

<section class="lp-cta">
  <div class="wrap"><h2>جاهز تبدأ تجارتك الإلكترونية؟</h2><p>أنشئ متجرك الآن وابدأ البيع خلال دقائق.</p>
    <div class="lp-cta-btns"><a href="{{ route('signup') }}" class="btn btn-light">ابدأ تجربتك المجانية</a><a href="{{ route('contact') }}" class="btn lp-ghost-w">تحدّث مع فريقنا</a></div></div>
</section>
@endsection
