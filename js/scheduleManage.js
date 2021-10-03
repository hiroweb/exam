/*式場からの火葬場対応json*/



/*今日から〇日後のを取得 getDate(2);(2日後)
@param day int 
@return 2日後の日付 date形式 2020-09-10
*/
function getDate(day) {
  var date = new Date();
  date.setDate(date.getDate() + day);
  var year  = date.getFullYear();
  var month = date.getMonth() + 1;
  var day   = date.getDate();
  return String(year) + "-" + String(month) + "-" + String(day);
}

/*指定した日からら〇日後のを取得
@param date str 2020-10-10 
@param day int
@return day日後の日付 date形式 2020-09-10
*/
function getDatePlus(date,day) {
  var date = date;
  date.setDate(date.getDate() + day);
  var year  = date.getFullYear();
  var month = date.getMonth() + 1;
  var day   = date.getDate();
  return String(year) + "-" + String(month) + "-" + String(day);
}

/*式場選択時の火葬場選択処理
@param val str 斎場コード
*/

function getKs(val) {
	sjo_kasou=val;
	$('select[name="CSC_saijo_CD"]').val([sjo_kasou]);
	var item = kasoro[sjo_kasou];
	var item2 = roomname[sjo_kasou]; //リストからカテゴリに登録された製品の配列を取得
	$('#CSC_kasoro_NO').empty(); 
	$('#CSC_room_NO').empty(); 

	$.each(item,function(index, value){
  	option = '<option value="' + index + '">' + value + '</option>';
    $('#CSC_kasoro_NO').append(option);
	});

	$.each(item2,function(index, value){
  	option2 = '<option value="' + index + '">' + value + '</option>';
    $('#CSC_room_NO').append(option2);
	});
	}



/*selectタグに配列内容をoptionを挿入
@param name selectタグのセレクタ
@param ary 配列
@param line boo 一行目を入れるかどうか
*/

function selectAddOption(name,ary,line = 0){
	$(name).empty();

if(line==1){
	console.log('2');
	$(name).append('<option value="">選択してください</option>');
}
		$.each(ary,function(k, v){
  	option = '<option value="' + k + '">' + v + '</option>';
    $(name).append(option);
	});
}

/*指定した配列のtable-rowを表示する
@param ary 配列　セレクタ名
*/
function displayTableRow(ary){
	for (var i = 0; i < ary.length; i++) {
	$(ary[i]).css('display','table-row');
	}
}

/*指定した配列のtable-rowを表示する
@param ary 配列　セレクタ名
*/
function displayTableRowGroup(ary){
	for (var i = 0; i < ary.length; i++) {
	$(ary[i]).css('display','table-row-group');
	}
}

/*指定した配列のtable-rowを表示する
@param ary 配列　セレクタ名
*/
function displayNone(ary){
	for (var i = 0; i < ary.length; i++) {
	$(ary[i]).hide(500).css('display','none');
	}
}