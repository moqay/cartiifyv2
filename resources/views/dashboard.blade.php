<!doctype html>
<html lang="ar" dir="rtl">
<head>
<title>لوحة التحكم — Cartiify</title>
@include('partials.head')
</head>
<body class="emu">
<div id="trial" class="demo-banner" hidden></div>
<div class="app">
  <aside class="side">
    <a href="{{ route('dashboard') }}" class="logo"><span class="logo-mark">C</span> Cartiify</a>
    <nav id="menu">
      <a data-screen="dashboard" class="active">📊 لوحة التحكم</a>
      <a data-screen="builder">🎨 البيلدر</a>
      <a data-screen="products">🛍️ المنتجات</a>
      <a data-screen="orders">📦 الطلبات</a>
      <a data-screen="payments">💳 الدفع والشحن</a>
      <a data-screen="plugins">🧩 متجر الإضافات</a>
      <a data-screen="ai">🤖 المساعد الذكي</a>
      <a data-screen="settings">⚙️ الإعدادات</a>
    </nav>
    <div class="side-foot"><div class="avatar" id="av"></div><div><b id="s-name"></b><small id="s-plan"></small></div><button id="logout" class="link" title="تسجيل الخروج">خروج</button></div>
  </aside>
  <main class="main">
    <header class="top">
      <h1 id="screen-title">لوحة التحكم</h1>
      <div class="top-actions"><a class="btn btn-ghost btn-sm" id="visit" href="/store/{{ $state['site']['sub'] }}" target="_blank">زيارة المتجر ↗</a><button class="btn btn-primary btn-sm" id="publish">نشر التعديلات</button></div>
    </header>
    <div id="screen" class="screen"></div>
  </main>
</div>
<div id="modal" class="modal" hidden><div class="modal-box"><button class="modal-x">✕</button><div id="modal-body"></div></div></div>
<script>window.__STATE__=@json($state);</script>
<script src="{{ asset('js/dashboard.js') }}"></script>
</body>
</html>
