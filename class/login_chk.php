<?php
include('config.php');
require_once(CLASS_path.'base.php');
class proc extends base {

	// --------------------------------------------------
	// 変数
	// --------------------------------------------------
	protected $stm = 'login';
	protected $ttl = 'ログイン';
	protected $exc = 'chk';
	protected $tplpc = '';
	protected $tplsp = '_sp';


	// --------------------------------------------------
	// セッション処理(login_chk)
	// --------------------------------------------------
	protected function session_proc($IN,$SC) {	
		/* セッションの開始 */
		$SC->preStart();
		return $IN;
	}

	// --------------------------------------------------
	// 初期値処理
	// --------------------------------------------------
	protected function value_proc($IN) {
		if (!$IN['back']) $IN['back'] = 'index.php';
		return $IN;
	}

	// --------------------------------------------------
	// ＤＢテーブル処理
	// --------------------------------------------------
	protected function DB_proc($IN,$DB,$SC,$SA) {
		/* 「メンバー」の読み込み */
		$sql = "SELECT *
			FROM member LEFT JOIN person USING(person_NO)
			WHERE `login_NO` = '{$IN["login_NO"]}'
			AND `login_PW` = '{$IN["login_PW"]}'";
		$MEM_num = $DB->query($sql);
		if ($MEM_num) {
			$MEM = $DB->fetch_assoc();
			/* ログイン */
			$SC->login($MEM['member_ID'],$MEM['PSN_sei_kj'].' '.$MEM['PSN_mei_kj']);
			$IN['back'] = str_replace('|','&',$IN['back']);
			header('Location:'.$IN['back']);
			exit;
		}else{
			throw new Exception('S04');
		}
		return $IN;
	}
}
$proc = new proc();
$proc->exec();
?>