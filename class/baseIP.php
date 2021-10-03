<?php
// --------------------------------------------------
// 入力引数展開クラス ver1.0.6
// 2021/03/26 
// cookie読み込みのバグ修正
// --------------------------------------------------

	class IP{

// --------------------------------------------------
// 変数宣言
// --------------------------------------------------

	public $sys_items_query = array('msgcd','nextpl');
	public $sys_items_cookie = array('token','back','mode','page');

	public $msgcd = '';

	//入力値格納用
	public $IN = array();

	//チェック要否格納用
	public $MK = array();

	//チェック結果格納用
	public $ER = array();
	public $EP = array();	/* pre処理用の空連想配列 */

	//入力必須格納用
	public $IM = array();

	//入力項目格納用
	public $items;

	//NGワード
	public $ng_words = array(
'糞',
'屑',
'殺害',
'殺人',
'殺す',
'死ね',
'氏ね',
'低脳',
'大麻',
'麻薬',
'在日',
'部落',
'非人',
'低脳',
'援交',
'幼女',
'奴隷',
'調教',
'強姦',
'獣姦',
'姦淫',
'淫夢',
'淫乱',
'淫売',
'売女',
'乱交',
'邪教',
'顔射',
'放尿',
'脱糞',
'基地外',
'ばーか',
'うんこ',
'きめぇ',
'きもい',
'ま○こ',
'ち○こ',
'まんこ',
'ちんこ',
'うざい',
'ちんちん',
'オタ',
'ロリ',
'ゴミ',
'チョン',
'キモイ',
'チンポ',
'レイプ',
'ウンコ',
'フェラ',
'ザーメン',
'デリヘル',
'ヴァギナ',
'shit',
'fuck',
'cunt'
);
	//OKワード
	public $ok_words = array('イエロー','カフェラテ','フェラーリ');

// --------------------------------------------------
// コンストラクタ
// --------------------------------------------------

	public function __construct($item_name){
	
		if (file_exists($item_name)) {
			include($item_name);
			$this->items = array_merge($this->sys_items_query,$this->sys_items_cookie,$items);
		}else{
			$this->items = array_merge($this->sys_items_query,$this->sys_items_cookie);
		}
		if (isset($chkMust)) $this->chkMust = $chkMust;
		if (isset($chkHankaku)) $this->chkHankaku = $chkHankaku;
		if (isset($chkUpper)) $this->chkUpper = $chkUpper;
		if (isset($chkLower)) $this->chkLower = $chkLower;
		if (isset($chkNumeric)) $this->chkNumeric = $chkNumeric;
		for ($i=1 ; $i<50; $i++) {
			if (isset(${'eq'.$i.'chars'})) $this->{'eq'.$i.'chars'} = ${'eq'.$i.'chars'};
			if (isset(${'min'.$i.'chars'})) $this->{'min'.$i.'chars'} = ${'min'.$i.'chars'};
			if (isset(${'max'.$i.'chars'})) $this->{'max'.$i.'chars'} = ${'max'.$i.'chars'};
		}
		if (isset($chkZenkaku)) $this->chkZenkaku = $chkZenkaku;
		if (isset($chkZenKana)) $this->chkZenKana = $chkZenKana;
		if (isset($chkZenHira)) $this->chkZenHira = $chkZenHira;
		if (isset($chkDate)) $this->chkDate = $chkDate;
		if (isset($chkEmail)) $this->chkEmail = $chkEmail;
		if (isset($chkUrl)) $this->chkUrl = $chkUrl;
		if (isset($chkPostal)) $this->chkPostal = $chkPostal;
		if (isset($chkPhone)) $this->chkPhone = $chkPhone;
		if (isset($chkPhone_e)) $this->chkPhone_e = $chkPhone_e;
		if (isset($chkNg)) $this->chkNg = $chkNg;
		if (isset($chkEq)) $this->chkEq = $chkEq;
		if (isset($chkLt)) $this->chkLt = $chkLt;
		if (isset($chkGt)) $this->chkGt = $chkGt;
		if (isset($chkLe)) $this->chkLe = $chkLe;
		if (isset($chkGe)) $this->chkGe = $chkGe;

		/* HDテーブルの記述有無チェック(from ver2.0) */
		$cnt = 1;
		$i = '';
		while ($cnt) {
			$this->HD[] = count(@${'HD'.$i});
			$i++;
			$cnt = count(@${'HD'.$i});
		}

	}

// --------------------------------------------------
// 引数の展開
// --------------------------------------------------

	public function perseInput($stm=null){
		foreach ($this->items as $item) {
			if (isset($_POST[$item])) {
				$this->IN += array($item => $this->sanitalize($_POST[$item]));
			}else{
				if(isset($_GET[$item])) {
					$this->IN += array($item => $this->sanitalize($_GET[$item]));
				}else{
					if (in_array($item,$this->sys_items_cookie)) {
						$cook = $stm.$item;
					}else{
						$cook = $item;
					}
					if(isset($_COOKIE[$cook])) {
						$this->IN += array($item => $this->sanitalize($_COOKIE[$cook]));
					}else{
						$this->IN += array($item => '');
					}
				}
			}
			if($this->IN[$item] == '') {
				$this->MK += array($item => false);
			}else{
				$this->MK += array($item => true);
			}
			$this->ER += array($item => '');
			$this->IM += array($item => false);
		}
		$this->EP = $this->ER;

		return $this->IN;
	}

// --------------------------------------------------
// 入力引数のサニタライズ
// --------------------------------------------------

	public function sanitalize($arg){
		if (is_array($arg)) {
			return array_map(array($this,'sanitalize'),$arg);
		}else{
			return htmlspecialchars($arg,ENT_QUOTES,'UTF-8',false);
		}
	}

// --------------------------------------------------
// 入力チェック
// --------------------------------------------------

	public function inputCheck(){
		$res = false;
		if (@$this->chkMust) $res |= $this->isMust($this->chkMust);
		if (@$this->chkHankaku) $res |= $this->isHankaku($this->chkHankaku);
		if (@$this->chkUpper) $res |= $this->isUpper($this->chkUpper);
		if (@$this->chkLower) $res |= $this->isLower($this->chkLower);
		if (@$this->chkNumeric) $res |= $this->isNumeric($this->chkNumeric);
		for ($i=1 ; $i<50; $i++) {
			if (isset($this->{'eq'.$i.'chars'})) $res |= $this->isCharsEq($this->{'eq'.$i.'chars'},$i);
			if (isset($this->{'min'.$i.'chars'})) $res |= $this->isCharsMin($this->{'min'.$i.'chars'},$i);
			if (isset($this->{'max'.$i.'chars'})) $res |= $this->isCharsMax($this->{'max'.$i.'chars'},$i);
		}
		if (@$this->chkZenkaku) $res |= $this->isZenkaku($this->chkZenkaku);
		if (@$this->chkZenKana) $res |= $this->isZenKana($this->chkZenKana);
		if (@$this->chkZenHira) $res |= $this->isZenHira($this->chkZenHira);
		if (@$this->chkDate) $res |= $this->isDate($this->chkDate);
		if (@$this->chkEmail) $res |= $this->isEmail($this->chkEmail);
		if (@$this->chkUrl) $res |= $this->isUrl($this->chkUrl);
		if (@$this->chkPostal) $res |= $this->isPostal($this->chkPostal);
		if (@$this->chkPhone) $res |= $this->isPhone($this->chkPhone);
		if (@$this->chkPhone_e) $res |= $this->isPhone_e($this->chkPhone_e);
		if (@$this->chkEq) $res |= $this->isEq($this->chkEq);
		if (@$this->chkLt) $res |= $this->isLt($this->chkLt);
		if (@$this->chkGt) $res |= $this->isGt($this->chkGt);
		if (@$this->chkLe) $res |= $this->isLe($this->chkLe);
		if (@$this->chkGe) $res |= $this->isGe($this->chkGe);

		if (@$this->chkNg) $res |= $this->isNg($this->chkNg);
		return $res;
	}


// --------------------------------------------------
// 入力必須
// --------------------------------------------------

	public function isMust($items){
		$res = false;
		foreach ($items as $item){
			if(!$this->MK[$item]) {
				if (!$this->msgcd) $this->msgcd = 'I01';
				$this->ER[$item] = '入力必須です';
				$res = true;
			}
			$this->IM[$item] = true;
		}
		return $res;
	}

// --------------------------------------------------
// 半角英数
// --------------------------------------------------

	public function isHankaku($items){
		$res = false;
		foreach ($items as $item){
			if ($this->MK[$item]) {
				if (!preg_match("/^[ -~a-zA-Z0-9]+$/",$this->IN[$item])) {
					$this->ER[$item] = '半角英数ではありません';
					$this->MK[$item] = false;
					$res = true;
				}
			}
		}
		return $res;
	}

// --------------------------------------------------
// 半角大文字
// --------------------------------------------------

	public function isUpper($items){
		$res = false;
		foreach ($items as $item){
			if ($this->MK[$item]) {
				if (!ctype_upper($this->IN[$item])) {
					$this->ER[$item] = '半角大文字ではありません';
					$this->MK[$item] = false;
					$res = true;
				}
			}
		}
		return $res;
	}

// --------------------------------------------------
// 半角小文字
// --------------------------------------------------

	public function isLower($items){
		$res = false;
		foreach ($items as $item){
			if ($this->MK[$item]) {
				if (!ctype_lower($this->IN[$item])) {
					$this->ER[$item] = '半角小文字ではありません';
					$this->MK[$item] = false;
					$res = true;
				}
			}
		}
		return $res;
	}

// --------------------------------------------------
// 半角数字
// --------------------------------------------------

	public function isNumeric($items){
		$res = false;
		foreach ($items as $item){
			if ($this->MK[$item]) {
				if (!is_numeric($this->IN[$item])) {
					$this->ER[$item] = '半角数字ではありません';
					$this->MK[$item] = false;
					$res = true;
				}
			}
		}
		return $res;
	}

// --------------------------------------------------
// 半角文字数
// --------------------------------------------------

	public function isCharsEq($items,$num){
		$res = false;
		foreach ($items as $item){
			if ($this->MK[$item]) {
				if ($num != strlen($this->IN[$item])) {
					$this->ER[$item] = '文字数が正しくありません '.$num.'文字です';
					$this->MK[$item] = false;
					$res = true;
				}
			}
		}
		return $res;
	}

// --------------------------------------------------
// 半角文字数下限
// --------------------------------------------------

	public function isCharsMin($items,$num){
		$res = false;
		foreach ($items as $item){
			if ($this->MK[$item]) {
				if ($num > strlen($this->IN[$item])) {
					$this->ER[$item] = '文字数が足りません '.$num.'文字以上です';
					$this->MK[$item] = false;
					$res = true;
				}
			}
		}
		return $res;
	}

// --------------------------------------------------
// 半角文字数上限
// --------------------------------------------------

	public function isCharsMax($items,$num){
		$res = false;
		foreach ($items as $item){
			if ($this->MK[$item]) {
				if ($num < strlen($this->IN[$item])) {
					$this->ER[$item] = '文字数が多すぎます '.$num.'文字以下です';
					$this->MK[$item] = false;
					$res = true;
				}
			}
		}
		return $res;
	}

// --------------------------------------------------
// 全角
// --------------------------------------------------

	public function isZenkaku($items){
		$res = false;
		foreach ($items as $item){
			if ($this->MK[$item]) {
				if (!preg_match("/^[０-９ａ-ｚＡ-Ｚぁ-んァ-ヶー－一-龠　]+$/u",$this->IN[$item])) {
					$this->ER[$item] = '全角文字ではありません';
					$this->MK[$item] = false;
					$res = true;
				}
			}
		}
		return $res;
	}

// --------------------------------------------------
// 全角カタカナ
// --------------------------------------------------

	public function isZenKana($items){
		$res = false;
		foreach ($items as $item){
			if ($this->MK[$item]) {
				if (!preg_match("/^[ァ-ヶー　）（Ａ-Ｚ０-９／‐，「」．]+$/u",$this->IN[$item])) {
					$this->ER[$item] = '全角カタカナではありません';
					$this->MK[$item] = false;
					$res = true;
				}
			}
		}
		return $res;
	}

// --------------------------------------------------
// 全角ひらがな
// --------------------------------------------------

	public function isZenHira($items){
		$res = false;
		foreach ($items as $item){
			if ($this->MK[$item]) {
				if (!preg_match("/^[ぁ-ゞ]+$/u",$this->IN[$item])) {
					$this->ER[$item] = '全角ひらがなではありません';
					$this->MK[$item] = false;
					$res = true;
				}
			}
		}
		return $res;
	}
// --------------------------------------------------
// 日付
// --------------------------------------------------

	public function isDate($items){
		$res = false;
		foreach ($items as $item){
			if ($this->MK[$item]) {
				if (strlen($this->IN[$item])<10) {
					$this->ER[$item] = '正しい日付ではありません';
					$this->MK[$item] = false;
					$res = true;
				}else{
					$y = mb_substr($this->IN[$item],0,4);
					$m = mb_substr($this->IN[$item],5,2);
					$d = mb_substr($this->IN[$item],8,2);
					if ((!ctype_digit($y.$m.$d))||(!checkdate($m,$d,$y))) {
						$this->ER[$item] = '正しい日付ではありません';
						$this->MK[$item] = false;
						$res = true;
					}
				}
			}
		}
		return $res;
	}

// --------------------------------------------------
// メールアドレス
// --------------------------------------------------

	public function isEmail($items){
		$res = false;
		foreach ($items as $item){
			if ($this->MK[$item]) {
				if (!preg_match("/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/",$this->IN[$item])) {
					$this->ER[$item] = '正しいメールアドレスではありません';
					$this->MK[$item] = false;
					$res = true;
				}
			}
		}
		return $res;
	}

// --------------------------------------------------
// URL
// --------------------------------------------------

	public function isURL($items){
		$res = false;
		foreach ($items as $item){
			if ($this->MK[$item]) {
				if (!preg_match('/^(https?|ftp)(:\/\/[-_.!~*\'()a-zA-Z0-9;\/?:\@&=+\$,%#]+)$/',$this->IN[$item])) {
					$this->ER[$item] = '正しいURLではありません';
					$this->MK[$item] = false;
					$res = true;
				}
			}
		}
		return $res;
	}

// --------------------------------------------------
// 郵便番号
// --------------------------------------------------

	public function isPostal($items){
		$res = false;
		foreach ($items as $item){
			if ($this->MK[$item]) {
				if (!preg_match("/^\d{3}\-\d{4}$/",$this->IN[$item])) {
					$this->ER[$item] = '正しい郵便番号ではありません';
					$this->MK[$item] = false;
					$res = true;
				}
			}
		}
		return $res;
	}

// --------------------------------------------------
// 電話番号
// --------------------------------------------------

	public function isPhone($items){
		$res = false;
		foreach ($items as $item){
			if ($this->MK[$item]) {
				if(!preg_match("/^0\d{1,5}-\d{0,4}-?\d{4}$/",$this->IN[$item]) || !preg_match("/^.{11,13}$/",$this->IN[$item])){
					$this->ER[$item] = '正しい電話番号ではありません';
					$this->MK[$item] = false;
					$res = true;
				}
			}
		}
		return $res;
	}

// --------------------------------------------------
// 電話番号_easy
// --------------------------------------------------

	public function isPhone_e($items){
		$res = false;
		foreach ($items as $item){
			if ($this->MK[$item]) {
				$tel = str_replace('-','',$this->IN[$item]);
				if(!preg_match("/^[0-9]{1,11}$/",$tel) || !preg_match("/^.{10,12}$/",$tel)||substr($tel,0,1)!='0'){
					$this->ER[$item] = '電話番号を正しく入力してください';
					$this->MK[$item] = false;
					$res = true;
				}
			}
		}
		return $res;
	}

// --------------------------------------------------
// 一致
// --------------------------------------------------

	public function isEq($items){
		$res = false;
		foreach ($items as $item){
			if ($this->MK[$item[0]] && $this->MK[$item[1]]) {
				if($this->IN[$item[0]] != $this->IN[$item[1]]) {
					$this->ER[$item[0]] = '一致しません';
					$this->ER[$item[1]] = '一致しません';
					$this->MK[$item[0]] = false;
					$this->MK[$item[1]] = false;
					$res = true;
				}
			}
		}
		return $res;
	}

// --------------------------------------------------
// 小なり比較
// --------------------------------------------------

	public function isLt($items){
		$res = false;
		foreach ($items as $item){
			if ($this->MK[$item[0]] && $this->MK[$item[1]]) {
				if($this->IN[$item[0]] >= $this->IN[$item[1]]) {
					$this->ER[$item[0]] = '値の大小関係が不適です';
					$this->ER[$item[1]] = '値の大小関係が不適です';
					$this->MK[$item[0]] = false;
					$this->MK[$item[1]] = false;
					$res = true;
				}
			}
		}
		return $res;
	}

// --------------------------------------------------
// 大なり比較
// --------------------------------------------------

	public function isGt($items){
		$res = false;
		foreach ($items as $item){
			if ($this->MK[$item[0]] && $this->MK[$item[1]]) {
				if($this->IN[$item[0]] <= $this->IN[$item[1]]) {
					$this->ER[$item[0]] = '値の大小関係が不適です';
					$this->ER[$item[1]] = '値の大小関係が不適です';
					$this->MK[$item[0]] = false;
					$this->MK[$item[1]] = false;
					$res = true;
				}
			}
		}
		return $res;
	}

// --------------------------------------------------
// 以下比較
// --------------------------------------------------

	public function isLe($items){
		$res = false;
		foreach ($items as $item){
			if ($this->MK[$item[0]] && $this->MK[$item[1]]) {
				if($this->IN[$item[0]] > $this->IN[$item[1]]) {
					$this->ER[$item[0]] = '値の大小関係が不適です';
					$this->ER[$item[1]] = '値の大小関係が不適です';
					$this->MK[$item[0]] = false;
					$this->MK[$item[1]] = false;
					$res = true;
				}
			}
		}
		return $res;
	}

// --------------------------------------------------
// 以上比較
// --------------------------------------------------

	public function isGe($items){
		$res = false;
		foreach ($items as $item){
			if ($this->MK[$item[0]] && $this->MK[$item[1]]) {
				if($this->IN[$item[0]] < $this->IN[$item[1]]) {
					$this->ER[$item[0]] = '値の大小関係が不適です';
					$this->ER[$item[1]] = '値の大小関係が不適です';
					$this->MK[$item[0]] = false;
					$this->MK[$item[1]] = false;
					$res = true;
				}
			}
		}
		return $res;
	}

// --------------------------------------------------
// NGワード
// --------------------------------------------------

	public function isNg($items){
		$res = false;
		foreach ($items as $item){
			if ($this->MK[$item]) {
				$str = $this->IN[$item];
				$str = mb_strtolower($str,'UTF-8');						// 小文字化
				$str = mb_convert_kana($str,'KVas','UTF-8');			// 半角英数字全角カタカナへ置換
				$target_sentence = preg_replace('/\s|、|。/','',$str);	// スペース、句読点などを削除
				// 許可キーワードのエスケープ
				foreach ($this->ok_words as $okWordsVal) {
					if (mb_strpos($target_sentence,$okWordsVal) !== FALSE) {
						$target_sentence = str_replace($okWordsVal,'*',$target_sentence);
					}
				}
				// 禁止キーワードの検索
				foreach ($this->ng_words as $ngWordsVal) {
					if (mb_strpos($target_sentence,$ngWordsVal) !== FALSE) {
						if (!$this->msgcd) $this->msgcd = 'I12';
						$this->ER[$item] = 'NGワードが含まれています。';
						$this->MK[$item] = false;
						$res = true;
						break;
					}
				}
				if (! $res) {
					// 縦読み対策
					// 1文字に分割
					$lines = explode("\n",$str);
					if (! empty($lines)) {
						if (count($lines) > 1) {
							foreach($lines as $linesKey => $linesVal) {
								$onechar[$linesKey] = preg_split('//u',$linesVal,-1,PREG_SPLIT_NO_EMPTY);
							}
						}
					}
					// 縦列を結合し、単語にする
					if (! empty($onechar)) {
						foreach($onechar as $onecharVal) {
							foreach($onecharVal as $positionKey => $positionVal) {
								$rows[$positionKey] = $rows[$positionKey] . $positionVal;
							}
						}
					}
					// 単語を結合し、１行にする
					if (! empty($rows)) {
						foreach($rows as $rowsVal) {
						// 3文字以下は対象外
							if (mb_strlen($rowsVal) <= 3) {
								continue;
							}
							$target_tateyomi = $target_tateyomi.'/'.$rowsVal;
						}
						// 全体でなく、1行目 $rows[0] や 2行目 $rows[1]　だけの場合
						// $target_tateyomi = $rows[0].'/'.$rows[1];
					}
					if (! empty($target_tateyomi)) {
						// 通常文と同じように禁止キーワードチェック
						foreach ($this->ng_words as $ngWordsVal) {
							// 対象文字列にキーワードが含まれるか
							if (mb_strpos($target_tateyomi, $ngWordsVal) !== FALSE) {
								if (!$this->msgcd) $this->msgcd = 'I12';
								$this->ER[$item] = 'NGワードが含まれています。';
								$this->MK[$item] = false;
								$res = true;
								break;
							}
						}
					}
				}
			}
		}
		return $res;
	}

// --------------------------------------------------
// 入力引数の'"をエスケープ
// --------------------------------------------------

	public function escapeInput($input) {
		$IN = array();
		foreach ($input as $key => $val){
			$IN += array($key => addslashes($val));
		}
		return $IN;
	}

}

?>