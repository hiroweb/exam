<?php
require_once(AUTOLOAD);
use Carbon\Carbon;

// --------------------------------------------------
// 数値フォーマット ver1.0.0
// 2020/04/16 H.Saito
// --------------------------------------------------

// 郵便番号7桁→3+4ハイフン挿入

    function Postal($Postal){
      if($Postal){
      $Postal = str_replace("-", "", $Postal);
       return substr($Postal, 0, 3).'-'.substr($Postal, 3, strlen($Postal));
     }else{
      return $Postal;
       }
     }

// 金額3桁区切り
    function Money($Money){
	 	return number_format($Money);
	 }

/*----------------------------
税込み価格算出
----------------------------*/

function priceIncludingTax($unitcost,$tax){
  $cost=$unitcost + ($unitcost * $tax / 100);
  return ($cost);
}



// 日にち日本語表示
	function Jdate($date){
		return date('Y年m月d日',strotime($date));
	}

// 時間日本語表示
	function Jtime($date){
		return date('H:i',strotime($date));
	}

//文字をまるめる
    function strm($data,$num){    
    return mb_strimwidth($data,0,$num,'…', utf8);
   }



//0470114444
 /**
  * 半角数字を漢数字に変換する（位取り記法）
  * @param string $instr 半角数字
  *                          小数、負数に対応；指数表記には未対応
  *                          カンマは削除
  * @return string 漢数字
 */
 function num2kan($instr) {
     static $kantbl1 = array(0=>'', 1=>'壱', 2=>'弐', 3=>'参', 4=>'四', 5=>'伍', 6=>'陸', 7=>'漆', 8=>'捌', 9=>'玖', '.'=>'．', '-'=>'－');
     static $kantbl2 = array(0=>'', 1=>'拾', 2=>'佰', 3=>'千');
     static $kantbl3 = array(0=>'', 1=>'千', 2=>'萬', 3=>'億', 4=>'兆');
 
     $outstr = '';
     $len = strlen($instr);
     $m = (int)($len / 4);
     //一、万、億、兆‥‥の繰り返し
     for ($i = 0; $i <= $m; $i++) {
         $s2 = '';
         //一、十、百、千の繰り返し
         for ($j = 0; $j < 4; $j++) {
             $pos = $len - $i * 4 - $j - 1;
             if ($pos >= 0) {
                 $ch  = substr($instr, $pos, 1);
                 if ($ch == ',')    continue;        //カンマは無視
                 $ch1 = isset($kantbl1[$ch]) ? $kantbl1[$ch] : '';
                 $ch2 = isset($kantbl2[$j])  ? $kantbl2[$j]  : '';
                 //冒頭が「一」の場合の処理
                 if ($ch1 != '') {
                     if ($ch1 == '一' && $ch2 != '')  $s2 = $ch2 . $s2;
                     else                                $s2 = $ch1 . $ch2 . $s2;
                 }
             }
         }
         if ($s2 != '')  $outstr = $s2 . $kantbl3[$i] . $outstr;
     }
 
     return $outstr;
 }



/**
 * 4つの時間と今を比較して、今どの場所にあるのかを返す
 * 
 * @param $a 初回安置 "2020-10-25 15:15:00"
 * @param $b 2回目安置
 * @param $c 3回目安置
 * @param $d 4回目安置
 * @param $i int 今日から何時間後
 * @return 01~04 or 9999(未入力)
 */

function WhereIsBody($a,$b,$c,$d,$i=0){


$n=date("Y-m-d H:i:s",strtotime("+".$i." hour"));
$now=strtotime($n);
$BSC01=strtotime($a);
$BSC04=strtotime($d);

if($b=="0000-00-00 00:00:00"){$BSC02=strtotime("2100-01-01 00:00:00");}else{$BSC02=strtotime($b);}

if($c=="0000-00-00 00:00:00"){$BSC03=strtotime("2100-01-01 00:00:00");}else{$BSC03=strtotime($c);}

//$zero=strtotime("0000-00-00 00:00:00");

if($BSC01<$now&&$now<$BSC02){
  $result='01';
}

if($BSC02<=$now&&$now<$BSC03){
  $result='02';
}

if($BSC03<=$now&&$now<$BSC04){
  $result='03';
}

if($BSC04<=$now){
  $result='04';
}



if($a ==' '||$a ==''||$a =='  '){
  $result='9999';
 }

 return $result;
}


function WhereIsBody2021($a,$b,$c,$d,$i=0){

  $n=date("Y-m-d H:i:s",strtotime("+".$i." hour"));
  $now=strtotime($n);
  $BSC01=strtotime($a);
  $BSC04=strtotime($d);
  
  if($b=="0000-00-00 24:00:00"){$BSC02=strtotime("2100-01-01 00:00:00");}else{$BSC02=strtotime($b);}
  
  if($c=="0000-00-00 24:00:00"){$BSC03=strtotime("2100-01-01 00:00:00");}else{$BSC03=strtotime($c);}
  
  //$zero=strtotime("0000-00-00 00:00:00");
  
  if($BSC01<$now&&$now<$BSC02){
    $result='01';
  }
  
  if($BSC02<=$now&&$now<$BSC03){
    $result='02';
  }
  
  if($BSC03<=$now&&$now<$BSC04){
    $result='03';
  }
  
  if($BSC04<=$now){
    $result='04';
  }
  
  
  
  if($a ==' '||$a ==''||$a =='  '){
    $result='9999';
   }
  
   return $result;
  }


