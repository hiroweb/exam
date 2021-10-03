/*--------------------------------------------------------------
日付
--------------------------------------------------------------*/


var gc={"0":{"y":35,"g":"S"},"1900":{"y":33,"g":"M"},"1901":{"y":34,"g":"M"},"1902":{"y":35,"g":"M"},"1903":{"y":36,"g":"M"},"1904":{"y":37,"g":"M"},"1905":{"y":38,"g":"M"},"1906":{"y":39,"g":"M"},"1907":{"y":40,"g":"M"},"1908":{"y":41,"g":"M"},"1909":{"y":42,"g":"M"},"1910":{"y":43,"g":"M"},"1911":{"y":44,"g":"M"},"1912":{"y":1,"g":"T"},"1913":{"y":2,"g":"T"},"1914":{"y":3,"g":"T"},"1915":{"y":4,"g":"T"},"1916":{"y":5,"g":"T"},"1917":{"y":6,"g":"T"},"1918":{"y":7,"g":"T"},"1919":{"y":8,"g":"T"},"1920":{"y":9,"g":"T"},"1921":{"y":10,"g":"T"},"1922":{"y":11,"g":"T"},"1923":{"y":12,"g":"T"},"1924":{"y":13,"g":"T"},"1925":{"y":14,"g":"T"},"1926":{"y":1,"g":"S"},"1927":{"y":2,"g":"S"},"1928":{"y":3,"g":"S"},"1929":{"y":4,"g":"S"},"1930":{"y":5,"g":"S"},"1931":{"y":6,"g":"S"},"1932":{"y":7,"g":"S"},"1933":{"y":8,"g":"S"},"1934":{"y":9,"g":"S"},"1935":{"y":10,"g":"S"},"1936":{"y":11,"g":"S"},"1937":{"y":12,"g":"S"},"1938":{"y":13,"g":"S"},"1939":{"y":14,"g":"S"},"1940":{"y":15,"g":"S"},"1941":{"y":16,"g":"S"},"1942":{"y":17,"g":"S"},"1943":{"y":18,"g":"S"},"1944":{"y":19,"g":"S"},"1945":{"y":20,"g":"S"},"1946":{"y":21,"g":"S"},"1947":{"y":22,"g":"S"},"1948":{"y":23,"g":"S"},"1949":{"y":24,"g":"S"},"1950":{"y":25,"g":"S"},"1951":{"y":26,"g":"S"},"1952":{"y":27,"g":"S"},"1953":{"y":28,"g":"S"},"1954":{"y":29,"g":"S"},"1955":{"y":30,"g":"S"},"1956":{"y":31,"g":"S"},"1957":{"y":32,"g":"S"},"1958":{"y":33,"g":"S"},"1959":{"y":34,"g":"S"},"1960":{"y":35,"g":"S"},"1961":{"y":36,"g":"S"},"1962":{"y":37,"g":"S"},"1963":{"y":38,"g":"S"},"1964":{"y":39,"g":"S"},"1965":{"y":40,"g":"S"},"1966":{"y":41,"g":"S"},"1967":{"y":42,"g":"S"},"1968":{"y":43,"g":"S"},"1969":{"y":44,"g":"S"},"1970":{"y":45,"g":"S"},"1971":{"y":46,"g":"S"},"1972":{"y":47,"g":"S"},"1973":{"y":48,"g":"S"},"1974":{"y":49,"g":"S"},"1975":{"y":50,"g":"S"},"1976":{"y":51,"g":"S"},"1977":{"y":52,"g":"S"},"1978":{"y":53,"g":"S"},"1979":{"y":54,"g":"S"},"1980":{"y":55,"g":"S"},"1981":{"y":56,"g":"S"},"1982":{"y":57,"g":"S"},"1983":{"y":58,"g":"S"},"1984":{"y":59,"g":"S"},"1985":{"y":60,"g":"S"},"1986":{"y":61,"g":"S"},"1987":{"y":62,"g":"S"},"1988":{"y":63,"g":"S"},"1989":{"y":1,"g":"H"},"1990":{"y":2,"g":"H"},"1991":{"y":3,"g":"H"},"1992":{"y":4,"g":"H"},"1993":{"y":5,"g":"H"},"1994":{"y":6,"g":"H"},"1995":{"y":7,"g":"H"},"1996":{"y":8,"g":"H"},"1997":{"y":9,"g":"H"},"1998":{"y":10,"g":"H"},"1999":{"y":11,"g":"H"},"2000":{"y":12,"g":"H"},"2001":{"y":13,"g":"H"},"2002":{"y":14,"g":"H"},"2003":{"y":15,"g":"H"},"2004":{"y":16,"g":"H"},"2005":{"y":17,"g":"H"},"2006":{"y":18,"g":"H"},"2007":{"y":19,"g":"H"},"2008":{"y":20,"g":"H"},"2009":{"y":21,"g":"H"},"2010":{"y":22,"g":"H"},"2011":{"y":23,"g":"H"},"2012":{"y":24,"g":"H"},"2013":{"y":25,"g":"H"},"2014":{"y":26,"g":"H"},"2015":{"y":27,"g":"H"},"2016":{"y":28,"g":"H"},"2017":{"y":29,"g":"H"},"2018":{"y":30,"g":"H"},"2019":{"y":1,"g":"R"},"2020":{"y":2,"g":"R"}};

