/*
苗字と名前をデータベースから探し、選択画面で選択。
@param param array 性・名（ひらがな）
@param person kojin,mosyu,renraku
 */

function IDF_ref_btn(person){

	$('#IDF_' + person + '_cancel_btn').on('click',function(){

		$('input[name="IDF_' + person + '_sei_kj"]').val('');
		$('input[name="IDF_' + person + '_mei_kj"]').val('');
		$('input[name="IDF_' + person + '_sei_kn"]').val('');
		$('input[name="IDF_' + person + '_mei_kn"]').val('');
		$('input[name="IDF_' + person + '_sex"]').val([0]);
		$('input[name="IDF_' + person + '_postal"]').val('');
		$('input[name="IDF_' + person + '_prefecture"]').val('');
		$('input[name="IDF_' + person + '_city"]').val('');
		$('input[name="IDF_' + person + '_address"]').val('');
		$('input[name="IDF_' + person + '_bld"]').val('');
		$('span.' + person + '_PSN').text('新規登録');
		$('span.' + person + '_PSN').css('color','#990000');

	});

		$('#IDF_' + person + '_ref_btn').on('click',function(){


		var ref_sei=$('input[name="IDF_' + person + '_sei_kn"]').val();
		var ref_mei=$('input[name="IDF_' + person + '_mei_kn"]').val();
		var param ={
			"ref_sei":ref_sei,
			"ref_mei":ref_mei
		};


			$('#layer').fadeIn();

		console.log(param);
		$.ajax({
			type:"post",
			url:"identifyPersons_ajax.php",
			data:JSON.stringify(param),
			dataType:"jsonp",
			scriptCharset:"utf-8"
		}).done(function(data){

    if(data == null) {

        content=$('.psn_table');
        content.html('<tr><th>名前</th><th>ふりがな</th><th>生年月日</th><th>住所</th><th style="white-space:nowrap;"><input type="button" class="red layer_close" value="キャンセル"></th></tr><tr><td colspan="5">データは見つかりませんでした。</td></tr></table>');
	
		$('.layer_close').on('click',function(){
			$('#layer').hide(500);
			return false;
		});

    }else{
			var trans ={
			'kojin':'故人',
			'mosyu':'喪主',
			'renraku':'連絡先'
			};

        content=$('.psn_table');
        content.html('<thead class="psn_header"><tr><th>名前</th><th>ふりがな</th><th>生年月日</th><th>住所</th><th style="white-space:nowrap;"><input type="button" class="green IDF_nobody" value="候補者なし"></th></tr><thead>');
  

  		for (var i =0; i<data.length; i++) 
            {
            	blank="'_blank'";
            	url = "'personManage_pre.php?person_NO="+data[i].person_NO+"'";
        	content.append('<tr data-id="'+data[i].person_NO+'"><td>' + data[i].PSN_sei_kj + data[i].PSN_mei_kj + data[i].member_img + '</td><td>'+data[i].PSN_sei_kn + data[i].PSN_mei_kn + '</td><td>' + data[i].PSN_birthday +'</td><td>' + data[i].PSN_prefecture + data[i].PSN_city + data[i].PSN_address + data[i].PSN_bld + '</td><td><input type="button" class="blue IDF_select" data-key="'+i+'" value="'+ trans[person] +'へ登録">&nbsp;&nbsp;<input type="button" class="gray" value="詳細" onclick="window.open('+url+','+blank+')"></td></tr>');
		}

		$('.IDF_select').on('click',function(){
			var key = $(this).data('key');
console.log(data[key]);
	$('input[name="IDF_' + person + '_sei_kj"]').val(data[key]['PSN_sei_kj']);
	$('input[name="IDF_' + person + '_mei_kj"]').val(data[key]['PSN_mei_kj']);
	$('input[name="IDF_' + person + '_sei_kn"]').val(data[key]['PSN_sei_kn']);
	$('input[name="IDF_' + person + '_mei_kn"]').val(data[key]['PSN_mei_kn']);
	$('input[name="IDF_' + person + '_sex"]').val([data[key]['PSN_sex']]);
	$('input[name="IDF_' + person + '_postal"]').val([data[key]['PSN_postal']]);
	$('input[name="IDF_' + person + '_prefecture"]').val([data[key]['PSN_prefecture']]);
	$('input[name="IDF_' + person + '_city"]').val([data[key]['PSN_city']]);
	$('input[name="IDF_' + person + '_address"]').val([data[key]['PSN_address']]);
	$('input[name="IDF_' + person + '_bld"]').val([data[key]['PSN_bld']]);

	$('select#gengo_' + person + '').val('w');
	$('select#IDF_' + person + '_birthdayY').val(data[key]['Y']);
	$('select#IDF_' + person + '_birthdayM').val(data[key]['M']);
	$('select#IDF_' + person + '_birthdayD').val(data[key]['D']);


	$('input[name="IDF_' + person + '_phone"]').val([data[key]['PSN_phone']]);
	$('input[name="IDF_' + person + '_fax"]').val([data[key]['PSN_fax']]);
	$('input[name="IDF_' + person + '_mobile"]').val([data[key]['PSN_mobile']]);
	$('input[name="IDF_' + person + '_email"]').val([data[key]['PSN_email']]);



	$('span.' + person + '_PSN').html(data[key]['person_NO'] + data[key]['member_text']);
	$('span.' + person + '_PSN').css('color','#990000');



	if(data[key]['Y']=='0000'){
		$('span.birth_' + person + '_none').html('<br>生年月日が未登録でした。');
	}else{
		$('span.birth_' + person + '_none').html('');

	}

	$('#layer').fadeOut();
		});

	$('.IDF_nobody').on('click',function(){
	// $('input[name="IDF_' + person + '_sei_kj"]').val('');
	// $('input[name="IDF_' + person + '_mei_kj"]').val('');
	// $('input[name="IDF_' + person + '_sei_kn"]').val('');
	// $('input[name="IDF_' + person + '_mei_kn"]').val('');
	// $('input[name="IDF_' + person + '_sex"]').val([0]);
	// $('input[name="IDF_' + person + '_postal"]').val('');
	// $('input[name="IDF_' + person + '_prefecture"]').val('');
	// $('input[name="IDF_' + person + '_city"]').val('');
	// $('input[name="IDF_' + person + '_address"]').val('');
	// $('input[name="IDF_' + person + '_bld"]').val('');
	$('span.' + person + '_PSN').text('新規登録');
	$('span.' + person + '_PSN').css('color','#990000');
//	$('span.birth_none').html('');
	$('#layer').fadeOut();
		});

		$('.layer_close').on('click',function(){
			$('#layer').fadeOut();
			return false;
		});
}
		}).fail(function(XMLHttpRequest, textStatus, errorThrown){
	      });
	});
}