function WhereIsBody_test($a,$b,$c,$d,$i=0){


$n=date("Y-m-d H:i:s",strtotime("+".$i." hour"));
$now=strtotime($n);
$BSC01=strtotime($a);
$BSC04=strtotime($d);

if($b=="0000-00-00 00:00:00"){$BSC02=strtotime("2100-01-01 00:00:00");}else{$BSC02=strtotime($b);}

if($c=="0000-00-00 00:00:00"){$BSC03=strtotime("2100-01-01 00:00:00");}else{$BSC03=strtotime($c);}

//$zero=strtotime("0000-00-00 00:00:00");

if($BSC01<$now&&$now<$BSC02){
  $result='01';
}

if($BSC02<=$now&&$now<$BSC03){
  $result='02';
}

if($BSC03<=$now&&$now<$BSC04){
  $result='03';
}

if($BSC04<=$now){
  $result='04';
}



if($a ==' '||$a ==''||$a =='  '){
  $result='9999';
 }

$ary=array($BSC01,$BSC02,$BSC03,$BSC04,$now);

 return $ary;
}

/**
 * 今が、2つの時間の間にあるかどうかの判定
 *  
 * @var str 一つ目の日時 "0000-00-00 00:00:00" 第一引数
 * @var str 二つ目の日時 "0000-00-00 00:00:00" 第二引数
 * @return boolean 
 */

function flag_now($time01,$time02){

  $start=strtotime($time01);
  $end=strtotime($time02);
  $now=strtotime(date("Y-m-d H:i:s"));
  
  if($start>$end){
    $start=strtotime($time02);
    $end=strtotime($time01);
  }

  if($start<=$now && $now <=$end){
    $result = 1;
  }else{
    $result = 0;
  }

  if($time01==' '||$time01=='0000-00-00 00:00:00'||$time02==' '||$time02=='0000-00-00 00:00:00'){
    $result=0;
  }


return $result;

}






/**
 * 時間(hhmm)を指定した分単位で切り上げる
 * 
 * @param $time 時間と分の文字列(1130, 11:30など)
 * @param $per 切り上げる単位(分) 5分なら5
 * @return false or 切り上げられた DateTime オブジェクト(->fomat で自由にフォーマットして使用する)
 */
function ceilPerTime($time, $per=5){

    // 値がない時、単位が0の時は false を返して終了する
    if( !isset($time) || !is_numeric($per) || ($per == 0 )) {
        return false;
    }else{
        $deteObj = new DateTime($time);
        // 指定された単位で切り上げる
        // フォーマット文字 i だと、 例えば1分が 2桁の 01 となる(1桁は無い）ので、整数に変換してから切り上げる
        $ceil_num = ceil(sprintf('%d', $deteObj->format('i'))/$per) *$per;

        // 切り上げた「分」が60になったら「時間」を1つ繰り上げる
        // 60分 -> 00分に直す
        $hour = $deteObj->format('H');

        if( $ceil_num == 60 ) {
            $hour = $deteObj->modify('+1 hour')->format('H');
            $ceil_num = '00';
        }
        $have = $hour.sprintf( '%02d', $ceil_num );

        return new DateTime($have);
    }
}

/**
 * 時間(hhmm)を指定した分単位で切り捨てる
 * 
 * @param $time 時間と分の文字列(1130, 11:30など)
 * @param $per 切り捨てる単位(分) 5分なら5
 * @return false or 切り捨てられた DateTime オブジェクト(->fomat で自由にフォーマットして使用する)
 */
function floorPerTime($time, $per=5){

    // 値がない時、単位が0の時は false を返して終了する
    if( !isset($time) || !is_numeric($per) || ($per == 0 )) {
        return false;
    }else{
        $deteObj = new DateTime($time);

        // 指定された単位で切り捨てる
        // フォーマット文字 i だと、 例えば1分が 2桁の 01 となる(1桁は無い）ので、整数に変換してから切り捨てる
        $ceil_num = floor(sprintf('%d', $deteObj->format('i'))/$per) *$per;

        $hour = $deteObj->format('H');

        $have = $hour.sprintf( '%02d', $ceil_num );

        return new DateTime($have);
    }
}

/**
 * 斎場コードの順序を指定した配列と連番配列を結合し、
 * 指定配列が順番通りにくるようにする
 * 第二引数までカウントを続け、配列に含まないものは配列の後に斎場コード順に追加される
 * 
 * @var array $ary 第一引数
 * @param int $val 第二引数 
 * @return array 
 */

function arrange_saijo_CD($ary,$int=400){
  $ary_copy=$ary;

  for ($i=0; $i < $int; $i++) { 
    //0埋め4桁
    $k = str_pad($i,4,0,STR_PAD_LEFT);

      if(!in_array($k,$ary_copy)){
          $ary[]=$k;
      }
  }
$result=$ary;
return $result;

}


/**
 * SQL文の発行
 * ORDER部分で、配列順に出力されるようにする
 *  
 * @var array 順番 $ary 第一引数
 * @param val カラム名 $val 第二引数 
 * @return str "ORDER BY SJO.saijo_CD=0298 DESC,SJO.saijo_CD=0296 DESC,SJO.saijo_CD=0244 DESC,~"
 */
function arrange_sql_order($ary,$val){
  $str='';
  $result='';
  for ($i=0; $i < count($ary); $i++) { 
    $str.=$val."='".$ary[$i]."' DESC,";
  }
  $result.="ORDER BY ".$str.$val." ASC";
  return $result;
}

/**
 * SQL文の発行
 * WHERE部分で、配列順に出力されるようにする
 *  
 * @var array 順番 $ary 第一引数
 * @param val カラム名 $val 第二引数 
 * @return str "ORDER BY SJO.saijo_CD=0298 DESC,SJO.saijo_CD=0296 DESC,SJO.saijo_CD=0244 DESC,~"
 */
function arrange_sql_where($ary,$val){
  $str='';
  $result='';
  for ($i=0; $i < count($ary); $i++) { 
    $ary[$i]=$val." = '".$ary[$i]."'";
  }
 $str= "(".implode(" OR ", $ary).")";
  $result.=$str;
  return $result;
}

