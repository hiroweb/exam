function IDF_ref_btn(param,person){



	$('#IDF_' + person + '_cancel_btn').on('click',function(){
		console.log('aa');
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

        content=$('.psn_table');
        content.html('<thead class="psn_header"><tr><th>名前</th><th>ふりがな</th><th>生年月日</th><th>住所</th><th style="white-space:nowrap;"><input type="button" class="green IDF_nobody" value="候補者なし"></th></tr><thead>');
  

  		for (var i =0; i<data.length; i++) 
            {
            	blank="'_blank'";
            	url = "'personManage_pre.php?person_NO="+data[i].person_NO+"'";
        	content.append('<tr data-id="'+data[i].person_NO+'"><td>' + data[i].PSN_sei_kj + data[i].PSN_mei_kj +'</td><td>'+data[i].PSN_sei_kn + data[i].PSN_mei_kn + '</td><td>' + data[i].PSN_birthday +'</td><td>' + data[i].PSN_prefecture + data[i].PSN_city + data[i].PSN_address + data[i].PSN_bld + '</td><td><input type="button" class="blue IDF_select" data-key="'+i+'" value="故人へ登録">&nbsp;&nbsp;<input type="button" class="gray" value="詳細" onclick="window.open('+url+','+blank+')"></td></tr>');
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
	$('span.' + person + '_PSN').text(data[key]['person_NO']);

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