var wareki ={"M":{"33":33,"34":34,"35":35,"36":36,"37":37,"38":38,"39":39,"40":40,"41":41,"42":42,"43":43,"44":44,"45":45},"T":{"1":1,"2":2,"3":3,"4":4,"5":5,"6":6,"7":7,"8":8,"9":9,"10":10,"11":11,"12":12,"13":13,"14":14,"15":15},"S":{"1":1,"2":2,"3":3,"4":4,"5":5,"6":6,"7":7,"8":8,"9":9,"10":10,"11":11,"12":12,"13":13,"14":14,"15":15,"16":16,"17":17,"18":18,"19":19,"20":20,"21":21,"22":22,"23":23,"24":24,"25":25,"26":26,"27":27,"28":28,"29":29,"30":30,"31":31,"32":32,"33":33,"34":34,"35":35,"36":36,"37":37,"38":38,"39":39,"40":40,"41":41,"42":42,"43":43,"44":44,"45":45,"46":46,"47":47,"48":48,"49":49,"50":50,"51":51,"52":52,"53":53,"54":54,"55":55,"56":56,"57":57,"58":58,"59":59,"60":60,"61":61,"62":62,"63":63,"64":64},"H":{"1":1,"2":2,"3":3,"4":4,"5":5,"6":6,"7":7,"8":8,"9":9,"10":10,"11":11,"12":12,"13":13,"14":14,"15":15,"16":16,"17":17,"18":18,"19":19,"20":20,"21":21,"22":22,"23":23,"24":24,"25":25,"26":26,"27":27,"28":28,"29":29,"30":30,"31":31},"R":{"1":1,"2":2}};

var gengo ={
	"M":{"1900":33,"1901":34,"1902":35,"1903":36,"1904":37,"1905":38,"1906":39,"1907":40,"1908":41,"1909":42,"1910":43,"1911":44,"1912":45},
	"T":{"1912":1,"1913":2,"1914":3,"1915":4,"1916":5,"1917":6,"1918":7,"1919":8,"1920":9,"1921":10,"1922":11,"1923":12,"1924":13,"1925":14,"1926":15},
	"S":{"1926":1,"1927":2,"1928":3,"1929":4,"1930":5,"1931":6,"1932":7,"1933":8,"1934":9,"1935":10,"1936":11,"1937":12,"1938":13,"1939":14,"1940":15,"1941":16,"1942":17,"1943":18,"1944":19,"1945":20,"1946":21,"1947":22,"1948":23,"1949":24,"1950":25,"1951":26,"1952":27,"1953":28,"1954":29,"1955":30,"1956":31,"1957":32,"1958":33,"1959":34,"1960":35,"1961":36,"1962":37,"1963":38,"1964":39,"1965":40,"1966":41,"1967":42,"1968":43,"1969":44,"1970":45,"1971":46,"1972":47,"1973":48,"1974":49,"1975":50,"1976":51,"1977":52,"1978":53,"1979":54,"1980":55,"1981":56,"1982":57,"1983":58,"1984":59,"1985":60,"1986":61,"1987":62,"1988":63,"1989":64},
	"H":{"1989":1,"1990":2,"1991":3,"1992":4,"1993":5,"1994":6,"1995":7,"1996":8,"1997":9,"1998":10,"1999":11,"2000":12,"2001":13,"2002":14,"2003":15,"2004":16,"2005":17,"2006":18,"2007":19,"2008":20,"2009":21,"2010":22,"2011":23,"2012":24,"2013":25,"2014":26,"2015":27,"2016":28,"2017":29,"2018":30,"2019":31},
	"R":{"2019":1,"2020":2,"2021":3}};

