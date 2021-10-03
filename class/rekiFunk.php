<?php
#=========================================================================
# 六曜算出関数
#
# 引数：新暦年月日
# 戻値：0:大安 1:赤口 2:先勝 3:友引 4:先負 5:仏滅
#
#=========================================================================
function get_rokuyou($year,$mon,$day)
{

	list($q_yaer,$uruu,$q_mon,$q_day) = calc_kyureki($year,$mon,$day);

	return(($q_mon + $q_day) % 6);
}

#=========================================================================
# 新暦に対応する、旧暦を求める。
#
# 呼び出し時にセットする変数
# 引　数　year : 計算する日付
#         mon
#         day
#
# 戻り値　kyureki : 答えの格納先（配列に答えをかえす）
#         　　  kyureki[0] : 旧暦年
#         　　  kyureki[1] : 平月／閏月 flag .... 平月:0 閏月:1
#         　　  kyureki[2] : 旧暦月
#         　　  kyureki[3] : 旧暦日
#
#=========================================================================
function calc_kyureki($year,$mon,$day)
{

	$tm0 = YMDT2JD($year,$mon,$day,0,0,0);
#-----------------------------------------------------------------------
# 計算対象の直前にあたる二分二至の時刻を求める
# chu[0,0]:二分二至の時刻  chu[0,1]:その時の太陽黄経
#-----------------------------------------------------------------------
	list($chu[0][0],$chu[0][1]) = before_nibun($tm0);

#-----------------------------------------------------------------------
# 中気の時刻を計算（４回計算する）
# chu[i,0]:中気の時刻  chu[i,1]:太陽黄経
#-----------------------------------------------------------------------
	for($i=1;$i<4;$i++){
		list($chu[$i][0],$chu[$i][1]) = calc_chu($chu[$i-1][0]+32.0);
	}

#-----------------------------------------------------------------------
#  計算対象の直前にあたる二分二至の直前の朔の時刻を求める
#-----------------------------------------------------------------------
	$saku[0] = calc_saku($chu[0][0]);

#-----------------------------------------------------------------------
# 朔の時刻を求める
#-----------------------------------------------------------------------
	for($i=1;$i<5;$i++){
		$tm=$saku[$i-1];
		$tm += 30.0;
		$saku[$i]=calc_saku($tm);

# 前と同じ時刻を計算した場合（両者の差が26日以内）には、初期値を
# +33日にして再実行させる。
		if( abs( int($saku[$i-1])-int($saku[$i]) ) <= 26.0 ){
			$saku[$i]=calc_saku($saku[$i-1]+35.0);
		}
	}

#-----------------------------------------------------------------------
# saku[1]が二分二至の時刻以前になってしまった場合には、朔をさかのぼり過ぎ
# たと考えて、朔の時刻を繰り下げて修正する。
# その際、計算もれ（saku[4]）になっている部分を補うため、朔の時刻を計算
# する。（近日点通過の近辺で朔があると起こる事があるようだ...？）
#-----------------------------------------------------------------------
	if( int($saku[1]) <= int($chu[0][0]) ){
		for($i=0;$i<5;$i++){
			$saku[$i]=$saku[$i+1];
		}
		$saku[4] = calc_saku($saku[3]+35.0);
	}

#-----------------------------------------------------------------------
# saku[0]が二分二至の時刻以後になってしまった場合には、朔をさかのぼり足
# りないと見て、朔の時刻を繰り上げて修正する。
# その際、計算もれ（saku[0]）になっている部分を補うため、朔の時刻を計算
# する。（春分点の近辺で朔があると起こる事があるようだ...？）
#-----------------------------------------------------------------------
	elseif( int($saku[0]) > int($chu[0][0]) ){
		for($i=4;$i>0;$i--){
			$saku[$i] = $saku[$i-1];
		}
		$saku[0] = calc_saku($saku[0]-27.0);
	}

#-----------------------------------------------------------------------
# 閏月検索Ｆｌａｇセット
# （節月で４ヶ月の間に朔が５回あると、閏月がある可能性がある。）
# lap=0:平月  lap=1:閏月
#-----------------------------------------------------------------------
	if(int($saku[4]) <= int($chu[3][0]) ){
		$lap=1;
	}else{
		$lap=0;
	}

#-----------------------------------------------------------------------
# 朔日行列の作成
# m[i,0] ... 月名（1:正月 2:２月 3:３月 ....）
# m[i,1] ... 閏フラグ（0:平月 1:閏月）
# m[i,2] ... 朔日のjd
#-----------------------------------------------------------------------
	$m[0][0]=int($chu[0][1]/30.0) + 2;
	if( $m[0][1] > 12 ){
		$m[0][0]-=12;
	}
	$m[0][2]=int($saku[0]);
	$m[0][1]=0;

	for($i=1;$i<5;$i++){
		if($lap == 1 && $i !=1 ){
			if( int($chu[$i-1][0]) <= int($saku[$i-1]) || int($chu[$i-1][0]) >= int($saku[$i]) ){
				$m[$i-1][0] = $m[$i-2][0];
				$m[$i-1][1] = 1;
				$m[$i-1][2] = int($saku[$i-1]);
				$lap=0;
			}
		}
		$m[$i][0] = $m[$i-1][0]+1;
		if( $m[$i][0] > 12 ){
			$m[$i][0]-=12;
		}
		$m[$i][2]=int($saku[$i]);
		$m[$i][1]=0;
	}

#-----------------------------------------------------------------------
# 朔日行列から旧暦を求める。
#-----------------------------------------------------------------------
	$state=0;
	for($i=0;$i<5;$i++){
		if(int($tm0) < int($m[$i][2])){
			$state=1;
			break;
		}elseif(int($tm0) == int($m[$i][2])){
			$state=2;
			break;
		}
	}
	if($state==0||$state==1){
		$i--;
	}

	$kyureki[1]=$m[$i][1];
	$kyureki[2]=$m[$i][0];
	$kyureki[3]=int($tm0)-int($m[$i][2])+1;

#-----------------------------------------------------------------------
# 旧暦年の計算
# （旧暦月が10以上でかつ新暦月より大きい場合には、
#   まだ年を越していないはず...）
#-----------------------------------------------------------------------

	$a = JD2YMDT($tm0);
	$kyureki[0] = $a[0];
	if($kyureki[2] > 9 && $kyureki[2] > $a[1]){
		$kyureki[0]--;
	}

	return array($kyureki[0],$kyureki[1],$kyureki[2],$kyureki[3]);

}

