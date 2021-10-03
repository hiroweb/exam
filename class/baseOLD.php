<?php
// --------------------------------------------------
// BASE	ver1.0.5
// 2020/11/19 
// 例外処理（exc=del,mode=delete時）のバグ修正
// --------------------------------------------------

abstract class base {
	// --------------------------------------------------
	// 変数宣言
	// --------------------------------------------------
	protected $stm = '';
	protected $ttl = '';
	protected $exc = '';
	protected $tplpc = '';
	protected $tplsp = '';
	protected $ses = '1';

	public $msgcd = '';
	public $message = '';
	public $disp_name = '';

	public $PT;
	public $UA;
	public $IM;
	public $ER;
	public $TR;

	// --------------------------------------------------
	// コンストラクタ
	// --------------------------------------------------
	public function __construct(){
		/* デバイス判定 */
		$this->UA = $_SERVER['HTTP_USER_AGENT'];	
		if ( preg_match('/Windows Phone/ui', $this->UA) ) { //UAにAndroidも含まれるので注意
			@define('DEVICE','WindowsPhone');
			@define('IS_SP',true);
			@define('IS_PC',false);
		} else if ( preg_match('/Windows/', $this->UA) ) {
			@define('DEVICE','Windows');
			@define('IS_SP',false);
			@define('IS_PC',true);
		} else if ( preg_match('/Macintosh/', $this->UA) ) {
			@define('DEVICE','Macintosh');
			@define('IS_SP',false);
			@define('IS_PC',true);
		} else if ( preg_match('/iPhone/', $this->UA) ) {
			@define('DEVICE','iPhone');
			@define('IS_SP',true);
			@define('IS_PC',false);
		} else if ( preg_match('/iPad/', $this->UA) ) {
			@define('DEVICE','iPad');
			@define('IS_SP',false);
			@define('IS_PC',true);
		} else if ( preg_match('/iPod/', $this->UA) ) {
			@define('DEVICE','iPod');
			@define('IS_SP',true);
			@define('IS_PC',false);
		} else if ( preg_match('/Android/', $this->UA) ) {
		    if ( preg_match('/Mobile/', $this->UA) ) {
				@define('DEVICE','Android');
				@define('IS_SP',true);
				@define('IS_PC',false);
		    } else {
				@define('DEVICE','AndroidTablet');
				@define('IS_SP',false);
				@define('IS_PC',true);
		    }
		} else {
			@define('DEVICE','unknown');
			@define('IS_SP',true);
			@define('IS_PC',false);
		}
	}