function botsu_message(trigger){

	$(trigger).on('change',function(){
		reiwa = $(this).val();
		ty = parseInt(reiwa) + 2018;

//		console.log(year);
	var botsu_msg = '令和' + reiwa + '年は、西暦' + ty + '年です。';

	$('span.botsu_msg').html(botsu_msg);


	});




}


/*
年齢を算出
@param y1~d1 没年月日
@param y2~d2 生年月日
 */

    function botuAge(y1,m1,d1,y2,m2,d2) 
    {
	//没年月日
	y1=parseInt(y1) + 2018;
  	var botuday  = new Date(y1, m1-1, d1);
	//誕生年月日
  	var birthday  = new Date(y2, m2-1, d2);
  	//今日
  	var today = new Date();
	//今年の誕生日
	var thisYearBirthday =
	    new Date(today.getFullYear(), birthday.getMonth(), birthday.getDate());  
	//今年-誕生年
	var age = botuday.getFullYear() - birthday.getFullYear();
	// 今年の誕生日を迎えていなければage-1を返す
	return (botuday < thisYearBirthday)?age-1:age;

    }


/*
年齢を算出
@param y1~d1 没年月日
@param y2~d2 生年月日
 */

    function getAge(y,m,d) 
    {
	//誕生年月日
  	var birthday  = new Date(y, m-1, d);
  	//今日
  	var today = new Date();
	//今年の誕生日
	var thisYearBirthday =
	    new Date(today.getFullYear(), birthday.getMonth(), birthday.getDate());  
	//今年-誕生年
	var age = today.getFullYear() - birthday.getFullYear();
	// 今年の誕生日を迎えていなければage-1を返す
	return (today < thisYearBirthday)?age-1:age;

    }




/*
郵便番号がなければハイフンを挿入
@param postal 2770845
@return 277-0845
 */

function post_insHyphen(postal){
		if(postal.match('-')){
			result=postal;
		}else{
			postal_a=postal.slice(0,3);
			postal_b='-';
			postal_c=postal.slice(3);
			postal=postal_a + postal_b + postal_c;
			result=postal;
		}
		return result;
}