/**
 * 改行を削除
 *  
 * @var str 文字列
 * @return 改行削除後の文字列
 */

function delete_newline($str){
  
  return str_replace(array("\r\n", "\r", "\n"), '', $str);
}

/**
 * 行ラストのカンマを削除
 *  
 * @var str 文字列
 * @return カンマ削除後の文字列
 */
  function delete_comma($str){
    return rtrim($str,',');
  }


/**
 * 日付チェック
 * 引数：西暦(9999/99/99 or 9999-99-99)
 * 戻値：結果
 */
function chkDate($value) {
  if ((strpos($value, '/') !== false) && (strpos($value, '-') !== false)) {
    return false;
  }
  $value   = str_replace('/', '-', $value);
  $pattern = '#^([0-9]{1,4})-(0[1-9]|1[0-2]|[1-9])-([0-2][0-9]|3[0-1]|[1-9])$#';
  preg_match($pattern, $value, $arrmatch);
  if ((isset($arrmatch[1]) === false) || (isset($arrmatch[2]) === false) || (isset($arrmatch[3]) === false)) {
    return false;
  }
  if (checkdate((int)$arrmatch[2], (int)$arrmatch[3], (int)$arrmatch[1]) === false) {
    return false;
  }
  
  return true;
}


/**
 * 和暦変換(グレゴリオ暦が採用された「明治6年1月1日」以降に対応)
 * 引数：西暦(9999/99/99 or 9999-99-99)
 * 戻値：和暦
 */
function chgAdToJpDate($value) {
  //和暦変換用データ
  $arr = array(
    array('date' => '2019-05-01', 'year' => '2019', 'name' => '令和'),// 新元号追加
    array('date' => '1989-01-08', 'year' => '1989', 'name' => '平成'),
    array('date' => '1926-12-25', 'year' => '1926', 'name' => '昭和'),
    array('date' => '1912-07-30', 'year' => '1912', 'name' => '大正'),
    array('date' => '1873-01-01', 'year' => '1868', 'name' => '明治'),// 明治6年1月1日以降
  );
  // 日付チェック
  if (chkDate($value) === false) {
    return '';
  }
  $arrad  = explode('-', str_replace('/', '-', $value));
  $addate = (int)sprintf('%d%02d%02d', (int)$arrad[0], (int)$arrad[1], (int)$arrad[2]);
  $result = '';
  foreach ($arr as $key=>$row) {
    // 日付チェック
    if (chkDate($row['date']) === false) {
      return '';
    }
    $arrjp  = explode('-', str_replace('/', '-', $row['date']));
    $jpdate = (int)sprintf('%d%02d%02d', (int)$arrjp[0], (int)$arrjp[1], (int)$arrjp[2]);
    // 元号の開始日と比較
    if ($addate >= $jpdate) {
      // 和暦年の計算
      $year = sprintf('%d', ((int)$arrad[0] - (int)$row['year']) + 1);
      if ((int)$year === 1) {
        $year = '元';
      }
      // 和暦年月日作成
      $result = sprintf('%s%s年%d月%d日', $row['name'], $year, (int)$arrad[1], (int)$arrad[2]);
      break;
    }
  }
  return $result;
}

/**
 * 和暦変換(グレゴリオ暦が採用された「明治6年1月1日」以降に対応)
 * 引数：西暦(9999/99/99 or 9999-99-99)
 * 戻値：配列
 */
function chgAdToJpDateParts($value) {
  //和暦変換用データ
  $arr = array(
    array('date' => '2019-05-01', 'year' => '2019', 'name' => '令和', 'g' => 'R'),// 新元号追加
    array('date' => '1989-01-08', 'year' => '1989', 'name' => '平成', 'g' => 'H'),
    array('date' => '1926-12-25', 'year' => '1926', 'name' => '昭和', 'g' => 'S'),
    array('date' => '1912-07-30', 'year' => '1912', 'name' => '大正', 'g' => 'T'),
    array('date' => '1873-01-01', 'year' => '1868', 'name' => '明治', 'g' => 'M'),// 明治6年1月1日以降
  );
  // 日付チェック
  if (chkDate($value) === false) {
    return '';
  }
  $arrad  = explode('-', str_replace('/', '-', $value));
  $addate = (int)sprintf('%d%02d%02d', (int)$arrad[0], (int)$arrad[1], (int)$arrad[2]);
  $result = '';
  foreach ($arr as $key=>$row) {
    // 日付チェック
    if (chkDate($row['date']) === false) {
      return '';
    }
    $arrjp  = explode('-', str_replace('/', '-', $row['date']));
    $jpdate = (int)sprintf('%d%02d%02d', (int)$arrjp[0], (int)$arrjp[1], (int)$arrjp[2]);
    // 元号の開始日と比較
    if ($addate >= $jpdate) {
      // 和暦年の計算
      $year = sprintf('%d', ((int)$arrad[0] - (int)$row['year']) + 1);
      if ((int)$year === 1) {
        $year = '元';
      }
      // 和暦年月日作成
      break;
    }
  }
  return array('G'=>$row['g'],'Y'=>$year,'M'=>(int)$arrad[1],'D'=>(int)$arrad[2]);
}

/**
 * 和暦変換 元号のみ返す
 * 引数：西暦(9999/99/99 or 9999-99-99)
 * 戻値：RHSTM
 */