#=========================================================================
# 中気の時刻を求める
# 
# 呼び出し時にセットする変数
# tm ........ 計算対象となる時刻（ユリウス日）
# chu ....... 戻り値を格納する配列のポインター
# i ......... 戻り値を格納する配列の要素番号
# 戻り値 .... 中気の時刻、その時の黄経を配列で渡す
#
#=========================================================================
function calc_chu($tm)
{
#-----------------------------------------------------------------------
#時刻引数を分解する
#-----------------------------------------------------------------------
	$tm1 = int( $tm );
	$tm2 = $tm - $tm1;

#-----------------------------------------------------------------------
# JST ==> DT （補正時刻=0.0sec と仮定して計算）
#-----------------------------------------------------------------------
	$tm2-=9.0/24.0;

#-----------------------------------------------------------------------
# 中気の黄経 λsun0 を求める
#-----------------------------------------------------------------------
	$t=($tm2+0.5) / 36525.0;
	$t=$t + ($tm1-2451545.0) / 36525.0;
	$rm_sun = LONGITUDE_SUN( $t );

	$rm_sun0 = 30.0*int($rm_sun/30.0);

#-----------------------------------------------------------------------
# 繰り返し計算によって中気の時刻を計算する
# （誤差が±1.0 sec以内になったら打ち切る。）
#-----------------------------------------------------------------------
	for( $delta_t2 = 1.0 ; abs( $delta_t1 + $delta_t2 ) > ( 1.0 / 86400.0 ) ; ){

#-----------------------------------------------------------------------
# λsun を計算
#-----------------------------------------------------------------------
		$t =($tm2+0.5) / 36525.0;
		$t =$t + ($tm1-2451545.0) / 36525.0;
		$rm_sun=LONGITUDE_SUN( $t );

#-----------------------------------------------------------------------
# 黄経差 Δλ＝λsun －λsun0
#-----------------------------------------------------------------------
		$delta_rm = $rm_sun - $rm_sun0 ;

#-----------------------------------------------------------------------
# Δλの引き込み範囲（±180°）を逸脱した場合には、補正を行う
#-----------------------------------------------------------------------
		if( $delta_rm > 180.0 ){
			$delta_rm-=360.0;
		}elseif( $delta_rm < -180.0 ){
			$delta_rm+=360.0;
		}

#-----------------------------------------------------------------------
# 時刻引数の補正値 Δt
# delta_t = delta_rm * 365.2 / 360.0;
#-----------------------------------------------------------------------
		$delta_t1 = int($delta_rm * 365.2 / 360.0);
		$delta_t2 = $delta_rm * 365.2 / 360.0;
		$delta_t2 -= $delta_t1;

#-----------------------------------------------------------------------
# 時刻引数の補正
# tm -= delta_t;
#-----------------------------------------------------------------------
		$tm1 = $tm1 - $delta_t1;
		$tm2 = $tm2 - $delta_t2;
		if($tm2 < 0){
			$tm2+=1.0;$tm1-=1.0;
		}
	}

#-----------------------------------------------------------------------
# 戻り値の作成
# chu[i,0]:時刻引数を合成するのと、DT ==> JST 変換を行い、戻り値とする
# （補正時刻=0.0sec と仮定して計算）
# chu[i,1]:黄経
#-----------------------------------------------------------------------
	$temp[0] = $tm2+9.0/24.0;
	$temp[0] += $tm1;
	$temp[1] = $rm_sun0;

	return array($temp[0],$temp[1]);
}

