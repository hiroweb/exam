//続柄json配列


/*
苗字と名前をデータベースから探し、選択画面で選択。
@param param array 性・名（ひらがな）
@param person kojin,mosyu,renraku
 */

function PRF_clear(person){

	$(document).on('click','#PRF_' + person + '_cancel_btn',function(){
		$('input[name="PRF_' + person + '_person_NO"]').val('');
		$('input[name="PRF_' + person + '_sei_kn"]').val('');
		$('input[name="PRF_' + person + '_mei_kn"]').val('');
		$('input[name="PRF_' + person + '_sei_kj"]').val('');
		$('input[name="PRF_' + person + '_mei_kj"]').val('');
		$('input[name="PRF_' + person + '_sex"]').val([0]);
		$('input[name="PRF_' + person + '_postal"]').val('');
		$('input[name="PRF_' + person + '_prefecture"]').val('');
		$('input[name="PRF_' + person + '_city"]').val('');
		$('input[name="PRF_' + person + '_address"]').val('');
		$('input[name="PRF_' + person + '_bld"]').val('');
		$('span.' + person + '_PSN').text('新規登録');
		$('span.' + person + '_PSN').css('color','#990000');
	 	selectAddOption_per('select[name="PRF_' + person + '_zokugara"]',0,person);

	$('input[name="PRF_' + person + '_sei_kn"]').parent('td').html('<input type="text" name="PRF_' + person + '_sei_kn" value="">&nbsp;<span class="error"></span><input type="text" name="PRF_' + person + '_mei_kn" value=""><span class="error"></span>&nbsp;&nbsp;&nbsp;<input type="button" class="PRF_' + person + '_ref_btn blue" id="PRF_' + person + '_ref_btn" value="個人情報検索">&nbsp;&nbsp;&nbsp;<input type="button" class="PRF_' + person + '_cancel_btn green" id="PRF_' + person + '_cancel_btn" value="クリア">');
	$('input[name="PRF_' + person + '_sei_kj"]').parent('td').html('<input type="text" name="PRF_' + person + '_sei_kj" value="" class="gaiji">&nbsp;<input type="text" name="PRF_' + person + '_mei_kj" value="" class="gaiji">');


	});



}

/*
php関数 indi_check()で返ってきた結果で怪しい人がいる場合はレイヤー表示し、選ばせる。
新しい個人として登録→Insert
この人として登録→そのperson_NOでUpdate
@param person kojin,mosyu,renraku


 */

