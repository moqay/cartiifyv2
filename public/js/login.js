$(function () {
  $('#f-login').on('submit', function (e) {
    e.preventDefault();
    var $e = $('#e-login').prop('hidden', true), $b = $(this).find('button').prop('disabled', true);
    Cartiify.api('POST', '/login', { email: $.trim($('[name=email]', this).val()), password: $('[name=password]', this).val() })
      .done(function (r) { location.href = r.redirect; })
      .fail(function (x) { $e.text(Cartiify.firstError(x).message).prop('hidden', false); $b.prop('disabled', false); });
  });
});
