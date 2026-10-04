$(function () {
  $('a[href^="#"]').on('click', function (e) {
    var $t = $($(this).attr('href'));
    if (!$t.length) return;
    e.preventDefault();
    $('html, body').animate({ scrollTop: $t.offset().top - 70 }, 400);
  });

  $('#waitlist-form').on('submit', function (e) {
    e.preventDefault();
    $(this).slideUp(150);
    $('#wl-ok').prop('hidden', false);
  });

  $(window).on('scroll', function () {
    $('.nav').toggleClass('scrolled', $(this).scrollTop() > 10);
  });
});