#=========================================================================
# 直前の二分二至の時刻を求める
#
# 呼び出し時にセットする変数
# tm ........ 計算対象となる時刻（ユリウス日）
# nibun ..... 戻り値を格納する配列のポインター
# 戻り値 .... 二分二至の時刻、その時の黄経を配列で渡す
# （戻り値の渡し方がちょっと気にくわないがまぁいいや。）
#=========================================================================
function before_nibun($tm)
{

#-----------------------------------------------------------------------
#時刻引数を分解する
#-----------------------------------------------------------------------
	$tm1 = int( $tm );
	$tm2 = $tm - $tm1;

#-----------------------------------------------------------------------
# JST ==> DT （補正時刻=0.0sec と仮定して計算）
#-----------------------------------------------------------------------
	$tm2-=9.0/24.0;

#-----------------------------------------------------------------------
# 直前の二分二至の黄経 λsun0 を求める
#-----------------------------------------------------------------------
	$t=($tm2+0.5) / 36525.0;
	$t=$t + ($tm1-2451545.0) / 36525.0;
	$rm_sun=LONGITUDE_SUN( $t );
	$rm_sun0=90*int($rm_sun/90.0);

#-----------------------------------------------------------------------
# 繰り返し計算によって直前の二分二至の時刻を計算する
# （誤差が±1.0 sec以内になったら打ち切る。）
#-----------------------------------------------------------------------
	for( $delta_t2 = 1.0 ; abs( $delta_t1+$delta_t2 ) > ( 1.0 / 86400.0 ) ; ){

#-----------------------------------------------------------------------
# λsun を計算
#-----------------------------------------------------------------------
		$t=($tm2+0.5) / 36525.0;
		$t=$t + ($tm1-2451545.0) / 36525.0;
		$rm_sun=LONGITUDE_SUN( $t );

#-----------------------------------------------------------------------
# 黄経差 Δλ＝λsun －λsun0
#-----------------------------------------------------------------------
		$delta_rm = $rm_sun - $rm_sun0 ;

#-----------------------------------------------------------------------
# Δλの引き込み範囲（±180°）を逸脱した場合には、補正を行う
#-----------------------------------------------------------------------
		if( $delta_rm > 180.0 ){
			$delta_rm-=360.0;
		}elseif( $delta_rm < -180.0){
			$delta_rm+=360.0;
		}

#-----------------------------------------------------------------------
# 時刻引数の補正値 Δt
# delta_t = delta_rm * 365.2 / 360.0;
#-----------------------------------------------------------------------
		$delta_t1 = int($delta_rm * 365.2 / 360.0);
		$delta_t2 = $delta_rm * 365.2 / 360.0;
		$delta_t2 -= $delta_t1;

#-----------------------------------------------------------------------
# 時刻引数の補正
# tm -= delta_t;
#-----------------------------------------------------------------------
		$tm1 = $tm1 - $delta_t1;
		$tm2 = $tm2 - $delta_t2;
		if($tm2 < 0){
			$tm2+=1.0;$tm1-=1.0;
		}

	}

#-----------------------------------------------------------------------
# 戻り値の作成
# nibun[0,0]:時刻引数を合成するのと、DT ==> JST 変換を行い、戻り値とする
# （補正時刻=0.0sec と仮定して計算）
# nibun[0,1]:黄経
#-----------------------------------------------------------------------
	$nibun[0] = $tm2+9.0/24.0;
	$nibun[0] += $tm1;
	$nibun[1] = $rm_sun0;

	return array($nibun[0],$nibun[1]);

}