function only_en(id){
	$(id).on('input',function(){

	  	var str=$(this).val();
    	while(str.match(/[^A-Z^a-z\d\-]/))
    {
        str=str.replace(/[^A-Z^a-z\d\-]/,"");
    }
    	$(this).val(str);

	});
}

/*
1から2へ住所をコピー
@param id クリックするボタン
@param p1 人１
@param p2 人２
 */

function copy_address(id,p1,p2){

$(id).on('click',function(){

		ad01=$('input[name="IDF_' + p1 + '_postal"]').val();
		ad02=$('input[name="IDF_' + p1 + '_prefecture"]').val();
		ad03=$('input[name="IDF_' + p1 + '_city"]').val();
		ad04=$('input[name="IDF_' + p1 + '_address"]').val();
		ad05=$('input[name="IDF_' + p1 + '_bld"]').val();

		$('input[name="IDF_' + p2 + '_postal"]').val(ad01);
		$('input[name="IDF_' + p2 + '_prefecture"]').val(ad02);
		$('input[name="IDF_' + p2 + '_city"]').val(ad03);
		$('input[name="IDF_' + p2 + '_address"]').val(ad04);
		$('input[name="IDF_' + p2 + '_bld"]').val(ad05);

});
}

/*
訃報紙のご遠慮文章作成

 */

function huhou_accept_text(){

attendance=$('input[name="IDF_attendance"]');
obituary=$('input[name="IDF_obituary"]');
donation=$('input[name="IDF_donation"]');
sougi='葬儀は故人の遺志並びに遺族の希望によりまして家族葬にて執り行います';
var ac1='会葬の儀';
var ac2='寄贈品';
var ac3='御厚志';
sougi2='大変恐縮ではございますが、' + ac1 + ac2 + ac3 + 'はご辞退申し上げます';
	$('input[name="IDF_attendance"],input[name="IDF_donation"],input[name="IDF_obituary"]').on('change',function(){
		v1=$('input[name="IDF_attendance"]:checked').val();
		v2=$('input[name="IDF_donation"]:checked').val();
		v3=$('input[name="IDF_obituary"]:checked').val();

		if(v1=='1'&&v2=='1'&v3=='1'){
			$('input[name="IDF_huhou_text03"]').val('');
		}

			if(v1!='0'&&v2!='0'&&v3!='0'){
			sougi='';
			sougi2='';
			}
			if(v1=='0'&&v2!='0'&&v3!='0'){
	sougi='葬儀は故人の遺志並びに遺族の希望によりまして家族葬にて執り行います';
	sougi2='大変恐縮ではございますが、会葬の儀はご辞退申し上げます';
			}
			if(v2=='0'&&v1!='0'&&v3!='0'){
	sougi='葬儀は故人の遺志並びに遺族の希望によりまして家族葬にて執り行います';
	sougi2='大変恐縮ではございますが、寄贈品はご辞退申し上げます';
			}
			if(v3=='0'&&v1!='0'&&v2!='0'){
	sougi='葬儀は故人の遺志並びに遺族の希望によりまして家族葬にて執り行います';
	sougi2='大変恐縮ではございますが、御厚志はご辞退申し上げます';
			}
			if(v1=='0'&&v2=='0'&&v3!='0'){
	sougi='葬儀は故人の遺志並びに遺族の希望によりまして家族葬にて執り行います';
	sougi2='大変恐縮ではございますが、会葬の儀、寄贈品はご辞退申し上げます';
			}
			if(v1=='0'&&v3=='0'&&v2!='0'){
	sougi='葬儀は故人の遺志並びに遺族の希望によりまして家族葬にて執り行います';
	sougi2='大変恐縮ではございますが、会葬の儀、御厚志はご辞退申し上げます';
			}
			if(v2=='0'&&v3=='0'&&v1!='0'){
	sougi='葬儀は故人の遺志並びに遺族の希望によりまして家族葬にて執り行います';
	sougi2='大変恐縮ではございますが、寄贈品、御厚志はご辞退申し上げます';
			}
			if(v1=='0'&&v2=='0'&&v3=='0'){
	sougi='葬儀は故人の遺志並びに遺族の希望によりまして家族葬にて執り行います';
	sougi2='大変恐縮ではございますが、会葬の儀、寄贈品、御厚志はご辞退申し上げます';
			}
			$('input[name="IDF_huhou_text03"]').val(sougi);
			$('input[name="IDF_huhou_text04"]').val(sougi2);

	});
}