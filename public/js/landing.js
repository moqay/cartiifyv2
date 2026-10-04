$(function () {
  $('a[href^="#"]').on('click', function (e) {
    var $t = $($(this).attr('href'));
    if (!$t.length) return;
    e.preventDefault();
    $('html, body').animate({ scrollTop: $t.offset().top - 70 }, 400);
  });

  $(window).on('scroll', function () { $('.lp-nav').toggleClass('scrolled', $(this).scrollTop() > 10); });

  $('#claim-in').on('input', function () { $(this).val($(this).val().toLowerCase().replace(/[^a-z0-9-]/g, '')); });

  $('#billing').on('click', 'button', function () {
    var m = parseFloat($(this).data('m'));
    $('#billing button').removeClass('on'); $(this).addClass('on');
    $('.lp-price b').each(function () { $(this).text(Math.round($(this).data('base') * m)); });
  });

  $('.lp-faq').on('click', '.q button', function () {
    var $q = $(this).closest('.q'), open = $q.hasClass('open');
    $('.lp-faq .q').removeClass('open').find('p').slideUp(150);
    if (!open) { $q.addClass('open').find('p').slideDown(150); }
  });

  var io = 'IntersectionObserver' in window && new IntersectionObserver(function (en) {
    en.forEach(function (x) { if (x.isIntersecting) { $(x.target).addClass('in'); io.unobserve(x.target); } });
  }, { threshold: .12 });
  if (io) $('.lp-b, .lp-show, .lp-steps li, .lp-plan, .lp-num-grid div').addClass('rv').each(function () { io.observe(this); });
});