#=========================================================================
# 朔の計算
# 与えられた時刻の直近の朔の時刻（JST）を求める
#
# 呼び出し時にセットする変数
# tm ........ 計算対象となる時刻（ユリウス日）
# 戻り値 .... 朔の時刻
#
# ※ 引数、戻り値ともユリウス日で表し、時分秒は日の小数で表す。
#
#=========================================================================
function calc_saku($tm)
{

#-----------------------------------------------------------------------
# ループカウンタのセット
#-----------------------------------------------------------------------
	$lc=1;

#-----------------------------------------------------------------------
#時刻引数を分解する
#-----------------------------------------------------------------------
	$tm1 = int( $tm );
	$tm2 = $tm - $tm1;

#-----------------------------------------------------------------------
# JST ==> DT （補正時刻=0.0sec と仮定して計算）
#-----------------------------------------------------------------------
	$tm2-=9.0/24.0;

#-----------------------------------------------------------------------
# 繰り返し計算によって朔の時刻を計算する
# （誤差が±1.0 sec以内になったら打ち切る。）
#-----------------------------------------------------------------------
	for( $delta_t2 = 1.0 ; abs( $delta_t1+$delta_t2 ) > ( 1.0 / 86400.0 ) ; $lc++){

#-----------------------------------------------------------------------
# 太陽の黄経λsun ,月の黄経λmoon を計算
# t = (tm - 2451548.0 + 0.5)/36525.0;
#-----------------------------------------------------------------------
		$t=($tm2+0.5) / 36525.0;
		$t=$t + ($tm1-2451545.0) / 36525.0;
		$rm_sun=LONGITUDE_SUN( $t );
		$rm_moon=LONGITUDE_MOON( $t );

#-----------------------------------------------------------------------
# 月と太陽の黄経差Δλ
# Δλ＝λmoon－λsun
#-----------------------------------------------------------------------
		$delta_rm = $rm_moon - $rm_sun ;

#-----------------------------------------------------------------------
# ループの１回目（lc=1）で delta_rm < 0.0 の場合には引き込み範囲に
# 入るように補正する
#-----------------------------------------------------------------------
		if( $lc==1 && $delta_rm < 0.0 ){
			$delta_rm = NORMALIZATION_ANGLE( $delta_rm );
		}
#-----------------------------------------------------------------------
#   春分の近くで朔がある場合（0 ≦λsun≦ 20）で、月の黄経λmoon≧300 の
#   場合には、Δλ＝ 360.0 － Δλ と計算して補正する
#-----------------------------------------------------------------------
		elseif( $rm_sun >= 0 && $rm_sun <= 20 && $rm_moon >= 300 ){
			$delta_rm = NORMALIZATION_ANGLE( $delta_rm );
			$delta_rm = 360.0 - $delta_rm;
		}
#-----------------------------------------------------------------------
# Δλの引き込み範囲（±40°）を逸脱した場合には、補正を行う
#-----------------------------------------------------------------------
		elseif( abs( $delta_rm ) > 40.0 ) {
			$delta_rm = NORMALIZATION_ANGLE( $delta_rm );
		}

#-----------------------------------------------------------------------
# 時刻引数の補正値 Δt
# delta_t = delta_rm * 29.530589 / 360.0;
#-----------------------------------------------------------------------
		$delta_t1 = int($delta_rm * 29.530589 / 360.0);
		$delta_t2 = $delta_rm * 29.530589 / 360.0;
		$delta_t2 -= $delta_t1;

#-----------------------------------------------------------------------
# 時刻引数の補正
# tm -= delta_t;
#-----------------------------------------------------------------------
		$tm1 = $tm1 - $delta_t1;
		$tm2 = $tm2 - $delta_t2;
		if($tm2 < 0.0){
			$tm2+=1.0;$tm1-=1.0;
		}

#-----------------------------------------------------------------------
# ループ回数が15回になったら、初期値 tm を tm-26 とする。
#-----------------------------------------------------------------------
		if($lc == 15 && abs( $delta_t1+$delta_t2 ) > ( 1.0 / 86400.0 ) ){
			$tm1 = int( $tm-26 );
			$tm2 = 0;
		}

#-----------------------------------------------------------------------
# 初期値を補正したにも関わらず、振動を続ける場合には初期値を答えとして
# 返して強制的にループを抜け出して異常終了させる。
#-----------------------------------------------------------------------
		elseif( $lc > 30 && abs( $delta_t1+$delta_t2 ) > ( 1.0 / 86400.0 ) ){
			$tm1=$tm;$tm2=0;
			break;
		}
	}

#-----------------------------------------------------------------------
# 時刻引数を合成するのと、DT ==> JST 変換を行い、戻り値とする
# （補正時刻=0.0sec と仮定して計算）
#-----------------------------------------------------------------------

	return($tm2+$tm1+9.0/24.0);
}