var toSeireki ={
	"M":{"33":1900,"34":1901,"35":1902,"36":1903,"37":1904,"38":1905,"39":1906,"40":1907,"41":1908,"42":1909,"43":1910,"44":1911,"45":1912},
	"T":{"1":1912,"2":1913,"3":1914,"4":1915,"5":1916,"6":1917,"7":1918,"8":1919,"9":1920,"10":1921,"11":1922,"12":1923,"13":1924,"14":1925,"15":1926},
	"S":{"1":1926,"2":1927,"3":1928,"4":1929,"5":1930,"6":1931,"7":1932,"8":1933,"9":1934,"10":1935,"11":1936,"12":1937,"13":1938,"14":1939,"15":1940,"16":1941,"17":1942,"18":1943,"19":1944,"20":1945,"21":1946,"22":1947,"23":1948,"24":1949,"25":1950,"26":1951,"27":1952,"28":1953,"29":1954,"30":1955,"31":1956,"32":1957,"33":1958,"34":1959,"35":1960,"36":1961,"37":1962,"38":1963,"39":1964,"40":1965,"41":1966,"42":1967,"43":1968,"44":1969,"45":1970,"46":1971,"47":1972,"48":1973,"49":1974,"50":1975,"51":1976,"52":1977,"53":1978,"54":1979,"55":1980,"56":1981,"57":1982,"58":1983,"59":1984,"60":1985,"61":1986,"62":1987,"63":1988,"64":1989},
	"H":{"1":1989,"2":1990,"3":1991,"4":1992,"5":1993,"6":1994,"7":1995,"8":1996,"9":1997,"10":1998,"11":1999,"12":2000,"13":2001,"14":2002,"15":2003,"16":2004,"17":2005,"18":2006,"19":2007,"20":2008,"21":2009,"22":2010,"23":2011,"24":2012,"25":2013,"26":2014,"27":2015,"28":2016,"29":2017,"30":2018,"31":2019},
	"R":{"1":2019,"2":2020,"3":2021}};



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
if(y>=1873){year=y-1873+1;gengo='M';}
if(y>=1912){year=y-1912+1;gengo='T';}
if(y>=1926){year=y-1926+1;gengo='S';}
if(y>=1989){year=y-1989+1;gengo='H';}
if(y>=2019){year=y-2019+1;gengo='R';}
result={year:year,gengo:gengo};
return result;
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
時間をリアルタイムで表示
setInterval(showtime.1000);
*/
function showtime(){
  var today = new Date();
  $weekday = ['日','月','火','水','木','金','土'];
  month = today.getMonth() + 1 ;
  $('.clock').html(month + "月"+ today.getDate() + "日（" + $weekday[today.getDay()] +"） " +today.getHours() + ":" + ('0'+today.getMinutes()).slice(-2) + ":" + ('0' +today.getSeconds()).slice(-2));
}


/*--------------------------------------------------------------
演算
--------------------------------------------------------------*/

/*合計値を取得
$selector textで取得する 
例：<span>50,000</span><span>60,000</span>
*/

function total_text(selector){
var ary=[];
$(selector).each(function(){
	v=$(this).text();
    v = v.replace(/,/g, "");
    v=parseInt(v);
    ary.push(v);
});
total=ary.reduce((a,x) => a+=x,0);
return total;
}


