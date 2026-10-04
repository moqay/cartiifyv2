$(function () {
  var C = Cartiify, S = window.__STATE__;
  var site = S.site, toast = C.toast;
  var api = function (m, u, d) { return C.api(m, u, d).fail(function (x) { toast(C.firstError(x).message); }); };
  var fmt = function (n) { return C.money(n, site.currency); };
  var esc = function (v) { return $('<div>').text(v == null ? '' : v).html(); };

  var statusLabel = { new: 'جديد', paid: 'مدفوع', shipped: 'تم الشحن', delivered: 'تم التسليم' };
  var statusNext = { new: 'paid', paid: 'shipped', shipped: 'delivered', delivered: 'new' };
  var shipping = C.shipping;
  var sections = ['البانر الرئيسي', 'التصنيفات', 'منتجات مميزة', 'عرض ترويجي', 'آراء العملاء'];
  var titles = { dashboard: 'لوحة التحكم', builder: 'البيلدر', products: 'المنتجات', orders: 'الطلبات', payments: 'الدفع والشحن', plugins: 'متجر الإضافات', ai: 'المساعد الذكي', settings: 'الإعدادات' };

  document.documentElement.style.setProperty('--sp', site.color);
  function header() {
    $('#s-name').text(site.name); $('#av').text(site.name.charAt(0));
    $('#s-plan').text('باقة ' + C.plans[S.plan].name);
    var days = Math.max(0, Math.ceil(((S.trialEnds || Date.now()) - Date.now()) / 864e5));
    $('#trial').html('🎁 تجربتك المجانية: متبقي <b>' + days + '</b> يوم · <a href="#settings" id="upg">ترقية الباقة</a>').prop('hidden', false);
  }
  header();

  function modal(html) { $('#modal-body').html(html); $('#modal').prop('hidden', false); }
  function closeModal() { $('#modal').prop('hidden', true); }
  $('#modal').on('click', function (e) { if ($(e.target).is('#modal, .modal-x')) closeModal(); });

  var screens = {};

  screens.dashboard = function () {
    var welcome = S.welcome && !S.demo ? '<div class="welcome"><div><h3>أهلاً ' + esc(S.user.name.split(' ')[0]) + '، متجرك جاهز</h3><p>رابط متجرك: <b dir="ltr">' + site.sub + '.cartiify.com</b> — أضفنا منتجات من قالب «' + C.templates[site.template].name + '» لتبدأ بها.</p></div><div class="wl-act"><a class="btn btn-primary btn-sm" href="/store/' + site.sub + '" target="_blank">زيارة متجرك</a><button class="btn btn-ghost btn-sm" id="dismiss">إخفاء</button></div></div>' : '';
    var rows = site.orders.slice(0, 6).map(function (o) { return '<tr data-view="' + o.id + '" class="clk"><td>' + o.number + '</td><td>' + esc(o.customer) + '</td><td>' + fmt(o.total) + '</td><td><span class="tag ' + o.status + '">' + statusLabel[o.status] + '</span></td></tr>'; }).join('');
    return welcome + '<div class="range"><button data-days="7" class="' + (days === 7 ? 'on' : '') + '">آخر 7 أيام</button><button data-days="30" class="' + (days === 30 ? 'on' : '') + '">آخر 30 يوماً</button></div>' +
      '<div class="stats" id="stats"><div class="stat sk"></div><div class="stat sk"></div><div class="stat sk"></div><div class="stat sk"></div></div>' +
      '<div class="two"><section class="panel"><h3>المبيعات</h3><div class="chart" id="chart"></div></section>' +
      '<section class="panel"><h3>أحدث الطلبات</h3><table class="tbl" id="recent"><tbody>' + rows + '</tbody></table></section></div>' +
      '<section class="panel" style="margin-top:18px"><h3>الأكثر مبيعاً</h3><div id="top" class="toplist"></div></section>';
  };

  var days = 7;
  function pct(d) { return d === null ? '<em class="flat">—</em>' : '<em class="' + (d >= 0 ? '' : 'down') + '">' + (d >= 0 ? '+' : '') + d + '%</em>'; }
  function loadStats() {
    C.api('GET', '/api/stats?days=' + days).done(function (r) {
      if (!$('#stats').length) return;
      $('#stats').html(stat('المبيعات', fmt(r.sales), pct(r.salesDelta)) + stat('الطلبات', r.orders, pct(r.ordersDelta)) + stat('متوسط الطلب', fmt(r.aov), '<em class="flat">لكل طلب</em>') + stat('الزوار', r.visits.toLocaleString('en-US'), '<em class="flat">تحويل ' + r.conversion + '%</em>'));
      var max = Math.max.apply(null, r.series.map(function (x) { return x.sales; })) || 1;
      $('#chart').html(r.series.map(function (x) { return '<i style="height:' + Math.max(3, x.sales / max * 100) + '%" data-tip="' + x.label + ' · ' + fmt(x.sales) + ' · ' + x.orders + ' طلب"></i>'; }).join(''));
      $('#top').html(r.top.length ? r.top.map(function (t, i) { return '<div class="trow"><span class="rk">' + (i + 1) + '</span><span class="thumb">' + t.emoji + '</span><b>' + esc(t.name) + '</b><span>' + t.qty + ' قطعة</span><em>' + fmt(t.revenue) + '</em></div>'; }).join('') : '<p class="hint">لا توجد مبيعات في هذه الفترة.</p>');
    });
  }
  function stat(l, v, d) { return '<div class="stat"><span>' + l + '</span><b>' + v + '</b>' + d + '</div>'; }

  function storePreview() {
    var cards = site.products.slice(0, 4).map(function (p) { return '<div class="sp-card"><div class="sp-img">' + p.emoji + '</div><b>' + esc(p.name) + '</b><span>' + fmt(p.price) + '</span></div>'; }).join('');
    var cats = $.unique(site.products.map(function (p) { return p.cat; })).slice(0, 4).map(function (c) { return '<span>' + esc(c) + '</span>'; }).join('');
    var h = function (i) { return site.hidden.indexOf(i) > -1 ? ' style="display:none"' : ''; };
    return '<div class="sp"><div class="sp-nav"><b>' + esc(site.name) + '</b><span>الرئيسية · المنتجات · اتصل بنا</span><span>🛒 0</span></div>' +
      '<div class="sp-sec sp-hero on" data-s="0"' + h(0) + '><h2>' + esc(site.headline) + '</h2><p>تسوّق أحدث المنتجات بأفضل الأسعار</p><button class="sp-btn">تسوّق الآن</button></div>' +
      '<div class="sp-sec sp-cats" data-s="1"' + h(1) + '>' + cats + '</div>' +
      '<div class="sp-sec" data-s="2"' + h(2) + '><h4>منتجات مميزة</h4><div class="sp-grid">' + cards + '</div></div>' +
      '<div class="sp-sec sp-banner" data-s="3"' + h(3) + '>🚚 شحن مجاني للطلبات فوق ' + fmt(1000) + '</div>' +
      '<div class="sp-sec sp-rev" data-s="4"' + h(4) + '><h4>آراء العملاء</h4><p>⭐⭐⭐⭐⭐ "خدمة ممتازة وتوصيل سريع" — سارة</p></div></div>';
  }

  screens.builder = function () {
    var list = sections.map(function (s, i) { return '<li data-i="' + i + '" class="' + (i === 0 ? 'on' : '') + '"><span>⋮⋮</span>' + s + '<button class="hide" title="إخفاء">👁</button></li>'; }).join('');
    var sw = ['#6d5efc', '#0ea5a4', '#e8590c', '#16a34a', '#db2777'].map(function (c) { return '<button data-color="' + c + '" style="background:' + c + '"></button>'; }).join('');
    return '<div class="builder"><div class="b-side"><h3>أقسام الصفحة</h3><ul id="sec-list">' + list + '</ul>' +
      '<h3>العنوان الرئيسي</h3><input class="input" id="headline" value="' + esc(site.headline) + '">' +
      '<h3>المظهر</h3><label class="lbl">اللون الأساسي</label><div class="swatches">' + sw + '</div></div>' +
      '<div class="b-stage"><div class="b-tools"><button class="on" data-dev="desktop">🖥️ ديسكتوب</button><button data-dev="mobile">📱 موبايل</button></div><div class="frame" id="frame">' + storePreview() + '</div></div></div>';
  };

  screens.products = function () {
    var rows = site.products.map(function (p) {
      return '<tr><td><span class="thumb">' + p.emoji + '</span>' + esc(p.name) + '</td><td>' + esc(p.cat) + '</td><td>' + fmt(p.price) + '</td><td class="' + (p.stock < 10 ? 'low' : '') + '">' + p.stock + '</td><td><button class="link" data-edit="' + p.id + '">تعديل</button> <button class="link del" data-del="' + p.id + '">حذف</button></td></tr>';
    }).join('');
    return '<div class="bar"><input id="q" class="input" placeholder="ابحث عن منتج..."><button class="btn btn-primary btn-sm" id="add-product">+ منتج جديد</button></div>' +
      '<section class="panel"><table class="tbl" id="ptable"><thead><tr><th>المنتج</th><th>التصنيف</th><th>السعر</th><th>المخزون</th><th></th></tr></thead><tbody>' + rows + '</tbody></table></section>';
  };

  screens.orders = function () {
    var rows = site.orders.map(function (o, i) { return '<tr class="clk" data-view="' + o.id + '"><td>' + o.number + '</td><td>' + esc(o.customer) + '</td><td>' + o.date + ' · ' + o.time + '</td><td>' + (o.payment === 'card' ? 'بطاقة' : 'عند الاستلام') + '</td><td>' + fmt(o.total) + '</td><td><button class="tag ' + o.status + '" data-o="' + i + '">' + statusLabel[o.status] + '</button></td></tr>'; }).join('');
    return '<p class="hint">اضغط على الطلب لعرض تفاصيله، وعلى الحالة لتغييرها.</p><section class="panel"><table class="tbl"><thead><tr><th>الطلب</th><th>العميل</th><th>الوقت</th><th>الدفع</th><th>الإجمالي</th><th>الحالة</th></tr></thead><tbody>' + rows + '</tbody></table></section>';
  };

  function sw(k, i, on) { return '<label class="sw"><input type="checkbox" data-k="' + k + '" data-i="' + i + '"' + (on ? ' checked' : '') + '><span></span></label>'; }
  screens.payments = function () {
    var g = C.gatewayNames.map(function (n, i) { return '<div class="row"><b>' + n + '</b>' + sw('gateways', i, site.gateways[i]) + '</div>'; }).join('');
    var s = shipping.map(function (x, i) { return '<div class="row"><div><b>' + x[0] + '</b><small>' + x[1] + ' · ' + (x[2] ? fmt(x[2]) : 'مجاني') + '</small></div>' + sw('shipping', i, site.shipping[i]) + '</div>'; }).join('');
    return '<div class="two"><section class="panel"><h3>بوابات الدفع</h3>' + g + '</section><section class="panel"><h3>طرق الشحن</h3>' + s + '</section></div>';
  };

  screens.plugins = function () {
    return '<div class="pgrid">' + C.pluginList.map(function (p, i) {
      var on = site.plugins[i];
      return '<article class="pcard"><div class="pico">' + p[0] + '</div><h4>' + p[1] + '</h4><p>' + p[2] + '</p><button class="btn btn-sm ' + (on ? 'btn-ghost' : 'btn-primary') + '" data-plug="' + i + '">' + (on ? 'مثبّتة ✓' : 'تثبيت') + '</button></article>';
    }).join('') + '</div>';
  };

  screens.ai = function () {
    return '<section class="panel chat"><div class="msgs" id="msgs"><div class="m bot">أهلاً! أنا مساعد Cartiify. اطلب مني مثلاً: <b>أنشئ صفحة عروض</b> أو <b>اكتب وصف منتج</b> أو <b>حسّن SEO</b>.</div></div>' +
      '<div class="quick"><button>أنشئ صفحة عروض</button><button>اكتب وصف لأول منتج</button><button>حسّن SEO للمتجر</button></div>' +
      '<form id="chat-form" class="chat-in"><input class="input" placeholder="اكتب طلبك..." autocomplete="off"><button class="btn btn-primary btn-sm">إرسال</button></form></section>';
  };

  screens.settings = function () {
    var plans = $.map(C.plans, function (p, k) { return '<div class="row"><div><b>' + p.name + '</b><small>$' + p.price + '/شهر · ' + p.features.join(' · ') + '</small></div>' + (k === S.plan ? '<span class="tag paid">باقتك الحالية</span>' : '<button class="btn btn-ghost btn-sm" data-plan="' + k + '">اختيار</button>') + '</div>'; }).join('');
    var cur = $.map(C.currencies, function (sym, k) { return '<option value="' + k + '"' + (k === site.currency ? ' selected' : '') + '>' + k + ' (' + sym + ')</option>'; }).join('');
    return '<div class="two"><section class="panel"><h3>بيانات المتجر</h3><form id="f-set" class="form"><label>اسم المتجر<input class="input" name="name" value="' + esc(site.name) + '"></label>' +
      '<label>الرابط<input class="input" dir="ltr" value="' + site.sub + '.cartiify.com" disabled></label><label>العملة<select class="input" name="currency">' + cur + '</select></label>' +
      '<label>البريد<input class="input" dir="ltr" value="' + esc(S.user.email) + '" disabled></label><button class="btn btn-primary btn-sm">حفظ التغييرات</button></form></section>' +
      '<section class="panel"><h3>الاشتراك</h3>' + plans + '<h3 style="margin-top:26px">منطقة الخطر</h3><button class="btn btn-ghost btn-sm" id="reset" style="color:#dc2626">حذف المتجر والحساب</button></section></div>';
  };

  var replies = [[/عروض|صفحة/, '✅ تم إنشاء صفحة "عروض الموسم" بأربعة أقسام: بانر، عداد تنازلي، شبكة منتجات، وCTA. يمكنك فتحها في البيلدر.'], [/وصف|منتج/, null], [/seo|سيو|بحث/i, '🔍 اقتراحات: أضف عنوان وصفي لـ 6 منتجات، حسّن سرعة 3 صور، وأنشئ Sitemap تلقائياً.']];
  function ask(text) {
    $('<div class="m me"></div>').text(text).appendTo('#msgs');
    var r = '🙂 فهمت طلبك وسأنفذه على متجرك فور تفعيل هذه الميزة.';
    $.each(replies, function (_, x) { if (x[0].test(text)) { r = x[1] || '✍️ "' + site.products[0].name + ' بجودة عالية وتصميم عملي للاستخدام اليومي، متوفر الآن بسعر مميز في ' + site.name + '."'; return false; } });
    var $m = $('<div class="m bot"></div>').text('...').appendTo('#msgs');
    $('#msgs').scrollTop(99999);
    setTimeout(function () { $m.text(r); $('#msgs').scrollTop(99999); }, 700);
  }

  var current = 'dashboard';
  function show(name) {
    if (!screens[name]) name = 'dashboard';
    $('#menu a').removeClass('active').filter('[data-screen="' + name + '"]').addClass('active');
    $('#screen-title').text(titles[name]);
    current = name;
    $('#screen').html(screens[name]()).hide().fadeIn(150);
    if (name === 'dashboard') loadStats();
    history.replaceState(null, '', '#' + name);
  }

  $('#menu').on('click', 'a', function () { show($(this).data('screen')); });
  $('#trial').on('click', '#upg', function (e) { e.preventDefault(); show('settings'); });
  $('#publish').on('click', function () { toast('✔ تم نشر التعديلات على ' + site.sub + '.cartiify.com'); });
  $('#logout').on('click', function () { api('POST', '/logout').done(function (r) { location.href = r.redirect; }); });

  var $s = $('#screen');
  $s.on('click', '#dismiss', function () { S.welcome = false; api('POST', '/api/welcome/dismiss'); $('.welcome').slideUp(150); });
  $s.on('click', '#sec-list li', function (e) {
    var i = $(this).data('i');
    if ($(e.target).hasClass('hide')) {
      var k = site.hidden.indexOf(i); k > -1 ? site.hidden.splice(k, 1) : site.hidden.push(i);
      api('PUT', '/api/site', { hidden: site.hidden }); $('.sp-sec[data-s="' + i + '"]').toggle(k > -1); return;
    }
    $('#sec-list li').removeClass('on'); $(this).addClass('on');
    $('.sp-sec').removeClass('on'); var $t = $('.sp-sec[data-s="' + i + '"]').addClass('on'), f = $('#frame');
    if ($t.is(':visible')) f.animate({ scrollTop: f.scrollTop() + $t.position().top - 10 }, 200);
  });
  $s.on('click', '[data-color]', function () { site.color = $(this).data('color'); api('PUT', '/api/site', { color: site.color }); document.documentElement.style.setProperty('--sp', site.color); toast('تم تغيير اللون الأساسي'); });
  $s.on('change', '#headline', function () { site.headline = $.trim($(this).val()) || site.headline; api('PUT', '/api/site', { headline: site.headline }); $('.sp-hero h2').text(site.headline); toast('تم حفظ العنوان'); });
  $s.on('click', '[data-dev]', function () { $('[data-dev]').removeClass('on'); $(this).addClass('on'); $('#frame').toggleClass('mobile', $(this).data('dev') === 'mobile'); });
  $s.on('input', '#q', function () { var q = $.trim($(this).val()); $('#ptable tbody tr').each(function () { $(this).toggle($(this).text().indexOf(q) > -1); }); });

  $s.on('click', '#add-product, [data-edit]', function () {
    var id = $(this).data('edit'), p = site.products.filter(function (x) { return x.id == id; })[0] || { name: '', price: '', stock: '', cat: '', emoji: '📦' };
    modal('<h3>' + (id ? 'تعديل منتج' : 'منتج جديد') + '</h3><form id="f-prod" data-id="' + (id || '') + '" class="form">' +
      '<label>الاسم<input class="input" name="name" value="' + esc(p.name) + '" required></label><label>التصنيف<input class="input" name="cat" value="' + esc(p.cat) + '"></label>' +
      '<label>السعر<input class="input" type="number" min="0" name="price" value="' + p.price + '" required></label><label>المخزون<input class="input" type="number" min="0" name="stock" value="' + p.stock + '"></label>' +
      '<button class="btn btn-primary block">حفظ</button></form>');
  });
  $('#modal').on('submit', '#f-prod', function (e) {
    e.preventDefault();
    var f = $(this), id = f.data('id'), v = { name: $.trim(f.find('[name=name]').val()), cat: $.trim(f.find('[name=cat]').val()) || 'عام', price: +f.find('[name=price]').val() || 0, stock: +f.find('[name=stock]').val() || 0 };
    if (!v.name) return;
    api(id ? 'PUT' : 'POST', id ? '/api/products/' + id : '/api/products', v).done(function (r) {
      if (id) { $.extend(site.products.filter(function (x) { return x.id == id; })[0], v); }
      else { v.id = r.id; v.emoji = '📦'; site.products.unshift(v); }
      closeModal(); show('products'); toast('✔ تم حفظ المنتج');
    });
  });
  $s.on('click', '[data-del]', function () {
    var id = $(this).data('del');
    if (!confirm('حذف هذا المنتج؟')) return;
    api('DELETE', '/api/products/' + id).done(function () { site.products = site.products.filter(function (x) { return x.id != id; }); show('products'); toast('تم حذف المنتج'); });
  });
  $s.on('click', '[data-o]', function () { var o = site.orders[$(this).data('o')], $b = $(this); api('POST', '/api/orders/' + o.id + '/advance').done(function (r) { o.status = r.status; $b.attr('class', 'tag ' + o.status).text(statusLabel[o.status]); toast('تم تحديث حالة الطلب ' + o.number); }); });
  $s.on('change', '.sw input', function () { var on = $(this).is(':checked'), k = $(this).data('k'), i = $(this).data('i'); site[k][i] = on; api('PUT', '/api/site/toggle', { key: k, index: i, value: on }).done(function () { toast(on ? 'تم التفعيل' : 'تم الإيقاف'); }); });
  $s.on('click', '[data-plug]', function () {
    var i = $(this).data('plug'), $b = $(this), on = !site.plugins[i];
    api('PUT', '/api/site/toggle', { key: 'plugins', index: i, value: on }).done(function () {
      site.plugins[i] = on; $b.toggleClass('btn-ghost btn-primary').text(on ? 'مثبّتة ✓' : 'تثبيت');
      toast((on ? 'تم تثبيت ' : 'تم إلغاء تثبيت ') + C.pluginList[i][1]);
    });
  });
  $s.on('click', '.quick button', function () { ask($(this).text()); });
  $s.on('submit', '#chat-form', function (e) { e.preventDefault(); var $i = $(this).find('input'), v = $.trim($i.val()); if (v) { ask(v); $i.val(''); } });
  $s.on('submit', '#f-set', function (e) {
    e.preventDefault();
    var n = $.trim($(this).find('[name=name]').val()) || site.name, cur = $(this).find('[name=currency]').val();
    api('PUT', '/api/site', { name: n, currency: cur }).done(function () { site.name = n; site.currency = cur; header(); toast('✔ تم حفظ الإعدادات'); });
  });
  $s.on('click', '[data-plan]', function () { var p = $(this).data('plan'); api('PUT', '/api/plan', { plan: p }).done(function () { S.plan = p; header(); show('settings'); toast('تم تغيير الباقة إلى ' + C.plans[p].name); }); });
  $s.on('click', '#reset', function () { if (confirm('سيتم حذف المتجر والحساب نهائياً. متأكد؟')) { api('DELETE', '/api/account').done(function (r) { location.href = r.redirect; }); } });

  $s.on('click', '[data-days]', function () { days = +$(this).data('days'); $('.range button').removeClass('on'); $(this).addClass('on'); loadStats(); });
  $s.on('click', '[data-view]', function (e) {
    if ($(e.target).is('[data-o]')) return;
    var id = $(this).data('view'), o = site.orders.filter(function (x) { return x.id == id; })[0];
    if (!o) return;
    var lines = (o.items || []).map(function (l) { return '<div class="trow"><span class="thumb">' + (l.emoji || '📦') + '</span><b>' + esc(l.name) + '</b><span>× ' + l.qty + '</span><em>' + fmt(l.qty * l.price) + '</em></div>'; }).join('');
    modal('<h3>طلب ' + o.number + '</h3><p class="hint">' + o.date + ' · ' + o.time + '</p>' + lines + '<div class="trow tot"><b>الإجمالي</b><em>' + fmt(o.total) + '</em></div>' +
      '<div class="cust"><div><small>العميل</small><b>' + esc(o.customer) + '</b></div><div><small>الهاتف</small><b dir="ltr">' + esc(o.phone || '—') + '</b></div><div><small>العنوان</small><b>' + esc(o.address || '—') + '</b></div><div><small>الدفع</small><b>' + (o.payment === 'card' ? 'بطاقة' : 'عند الاستلام') + '</b></div></div>');
  });

  var unread = 0;
  function poll() {
    var last = site.orders.reduce(function (m, o) { return Math.max(m, o.id); }, 0);
    C.api('GET', '/api/orders/feed?after=' + last).done(function (r) {
      if (!r.orders.length) return;
      r.orders.forEach(function (o) { site.orders.unshift(o); toast('طلب جديد ' + o.number + ' · ' + o.customer + ' · ' + fmt(o.total)); });
      unread += r.orders.length; $('#bell-n').text(unread).prop('hidden', false);
      if (current === 'orders' || current === 'dashboard') { var y = $s.scrollTop(); show(current); $s.scrollTop(y); }
    });
  }
  setInterval(poll, 9000);
  $('#bell').on('click', function () { unread = 0; $('#bell-n').prop('hidden', true); show('orders'); });
  if (S.demo) $('#demo-bar').prop('hidden', false);

  show(location.hash.slice(1));
});