#=========================================================================
#  角度の正規化を行う。すなわち引数の範囲を ０≦θ＜３６０ にする。
#=========================================================================
function NORMALIZATION_ANGLE($angle)
{

	if( $angle < 0.0 ){
		$angle1 = -$angle;
		$angle2 = int( $angle1 / 360.0 );
		$angle1 -= 360.0 * $angle2;
		$angle1 = 360.0 - $angle1;
	}else{
		$angle1 = int( $angle / 360.0 );
		$angle1 = $angle - 360.0 * $angle1;
	}

	return($angle1);
}

#=========================================================================
# 太陽の黄経 λsun を計算する
#=========================================================================
function LONGITUDE_SUN($t)
{
#-----------------------------------------------------------------------
# 円周率の定義と（角度の）度からラジアンに変換する係数の定義
#-----------------------------------------------------------------------
$PI=3.141592653589793238462;
$k=$PI/180.0;

#-----------------------------------------------------------------------
# 摂動項の計算
#-----------------------------------------------------------------------
	$ang = NORMALIZATION_ANGLE(  31557.0 * $t + 161.0 );
	$th =       .0004 * cos( $k*$ang );
	$ang = NORMALIZATION_ANGLE(  29930.0 * $t +  48.0 );
	$th = $th +  .0004 * cos( $k*$ang );
	$ang = NORMALIZATION_ANGLE(   2281.0 * $t + 221.0 );
	$th = $th +  .0005 * cos( $k*$ang );
	$ang = NORMALIZATION_ANGLE(    155.0 * $t + 118.0 );
	$th = $th +  .0005 * cos( $k*$ang );
	$ang = NORMALIZATION_ANGLE(  33718.0 * $t + 316.0 );
	$th = $th +  .0006 * cos( $k*$ang );
	$ang = NORMALIZATION_ANGLE(   9038.0 * $t +  64.0 );
	$th = $th +  .0007 * cos( $k*$ang );
	$ang = NORMALIZATION_ANGLE(   3035.0 * $t + 110.0 );
	$th = $th +  .0007 * cos( $k*$ang );
	$ang = NORMALIZATION_ANGLE(  65929.0 * $t +  45.0 );
	$th = $th +  .0007 * cos( $k*$ang );
	$ang = NORMALIZATION_ANGLE(  22519.0 * $t + 352.0 );
	$th = $th +  .0013 * cos( $k*$ang );
	$ang = NORMALIZATION_ANGLE(  45038.0 * $t + 254.0 );
	$th = $th +  .0015 * cos( $k*$ang );
	$ang = NORMALIZATION_ANGLE( 445267.0 * $t + 208.0 );
	$th = $th +  .0018 * cos( $k*$ang );
	$ang = NORMALIZATION_ANGLE(     19.0 * $t + 159.0 );
	$th = $th +  .0018 * cos( $k*$ang );
	$ang = NORMALIZATION_ANGLE(  32964.0 * $t + 158.0 );
	$th = $th +  .0020 * cos( $k*$ang );
	$ang = NORMALIZATION_ANGLE(  71998.1 * $t + 265.1 );
	$th = $th +  .0200 * cos( $k*$ang );
	$ang = NORMALIZATION_ANGLE(  35999.05 * $t + 267.52 );
	$th = $th - 0.0048 * $t * cos( $k*$ang ) ;
	$th = $th + 1.9147     * cos( $k*$ang ) ;

#-----------------------------------------------------------------------
# 比例項の計算
#-----------------------------------------------------------------------
	$ang = NORMALIZATION_ANGLE( 36000.7695 * $t );
	$ang = NORMALIZATION_ANGLE( $ang + 280.4659 );
	$th  = NORMALIZATION_ANGLE( $th + $ang );

	return($th);
}