function total_data(selector,data){
var ary=[];
$(selector).each(function(){
	v = $(this).data(data);
//	console.log(v);
//    v = v.replace(/,/g, "");
    v=parseInt(v);
    ary.push(v);
});
total=ary.reduce((a,x) => a+=x,0);
return total;
}



function test(){
console.log('a');
}




/*
配列のクラスの数字が変換されたら合計に表示
また、入力された数字を3桁カンマ区切りにする

@ary ary セレクタの配列
@total str 合計値を表示するセレクタ 

 */
function total_calculation(ary,total,watch=[]){

//配列をカンマ区切りで連結
var selectors = ary.join(',');
//mergeで元配列を残す
var all = $.merge([], watch);
var all = $.merge(all, ary);
var selectors_all = all.join(',');


var spanTotal = 'span' + total;
var inputTotal = 'input' + total;

//配列をの値を取得して3桁区切りで表示する
$.each(all, function(k, v) {
	value = $(v).val();
	value=parseInt(value);
//	console.log(value);

});

	//配列のセレクタからvalを取り出して数字の配列にする。
	var sum_ary=[];
	$.each(ary, function(k, v) {
		value = $(v).val();
	//3桁区切りを数値に変換する
		value = removeComma(value);
//		console.log(value)
		sum_ary.push(value);
	});
	//配列の数値を足す
//	console.log(sum_ary);
	alltotal=sum_ary.reduce((a,x) => a+=x,0);
	alltotal=parseInt(alltotal);
//	console.log(all);
//	console.log(all);
	$(spanTotal).text(alltotal.toLocaleString());
	$(inputTotal).val(alltotal.toLocaleString());
	
$(document).on('change',selectors_all,function(){

	var sum_ary=[];
	$.each(ary, function(k, v) {
		value = $(v).val();
	//3桁区切りを数値に変換する
		value = removeComma(value);
//		console.log(value)
		sum_ary.push(value);
	});
	//配列の数値を足す
//	console.log(sum_ary);
	alltotal=sum_ary.reduce((a,x) => a+=x,0);
	alltotal=parseInt(alltotal);
//	console.log(all);
//	console.log(all);
	$(spanTotal).text(alltotal.toLocaleString());
	$(inputTotal).val(alltotal.toLocaleString());
});
}


/*
配列のクラスの数字が変換されたら合計に表示
また、入力された数字を3桁カンマ区切りにする

@ary ary セレクタの配列
@total str 合計値を表示するセレクタ 
@tax ary
 */
function total_calculation_tax(ary,total,watch,tax){

//配列をカンマ区切りで連結
var selectors = ary.join(',');
//mergeで元配列を残す
var all = $.merge([], watch);
var all = $.merge(all, ary);
var selectors_all = all.join(',');

var spanTotal = 'span' + total;
var inputTotal = 'input' + total;

var selector_tax=tax;


//配列をの値を取得して3桁区切りで表示する
$.each(all, function(k, v) {
	value = $(v).val();
	value = removeComma(value);
	value=parseInt(value);

	//	console.log(value);
	$(v).val(value.toLocaleString());

});

//taxの値を取得して配列に入れる
var tax_ary=[];
$.each(tax, function(k, v) {
	value = $(v).val();
	tax_ary.push(value);
});



	//配列のセレクタからvalを取り出して数字の配列にする。
	var sum_ary=[];
	$.each(ary, function(k, v) {
		value = $(v).val();
	//3桁区切りを数値に変換する
		value = removeComma(value);
	//税込を算出
		if(tax_ary[k]=='0'){
		tax = 0;
		}else{
		tax = value * tax_ary[k] / 100;
		}

		value = parseInt(value) + parseInt(tax);
		sum_ary.push(value);
	});
	//配列の数値を足す
	alltotal=sum_ary.reduce((a,x) => a+=x,0);
	alltotal=parseInt(alltotal);
	$(spanTotal).text(alltotal.toLocaleString());
	$(inputTotal).val(alltotal.toLocaleString());
	
$(document).on('change',selectors_all,function(){

	var sum_ary=[];

	//taxの値を読み取って配列へ格納
	var tax_ary=[];
	$.each(selector_tax, function(k, v) {
	tax = $(v).val();
	tax_ary.push(tax);
	});


	$.each(ary, function(k, v) {
		value = $(v).val();
	//3桁区切りを数値に変換する
		value = removeComma(value);
	//税込を算出
//	console.log(tax_ary[k]);
		if(tax_ary[k]=='0'){
		tax = 0;
		}else{
		tax = value * tax_ary[k] / 100;
		}
		value = parseInt(value) + parseInt(tax);
//		console.log(value)
		sum_ary.push(value);


	});
	//配列の数値を足す
//	console.log(sum_ary);
	alltotal=sum_ary.reduce((a,x) => a+=x,0);
	alltotal=parseInt(alltotal);
	$(spanTotal).text(alltotal.toLocaleString());
	$(inputTotal).val(alltotal.toLocaleString());
});
}


