window.Cartiify = (function ($) {
  var CFG = window.CFG;

  function api(method, url, data) {
    return $.ajax({
      url: url, method: method, dataType: 'json', contentType: 'application/json',
      data: data === undefined ? undefined : JSON.stringify(data),
      headers: { 'X-CSRF-TOKEN': $('meta[name=csrf-token]').attr('content'), 'Accept': 'application/json' }
    });
  }
  function firstError(xhr) {
    var j = xhr.responseJSON || {};
    if (j.errors) { var k = Object.keys(j.errors)[0]; return { field: k, message: j.errors[k][0] }; }
    return { field: null, message: j.message || 'حدث خطأ، حاول مرة أخرى.' };
  }
  function money(n, cur) { return Number(n).toLocaleString('en-US') + ' ' + CFG.currencies[cur || 'EGP']; }
  function toast(msg) {
    var $t = $('#toast');
    if (!$t.length) $t = $('<div id="toast" class="toast"></div>').appendTo('body');
    $t.text(msg).addClass('show');
    clearTimeout($t.data('t'));
    $t.data('t', setTimeout(function () { $t.removeClass('show'); }, 2200));
  }

  return { plans: CFG.plans, templates: CFG.templates, currencies: CFG.currencies, gatewayNames: CFG.gateways, shipping: CFG.shipping, pluginList: CFG.plugins, api: api, firstError: firstError, money: money, toast: toast };
})(jQuery);