#=========================================================================
# 月の黄経 λmoon を計算する
#=========================================================================
function LONGITUDE_MOON($t)
{
#-----------------------------------------------------------------------
# 円周率の定義と（角度の）度からラジアンに変換する係数の定義
#-----------------------------------------------------------------------
$PI=3.141592653589793238462;
$k=$PI/180.0;

#-----------------------------------------------------------------------
# 摂動項の計算
#-----------------------------------------------------------------------
  $ang = NORMALIZATION_ANGLE( 2322131.0  * $t + 191.0  );
   $th =      .0003 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(    4067.0  * $t +  70.0  );
   $th = $th + .0003 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  549197.0  * $t + 220.0  );
   $th = $th + .0003 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE( 1808933.0  * $t +  58.0  );
   $th = $th + .0003 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  349472.0  * $t + 337.0  );
   $th = $th + .0003 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  381404.0  * $t + 354.0  );
   $th = $th + .0003 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  958465.0  * $t + 340.0  );
   $th = $th + .0003 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(   12006.0  * $t + 187.0  );
   $th = $th + .0004 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(   39871.0  * $t + 223.0  );
   $th = $th + .0004 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  509131.0  * $t + 242.0  );
   $th = $th + .0005 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE( 1745069.0  * $t +  24.0  );
   $th = $th + .0005 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE( 1908795.0  * $t +  90.0  );
   $th = $th + .0005 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE( 2258267.0  * $t + 156.0  );
   $th = $th + .0006 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  111869.0  * $t +  38.0  );
   $th = $th + .0006 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(   27864.0  * $t + 127.0  );
   $th = $th + .0007 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  485333.0  * $t + 186.0  );
   $th = $th + .0007 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  405201.0  * $t +  50.0  );
   $th = $th + .0007 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  790672.0  * $t + 114.0  );
   $th = $th + .0007 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE( 1403732.0  * $t +  98.0  );
   $th = $th + .0008 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  858602.0  * $t + 129.0  );
   $th = $th + .0009 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE( 1920802.0  * $t + 186.0  );
   $th = $th + .0011 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE( 1267871.0  * $t + 249.0  );
   $th = $th + .0012 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE( 1856938.0  * $t + 152.0  );
   $th = $th + .0016 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  401329.0  * $t + 274.0  );
   $th = $th + .0018 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  341337.0  * $t +  16.0  );
   $th = $th + .0021 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(   71998.0  * $t +  85.0  );
   $th = $th + .0021 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  990397.0  * $t + 357.0  );
   $th = $th + .0021 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  818536.0  * $t + 151.0  );
   $th = $th + .0022 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  922466.0  * $t + 163.0  );
   $th = $th + .0023 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(   99863.0  * $t + 122.0  );
   $th = $th + .0024 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE( 1379739.0  * $t +  17.0  );
   $th = $th + .0026 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  918399.0  * $t + 182.0  );
   $th = $th + .0027 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(    1934.0  * $t + 145.0  );
   $th = $th + .0028 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  541062.0  * $t + 259.0  );
   $th = $th + .0037 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE( 1781068.0  * $t +  21.0  );
   $th = $th + .0038 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(     133.0  * $t +  29.0  );
   $th = $th + .0040 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE( 1844932.0  * $t +  56.0  );
   $th = $th + .0040 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE( 1331734.0  * $t + 283.0  );
   $th = $th + .0040 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  481266.0  * $t + 205.0  );
   $th = $th + .0050 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(   31932.0  * $t + 107.0  );
   $th = $th + .0052 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  926533.0  * $t + 323.0  );
   $th = $th + .0068 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  449334.0  * $t + 188.0  );
   $th = $th + .0079 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  826671.0  * $t + 111.0  );
   $th = $th + .0085 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE( 1431597.0  * $t + 315.0  );
   $th = $th + .0100 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE( 1303870.0  * $t + 246.0  );
   $th = $th + .0107 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  489205.0  * $t + 142.0  );
   $th = $th + .0110 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE( 1443603.0  * $t +  52.0  );
   $th = $th + .0125 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(   75870.0  * $t +  41.0  );
   $th = $th + .0154 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  513197.9  * $t + 222.5  );
   $th = $th + .0304 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  445267.1  * $t +  27.9  );
   $th = $th + .0347 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  441199.8  * $t +  47.4  );
   $th = $th + .0409 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  854535.2  * $t + 148.2  );
   $th = $th + .0458 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE( 1367733.1  * $t + 280.7  );
   $th = $th + .0533 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  377336.3  * $t +  13.2  );
   $th = $th + .0571 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(   63863.5  * $t + 124.2  );
   $th = $th + .0588 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  966404.0  * $t + 276.5  );
   $th = $th + .1144 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(   35999.05 * $t +  87.53 );
   $th = $th + .1851 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  954397.74 * $t + 179.93 );
   $th = $th + .2136 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  890534.22 * $t + 145.7  );
   $th = $th + .6583 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE(  413335.35 * $t +  10.74 );
   $th = $th + 1.2740 * cos( $k*$ang );
  $ang = NORMALIZATION_ANGLE( 477198.868 * $t + 44.963 ); 
   $th = $th + 6.2888 * cos( $k*$ang );

