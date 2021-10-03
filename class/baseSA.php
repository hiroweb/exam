<?php
// --------------------------------------------------
// SQL組み立てクラス ver1.0.2
// 2020/01/23 
// --------------------------------------------------

	class SA{

// --------------------------------------------------
// 変数宣言
// --------------------------------------------------

	//ヘッダー項目格納用
	public $HD = array();

	//フィルター演算子格納用
	public $OT = array();

	//フィルター項目格納用
	public $FT = array();

	//ソート項目格納用
	public $ST = array();

	//子展開項目格納用
	public $OC = array();

// --------------------------------------------------
// コンストラクタ
// --------------------------------------------------

	public function __construct($stm='',$no=null){
		if ($stm) {
			include($stm.'_items.php');
			if (@${'HD'.$no}) {
				$this->HD = ${'HD'.$no};
				$this->OT = $this->perseArray($stm.'_', 'OT'.$no);
				$this->FT = $this->perseArray($stm.'_', 'FT'.$no);
				$this->ST = $this->perseArray($stm.'_', 'ST'.$no);
				$this->OC = $this->perseArray($stm.'_', 'OC'.$no);
				$this->storeCookie($stm,$no);
			}
		}else{
			$this->clearCookie('');
			$this->clearCookie(1);
			$this->clearCookie(2);
			$this->clearCookie(3);
		}
	}

// --------------------------------------------------
// 汎用配列展開
// --------------------------------------------------

	public function perseArray($stm,$name,$default='') {
		$num = ($this->HD)? count($this->HD):99;
		$arr = array_fill(0, $num, $default);
		if(isset($_POST[$name])) {
			$arr = ($_POST[$name]);
		}else{
			if(isset($_GET[$name])) {
				$arr = ($_GET[$name]);
			}else{
				if(isset($_COOKIE[$stm.$name])) {
					$arr = $_COOKIE[$stm.$name];
				}
			}
		}
		return $arr;
	}

// --------------------------------------------------
// Cookie保存
// --------------------------------------------------

	public function storeCookie($stm,$no) {
		for ($ix = 0; $ix< count($this->HD); $ix++) {
			setcookie ($stm.'_OT'.$no.'['.$ix.']', $this->OT[$ix]);
			setcookie ($stm.'_FT'.$no.'['.$ix.']', $this->FT[$ix]);
			setcookie ($stm.'_ST'.$no.'['.$ix.']', $this->ST[$ix]);
			setcookie ($stm.'_OC'.$no.'['.$ix.']', $this->OC[$ix]);
		}
		return;
	}

// --------------------------------------------------
// Cookie削除
// --------------------------------------------------

	public function clearCookie($no) {
		$arr = ($_COOKIE['OT'.$no]);
		for ($ix = 0; $ix< count($arr); $ix++) {
			setcookie ('OT'.$no.'['.$ix.']', null,time()-600);
		}
		for ($ix = 0; $ix< count($arr); $ix++) {
			setcookie ('FT'.$no.'['.$ix.']', null,time()-600);
		}
		for ($ix = 0; $ix< count($arr); $ix++) {
			setcookie ('ST'.$no.'['.$ix.']', null,time()-600);
		}

		$arr = ($_COOKIE['OC'.$no]);
		for ($ix = 0; $ix< count($arr); $ix++) {
			setcookie ('OC'.$no.'['.$ix.']', null,time()-600);
		}
	}

// --------------------------------------------------
// WHERE句組み立て
// --------------------------------------------------

	public function whereAssemble($where='') {
		if ($where) $where .= " AND ";
		for ($ix = 0; $ix< count($this->HD); $ix++) {
			if ($this->FT[$ix] != '') {
				if (is_array($this->HD[$ix])) {
					$target = 'CONCAT(';
					foreach ($this->HD[$ix] as $val){
						$target .= $val.',';
					}
					$target = substr($target, 0, -1).')';
				}else{
					$target = $this->HD[$ix];
				}
				switch ($this->OT[$ix]){
					case '＞':
						$where .= $target." > '".$this->FT[$ix]."' AND ";
						break;
					case '≧':
						$where .= $target." >= '".$this->FT[$ix]."' AND ";
						break;
					case '＝':
						$where .= $target." = '".$this->FT[$ix]."' AND ";
						break;
					case '≦':
						$where .= $target." <= '".$this->FT[$ix]."' AND ";
						break;
					case '＜':
						$where .= $target." < '".$this->FT[$ix]."' AND ";
						break;
					case '≠':
						$where .= $target." != '".$this->FT[$ix]."' AND ";
						break;
					case '≒':
						$where .= $target." LIKE '%".$this->FT[$ix]."%' AND ";
						break;
					default:
						$where .= $target." LIKE '%".$this->FT[$ix]."%' AND ";
						break;
				}
			}
		}
		if ($where) {
			return substr($where, 0, -5);
		}else{
			return false;
		}
	}
/*
// --------------------------------------------------
// ORDER句組み立て
// --------------------------------------------------
*/
	public function orderAssemble($userorder='') {
		$order = '';
		for ($ix = 0; $ix< count($this->HD); $ix++) {
			if ($this->ST[$ix]) {
				if (is_array($this->HD[$ix])) {
					$target = 'CONCAT(';
					foreach ($this->HD[$ix] as $val){
						$target .= $val.',';
					}
					$target = substr($target, 0, -1).')';
				}else{
					$target = $this->HD[$ix];
				}
				$order .= $target.' '.$this->ST[$ix].',';
			}
		}
		if ($userorder) $userorder .= ',';
		$order .= $userorder;
		if ($order) {
			return substr($order, 0, -1);
		}else{
			return false;
		}
	}

}
?>