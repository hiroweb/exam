<?php
// --------------------------------------------------
// 個人チェック
// 2020/09/05 saito
//
// ■入力引数について
//
// 1.$IN
// STREMの内部変数$IN
// 確認画面等の表示用に容疑者リストのから絞込みを行う場合
// $IN['key']		：絞り込み対象の個人番号(person_NO)を配列として予め指定
// $IN['zok']		：上記対象者の続柄をコード(3桁を)を配列として予め指定

// 2.$TX
// チェックの対象となるTX(異動データ)
// この中でチェックに用いる以下の項目は引数として渡す前にTXに予め設定しておく必要がある
// ・TX['sei']		：漢字姓とかな姓を連結した文字列
// ・TX['mei']		：漢字名とかな名を連結した文字列
// ・TX['name']		：漢字姓と漢字名とかな姓とかな名を連結した文字列
// ・TX['adr']		：郵便番号と都道府県と市区町村と町名番地を連結した文字列
// ・TX['sex']		：性別
// ・TX['birthday']	：誕生日
// ・TX['phone']	：電話番号
//
// 3.$prefix
// 表示等の用途で容疑者リストを得る場合には指定しない
//
// ■出力引数について
// $IN['indi'] = 本人容器者の数;
// $IN['fami'] = 家族容疑者の数;
// $IN['PSN'] = 容疑者リスト;
// --------------------------------------------------

class PC {

// --------------------------------------------------
// 変数宣言
// --------------------------------------------------

	//DBクラス
	var $DB;

// --------------------------------------------------
// コンストラクタ
// --------------------------------------------------

	public function __construct($DB){
		$this->DB = $DB;
	}

// --------------------------------------------------
// 本人チェック
// --------------------------------------------------
	public function indi_check($IN,$TX,$prefix=''){

		$IN['indi'] = null;
		$IN['PSN'] = null;

		if (!is_array($TX)) {
			$IN['indi'] = false;
			return $IN;
		}
		$sql = "SELECT * FROM
			(SELECT *,CONCAT(PSN_sei_kj,PSN_sei_kn) AS sei,CONCAT(PSN_mei_kj,PSN_mei_kn) AS mei,CONCAT(PSN_postal,PSN_prefecture,PSN_city,PSN_address) AS adr FROM person) AS edit
			WHERE 
			(sei LIKE '%{$TX[$prefix."sei"]}%' AND mei LIKE '%{$TX[$prefix."mei"]}%')
			OR
			(mei LIKE '%{$TX[$prefix."mei"]}%' AND adr LIKE '%{$TX[$prefix."adr"]}%')
			OR
			(mei LIKE '%{$TX[$prefix."mei"]}%' AND PSN_birthday = '{$TX[$prefix."birthday"]}' AND PSN_sex LIKE '%{$TX[$prefix."sex"]}%')";
		$IN['indi'] = $this->DB->query2($sql);
		if ($IN['indi'] && !$prefix) {
			while ($PSN = $this->DB->fetch_assoc2()){
				$i = array_search($PSN['person_NO'], $IN['key']);
				$PSN['zok'] = $IN['zok'][$i];
				$IN['PSN'][] = $PSN;
				$IN['PSN_sql']=$sql;
			}
		}

		return $IN;
	}

// --------------------------------------------------
// 家族(属性)チェック
// --------------------------------------------------
	public function fami_check1($IN,$TX,$prefix='',$person_NO=''){

		$IN['fami'] = null;
		$IN['PSN'] = null;

		if (!is_array($TX)) {
			$IN['fami'] = false;
			return $IN;
		}
		$sql = "SELECT * FROM person_rel WHERE person_NO = '{$person_NO}'";
		$PSR_num = $this->DB->query2($sql);
		$sql = "SELECT * FROM
			(SELECT *,CONCAT(PSN_sei_kj,PSN_mei_kj,PSN_sei_kn,PSN_mei_kn) AS name,CONCAT(PSN_postal,PSN_prefecture,PSN_city,PSN_address) AS adr FROM person) AS edit
			WHERE name != '{$TX[$prefix."name"]}'
			AND adr LIKE '%{$TX[$prefix."adr"]}%'
			AND PSN_phone = '{$TX[$prefix."phone"]}'";
		if ($PSR_num) {
			while ($PSR = $this->DB->fetch_assoc2()) {
				$sql .= " AND person_NO != '{$PSR["PSR_person_NO"]}'";
			}
		}
		$IN['fami'] = $this->DB->query2($sql);
		if ($IN['fami'] && !$prefix) {
			while ($PSN = $this->DB->fetch_assoc2()){
				$i = array_search($PSN['person_NO'], (array)$IN['key']);
				$PSN['zok'] = $IN['zok'][$i];
				$IN['PSN'][] = $PSN;
			}
		}

		return $IN;
	}

// --------------------------------------------------
// 家族(関係)チェック
// --------------------------------------------------
	public function fami_check2($IN,$prefix='',$person_NO=''){

		$IN['fami'] = null;
		$IN['PSN'] = null;

		$sql = "SELECT PSR_person_NO AS P FROM person_rel WHERE person_NO = '{$person_NO}'";
		$PSR_num = $this->DB->query2($sql);
		if ($PSR_num) {
			while ($PSR = $this->DB->fetch_assoc2()) {
				$zok[] = $PSR;
			}
		}
		if ($zok) {
			$where1 = "(";
			$where2 = "(PSR_person_NO!='{$person_NO}' AND ";
			foreach ($zok as $key => $val) {
				$where1 .= "person_NO='{$val["P"]}' OR ";
				$where2 .= "PSR_person_NO!='{$val["P"]}' AND ";
			}
			$where1 = substr($where1, 0, -4).') AND ';
			$where2 = substr($where2, 0, -5).') GROUP BY PSR_person_NO';
			$sql = "SELECT PSR_person_NO AS P FROM person_rel WHERE ".$where1.$where2;
			$PSR_num = $this->DB->query2($sql);
			if ($PSR_num) {
				while ($PSR = $this->DB->fetch_assoc2()) {
					$sql = "SELECT * FROM person WHERE person_NO= '{$PSR["P"]}'";
					$IN['fami'] = $this->DB->query3($sql);
					if ($IN['fami'] && !$prefix) {
						while ($PSN = $this->DB->fetch_assoc3()) {
							$i = array_search($PSN['person_NO'], $IN['key']);
							$PSN['zok'] = $IN['zok'][$i];
							$IN['PSN'][] = $PSN;
						}
					}
				}
			}
		}

		return $IN;
	}
}