/*
フォームに入力された値を取得して掛け算
aryには3つのセレクタ
ary a * b = c
 */

function calculation_multiple(a,b,c){
	vala =$(a).val();
	valb =$(b).val();
	console.log(a);
	console.log(vala);
	vala = Number( vala.replace(/,/, '') );
	valb = Number( valb.replace(/,/, '') );
	valc= vala * valb;
	$(c).val(valc.toLocaleString());

$(a +',' +b).on('change',function(){
	vala =$(a).val();
	valb =$(b).val();
	vala = Number( vala.replace(/,/, '') );
	valb = Number( valb.replace(/,/, '') );
	valc= vala * valb;
	console.log(vala);
	console.log(valb);

	$(c).val(valc.toLocaleString());


});	
}


/*--------------------------------------------------------------
フォーム
--------------------------------------------------------------*/

/* ------------------------
ボタンリンク
$().on('click',function(){
	param['form']='#form1';
	param['link']='funeralDocument_lst.php';
	param['doc']='obituary';
	keys=['SSC_ID','SSCsts'];
	btnLink(param,keys);
});
	paramのキー名をnameにもったinput hiddenに値をセットして飛ぶ。
------------------------*/
function btnLink(param,keys){
	$(param.click).on('click',function(){
		var data_tr = $(this).parents('tr').data();
		var data_btn = $(this).data();
		var data = $.extend(data_tr,data_btn);
		console.log(data);
		i=0;
		$.each(data,function(k,v){
			var n=keys[i];
			param[n]=v;
			i = i+1;
		});
		console.log(param);
		$.each(param,function(k,v){
			$('input[name="'+k+'"]').val(v);
		});
		$(param.form).attr('action',param.link);
		$(param.form).submit();
	});	
};



/*チェックボックスの数のリミットを設定
max…同時にチェックしてよいチェックボックスの数
selector…対象のセレクター
*/
function checkLimit(max,selector){
//選べる寄贈品の数
var len = $(selector+':checked').length;
if(len >=max){
	$(selector).not(':checked').attr('disabled', 'disabled');
}else{
	 $(selector).not(':checked').removeAttr('disabled');
}
}


/*
ボタンを押せなくする処理
aの数が0だったらbにdisabledをつける
*/