	// --------------------------------------------------
	// 主処理
	// --------------------------------------------------
	public function exec() {

		/* 標準出力をバッファに */
		ob_start();

		/* CONST読込 */
		include(CONST_path);

		/* 汎用テーブル読み込み */
		require_once(CLASS_path.'publicTables.php');
		$this->PT = new PT();

		/* メッセージテーブル読み込み */
		include(CLASS_path.'msgTable.php');

		try{

			// --------------------------------------------------
			// 入力引数処理
			// --------------------------------------------------
			/* IP class リクエスト */
			require_once(CLASS_path.'baseIP.php');
			$IP = new IP($this->stm.'_items.php');

			/* 入力引数の読み込み */
			$IN = $IP->perseInput($this->stm);

			/* 引継ぎエラーハンドル0 */
			if (@$IN['msgcd']) {
				throw new Exception($IN['msgcd']);
			}

			/* 入力チェック */
			$chk = $IP->inputCheck();
			$this->IM = $IP->IM;
			$this->ER = $IP->EP;
			if ($chk && $this->exc=='chk') {
				$this->ER = $IP->ER;
				$this->msgcd = 'I00';
			}

			// --------------------------------------------------
			// 初期値のセット
			// --------------------------------------------------
			if (!$IN['nextpl']) {
				switch ($this->exc) {
					case 'pre':
						if ($IN['mode']=='delete') {
							$IN['nextpl'] = 'confirm';
						}else{
							$IN['nextpl'] = 'input';
						}
						break;
					case 'chk':
						$IN['nextpl'] = 'confirm';
						break;
					case 'ins':
						$IN['nextpl'] = 'complete';
						break;
					case 'upd':
						$IN['nextpl'] = 'complete';
						break;
					case 'del':
						$IN['nextpl'] = 'complete';
						break;
					case 'lst':
						$IN['nextpl'] = 'list';
						break;
					default:
						$IN['nextpl'] = '';
						break;
				}
			}

			/* 機械作業日・機械作業日時 */
			$IN['sysdate'] = @date("Y-m-d H:i:s");
			$IN['sysday'] = @date('Y-m-d');

			/* 初期値のセットFUNCTION */
			if (!$IN = $this->value_proc($IN)) {
				throw new Exception('X01');
			}

			// --------------------------------------------------
			// セッション処理
			// --------------------------------------------------
			/* セッション class リクエスト */
			require_once(CLASS_path.'baseSC.php');
			$SC = new SC;

			if ($this->ses) {
				/* セッション処理FUNCTION */
				if ($this->exc=='api') {
					if (!$IN = $this->api_session_proc($IN,$SC)) {
						throw new Exception($SC->msgcd);
					}
				}else{
					if (!$IN = $this->session_proc($IN,$SC)) {
						throw new Exception($SC->msgcd);
					}
				}
			}

			// --------------------------------------------------
			// ＤＢテーブル処理
			// --------------------------------------------------
			/* DB class リクエスト */
			require_once(DB_path);
			$DB = new DB();

			/* トランザクション開始 */
			if (!$DB->begin()) {
				throw new Exception('A00');
			}

			/* SA class リクエスト */
			require_once(CLASS_path.'baseSA.php');
			/* SAインスタンス量産 */
			$this->SA = null;
			$i = '';
			foreach ($IP->HD as $val) {
				if ($IP->HD[$i] > 0) {
					$this->SA[] = new SA($this->stm,$i);
				}else{
					$this->SA[] = null;
				}
				$i++;
			}

			/* ＤＢテーブル処理FUNCTION */
			if (!$IN = $this->DB_proc($IN,$DB,$SC,$this->SA)) {
				throw new Exception('X01');
			}

			/* トランザクション完了 */
			if (!$DB->commit()) {
				throw new Exception('A00');
			}

			// --------------------------------------------------
			// メール送信処理
			// --------------------------------------------------
				
			/* MS class リクエスト */
			require_once(CLASS_path.'baseMS.php');
			$MS = new MS($DB);

			/* メール送信UNCTION */
			if (!$IN = $this->mail_proc($IN,$MS)) {
				throw new Exception('X01');
			}

			/* DB クローズ */
			$DB->close();

		// --------------------------------------------------
		// 例外
		// --------------------------------------------------
		} catch (Exception $e) {
			if (isset($this->DB)) {
				if (!$this->DB->rollback()) {
					throw new Exception('A00');
				}
				$this->DB->close();
			}

			$this->msgcd = $e->getMessage();
		}
		if ($this->msgcd) {
			switch ($this->exc) {
				case 'lst':
					$IN['nextpl'] = 'list';
					break;
				case 'pre':
					if ($IN['mode']=='delete') {
						$IN['nextpl'] = 'confirm';
					}else{
						$IN['nextpl'] = 'input';
					}
					break;
				case 'chk':
					$IN['nextpl'] = 'input';
					break;
				case 'ins':
					$IN['nextpl'] = 'input';
					break;
				case 'upd':
					$IN['nextpl'] = 'input';
					break;
				case 'del':
					$IN['nextpl'] = 'confirm';
					break;
				default:
					$IN['nextpl'] = '';
					break;
			}
		}

		// --------------------------------------------------
		// 出力処理
		// --------------------------------------------------
		/* COOKIE */
		foreach ($IP->sys_items_cookie as $item) {
			setcookie($this->stm.$item,$IN[$item]);
		}

		/* トレース */
		$this->TR =ob_get_contents();
		ob_end_clean();

		/* エラーメッセージ */
		if (@$msg[$this->msgcd]) {
			$this->message = $msg[$this->msgcd];
		}else{
			$this->message = $this->msgcd;
		}

		/* 出力処理FUNCTION */
		if (!$IN = $this->output_proc($IN,$IP)) {
			throw new Exception('X01');
		}

	}