function chgAdToJpDate_gengo($value) {
  //和暦変換用データ
  $arr = array(
    array('date' => '2019-05-01', 'year' => '2019', 'name' => 'R'),// 新元号追加
    array('date' => '1989-01-08', 'year' => '1989', 'name' => 'H'),
    array('date' => '1926-12-25', 'year' => '1926', 'name' => 'S'),
    array('date' => '1912-07-30', 'year' => '1912', 'name' => 'T'),
    array('date' => '1873-01-01', 'year' => '1868', 'name' => 'M'),// 明治6年1月1日以降
  );
  // 日付チェック
  if (chkDate($value) === false) {
    return '';
  }
  $arrad  = explode('-', str_replace('/', '-', $value));
  $addate = (int)sprintf('%d%02d%02d', (int)$arrad[0], (int)$arrad[1], (int)$arrad[2]);
  $result = '';
  foreach ($arr as $key=>$row) {
    // 日付チェック
    if (chkDate($row['date']) === false) {
      return '';
    }
    $arrjp  = explode('-', str_replace('/', '-', $row['date']));
    $jpdate = (int)sprintf('%d%02d%02d', (int)$arrjp[0], (int)$arrjp[1], (int)$arrjp[2]);
    // 元号の開始日と比較
    if ($addate >= $jpdate) {
      // 和暦年の計算
      $year = sprintf('%d', ((int)$arrad[0] - (int)$row['year']) + 1);
      if ((int)$year === 1) {
        $year = '元';
      }
      // 和暦年月日作成
      $result = $row['name'];
      break;
    }
  }
  return $result;
}



function info($table){

$sql="SHOW COLUMNS FROM ".$table;
$DB=new DB();
$res=$DB->query($sql);
if($res){
    while($res = $DB->fetch_assoc()){
    $ary[]=$res['Field'];
    }
  }
return $ary;
 }


function str_field($table){
$sql="SHOW COLUMNS FROM ".$table;
$DB=new DB();
$res=$DB->query($sql);
if($res){
    while($res = $DB->fetch_assoc()){
    $ary[]=$res['Field'];
    }
  }
return $ary;

}


/**
 * SQL文の生成 INSERT
 * 引数：$table テーブル名
 * 引数：$ary カラム名の配列
 * 戻値：INSERT文
 */

function str_insert($table,$ary){
$sql = "

    \$sql=\"INSERT INTO ".$table."
        (";
for ($i=0; $i < count($ary); $i++) {
  #もし配列になっていたら、値を$IN[要素]に書き変える
  if(is_array($ary[$i])){
    foreach($ary[$i] as $v){
    $value=$v;
    $k=array_keys($ary[$i],$v);
    $key=$k[0];
    }
  }else{
    $key=$ary[$i];
    $value=$ary[$i];
  } 
      $sql .= "
        `".$key."`,";
}
      $sql=rtrim($sql,',');
      $sql.="
      )VALUES(";
for ($i=0; $i < count($ary); $i++) {
  #もし配列になっていたら、値を$IN[要素]に書き変える
  if(is_array($ary[$i])){
    foreach($ary[$i] as $v){
    $value=$v;
    $k=array_keys($ary[$i],$v);
    $key=$k[0];
    }
  }else{
    $key=$ary[$i];
    $value=$ary[$i];
  } 
      $sql.="
        '{\$IN[\"".$value."\"]}',";    
}
     $sql=rtrim($sql,',');
      $sql.="
      )\";
      ";

     $sql.="
    \$res = \$DB->query(\$sql);
     if(!\$res){
      throw new Exception('');
     }

";

      return $sql;

}


function str_insert2($table){

$sql="SHOW COLUMNS FROM ".$table;
$DB=new DB();
$res=$DB->query($sql);
if($res){
    while($res = $DB->fetch_assoc()){
    $ary[]=$res['Field'];
    }
  }
$sql = "

    \$sql=\"INSERT INTO ".$table."
        (";
for ($i=0; $i < count($ary); $i++) {
  #もし配列になっていたら、値を$IN[要素]に書き変える
  if(is_array($ary[$i])){
    foreach($ary[$i] as $v){
    $value=$v;
    $k=array_keys($ary[$i],$v);
    $key=$k[0];
    }
  }else{
    $key=$ary[$i];
    $value=$ary[$i];
  } 
      $sql .= "
        `".$key."`,";
}
      $sql=rtrim($sql,',');
      $sql.="
      )VALUES(";
for ($i=0; $i < count($ary); $i++) {
  #もし配列になっていたら、値を$IN[要素]に書き変える
  if(is_array($ary[$i])){
    foreach($ary[$i] as $v){
    $value=$v;
    $k=array_keys($ary[$i],$v);
    $key=$k[0];
    }
  }else{
    $key=$ary[$i];
    $value=$ary[$i];
  } 
      $sql.="
        '{\$IN[\"".$value."\"]}',";    
}
     $sql=rtrim($sql,',');
      $sql.="
      )\";
      ";

     $sql.="
    \$res = \$DB->query(\$sql);
     if(!\$res){
      throw new Exception('');
     }

";

      return $sql;

}

/**
 * SQL文の生成 UPDATE
 * 引数：$table テーブル名
 * 引数：$ary カラム名の配列 二次元になっているとvalueが値になる
 * 引数：$needle キー　ex:WHERE needle = $IN["needle"]
 * 戻値：INSERT文
 */
function str_update2($table,$needle=''){

$sql="SHOW COLUMNS FROM ".$table;
$DB=new DB();
$res=$DB->query($sql);
if($res){
    while($res = $DB->fetch_assoc()){
    $ary[]=$res['Field'];
    }
  }

$sql = "

    \$sql=\"UPDATE ".$table."
        SET";
for ($i=0; $i < count($ary); $i++) {
  if(is_array($ary[$i])){
    foreach($ary[$i] as $v){
    $value=$v;
    $k=array_keys($ary[$i],$v);
    $key=$k[0];
    }
  }else{
    $key=$ary[$i];
    $value=$ary[$i];
  } 
      $sql.="
      ".$key."=";
      $sql.="'{\$IN[\"".$value."\"]}',";    
}
     $sql=rtrim($sql,',');
      $sql.="
      WHERE ".$needle." ='{\$IN[\"".$needle."\"]}'";
      $sql.="\";
      ";

     $sql.="
    \$res = \$DB->query(\$sql);
     if(!\$res){
      throw new Exception('');
     }

";

      return $sql;

}