function PRF_duplicate_manage(person,ary){

data=ary;
console.log(ary);

			$('#layer').fadeIn();

			var trans ={
			'kojin':'故人',
			'mosyu':'喪主',
			'renraku':'連絡先',
			'irai':'ご依頼者',
			'shinpai':'ご心配な方'

			};

        content=$('.psn_table');
        content.html('<thead class="psn_header"><tr><th>名前</th><th>ふりがな</th><th>生年月日</th><th>住所</th><th style="white-space:nowrap;"><input type="button" class="green PRF_nobody" value="'+ trans[person] +'を選択内容で登録"></th></tr></thead><tr><td colspan="4">新しい'+ trans[person] +'として登録</td><td><input type="radio" name="PRF_'+person+'_person_NO" value=""></td>');
  

  		for (var i =0; i<data.length; i++) 
            {
            	blank="'_blank'";
            	url = "'personManage_pre.php?person_NO="+data[i].person_NO+"'";
        	content.append('<tr data-id="'+data[i].person_NO+'"><td>' + data[i].PSN_sei_kj + data[i].PSN_mei_kj + data[i].member_img + '</td><td>'+data[i].PSN_sei_kn + data[i].PSN_mei_kn + '</td><td>' + data[i].PSN_birthday +'</td><td>' + data[i].PSN_prefecture + data[i].PSN_city + data[i].PSN_address + data[i].PSN_bld + '</td><td><input type="radio" class="blue PRF_select" data-key="'+i+'" value="'+ trans[person] +'へ上書き"></td></tr>');
			}

		$('.PRF_select').on('click',function(){
			var key = $(this).data('key');
console.log(data[key]);
	$('input:hidden[name="PRF_' + person + '_person_NO"]').val(data[key]['person_NO']);


$('input[name="PRF_' + person + '_sei_kn"]').val(data[key]['PSN_sei_kn']);
$('input[name="PRF_' + person + '_mei_kn"]').val(data[key]['PSN_mei_kn']);
$('input[name="PRF_' + person + '_sei_kj"]').val(data[key]['PSN_sei_kj']);
$('input[name="PRF_' + person + '_mei_kj"]').val(data[key]['PSN_mei_kj']);



	$('input[name="PRF_' + person + '_sex"]').val([data[key]['PSN_sex']]);
	$('input[name="PRF_' + person + '_postal"]').val([data[key]['PSN_postal']]);
	$('input[name="PRF_' + person + '_prefecture"]').val([data[key]['PSN_prefecture']]);
	$('input[name="PRF_' + person + '_city"]').val([data[key]['PSN_city']]);
	$('input[name="PRF_' + person + '_address"]').val([data[key]['PSN_address']]);
	$('input[name="PRF_' + person + '_bld"]').val([data[key]['PSN_bld']]);


year=parseInt(data[key]['Y']);

b_ary=toWareki_y(year);

console.log(b_ary);
gengo_radio=b_ary['gengo'];
wareki_y=b_ary['year'];
	$('input[name="' + person + '_gengo"').val([gengo_radio]);
	$('input#PRF_' + person + '_birthdayY').val(wareki_y);
	$('input#PRF_' + person + '_birthdayM').val(data[key]['M']);
	$('input#PRF_' + person + '_birthdayD').val(data[key]['D']);
	var ymd=data[key]['Y']+'-'+data[key]['M']+'-'+data[key]['D'];

	$('input[name="PRF_' + person + '_birthday"]').val(ymd);

	$('input[name="PRF_' + person + '_phone"]').val([data[key]['PSN_phone']]);
	$('input[name="PRF_' + person + '_fax"]').val([data[key]['PSN_fax']]);
	$('input[name="PRF_' + person + '_mobile"]').val([data[key]['PSN_mobile']]);
	$('input[name="PRF_' + person + '_email"]').val([data[key]['PSN_email']]);

	$('span.' + person + '_PSN').html(data[key]['person_NO'] + data[key]['member_text']);
	$('span.' + person + '_PSN').css('color','#990000');


	if(data[key]['Y']=='0000'){
		$('span.birth_' + person + '_none').html('<br>生年月日が未登録でした。');
	}else{
		$('span.birth_' + person + '_none').html('');

	}

//続柄切り替え

selectAddOption_per('select[name="PRF_' + person + '_zokugara"]',data[key]['PSN_sex'],person);
	


	$('#layer').fadeOut();
		});



}
function PRF_ref_btn2(person){

	PRF_clear(person);
	$(document).on('click','#PRF_' + person + '_ref_btn',function(){
		//console.log(person);
		var PSN_sei_kn=$('input[name="PRF_' + person + '_sei_kn"]').val();
		var PSN_mei_kn=$('input[name="PRF_' + person + '_mei_kn"]').val();
		var PSN_prefecture=$('input[name="PRF_' + person + '_prefecture"]').val();

		var param ={
			"PSN_sei_kn":PSN_sei_kn,
			"PSN_mei_kn":PSN_mei_kn,
			"PSN_PSN_prefecture":PSN_prefecture
		};
		$('#layer').fadeIn();
		param['api']='searchPerson_api.php';
		console.log(param);
		ajax(param,param['api']).done(function(data){
			console.log(data);
			var LS = data.LS;
			console.log(LS);
			if(LS == null) {
				content=$('.psn_table');
				content.html('<thead class="psn_header"><tr><th>名前</th><th>ふりがな</th><th>生年月日</th><th>住所</th><th style="white-space:nowrap;"><input type="button" class="green PRF_nobody" value="戻る"></th></tr></thead><tr><td colspan="5">データは見つかりませんでした。</td></tr></table>');
				$('.layer_close').on('click',function(){
					$('#layer').hide(500);
					return false;
				});
	
				$('.PRF_nobody').on('click',function(){
				$('span.' + person + '_PSN').text('新規登録');
				$('span.' + person + '_PSN').css('color','#990000');
				$('input[name="' + person + '_nobody"]').val(1);
				$('#layer').fadeOut();
				});
			}else{
				console.log(data);
				var LS = data.LS;
				console.log(LS);
				var trans ={
				'kojin':'故人',
				'mosyu':'喪主',
				'renraku':'連絡先',
				'irai':'ご依頼者',
				'shinpai':'ご心配な方'
				};
				content=$('.psn_table');
				content.html('<thead class="psn_header"><tr><th>名前</th><th>ふりがな</th><th>生年月日</th><th>住所</th><th style="white-space:nowrap;"><input type="button" class="green PRF_nobody" value="戻る"></th></tr></thead>');
				for (var i =0; i<LS.length; i++){
					blank="'_blank'";
					url = "'personManage_pre.php?person_NO="+LS[i].person_NO+"'";
					content.append('<tr data-id="'+LS[i].person_NO+'"><td>' + LS[i].PSN_sei_kj + LS[i].PSN_mei_kj + LS[i].member_img + '</td><td>'+LS[i].PSN_sei_kn + LS[i].PSN_mei_kn + '</td><td>' + LS[i].PSN_birthday +'</td><td>' + LS[i].PSN_prefecture + LS[i].PSN_city + LS[i].PSN_address + LS[i].PSN_bld + '</td><td><input type="button" class="blue PRF_select" data-key="'+i+'" value="'+ trans[person] +'として登録">&nbsp;&nbsp;<input type="button" class="gray" value="詳細" onclick="window.open('+url+','+blank+')"></td></tr>');
				}
	
				$('.PRF_select').on('click',function(){
					var key = $(this).data('key');
					console.log(key);
					console.log(LS[key]);
					$('input:hidden[name="PRF_' + person + '_person_NO"]').val(LS[key]['person_NO']);
					$('input[name="PRF_' + person + '_mei_kn"]').attr('type', 'hidden');
					$('input[name="PRF_' + person + '_mei_kj"]').attr('type', 'hidden');
					$('.PRF_' + person + '_ref_btn').css('display','none');
					$('input[name="PRF_' + person + '_sei_kn"]').after('&nbsp;&nbsp;' + LS[key]['PSN_mei_kn']);
					$('input[name="PRF_' + person + '_sei_kj"]').after('&nbsp;&nbsp;' + LS[key]['PSN_mei_kj']);
					$('input[name="PRF_' + person + '_sei_kn"]').val(LS[key]['PSN_sei_kn']);
					$('input[name="PRF_' + person + '_mei_kn"]').val(LS[key]['PSN_mei_kn']);
					$('input[name="PRF_' + person + '_sei_kj"]').val(LS[key]['PSN_sei_kj']);
					$('input[name="PRF_' + person + '_mei_kj"]').val(LS[key]['PSN_mei_kj']);
					$('input[name="PRF_' + person + '_sex"]').val([LS[key]['PSN_sex']]);
					$('input[name="PRF_' + person + '_postal"]').val([LS[key]['PSN_postal']]);
					$('input[name="PRF_' + person + '_prefecture"]').val([LS[key]['PSN_prefecture']]);
					$('input[name="PRF_' + person + '_city"]').val([LS[key]['PSN_city']]);
					$('input[name="PRF_' + person + '_address"]').val([LS[key]['PSN_address']]		);
					$('input[name="PRF_' + person + '_bld"]').val([LS[key]['PSN_bld']]);
					year=parseInt(LS[key]['Y']);
					b_ary=toWareki_y(year);
					console.log(b_ary);
					gengo_radio=b_ary['gengo'];
					wareki_y=b_ary['year'];
					$('input[name="' + person + '_gengo"').val([gengo_radio]);
					$('input#PRF_' + person + '_birthdayY').val(wareki_y);
					$('input#PRF_' + person + '_birthdayM').val(LS[key]['M']);
					$('input#PRF_' + person + '_birthdayD').val(LS[key]['D']);
					var ymd=LS[key]['Y']+'-'+LS[key]['M']+'-'+LS[key]['D'];
					$('input[name="PRF_' + person + '_birthday"]').val(ymd);
					$('input[name="PRF_' + person + '_phone"]').val([LS[key]['PSN_phone']]);
					$('input[name="PRF_' + person + '_fax"]').val([LS[key]['PSN_fax']]);
					$('input[name="PRF_' + person + '_mobile"]').val([LS[key]['PSN_mobile']]);
					$('input[name="PRF_' + person + '_email"]').val([LS[key]['PSN_email']]);
					$('span.' + person + '_PSN').html(LS[key]['person_NO'] + LS[key]['member_text']);
					$('span.' + person + '_PSN').css('color','#990000');
						if(LS[key]['Y']=='0000'){
						$('span.birth_' + person + '_none').html('<br>生年月日が未登録でした。');
					}else{
						$('span.birth_' + person + '_none').html('');
					}
						//続柄切り替え
					selectAddOption_per('select[name="PRF_' + person + '_zokugara"]',LS[key]['PSN_sex'],person);
					$('#layer').fadeOut();
				});
	
				//元に戻すボタン
				$('.PRF_nobody').on('click',function(){
					$('span.' + person + '_PSN').text('新規登録');
					$('span.' + person + '_PSN').css('color','#990000');
					$('input[name="' + person + '_nobody"]').val(1);
					$('#layer').fadeOut();
				});
				$('.layer_close').on('click',function(){
					$('#layer').fadeOut();
					return false;
				});
			}
		}).fail(function(data){
			console.log(data);
		})
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
没年齢を算出
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
現在の年齢を算出
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

/*
半角英文字以外入力不可
@param id セレクタ名
 */

function only_en(id){
	$(id).on('input',function(){

	  	var str=$(this).val();
    	while(str.match(/[^A-Z^a-z^@\d\-]/))
    {
        str=str.replace(/[^A-Z^a-z^@\d\-]/,"");
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

		ad01=$('input[name="PRF_' + p1 + '_postal"]').val();
		ad02=$('input[name="PRF_' + p1 + '_prefecture"]').val();
		ad03=$('input[name="PRF_' + p1 + '_city"]').val();
		ad04=$('input[name="PRF_' + p1 + '_address"]').val();
		ad05=$('input[name="PRF_' + p1 + '_bld"]').val();

		$('input[name="PRF_' + p2 + '_postal"]').val(ad01);
		$('input[name="PRF_' + p2 + '_prefecture"]').val(ad02);
		$('input[name="PRF_' + p2 + '_city"]').val(ad03);
		$('input[name="PRF_' + p2 + '_address"]').val(ad04);
		$('input[name="PRF_' + p2 + '_bld"]').val(ad05);

});
}

/*
訃報紙のご遠慮文章作成

 */

function huhou_accept_text(){

	$('input[name="PRF_attendance"],input[name="PRF_donation"],input[name="PRF_obituary"],input[name="PRF_huhou_reason"]').on('change',function(){

		v1=$('input[name="PRF_attendance"]:checked').val();
		v2=$('input[name="PRF_donation"]:checked').val();
		v3=$('input[name="PRF_obituary"]:checked').val();
		v4=$('input[name="PRF_huhou_reason"]:checked').val();

// console.log(v1);
// console.log(v2);
// console.log(v3);
// console.log(v4);

		if(v1=='1'&&v2=='1'&v3=='1'){
			$('input[name="PRF_huhou_text03"]').val('');
		}

			if(v1!='0'&&v2!='0'&&v3!='0'){
			sougi='';
			sougi2='';
			}

			if(v1=='0'&&v2!='0'&&v3!='0'&&v4=='1'){
//				console.log(222);
	sougi='葬儀は故人の遺志並びに遺族の希望によりまして家族葬にて執り行います';
	sougi2='大変恐縮ではございますが、会葬の儀はご辞退申し上げます';
			}

			if(v2=='0'&&v1!='0'&&v3!='0'&&v4=='1'){
	sougi='葬儀は故人の遺志並びに遺族の希望によりまして家族葬にて執り行います';
	sougi2='大変恐縮ではございますが、寄贈品はご辞退申し上げます';
			}
			if(v3=='0'&&v1!='0'&&v2!='0'&&v4=='1'){
	sougi='葬儀は故人の遺志並びに遺族の希望によりまして家族葬にて執り行います';
	sougi2='大変恐縮ではございますが、御厚志はご辞退申し上げます';
			}
			if(v1=='0'&&v2=='0'&&v3!='0'&&v4=='1'){
	sougi='葬儀は故人の遺志並びに遺族の希望によりまして家族葬にて執り行います';
	sougi2='大変恐縮ではございますが、会葬の儀、寄贈品はご辞退申し上げます';
			}
			if(v1=='0'&&v3=='0'&&v2!='0'&&v4=='1'){
	sougi='葬儀は故人の遺志並びに遺族の希望によりまして家族葬にて執り行います';
	sougi2='大変恐縮ではございますが、会葬の儀、御厚志はご辞退申し上げます';
			}
			if(v2=='0'&&v3=='0'&&v1!='0'&&v4=='1'){
	sougi='葬儀は故人の遺志並びに遺族の希望によりまして家族葬にて執り行います';
	sougi2='大変恐縮ではございますが、寄贈品、御厚志はご辞退申し上げます';
			}
			if(v1=='0'&&v2=='0'&&v3=='0'&&v4=='1'){
	sougi='葬儀は故人の遺志並びに遺族の希望によりまして家族葬にて執り行います';
	sougi2='大変恐縮ではございますが、会葬の儀、寄贈品、御厚志はご辞退申し上げます';
			}

			if(v1=='0'&&v2!='0'&&v3!='0'&&v4=='2'){
	sougi='昨今の状況下を鑑みて、誠に勝手ながら葬儀は家族葬にて執り行います';
	sougi2='大変恐縮ではございますが、会葬の儀はご辞退申し上げます';
			}
			if(v2=='0'&&v1!='0'&&v3!='0'&&v4=='2'){
	sougi='昨今の状況下を鑑みて、誠に勝手ながら葬儀は家族葬にて執り行います';
	sougi2='大変恐縮ではございますが、寄贈品はご辞退申し上げます';
			}
			if(v3=='0'&&v1!='0'&&v2!='0'&&v4=='2'){
	sougi='昨今の状況下を鑑みて、誠に勝手ながら葬儀は家族葬にて執り行います';
	sougi2='大変恐縮ではございますが、御厚志はご辞退申し上げます';
			}
			if(v1=='0'&&v2=='0'&&v3!='0'&&v4=='2'){
	sougi='昨今の状況下を鑑みて、誠に勝手ながら葬儀は家族葬にて執り行います';
	sougi2='大変恐縮ではございますが、会葬の儀、寄贈品はご辞退申し上げます';
			}
			if(v1=='0'&&v3=='0'&&v2!='0'&&v4=='2'){
	sougi='昨今の状況下を鑑みて、誠に勝手ながら葬儀は家族葬にて執り行います';
	sougi2='大変恐縮ではございますが、会葬の儀、御厚志はご辞退申し上げます';
			}
			if(v2=='0'&&v3=='0'&&v1!='0'&&v4=='2'){
	sougi='昨今の状況下を鑑みて、誠に勝手ながら葬儀は家族葬にて執り行います';
	sougi2='大変恐縮ではございますが、寄贈品、御厚志はご辞退申し上げます';
			}
			if(v1=='0'&&v2=='0'&&v3=='0'&&v4=='2'){
	sougi='昨今の状況下を鑑みて、誠に勝手ながら葬儀は家族葬にて執り行います';
	sougi2='大変恐縮ではございますが、会葬の儀、寄贈品、御厚志はご辞退申し上げます';
			}

			$('input[name="PRF_huhou_text03"]').val(sougi);
			$('input[name="PRF_huhou_text04"]').val(sougi2);

	});
}


/*
selectタグに生年月日の和暦選択肢を挿入
@param val 	明治（M）
			大正（T）
			昭和（S）
			平成（H）
			令和（R）
@param name 挿入するselectタグのクラス名
 */
var JStoAD=gengo;

function selectDate(val,name){
	$(name).html('');
	$.each(JStoAD[val],function(k,v){
		$(name).append('<option value="' + v + '">' + k + '</option>');
	});
    }


/*selectタグに配列内容をoptionを挿入
@param name selectタグのセレクタ
@param ary 配列
*/

function selectAddOption(name,ary){
	$(name).empty();
//	$(name).append('<option value="">選択してください</option>');
		$.each(ary,function(k, v){
  	option = '<option value="' + k + '">' + v + '</option>';
    $(name).append(option);
	});
}


/*selectタグに配列内容をoptionを挿入
@param name selectタグのセレクタ
@param ary 配列
@val 1・・・喪主から　2・・・故人から　3…連絡先から
*/

function selectAddOption_per(name,sex,val){
	if(val=="shinpai"){
		per1='ご依頼者';
		per2='ご心配な方';
		zok=zok_PSN[sex];
	}
	else if(val=="irai"){
		per1='ご心配な方';
		per2='ご依頼者';
		zok=zok_PSN[sex];
	}
//		console.log(zok);
	$(name).empty();
	$(name).append('<option value="">'+per1+'から見た'+per2+'の続柄</option>');
	console.log(zok);
	for (var i = 0; i < zok.length; i++) {
		$.each(zok[i],function(k, v){
  		option = '<option value="' + k + '">' + v + '</option>';
    	$(name).append(option);
		});

//	console.log(zok[i]);
	}
}


function selectAddOption_mosyu(name,ary){
	$(name).empty();
	$(name).append('<option value="">故人から見た喪主の続柄</option>');
		$.each(ary,function(k, v){
  	option = '<option value="' + k + '">' + v + '</option>';
    $(name).append(option);
	});
}

function selectAddOption_renraku(name,ary){
	$(name).empty();
	$(name).append('<option value="">故人から見た連絡先の続柄</option>');
		$.each(ary,function(k, v){
  	option = '<option value="' + k + '">' + v + '</option>';
    $(name).append(option);
	});
}

/*生年月日のinput hidden に年月日を連結してセットする*/
function birth_set(person){
if(y && m && d){

var	g = $('input[name="'+person+'_gengo"]:checked').val();
var	y = $('#PRF_' + person + '_birthdayY').val();
var	m = $('#PRF_' + person + '_birthdayM').val();
var	d = $('#PRF_' + person + '_birthdayD').val();

var y=toSeireki[g][y];
//console.log(y);

	ymd=y+'-'+m+'-'+d;	

	$('input[name="PRF_' + person + '_birthday"]').val(ymd);
	birth_text(person);
}
	$(document).on('change','input[name="' + person + '_gengo"],#PRF_' + person + '_birthdayY,#PRF_' + person + '_birthdayM,#PRF_' + person + '_birthdayD',function(){
		var	g = $('input[name="'+person+'_gengo"]:checked').val();
		var	y = $('#PRF_' + person + '_birthdayY').val();
		var	m = $('#PRF_' + person + '_birthdayM').val();
		var	d = $('#PRF_' + person + '_birthdayD').val();
			var year=toSeireki[g][y];
			console.log(year);
			if(y && m && d){
				ymd=year+'-'+m+'-'+d;	
				$('input[name="PRF_' + person + '_birthday"]').val(ymd);
				birth_text(person);
			}else{
				$('input[name="PRF_' + person + '_birthday"]').val('');
			}
	});
}

/*昭和〇年は西暦〇年です。というメッセージを表示*/
function birth_text(person){
var	g = $('input[name="'+person+'_gengo"]:checked').val();
var	y = $('#PRF_' + person + '_birthdayY').val();
var year=toSeireki[g][y];

var ary={M:'明治',T:'大正',S:'昭和',H:'平成',R:'令和'};
text=ary[g]+y+'年は西暦'+year+'年です。';
//console.log(text);
$('span.'+person+'_birth_msg').text(text);
}

/*没日のinput hiddenに年月日を連結してセットする*/
function botu_set(){
var	y = $('#PRF_kojin_botudayY').val();
var	m = $('#PRF_kojin_botudayM').val();
var	d = $('#PRF_kojin_botudayD').val();
y=parseInt(y)+parseInt(2018);
	ymd=y+'-'+m+'-'+d;
//	console.log(ymd);	
	$('input[name="PRF_kojin_botudate"]').val(ymd);

	$(document).on('change','#PRF_kojin_botudayY,#PRF_kojin_botudayM,#PRF_kojin_botudayD',function(){
	var	y = $('#PRF_kojin_botudayY').val();
	var	m = $('#PRF_kojin_botudayM').val();
	var	d = $('#PRF_kojin_botudayD').val();
y=parseInt(y)+parseInt(2018);
	ymd=y+'-'+m+'-'+d;	
	$('input[name="PRF_kojin_botudate"]').val(ymd);

	});
}


/*西暦の4桁を和暦に変換
@param y 年　例：1981
@return 配列 例:array(1981,S);
*/
function toWareki_y(y){
// let ary=[
// {date:'2019-05-01',year:'2019',name:'令和',gengo:'R'},
// {date:'1989-01-08',year:'1989',name:'平成',gengo:'H'},
// {date:'1926-12-25',year:'1926',name:'昭和',gengo:'S'},
// {date:'1912-07-30',year:'1912',name:'大正',gengo:'T'},
// {date:'1873-01-01',year:'1868',name:'明治',gengo:'M'}
// ];
y=parseInt(y);
if(y<1873){year=1;gengo='M';}//0000-00-00の場合の処理
if(y>=1873){year=y-1873+1;gengo='M';}
if(y>=1912){year=y-1912+1;gengo='T';}
if(y>=1926){year=y-1926+1;gengo='S';}
if(y>=1989){year=y-1989+1;gengo='H';}
if(y>=2019){year=y-2019+1;gengo='R';}
result={year:year,gengo:gengo};
return result;
}


/*性別選択時に続柄を絞る
読み込み時に性別が選択されていると続柄を絞る
@param 選択される変数の値
*/

function zokugara_narrow(person,val){
v = $('input[name="PRF_'+person+'_sex"]:checked').val();	
selectAddOption_per('select[name="PRF_'+person+'_zokugara"]',v,person);
$('select[name="PRF_'+person+'_zokugara"]').val(val);
	$('input[name="PRF_'+person+'_sex"]').on('click',function(){
		 v=$(this).val();
	 	selectAddOption_per('select[name="PRF_'+person+'_zokugara"]',v,person);
	});

}