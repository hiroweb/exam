jQuery(document).ready( function() {
    jQuery( "#textsizer a" ).textresizer({
        target: "#contents",                       // �Ώۗv�f
        type: "fontSize",                        // �T�C�Y�w����@
        sizes: [ "22px", "14px"],                  // �t�H���g�T�C�Y
        selectedIndex: 2                           // �����\��
    });
});


$(function(){
	var setImg = '#viewer';
	var fadeSpeed = 1500;
	var switchDelay = 5000;

	$(setImg).children('img').css({opacity:'0'});
	$(setImg + ' img:first').stop().animate({opacity:'1',zIndex:'20'},fadeSpeed);

	setInterval(function(){
		$(setImg + ' :first-child').animate({opacity:'0'},fadeSpeed).next('img').animate({opacity:'1'},fadeSpeed).end().appendTo(setImg);
	},switchDelay);
});

$(document).ready(function($){

	$('#mega-1').dcVerticalMegaMenu({
		rowItems: '3',
		speed: 'fast',
		effect: 'show',
		direction: 'right'
	});
	$('#mega-2').dcVerticalMegaMenu({
		rowItems: '3',
		speed: 'slow',
		effect: 'fade',
		direction: 'left'
	});
	$('#mega-3').dcVerticalMegaMenu({
		rowItems: '4',
		speed: 'slow',
		effect: 'slide',
		direction: 'right'
	});
	$('#mega-4').dcVerticalMegaMenu({
		rowItems: '3',
		speed: 'fast',
		effect: 'slide',
		direction: 'left'
	});

});