function str_update($table,$ary,$needle=''){
$sql = "

    \$sql=\"UPDATE ".$table."
        SET";
for ($i=0; $i < count($ary); $i++) {
  if(is_array($ary[$i])){
    foreach($ary[$i] as $v){
    $value=$v;
    $k=array_keys($ary[$i],$v);
    $key=$k[0];
    }
  }else{
    $key=$ary[$i];
    $value=$ary[$i];
  } 
      $sql.="
      ".$key."=";
      $sql.="'{\$IN[\"".$value."\"]}',";    
}
     $sql=rtrim($sql,',');
      $sql.="
      WHERE ".$needle." ='{\$IN[\"".$needle."\"]}'";
      $sql.="\";
      ";

     $sql.="
    \$res = \$DB->query(\$sql);
     if(!\$res){
      throw new Exception('');
     }

";

      return $sql;

}

/**
 * SQL文の生成 SELECT
 * 引数：$table テーブル名
 * 引数：$ary カラム名の配列 二次元になっているとvalueが値になる
 * 戻値：INSERT文
 */

function str_select($table,$ryaku='SSC',$needle){
$sql = "

    \$sql=\"SELECT ".$ryaku.".*,
      pk.PSN_sei_kj AS FNF_kojin_sei_kj,
      pk.PSN_mei_kj AS FNF_kojin_mei_kj,
      pm.PSN_sei_kj AS FNF_mosyu_sei_kj,
      pm.PSN_mei_kj AS FNF_mosyu_mei_kj,
      SC01.SC_name AS SC_name01,
      SC02.SC_name AS SC_name02,
      FNF.*,SJO.*,AGT.*,OBT.*,


      DATE_FORMAT(".$ryaku.".CSC_coffing_time,'%k時%i分') AS CSC_coffing_time,

      DATE_FORMAT(SC01.SC_date,'%Y') AS SC_year01,
      DATE_FORMAT(SC02.SC_date,'%Y') AS SC_year02,
      DATE_FORMAT(SC01.SC_date,'%Y-%c-%e') AS SC_date01,
      DATE_FORMAT(SC02.SC_date,'%Y-%c-%e') AS SC_date02,
      TIME_FORMAT(SC01.SC_time,'%k時%i分') AS SC_time01,
      TIME_FORMAT(SC02.SC_time,'%k時%i分') AS SC_time02,
      TIME_FORMAT(SC01.SC_time_end,'%k時%i分') AS SC_time_end01,
      TIME_FORMAT(SC02.SC_time_end,'%k時%i分') AS SC_time_end02,
      DATE_FORMAT(FNF_kojin_botudate,'%Y%-%c-%e') AS FNF_kojin_botudate

      FROM `saijo_schedule` AS ".$ryaku."
      LEFT JOIN funeral_family AS FNF ON FNF.SSC_ID=".$ryaku.".SSC_ID
      LEFT JOIN person AS pk ON FNF_kojin_person_NO=pk.person_NO
      LEFT JOIN person AS pm ON FNF_mosyu_person_NO=pm.person_NO
      LEFT JOIN schedule AS SC01 ON ".$ryaku.".SC_ID01 = SC01.SC_ID
      LEFT JOIN schedule AS SC02 ON ".$ryaku.".SC_ID02 = SC02.SC_ID
      LEFT JOIN saijo AS SJO ON SJO.saijo_CD = ".$ryaku.".saijo_CD
      LEFT JOIN agent AS AGT ON AGT.agent_ID = S".$ryaku.".agent_ID
      LEFT JOIN funeral_obituary AS OBT ON OBT.SSC_ID = ".$ryaku.".SSC_ID
      WHERE ".$ryaku.".".$needle." = '{\$IN[\"".$needle."\"]}'";
      $sql.="\";
      ";

     $sql.="
    \$".$ryaku."_num = \$DB->query(\$sql);
     if(\$".$ryaku."){
        while(\$".$ryaku." = \$DB->fetch_assoc()){
          \$IN['LS'][] = \$".$ryaku.";
        }
      }else{

      }

";

      return $sql;

}





/**
 * SQL文の生成 DELETE
 * 引数：$table テーブル名
 * 引数：$ary カラム名の配列 二次元になっているとvalueが値になる
 * 戻値：INSERT文
 */

function str_delete($table,$ary=array(),$needle){
$sql = "

    \$sql=\"DELETE ".$table;
      $sql.="
      WHERE ".$needle." ='{\$IN[\"".$needle."\"]}'";
      $sql.="\";
      ";

     $sql.="
    \$res = \$DB->query(\$sql);
     if(!\$res){
      throw new Exception('');
     }

";

      return $sql;

}



/**
 * input hiddenの生成
 * 引数：$ary name="ary" value="{$IN.ary}"
 * 戻値：input hidden
 */

function str_inputHidden($ary){
$str = "";

for ($i=0; $i <count($ary) ; $i++) { 
$str .= '
        <input type="hidden" name="'.$ary[$i].'" value="{$IN[\''.$ary[$i].'\']}">';

}
      return $str;

}

/**
 * SQL文の生成 （prefixの置き換え）
 * 引数：ary カラム名
 * 引数：str 変換前prefix 
 * 引数：str 変換後prefix 
 * 戻値：
 */

function str_replacePrefix($ary,$ex,$new){
$str='
'; 
  for ($i=0; $i < count($ary); $i++) { 
    $str.='
       '.$ex.'.'.$ex.'_'.$ary[$i].' AS '.$new.'_'.$ary[$i].',';

}
return $str;


}

/**
 * ハイフンなしの電話番号からハイフン付き電話番号を復元する
 * 既にハイフンで区切られていた場合も正しく修正される
 * 引数：input 電話番号
 * 引数：strict 総務省資料に厳格に従う
 * 使い方：echo format_phone_number('0120828828'); // 0120-828-828
 */
