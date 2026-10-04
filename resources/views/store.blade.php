<!doctype html>
<html lang="ar" dir="rtl">
<head>
<title>{{ $site->name }}</title>
@include('partials.head')
<style>:root{--sp:{{ $site->color }}}</style>
</head>
@php $cur = config('cartiify.currencies')[$site->currency]; $fmt = fn ($n) => number_format($n).' '.$cur; $show = fn ($i) => ! in_array($i, $site->hidden); @endphp
<body class="storefront">
<div class="sf-bar" dir="ltr">🔒 {{ $site->subdomain }}.cartiify.com</div>
<div class="sp">
  <div class="sp-nav"><b>{{ $site->name }}</b><span>الرئيسية · المنتجات · اتصل بنا</span><span id="cart">🛒 0</span></div>
  @if($show(0))<div class="sp-sec sp-hero"><h2>{{ $site->headline }}</h2><p>تسوّق أحدث المنتجات بأفضل الأسعار</p><button class="sp-btn">تسوّق الآن</button></div>@endif
  @if($show(1))<div class="sp-sec sp-cats">@foreach($site->products->pluck('category')->unique() as $c)<span>{{ $c }}</span>@endforeach</div>@endif
  @if($show(2))<div class="sp-sec"><h4>منتجاتنا</h4><div class="sp-grid">
    @foreach($site->products as $p)<div class="sp-card"><div class="sp-img">{{ $p->emoji }}</div><b>{{ $p->name }}</b><span>{{ $fmt($p->price) }}</span><button class="btn btn-primary btn-sm block" data-add>أضف للسلة</button></div>@endforeach
  </div></div>@endif
  @if($show(3))<div class="sp-sec sp-banner">🚚 شحن مجاني للطلبات فوق {{ $fmt(1000) }}</div>@endif
  @if($show(4))<div class="sp-sec sp-rev"><h4>آراء العملاء</h4><p>⭐⭐⭐⭐⭐ "خدمة ممتازة وتوصيل سريع" — سارة</p></div>@endif
  <footer class="sf-foot">© {{ $site->name }} · مدعوم بواسطة <a href="/">Cartiify</a></footer>
</div>
<script>$(function(){var n=0;$('[data-add]').on('click',function(){n++;$('#cart').text('🛒 '+n);Cartiify.toast('تمت الإضافة للسلة');});});</script>
</body>
</html>
