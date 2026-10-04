$(function () {
  var C = Cartiify, data = { plan: 'growth', tpl: 'electronics' }, checkTimer;
  var q = new URLSearchParams(location.search).get('plan');
  if (q && C.plans[q]) data.plan = q;

  function go(n) {
    $('.wstep').prop('hidden', true).filter('[data-step=' + n + ']').prop('hidden', false);
    $('#wiz-steps li').each(function (i) { $(this).toggleClass('on', i < n).toggleClass('cur', i === n - 1); });
    $('html,body').scrollTop(0);
  }

  $('#plan-cards').html($.map(C.plans, function (p, k) {
    return '<article class="card plan' + (k === 'growth' ? ' hot' : '') + '" data-plan="' + k + '">' + (k === 'growth' ? '<span class="badge">الأكثر طلباً</span>' : '') +
      '<h3>' + p.name + '</h3><div class="price">$' + p.price + '<small>/شهر</small></div><ul>' + p.features.map(function (f) { return '<li>' + f + '</li>'; }).join('') + '</ul><button class="btn ' + (k === 'growth' ? 'btn-primary' : 'btn-ghost') + '">اختر ' + p.name + '</button></article>';
  }).join(''));
  $('#plan-cards').on('click', '.plan', function () { data.plan = $(this).data('plan'); $('#sel-plan').text(C.plans[data.plan].name); go(2); });
  $('.back').on('click', function () { go($(this).closest('.wstep').data('step') - 1); });

  $('#f-account').on('submit', function (e) {
    e.preventDefault();
    var f = $(this), name = $.trim(f.find('[name=name]').val()), email = $.trim(f.find('[name=email]').val()).toLowerCase(), pass = f.find('[name=password]').val(), $e = $('#e-account');
    var msg = !name ? 'اكتب اسمك.' : !/^\S+@\S+\.\S+$/.test(email) ? 'البريد الإلكتروني غير صحيح.' : pass.length < 6 ? 'كلمة المرور 6 أحرف على الأقل.' : '';
    if (msg) { $e.text(msg).prop('hidden', false); return; }
    $e.prop('hidden', true);
    data.name = name; data.email = email; data.pass = pass;
    go(3);
  });

  $('#tpls').html($.map(C.templates, function (t, k) {
    return '<div class="tpl' + (k === data.tpl ? ' on' : '') + '" data-t="' + k + '"><div class="tpl-pv" style="background:' + t.color + '">' + t.emoji + '</div><b>' + t.name + '</b></div>';
  }).join(''));
  $('#tpls').on('click', '.tpl', function () { data.tpl = $(this).data('t'); $('.tpl').removeClass('on'); $(this).addClass('on'); });

  var slug = function (v) { return v.toLowerCase().replace(/[^a-z0-9-]/g, '').replace(/^-+|-+$/g, '').slice(0, 30); };
  var subTouched = false;
  $('[name=sub]').on('input', function () {
    subTouched = true; var v = slug($(this).val()); $(this).val(v);
    clearTimeout(checkTimer);
    var $h = $('#sub-hint');
    if (v.length < 3) { $h.text(''); return; }
    checkTimer = setTimeout(function () {
      $.getJSON('/api/subdomain', { sub: v }, function (r) {
        $h.text(r.available ? '✔ ' + v + '.cartiify.com متاح' : '✖ هذا الرابط غير متاح').css('color', r.available ? '#16a34a' : '#dc2626');
      });
    }, 300);
  });
  $('[name=sname]').on('input', function () {
    if (!subTouched) { $('[name=sub]').val(slug($(this).val().replace(/\s+/g, '-'))).trigger('input'); subTouched = false; }
  });

  $('#f-site').on('submit', function (e) {
    e.preventDefault();
    var f = $(this), sname = $.trim(f.find('[name=sname]').val()), sub = slug(f.find('[name=sub]').val()), $e = $('#e-site');
    var msg = !sname ? 'اكتب اسم المتجر.' : sub.length < 3 ? 'الرابط 3 أحرف إنجليزية على الأقل.' : '';
    if (msg) { $e.text(msg).prop('hidden', false); return; }
    $e.prop('hidden', true);
    data.sname = sname; data.sub = sub; data.currency = f.find('[name=currency]').val();
    create();
  });

  function create() {
    go(4);
    $('#t-url').text(data.sub + '.cartiify.com');
    var $li = $('#tasks li'), i = 0, animDone = false, res = null, failed = false;

    C.api('POST', '/signup', { plan: data.plan, name: data.name, email: data.email, password: data.pass, sname: data.sname, sub: data.sub, currency: data.currency, template: data.tpl })
      .done(function (r) { res = r; finish(); })
      .fail(function (x) {
        failed = true;
        var e = C.firstError(x), step = /^(name|email|password)$/.test(e.field) ? 2 : 3;
        go(step); $(step === 2 ? '#e-account' : '#e-site').text(e.message).prop('hidden', false);
      });

    (function next() {
      if (failed) return;
      if (i > 0) $li.eq(i - 1).addClass('ok');
      if (i >= $li.length) { animDone = true; return finish(); }
      i++; setTimeout(next, 650);
    })();

    function finish() { if (animDone && res) setTimeout(function () { location.href = res.redirect; }, 400); }
  }

  $('#sel-plan').text(C.plans[data.plan].name);
  go(1);
});
