 var recognizing;
 var rec = new webkitSpeechRecognition()
	rec.continuous = true;
  reset();
  rec.onend = reset;
  rec.lang = 'ja-JP';//日本語
  rec.onresult = function(event) {

  if (event.results.length > 0) {
  // var val=event.results[0][0].transcript;
  //   $('#q').val(val);
  	console.log(event.results);
     var value=event.results[0][0].transcript;
     console.log(value);

		$('input[name="EX_address"]').val(value);

		var EX_name=$('input[name="EX_name"]').val();
		var EX_address=$('input[name="EX_address"]').val();
		var EX_sex=$('input[name="EX_sex"]:checked').val();
		var EX_phone=$('input[name="EX_phone"]').val();
		var EX_login_NO=$('input[name="EX_login_NO"]').val();
		var EX_estimate_NO=$('input[name="EX_estimate_NO"]').val();

		if(EX_name.length<2&&EX_name!=''){
			return false;
		}
		var param={
			"EX_name":EX_name,
			"EX_address":EX_address,
			"EX_sex":EX_sex,
			"EX_phone":EX_phone,
			"EX_login_NO":EX_login_NO,
			"EX_estimate_NO":EX_estimate_NO
		};
//		console.log(param);
var sex=['不明','男性','女性'];
		  	ajax(param,'personExplorer_api.php').done(function(data){
			console.log(data);

	$('table.ex1').html('');
	var tr='<tr>';
		tr+='<th>お名前</th>';
		tr+='<th>性別</th>';
		tr+='<th>住所</th>';
		tr+='<th>電話番号</th>';
		tr+='<th>会員番号</th>';
		tr+='<th></th>';
		tr+='</tr>';
	
		if(data['LS']){
		var cnt=data['LS'].length;
		$('span.cnt').text('');
		$('span.cnt').text('検索結果 '+cnt+'件');
				for (var i = 0; i < data['LS'].length; i++) {
					if(data['LS'][i].login_no==null){
						data['LS'][i].login_no='非会員';
					}

					if(data['LS'][i].PSN_phone!=''&&data['LS'][i].PSN_mobile!=''){data['LS'][i].hyphen=' / ';}else{
						data['LS'][i].hyphen='';
					}

					tr+='<tr>';
					tr+='<td>'+data['LS'][i].PSN_sei_kj+' '+data['LS'][i].PSN_mei_kj+' <span class="small">'+data['LS'][i].PSN_sei_kn+' '+data['LS'][i].PSN_mei_kn+'</span></td>';
					tr+='<td>'+sex[data['LS'][i].PSN_sex]+'</td>';
					tr+='<td>'+data['LS'][i].PSN_prefecture+data['LS'][i].PSN_city+data['LS'][i].PSN_address+data['LS'][i].PSN_bld+'</td>';
					tr+='<td>'+data['LS'][i].PSN_phone+data['LS'][i].hyphen+data['LS'][i].PSN_mobile+'</td>';
					tr+='<td>'+data['LS'][i].login_no+'</td>';
					tr+='<td><input type="button" class="btnUpdate1" value="編集" data-no="'+data['LS'][i].person_NO+'"></td></td></td>';

					tr+='</tr>';
				}
}else{
	tr+='<tr><td colspan="5" class="cv_center">データが見つかりませんでした。</td></tr>';
}
		$('table.ex1').append(tr);

			}).fail(function(data){
			console.log(data);
			});
  }
}


  function reset() {
    recognizing = false;
    button.innerHTML = "音声開始";
  }

  function toggleStartStop() {
    if (recognizing) {
      rec.stop();
      reset();
    } else {
      rec.start();
      recognizing = true;
      button.innerHTML = "音声終了";
    }
  }