function format_phone_number($input, $strict = false) {
    $groups = array(
        5 => 
        array (
            '01564' => 1,
            '01558' => 1,
            '01586' => 1,
            '01587' => 1,
            '01634' => 1,
            '01632' => 1,
            '01547' => 1,
            '05769' => 1,
            '04992' => 1,
            '04994' => 1,
            '01456' => 1,
            '01457' => 1,
            '01466' => 1,
            '01635' => 1,
            '09496' => 1,
            '08477' => 1,
            '08512' => 1,
            '08396' => 1,
            '08388' => 1,
            '08387' => 1,
            '08514' => 1,
            '07468' => 1,
            '01655' => 1,
            '01648' => 1,
            '01656' => 1,
            '01658' => 1,
            '05979' => 1,
            '04996' => 1,
            '01654' => 1,
            '01372' => 1,
            '01374' => 1,
            '09969' => 1,
            '09802' => 1,
            '09912' => 1,
            '09913' => 1,
            '01398' => 1,
            '01377' => 1,
            '01267' => 1,
            '04998' => 1,
            '01397' => 1,
            '01392' => 1,
        ),
        4 => 
        array (
            '0768' => 2,
            '0770' => 2,
            '0772' => 2,
            '0774' => 2,
            '0773' => 2,
            '0767' => 2,
            '0771' => 2,
            '0765' => 2,
            '0748' => 2,
            '0747' => 2,
            '0746' => 2,
            '0826' => 2,
            '0749' => 2,
            '0776' => 2,
            '0763' => 2,
            '0761' => 2,
            '0766' => 2,
            '0778' => 2,
            '0824' => 2,
            '0797' => 2,
            '0796' => 2,
            '0555' => 2,
            '0823' => 2,
            '0798' => 2,
            '0554' => 2,
            '0820' => 2,
            '0795' => 2,
            '0556' => 2,
            '0791' => 2,
            '0790' => 2,
            '0779' => 2,
            '0558' => 2,
            '0745' => 2,
            '0794' => 2,
            '0557' => 2,
            '0799' => 2,
            '0738' => 2,
            '0567' => 2,
            '0568' => 2,
            '0585' => 2,
            '0586' => 2,
            '0566' => 2,
            '0564' => 2,
            '0565' => 2,
            '0587' => 2,
            '0584' => 2,
            '0581' => 2,
            '0572' => 2,
            '0574' => 2,
            '0573' => 2,
            '0575' => 2,
            '0576' => 2,
            '0578' => 2,
            '0577' => 2,
            '0569' => 2,
            '0594' => 2,
            '0827' => 2,
            '0736' => 2,
            '0735' => 2,
            '0725' => 2,
            '0737' => 2,
            '0739' => 2,
            '0743' => 2,
            '0742' => 2,
            '0740' => 2,
            '0721' => 2,
            '0599' => 2,
            '0561' => 2,
            '0562' => 2,
            '0563' => 2,
            '0595' => 2,
            '0596' => 2,
            '0598' => 2,
            '0597' => 2,
            '0744' => 2,
            '0852' => 2,
            '0956' => 2,
            '0955' => 2,
            '0954' => 2,
            '0952' => 2,
            '0957' => 2,
            '0959' => 2,
            '0966' => 2,
            '0965' => 2,
            '0964' => 2,
            '0950' => 2,
            '0949' => 2,
            '0942' => 2,
            '0940' => 2,
            '0930' => 2,
            '0943' => 2,
            '0944' => 2,
            '0948' => 2,
            '0947' => 2,
            '0946' => 2,
            '0967' => 2,
            '0968' => 2,
            '0987' => 2,
            '0986' => 2,
            '0985' => 2,
            '0984' => 2,
            '0993' => 2,
            '0994' => 2,
            '0997' => 2,
            '0996' => 2,
            '0995' => 2,
            '0983' => 2,
            '0982' => 2,
            '0973' => 2,
            '0972' => 2,
            '0969' => 2,
            '0974' => 2,
            '0977' => 2,
            '0980' => 2,
            '0979' => 2,
            '0978' => 2,
            '0920' => 2,
            '0898' => 2,
            '0855' => 2,
            '0854' => 2,
            '0853' => 2,
            '0553' => 2,
            '0856' => 2,
            '0857' => 2,
            '0863' => 2,
            '0859' => 2,
            '0858' => 2,
            '0848' => 2,
            '0847' => 2,
            '0835' => 2,
            '0834' => 2,
            '0833' => 2,
            '0836' => 2,
            '0837' => 2,
            '0846' => 2,
            '0845' => 2,
            '0838' => 2,
            '0865' => 2,
            '0866' => 2,
            '0892' => 2,
            '0889' => 2,
            '0887' => 2,
            '0893' => 2,
            '0894' => 2,
            '0897' => 2,
            '0896' => 2,
            '0895' => 2,
            '0885' => 2,
            '0884' => 2,
            '0869' => 2,
            '0868' => 2,
            '0867' => 2,
            '0875' => 2,
            '0877' => 2,
            '0883' => 2,
            '0880' => 2,
            '0879' => 2,
            '0829' => 2,
            '0550' => 2,
            '0228' => 2,
            '0226' => 2,
            '0225' => 2,
            '0224' => 2,
            '0229' => 2,
            '0233' => 2,
            '0237' => 2,
            '0235' => 2,
            '0234' => 2,
            '0223' => 2,
            '0220' => 2,
            '0192' => 2,
            '0191' => 2,
            '0187' => 2,
            '0193' => 2,
            '0194' => 2,
            '0198' => 2,
            '0197' => 2,
            '0195' => 2,
            '0238' => 2,
            '0240' => 2,
            '0260' => 2,
            '0259' => 2,
            '0258' => 2,
            '0257' => 2,
            '0261' => 2,
            '0263' => 2,
            '0266' => 2,
            '0265' => 2,
            '0264' => 2,
            '0256' => 2,
            '0255' => 2,
            '0243' => 2,
            '0242' => 2,
            '0241' => 2,
            '0244' => 2,
            '0246' => 2,
            '0254' => 2,
            '0248' => 2,
            '0247' => 2,
            '0186' => 2,
            '0185' => 2,
            '0144' => 2,
            '0143' => 2,
            '0142' => 2,
            '0139' => 2,
            '0145' => 2,
            '0146' => 2,
            '0154' => 2,
            '0153' => 2,
            '0152' => 2,
            '0138' => 2,
            '0137' => 2,
            '0125' => 2,
            '0124' => 2,
            '0123' => 2,
            '0126' => 2,
            '0133' => 2,
            '0136' => 2,
            '0135' => 2,
            '0134' => 2,
            '0155' => 2,
            '0156' => 2,
            '0176' => 2,
            '0175' => 2,
            '0174' => 2,
            '0178' => 2,
            '0179' => 2,
            '0184' => 2,
            '0183' => 2,
            '0182' => 2,
            '0173' => 2,
            '0172' => 2,
            '0162' => 2,
            '0158' => 2,
            '0157' => 2,
            '0163' => 2,
            '0164' => 2,
            '0167' => 2,
            '0166' => 2,
            '0165' => 2,
            '0267' => 2,
            '0250' => 2,
            '0533' => 2,
            '0422' => 2,
            '0532' => 2,
            '0531' => 2,
            '0436' => 2,
            '0428' => 2,
            '0536' => 2,
            '0299' => 2,
            '0294' => 2,
            '0293' => 2,
            '0475' => 2,
            '0295' => 2,
            '0297' => 2,
            '0296' => 2,
            '0495' => 2,
            '0438' => 2,
            '0466' => 2,
            '0465' => 2,
            '0467' => 2,
            '0478' => 2,
            '0476' => 2,
            '0470' => 2,
            '0463' => 2,
            '0479' => 2,
            '0493' => 2,
            '0494' => 2,
            '0439' => 2,
            '0268' => 2,
            '0480' => 2,
            '0460' => 2,
            '0538' => 2,
            '0537' => 2,
            '0539' => 2,
            '0279' => 2,
            '0548' => 2,
            '0280' => 2,
            '0282' => 2,
            '0278' => 2,
            '0277' => 2,
            '0269' => 2,
            '0270' => 2,
            '0274' => 2,
            '0276' => 2,
            '0283' => 2,
            '0551' => 2,
            '0289' => 2,
            '0287' => 2,
            '0547' => 2,
            '0288' => 2,
            '0544' => 2,
            '0545' => 2,
            '0284' => 2,
            '0291' => 2,
            '0285' => 2,
            '0120' => 3,
            '0570' => 3,
            '0800' => 3,
            '0990' => 3,
        ),
        3 => 
        array (
            '099' => 3,
            '054' => 3,
            '058' => 3,
            '098' => 3,
            '095' => 3,
            '097' => 3,
            '052' => 3,
            '053' => 3,
            '011' => 3,
            '096' => 3,
            '049' => 3,
            '015' => 3,
            '048' => 3,
            '072' => 3,
            '084' => 3,
            '028' => 3,
            '024' => 3,
            '076' => 3,
            '023' => 3,
            '047' => 3,
            '029' => 3,
            '075' => 3,
            '025' => 3,
            '055' => 3,
            '026' => 3,
            '079' => 3,
            '082' => 3,
            '027' => 3,
            '078' => 3,
            '077' => 3,
            '083' => 3,
            '022' => 3,
            '086' => 3,
            '089' => 3,
            '045' => 3,
            '044' => 3,
            '092' => 3,
            '046' => 3,
            '017' => 3,
            '093' => 3,
            '059' => 3,
            '073' => 3,
            '019' => 3,
            '087' => 3,
            '042' => 3,
            '018' => 3,
            '043' => 3,
            '088' => 3,
            '050' => 4,
        ),
        2 => 
        array (
            '04' => 4,
            '03' => 4,
            '06' => 4,
        ),
    );
    $groups[3] += 
        $strict ?
        array(
            '020' => 3,
            '070' => 3,
            '080' => 3,
            '090' => 3,
        ) :
        array(
            '020' => 4,
            '070' => 4,
            '080' => 4,
            '090' => 4,
        )
    ;
    $number = preg_replace('/[^\d]++/', '', $input);
    foreach ($groups as $len => $group) {
        $area = substr($number, 0, $len);
        if (isset($group[$area])) {
            $formatted = implode('-', array(
                $area,
                substr($number, $len, $group[$area]),
                substr($number, $len + $group[$area])
            ));
            return strrchr($formatted, '-') !== '-' ? $formatted : $input;
        }
    }
    $pattern = '/\A(00(?:[013-8]|2\d|91[02-9])\d)(\d++)\z/';
    if (preg_match($pattern, $number, $matches)) {
        return $matches[1] . '-' . $matches[2];
    }
    return $input;
}


