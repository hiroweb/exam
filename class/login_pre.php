<?php
include('config.php');
require_once(CLASS_path.'base.php');
class proc extends base {

	// --------------------------------------------------
	// 変数
	// --------------------------------------------------
	protected $stm = 'login';
	protected $ttl = 'ログイン';
	protected $exc = 'pre';
	protected $tplpc = '';
	protected $tplsp = '_sp';

	// --------------------------------------------------
	// セッション処理(login_pre)
	// --------------------------------------------------
	protected function session_proc($IN,$SC) {
		/* セッションの確認 */
		if ($SC->check()){
			if ($msgcd) {
				header("Location:".$IN['back']."?msgcd=".$msgcd);
				exit;
			}else{
				header("Location:index.php");
				exit;
			}
		}
		return $IN;
	}

	// --------------------------------------------------
	// 初期値処理
	// --------------------------------------------------
	protected function value_proc($IN) {
		$IN['nextpl'] = 'input';
		if (!$IN['back']) $IN['back'] = 'index.php';
		return $IN;
	}

	// --------------------------------------------------
	// ＤＢテーブル処理
	// --------------------------------------------------
	protected function DB_proc($IN,$DB,$SC,$SA) {
		if ($IN['login_NO']) {
			/* 「メンバー」の読み込み */
			$sql = "SELECT *
				FROM member LEFT JOIN person USING(person_NO)
				WHERE `login_NO` = '{$IN["login_NO"]}'";
			$MEM_num = $DB->query($sql);
			if ($MEM_num) {
				$MEM = $DB->fetch_assoc();
				$IN = array_merge($IN,$MEM);
				$IN["login_PW"] = "";
			}else{
				throw new Exception('S04');
			}
		}
		return $IN;
	}
}
$proc = new proc();
$proc->exec();
?>