#-----------------------------------------------------------------------
# 比例項の計算
#-----------------------------------------------------------------------
  $ang = NORMALIZATION_ANGLE(  481267.8809 * $t );
  $ang = NORMALIZATION_ANGLE(  $ang + 218.3162 );
  $th  = NORMALIZATION_ANGLE(  $th  +  $ang );

  return($th);
}

#=========================================================================
# 年月日、時分秒（世界時）からユリウス日（JD）を計算する
#
# ※ この関数では、グレゴリオ暦法による年月日から求めるものである。
#    （ユリウス暦法による年月日から求める場合には使用できない。）
#=========================================================================
function YMDT2JD($year,$month,$day,$hour,$min,$sec){

	if( $month < 3.0 ){
		$year -= 1.0;
		$month += 12.0;
	}

	$jd  = int( 365.25 * $year );
	$jd += int( $year / 400.0 );
	$jd -= int( $year / 100.0 );
	$jd += int( 30.59 * ( $month-2.0 ) );
	$jd += 1721088;
	$jd += $day;

	$t  = $sec / 3600.0;
	$t += $min /60.0;
	$t += $hour;
	$t  = $t / 24.0;

	$jd += $t;

	return( $jd );

}

#=========================================================================
# ユリウス日（JD）から年月日、時分秒（世界時）を計算する
#
# 戻り値の配列TIME[]の内訳
# TIME[0] ... 年  TIME[1] ... 月  TIME[2] ... 日
# TIME[3] ... 時  TIME[4] ... 分  TIME[5] ... 秒
#
# ※ この関数で求めた年月日は、グレゴリオ暦法によって表されている。
#
#=========================================================================
function JD2YMDT($JD)
{

	$x0 = int( $JD+68570.0);
	$x1 = int( $x0/36524.25 );
	$x2 = $x0 - int( 36524.25*$x1 + 0.75 );
	$x3 = int( ( $x2+1 )/365.2425 );
	$x4 = $x2 - int( 365.25*$x3 )+31.0;
	$x5 = int( int($x4) / 30.59 );
	$x6 = int( int($x5) / 11.0 );

	$TIME[2] = $x4 - int( 30.59*$x5 );
	$TIME[1] = $x5 - 12*$x6 + 2;
	$TIME[0] = 100*( $x1-49 ) + $x3 + $x6;

# 2月30日の補正
	if($TIME[1]==2 && $TIME[2] > 28){
		if($TIME[0] % 100 == 0 && $TIME[0] % 400 == 0){
			$TIME[2]=29;
		}elseif($TIME[0] % 4 ==0){
			$TIME[2]=29;
		}else{
			$TIME[2]=28;
		}
	}

	$tm=86400.0*( $JD - int( $JD ) );
	$TIME[3] = int( $tm/3600.0 );
	$TIME[4] = int( ($tm - 3600.0*$TIME[3])/60.0 );
	$TIME[5] = int( $tm - 3600.0*$TIME[3] - 60*$TIME[4] );

	return array($TIME[0],$TIME[1],$TIME[2],$TIME[3],$TIME[4],$TIME[5]);
}

