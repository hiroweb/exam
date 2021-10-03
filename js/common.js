$(document).ready(function(){
	/* テキスト ガイド(初期) */
	$('input[type=text],input[type=email]').each(function(){
		var title = $(this).attr('title');
		if(title && !$(this).val()){
console.log('GGGGGGGGGGGGGGG');
			$(this).val(title);
			$(this).css('color','#aaa');
		}
	});
	/* テキスト ガイド(フォーカス時) */
	$('input[type=text],input[type=email]').focus(function(){
		var title = $(this).attr('title');
		if($(this).val()==title){
			$(this).val('');
			$(this).css('color','');
		}
	});
	/* テキスト ガイド(脱フォーカス時) */
	$('input[type=text],input[type=email]').blur(function(){
		var title = $(this).attr('title');
		if(title && !$(this).val()){
console.log('SSSSSSSSSSSSSSSS');
			$(this).val(title);
			$(this).css('color','#aaa');
		}
	});
});

/* テキスト ガイド(送信時) */
function inputGuide() {
	$('input[type=text],input[type=email]').each(function(){
		var title = $(this).attr('title');
		if($(this).val()==title){
			$(this).val('');
		}
	});
}

/* 年月日の年selectセット */
function setYears(OBJname,YearFrom,YearTo) {
	var OBJ = $(OBJname + 'Y'); 
	for (var i=YearFrom; i>=YearTo; i--) {
		OBJ.append('<option value="' + i + '">' + i + '</option>');
	}
}

/* 年月日の月selectセット */
function setMonthes(OBJname) {
	var OBJ = $(OBJname + 'M'); 
	var from = 1;
	var to = 12;
	for (var i=from; i<=to; i++) {
		value = i + 100;
		value=value.toString().substr(1,2);
		OBJ.append('<option value="' + value + '">' + value + '</option>');
	}
}

/* 年月日の日selectセット */
function setDays(OBJname) {
	var OBJy = $(OBJname + 'Y')
	var OBJm = $(OBJname + 'M')
	var OBJd = $(OBJname + 'D')
	var from = 1;
	switch (OBJm.val()){
		case '02':
			if (isLeapYear(OBJy.val())) {
				var to = 29;
			}else{
				var to = 28;
			}
			break; 
		case '04':
			var to = 30;
			break; 
		case '06':
			var to = 30;
			break; 
		case '09':
			var to = 30;
			break; 
		case '11':
			var to = 30;
			break; 
		default:
			var to = 31;
			break; 
	}
	var sv_d = OBJd.val();
	OBJd.empty();
	OBJd.append('<option value="' + value + '">日</option>');
	for (var i=from; i<=to; i++) {
		value = i + 100;
		value = value.toString().substr(1,2);
		if (value == sv_d) {
			OBJd.append('<option value="' + value + '" selected>' + value + '</option>');
		}else{
			OBJd.append('<option value="' + value + '">' + value + '</option>');
		}
	}
}

/* 閏年判定 */
function isLeapYear(y) {
	return !(y % 4) && (y % 100) || !(y % 400) ? true : false;
}

