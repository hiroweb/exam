// --------------------------------------------------
// jquery.bigthumb.js
// 2016/05/25 
// --------------------------------------------------
(function($) {
	$.fn.bigthumb = function(options){

		var defaults = {
		};
		var s = $.extend(defaults, options);
         
		// 変数設定
		var popW = '200px';
		var popH = '200px';

		// ポップアップDIV設定
		$('body').append('<div id="thumb_pop" style="position:absolute;with:' + popW + ';height:' + popH + ';"><img src=""></div>');

		// サムネイル オンマウス時
		$(this).hover(
			function(e) {
				$('#thumb_pop').stop(true,false).show();
				var img = $('#thumb_pop').children('img');
				if ($(this).attr('src') != img.attr('src')){
					$('#thumb_pop').css('left',e.pageX + s.offsetX);
					$('#thumb_pop').css('top',e.pageY + s.offsetY);
					$('#thumb_pop').css('z-index','999999');
					img.attr('src',$(this).attr('src'));
				}
			},
			function(e) {
				$('#thumb_pop').stop(true,false).hide();
			}
		);

		return(this);
	};
})(jQuery);