	// --------------------------------------------------
	// セッション処理FUNCTION
	// --------------------------------------------------
	protected function session_proc($IN,$SC) {
		/* CSRF対策 */
		if ($this->exc=='ins' || $this->exc=='upd' || $this->exc=='del') {
			$chk = '1';
		}else{
			$chk = '';
		}
		/* セッションの開始 */
		if ($SC->check()){
			if ($SC->start($IN['token'],$chk)){
				$IN['ID'] = $SC->get('ID');
				$IN['NAME'] = $SC->get('name');
				$IN['TYPE'] = $SC->get('type');
				$IN['MAIL'] = $SC->get('email');
				$IN['token'] = $SC->get('token');
				$this->disp_name = $SC->get('name');
				return $IN;
			}else{
				header('Location:login_pre.php?msgcd='.$SC->msgcd);
				exit;
			}
		}else{
			if ($this->ses=='1') {
				header('Location:login_pre.php?back='.$IN['back'].'&msgcd='.$SC->msgcd);
				exit;
			}
			if ($this->ses=='2') {
				return $IN;
			}
		}
	}

	// --------------------------------------------------
	// APIセッション処理FUNCTION
	// --------------------------------------------------
	protected function api_session_proc($IN,$SC) {
		/* セッションの開始 */
		if (!$SC->APIstart()){
			$this->msgcd = $SC->msgcd;
		}
		return $IN;

	}

	// --------------------------------------------------
	// 初期値のセットFUNCTION
	// --------------------------------------------------
	protected function value_proc($IN) {
		return $IN;
	}

	// --------------------------------------------------
	// ＤＢテーブル処理FUNCTION
	// --------------------------------------------------
	abstract protected function DB_proc($IN,$DB,$SC,$SA);

	// --------------------------------------------------
	// メール送信処理FUNCTION
	// --------------------------------------------------
	protected function mail_proc($IN,$MS) {
		return $IN;
	}

	// --------------------------------------------------
	// 出力処理FUNCTION
	// --------------------------------------------------
	protected function output_proc($IN,$IP) {
		/* Smarty リクエスト */
		require_once('Smarty.class.php');
		$smarty = new Smarty();
		$smarty->template_dir = './templates/';
		$smarty->compile_dir  = './templates_c/';
		$smarty->config_dir   = './configs/';
		$smarty->cache_dir    = './cache/';

		/* SmartyへPTを出力 */
		$PT = new PT($smarty);

		/* Smarty 変数引継ぎ */
		$smarty->assign('IN',$IN);
		$smarty->assign('IM',$this->IM);
		$smarty->assign('ER',$this->ER);
		$smarty->assign('stm',$this->stm);
		$smarty->assign('disp_name',$this->disp_name);
		$smarty->assign('page_name',$this->ttl);

		/* エラーメッセージ引継ぎ */
		$smarty->assign('error_msg',$this->message);

		/* 子データ展開キー引継ぎ */
		if ($this->exc=='lst') {
			$i = 0;
			foreach ($IP->HD as $val) {
				$smarty->assign('OC'.$i, $this->SA[$i]->OC);
				$i++;
			}
		}

		/* トレース引継ぎ */
		$smarty->assign('TR',"\n<!-- USER TRACE (START) --\n".$this->TR."\n-- USER TRACE (END) -->");

		/* Smarty 出力 */
		if (IS_PC) {
			$tpl = $this->tplpc.'.tpl';
		}
		if (IS_SP) {
			$tpl = $this->tplsp.'.tpl';
		}
		if ($IN['nextpl']) {
			$tpl = $this->stm.'_'.$IN['nextpl'].$tpl;
		}else{
			$tpl = $this->stm.$tpl;
		}

		if (file_exists('templates/'.$tpl)) {
			$smarty->display($tpl);
		}else{
			echo "ERROR .tpl file not exist. name={$tpl}.";
		}

		return $IN;
	}

	// --------------------------------------------------
	// ページングSQL生成
	// --------------------------------------------------
	public function paging($IN,$sql,$num,$row=100) {
		if ($num>$row) {
			$IN['page_max'] = floor(($num - 1) / $row) + 1;
			if (!$IN['page']||$IN['page']<1) $IN['page'] = 1;
			if ($IN['page']>$IN['page_max']) $IN['page'] = $IN['page_max'];
			$limit = $IN['page'] * $row - $row;
//			setcookie('page',$IN['page']);
			$IN['page_sql'] = $sql." LIMIT {$limit},{$row}";
		}
		return $IN;
	}

}

?>