/* 郵便番号から住所セット */
function setByPostal(postalL,postalR,OBJp,OBJc,OBJa,OBJs) {
	if ((numericCheck(postalL,3))&&(numericCheck(postalR,4))) {
		$.ajax({
			type: 'GET',
			url: 'https://maps.googleapis.com/maps/api/geocode/json',
			crossDomain: true,
			dataType: 'json',
			data : {
				address : postalL + postalR,
				language : 'ja',
				sensor : false
			},
			success: function(json) {
				if(json.status == "OK"){
					obj = json.results[0].address_components;
					OBJp.val(obj[3].long_name);
					OBJc.val(obj[2].long_name);
					OBJa.val(obj[1].long_name);
					if (OBJs) {OBJs.val(obj[1].long_name);}
					setCity(OBJc,obj[3].long_name,obj[2].long_name);
					OBJa.css('color','');
					OBJp.selectmenu('refresh');
				}else{
					alert('郵便番号を正しく入力してください。');
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				alert('Error : ' + errorThrown);
			}
		});
	}else{
		alert('郵便番号が正しくありません');
	}
}

/* 市区町村selectセット */
function setCity(selectOBJ,prefecture,selectedVal) {
	var CB = 'city';
	$.ajax({
		type: 'GET',
		url: 'https://geoapi.heartrails.com/api/json?method=getCities&prefecture=' + prefecture + '&jsonp=' + CB,
		dataType: 'jsonp',
		jsonpCallback: CB,
		success: function(json) {
			selectOBJ.empty();
			selectOBJ.append('<option value="">市区町村</option>');
			for(var key in json['response']['location']){
				if (json['response']['location'][key]['city'] == selectedVal) {
					selectOBJ.append('<option value="' + json['response']['location'][key]['city'] + '" selected>' + json['response']['location'][key]['city'] + '</option>');
				}else{
					selectOBJ.append('<option value="' + json['response']['location'][key]['city'] + '">' + json['response']['location'][key]['city'] + '</option>');
				}
			}
			if (typeof selectOBJ.selectmenu=='function') {	//jQuery Mobile 対策
				selectOBJ.val(selectedVal);
				selectOBJ.selectmenu('refresh');
			}
		}
	});
}

/* 数字＆桁数チェック */
function numericCheck(num,len) {
	if (num == parseInt(num)){
		if (num.length == len) {
    		return true;
		}else{
			return false;
		}
	}else{
    	return false;
	}
}

/* 区切り文字で分割 */
function string2array(OBJname,delimiter) {
	var str = $('#' + OBJname).val().split(delimiter);
	$.each(str, function(i, v) {
		$('.' + OBJname).eq(i).val(v);
	});
}

/* 区切り文字で連結 */
function array2string(OBJname,delimiter) {
	var check = new Array();
	$.each($('.' + OBJname), function(i, v) {
		if ($(this).prop('type') == 'checkbox') {
			if ($(this).prop('checked')) {
				check[i] = $(this).val();
			}else{
				check[i] = '';
			}
		}else{
			if ($(this).val()) {
				check[i] = $(this).val();
			}
		}
	});
	if (check.length) {
		$('#' + OBJname).val(check.join(delimiter));
	}else{
		$('#' + OBJname).val('');
	}
}

/* ページングボタンコントロール */
function pagingBtnControl(end) {
	if ($('#page').val()==0) {
		$('#btnTop').prop('disabled',true);
		$('#btnPrev').prop('disabled',true);
	}
	if ($('#page').val()==end) {
		$('#btnEnd').prop('disabled',true);
		$('#btnNext').prop('disabled',true);
	}
}

/* タイムスライダー */
//var initOpenTime;

function timeSlider(slider,span,inOBJ,funcName,outOBJ1,outOBJ2,outOBJ3,outOBJ4) {
	var str = inOBJ.val().split(':');
	step = 1410 / span;
	initOpenTime = ((parseInt(str[0]) * 60 + parseInt(str[1])) / span) / step;
	new Dragdealer(slider,{
		x: initOpenTime,
		slide: false,
		snap: true,
		steps: step + 1,
		animationCallback: function(x, y) {
			sliderOBJ = '#' + slider;
			t = Math.round(x * step * span);
			if (t < 0) {
				$(sliderOBJ).children('.handle').html('指定しない');
			}else{
				h = Math.floor(t / 60);
				m = t % 60;
				if (m == 0) {m = '00';}
//				$('#time').html(h + ':' + m);
				$(sliderOBJ).children('.handle').html(h + ':' + m);
			}
		},
		dragStopCallback: function(x,y) {
			sliderOBJ = '#' + slider;
			if ($(sliderOBJ).children('.handle').html()=='指定しない') {
				outOBJ1.val('');
				if (outOBJ2) {outOBJ2.val('');}
				if (outOBJ3) {outOBJ3.val('');}
				if (outOBJ4) {outOBJ4.val('');}
			}else{
//				time = $('#time').html();
				time = $(sliderOBJ).children('.handle').html();
				if(time.length < 5) {time = '0' + time;}
				outOBJ1.val(time);
				if (outOBJ2) {outOBJ2.val(time);}
				if (outOBJ3) {outOBJ3.val(time);}
				if (outOBJ4) {outOBJ4.val(time);}
			}
			if (funcName) {
				strngCall = "return " + funcName + "()";
				f = new Function(strngCall);
				f();
			}
		}
	});
}

function textboxGuide(OBJ) {
	var key = OBJ.attr('id'); 
	if (OBJ.val() == '') {
		OBJ.css('color',gid_color).val(gid_words[key]);
		return;
	}
	if (OBJ.val() == gid_words[key]) {
		OBJ.css('color',nomalTXT).val('');
		return;
	}
}

/* 背景色に対して文字色を自動判定 */

function blackOrWhite ( hexcolor ) {
	var r = parseInt( hexcolor.substr( 1, 2 ), 16 ) ;
	var g = parseInt( hexcolor.substr( 3, 2 ), 16 ) ;
	var b = parseInt( hexcolor.substr( 5, 2 ), 16 ) ;

	return ( ( ( (r * 299) + (g * 587) + (b * 114) ) / 1000 ) < 128 ) ? "#ffffff" : "#000000" ;
}

/* rgb(255,255,255) → #fffffff 変換*/
function convert16Color(color){
		color = color.replace("rgb(","");
        color = color.replace(")","");
        //文字列分割
        color = color.split(",");
        //10進数を16進数に変換して連結
        color = "#"+parseInt(color[0]).toString(16)+parseInt(color[1]).toString(16)+parseInt(color[2]).toString(16);
		return color;
}