function chkDisabled(a,b){
	var cnt =$(a).length;
		if(cnt==0){
			$(b).prop('disabled',true);
		}else{
			$(b).prop('disabled',false);
		}
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

/*
入力されたら同じ値をコピーする
*/

function copyValue(from,to){
$(from).on('change',function(){
	from= $(from).val();
	$(to).val(from);
});
}

/*
フォーカスアウトでカンマを表示
フォーカスオンでカンマを削除
*/

function focus_comma(ary){
var selectors = ary.join(',');
  // フォーカスアウト
  $(selectors).on('blur', function(){
    var num = $(this).val();
    num = num.replace(/(\d)(?=(\d\d\d)+$)/g, '$1,');
    $(this).val(num);
  });

  // フォーカス
  $(selectors).on('focus', function(){
    var num = $(this).val();
    num = num.replace(/,/g, '');
    $(this).val(num);
    $(this).select();

  });

}

/*
フォームで空のときに0を表示する
ary:セレクタ名配列
*/

function empty_to_zero(ary){

for (var i = 0; i < ary.length; i++) {
	$(ary[i]).on('change',function(){
		var v=$(this).val();
		zero=parseInt(0);
		if(v==''){
			$(this).val(zero);
		}
	});
	}
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


/*--------------------------------------------------------------
通信
--------------------------------------------------------------*/

/*
該当するセレクタに対し、
	var selecor セレクタ名
	セレクタで該当する要素全てに対して処理
	return　jsonオブジェクト
		キー…name属性の値
		値…value属性の値
*/
function getParams(selector){
	var param={};
	$(selector).each(function(k,e){
		var name = $(e).attr('name');
		var val = $(e).val();
//		var data={[name]:val};
		param[name]=val;
	});	
	return param;
}

function getParameters(selector){
	var param={};
	$(selector+' input[type="text"],'+selector+' input[type="radio"]:checked,'+selector+' select,'+selector+' textarea').each(function(k,e){
		var name = $(e).attr('name');
		var val = $(e).val();
//		var data={[name]:val};
		param[name]=val;
	});	
	return param;
}

/*
該当するセレクタに対し、
	var selecor セレクタ名
	セレクタで該当する要素全てに対して処理
	valはラジオボタンの初期値
*/

function clearValues(selector,value=0){
	$(selector+' input[type="text"],'+selector+' select,'+selector+' textarea').each(function(k,e){
		$(e).val('');
	});	

	$(selector+' input[type="radio"]').each(function(k,e){
		$(e).val([value]);
	});	
}

/*
ajax通信する
	クラス内のinput,textarea,select要素から値を抜き取り、
	name属性をキー名としてJson配列を作り、ajax通信する
	
	var param=getParameters('.className');
	param['KEY']=$('input[name="KEY"]').val();
	ajax(param,'funeralDonationSelectUpdate_api.php').done(function(data){
		console.log(data);
		}).fail(function(data){
		console.log(data);
		})
 */
function ajax(param,url){
return $.ajax({
			type:"POST",
			url:url,
			data:param,
			dataType:"json",
			scriptCharset:"utf-8",
			beforeSend:function(){
				$('.loading').removeClass('hide');
			}
		})

}

/*--------------------------------------------------------------
CSS
--------------------------------------------------------------*/
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

/* class がついた要素の背景色を取得して文字色を適用*/
function BgToColor(className){
	$(className).each(function(i,o){
		bg = $(o).css('backgroundColor');
//		console.log(bg);
		bg = convert16Color(bg);
		color = blackOrWhite(bg);
		$(o).css('color',color);
	});
}



/*--------------------------------------------------------------
汎用
--------------------------------------------------------------*/
/*
カンマを削除する
 */
function removeComma(num) {
    num = num.replace(/,/g, '');
    return parseInt(num);
}

/*
配列のvalueを配列に格納
*/

function pushAry(selector){
	arr=[];
	$(selector).each(function(i){
		arr.push($(this).val());
	});
	return arr;
}

/*-------------------------------------
レイヤー機能
 -------------------------------------*/
function Bodylayer(click){
var layer=''
+'<div id="layer">'
+'<div id="layer_bg" class="layer_close"></div>'
+'<div id="layer_container">'
+''
+''
+'</div>'
+'</div>';


var layerCSS ={
    display: "none",
    zIndex: "500",
    position: "fixed",
    width: "100%",
    height: "100vh",
};

var layer_bgCSS = {
    width: "100%",
    height: "100vh",
    backgroundColor: "rgba(0,0,0,0.9)",
    position: "absolute",
    top: "0",
    left: "0",
    zIndex: 500
};

var layer_containerCSS = {
    position:"relative",
    boxSizing: "border-box",
    backgroundColor: "#fcfcfc",
    margin: "0 auto",
    top: "40px",
    width: "80%",
    height: "90vh",
    fontSize: "12px",
    zIndex: "600",
//    overflowY: "scroll"
}


$('body').prepend(layer);
$('div#layer').css(layerCSS);
$('div#layer_bg').css(layer_bgCSS);
$('div#layer_container').css(layer_containerCSS);
$(document).on('click',click,function(){
	$('div#layer').fadeIn();
});
$(document).on('click','.layer_close',function(){
	$('div#layer').fadeOut();
});
}


