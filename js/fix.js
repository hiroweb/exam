	$(function($) {
	var tab = $('.hoge'),
    offset = tab.offset();

$(window).scroll(function () {
  if($(window).scrollTop() > offset.top) {
    tab.addClass('fixed');
  } else {
    tab.removeClass('fixed');
  }
});
});