function mkran32(){
 return md5(uniqid(rand(),1));
}

/**
 * $IN["PRI_ID"] = randomstr(6, '0123456789','prior_inquiry','PRI_ID');
 * 指定された桁数のランダム文字列を生成する
 * （古い環境では暗号学的な強さにならない場合もあるが、ほとんどの環境は問題ない）
 * 
 * @param int $length 求める文字列の長さ（桁数）
 * @param string $chars ランダム文字列に使用したい文字一覧
 *
 * 16進数の範囲で16桁の文字列を生成する場合
 * $rand1 = randomstr(16, '0123456789ABCDEF');
 * 32進数（Ｂａｓｅ３２）の範囲で16桁の文字列を生成する場合
 * $rand2 = randomstr(16, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ234567');
 * 英数大小文字の範囲で16桁の文字列を生成する場合
 * $rand3 = randomstr(16, 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789');
 * 
 * 第三引数に$table名とカラム名を入れると該当テーブルのカラムを生成した乱数で検索し、該当があった場合はループし、新しい乱数をつくる
 */

 function randomstr($length, $chars,$table='',$column=''){
  if($table){
    $DB=new DB();
    while(true){
      $retstr = '';
      $data = openssl_random_pseudo_bytes($length);
      $num_chars = strlen($chars);
      for ($i = 0; $i < $length; $i++){
        $retstr .= substr($chars, ord(substr($data, $i, 1)) % $num_chars, 1);
      }
      $sql="SELECT {$column} FROM {$table} WHERE {$column} = '{$retstr}'";
      $res = $DB->query($sql);
      if(!$res){
        break;
      }
    }
  }else{
    $retstr = '';
    $data = openssl_random_pseudo_bytes($length);
    $num_chars = strlen($chars);
    for ($i = 0; $i < $length; $i++){
      $retstr .= substr($chars, ord(substr($data, $i, 1)) % $num_chars, 1);
    }
  }

  return $retstr;
}