#=========================================================================
# 今日が２４節気かどうか調べる
# 
# 引数　 .... 計算対象となる年月日　$year $mon $day
#
# 戻り値 .... ２４節気の名称
#
#=========================================================================
function check_24sekki($year,$mon,$day)
{

#-----------------------------------------------------------------------
# ２４節気の定義
#-----------------------------------------------------------------------
	$sekki24 = array("春分","清明","穀雨","立夏","小満","芒種","夏至","小暑","大暑","立秋","処暑","白露",
	                 "秋分","寒露","霜降","立冬","小雪","大雪","冬至","小寒","大寒","立春","雨水","啓蟄");

	$tm = YMDT2JD($year,$mon,$day,0,0,0);

#-----------------------------------------------------------------------
#時刻引数を分解する
#-----------------------------------------------------------------------
	$tm1 = int( $tm );
	$tm2 = $tm - $tm1;
	$tm2-=9.0/24.0;
	$t=($tm2+0.5) / 36525.0;
	$t=$t + ($tm1-2451545.0) / 36525.0;

	#今日の太陽の黄経
	$rm_sun_today = LONGITUDE_SUN( $t );

	$tm++;
	$tm1 = int($tm);
	$tm2 = $tm - $tm1;
	$tm2-=9.0/24.0;
	$t=($tm2+0.5) / 36525.0;
	$t=$t + ($tm1-2451545.0) / 36525.0;

	#明日の太陽の黄経
	$rm_sun_tommorow = LONGITUDE_SUN($t);

	#
	$rm_sun_today0   = 15.0 * int($rm_sun_today / 15.0);
	$rm_sun_tommorow0 = 15.0 * int($rm_sun_tommorow / 15.0);

	if($rm_sun_today0 != $rm_sun_tommorow0){
		return($sekki24[$rm_sun_tommorow0 / 15]);
	}else{
		return('');
	}
}
function int($in)
{
	if($in>0){return floor($in);}
	else{return ceil($in);}
}
?>