function mkPager($ary,$num){
$page=1;
  $result['count']=count($ary);
  $result['page_per']=$num;
  $result['page_last']='';

  for ($i=0; $i <count($ary) ; $i++) { 
    if($i!=0&&$i%$num==0){
      $page++;
    }
    $result['pages'][$page][]=$ary[$i];
  }

  $result['page_last']=$page;
return $result;

}

function userTrace($IN){
if($IN["ID"]=='ikuta'||$IN["ID"]=='saitoh'||$IN["ID"]=='toru'){
print_r($IN);
}
}

/* --------------------------
$res['icon']=icon($res);
--------------------------*/
function icon($ary){
  if($ary['agent_ID']!='0'){
    $result=$ary['agent_ID'];
  }

  if($ary['owner_ID']=='outside'){
    $result=99;
  }else{
    if($ary['SSC_client']>=51){
      $result=$ary['agent_ID'];
    }
    if($ary['SSC_client']<=50){
      $result=$ary['SSC_client'];
    }
  }
  return $result;
}



function howOld($birthday){
  $result='';
  if($birthday!=''){
    list($y,$m,$d) = explode('-',$birthday);
    if(checkdate($m,$d,$y) === true){
      $now = date("Ymd");
      $birthday = str_replace("-", "", $birthday);
      $result = floor(($now-$birthday)/10000);
    }  
  }
  return $result;
}


/*-----------------------
2021-07-14 改定 saito
今ご遺体がどこにあるか判定
日時を4つ、配列で渡す
-------------------------*/
function whereBody($ary,$i=0){
  $now = new Carbon();
    $now = $now -> addHours($i);
  foreach ($ary as $k => $v) {
    $BSC=$k+1;
    //BSC番号ゼロ埋めして言い換え
    $BSC=str_pad($BSC, 2, 0, STR_PAD_LEFT); // 01
    
    if($v!='0000-00-00 00:00:00'&&$v!='0000-00-00 99:00:00'&&$v!='0000-00-00 23:59:00'){
      $BSC_date=Carbon::parse($v);
      if($now<$BSC_date){
        //今を過ぎているか
        $flag=1;
      }else{
        $flag=0;
        $result['now']=$BSC;
      }
      $result['log'][]=array('key'=>$BSC,'datetime'=>$v,'Carbon'=>$date,'flag'=>$flag);
    }
  }
  return $result;
}

function FNP_agent($agt,$cli){

  if($cli>'50'){
    $result=$agt;
  }
  else if($cli=='28'){
    $result='01';
  }
  else{
    $result=$cli;
  }

  return $result;

}

/*PRF読み込み */
function IN_PRF($PRF_CD){
  $DB = new DB();
  $PT = new PT();
  $sql="SELECT PRF.*,
  MEM01.member_ID AS MEM01,
  MEM02.member_ID AS MEM02,
  OMS.OMS_name
  FROM prior_family AS PRF
  LEFT JOIN member AS MEM01 ON MEM01.person_NO = PRF.PRF_shinpai_person_NO AND PRF.PRF_shinpai_person_NO != 0
  LEFT JOIN member AS MEM02 ON MEM02.person_NO = PRF.PRF_irai_person_NO AND PRF.PRF_irai_person_NO != 0
  LEFT JOIN owner AS OMS ON OMS.owner_ID = PRF.PRFowner_ID
  WHERE PRF_CD ='$PRF_CD'";
  $res=$DB->query($sql);
  if($res){
    while($res=$DB->fetch_assoc()){
      if($res['MEM01']){
        $res['MEM01_star']='<img src="image/member.png" style="width:14px;height:auto;" alt="">';
      }else{$res['MEM01_star']='';}

      if($res['MEM02']){
        $res['MEM02_star']='<img src="image/member.png" style="width:14px;height:auto;" alt="">';
      }else{$res['MEM02_star']='';}
      if($res['MEM01']||$res['MEM02']){
        $res['member_flag']=1;
      }

      if($res["PRF_shinpai_sei_kj"].$res["PRF_shinpai_mei_kj"].$res["PRF_shinpai_sei_kn"].$res["PRF_shinpai_mei_kn"].$res["PRF_shinpai_zokugara"]!=''){
        $res["is_shinpai"]=1;
      }else{
        $res["is_shinpai"]=0;
      }

      if($res["PRF_irai_sei_kj"].$res["PRF_irai_mei_kj"].$res["PRF_irai_sei_kn"].$res["PRF_irai_mei_kn"].$res["PRF_irai_zokugara"]!=''){
        $res["is_irai"]=1;
      }else{
        $res["is_irai"]=0;
      }

      $result=$res;
      }
    return $result;
  }
}