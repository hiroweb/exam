<?php
// --------------------------------------------------
// セッション管理
// 2016/04/25
// --------------------------------------------------

class OS {

// --------------------------------------------------
// 変数宣言
// --------------------------------------------------

	protected $sessname = 'mgjkwejh';
	public $msgcd = '';

// --------------------------------------------------
// コンストラクタ
// --------------------------------------------------

	public function __construct(){
		include('config.php');
		session_name($this->sessname);
	}

	// セッションチェック
	public function check(){
		if(isset($_COOKIE[session_name()])){		// セッションハイジャック対策
			$session_id = $_COOKIE[session_name()];
			if(!preg_match('/[a-zA-Z,\-]+/', $session_id)){
				unset($_COOKIE["$session_name"]);
				unset($_GET["$session_name"]);
				unset($_POST["$session_name"]);
				$this->msgcd = 'S00';
				return false;
			}else{
				return true;
			}
		}else{
			$this->msgcd = 'S01';
			return false;
		}
	}

	// プレイン
	public function preIn($back=null,$key=null,$tab=0){
		session_start();
		$now = time();
		$this->set('back', $back);
		$this->set('key', $key);
		$this->set('tab', $tab);
		return true;
	}

	// プレスタート
	public function preStart(){
		session_start();
		return true;
	}

	// ログイン
	public function login($owner_ID=null,$disp_name=null){
		$now = time();
		$this->set('lastreq', $now);			// アクセス時刻を保存
		$this->set('owner_ID', $owner_ID);		// メンバーIDを保存
		$this->set('disp_name', $disp_name);	// メンバー名を保存
		if (LOG_file) $this->logging($owner_ID,'Log in');		// ロギング
		return true;
	}

	// セッション開始
	public function start($token=null){
		session_start();
		header('Expires:-1');		// 戻るボタンメッセージ対応
		header('Cache-Control:');	// 戻るボタンメッセージ対応
		header('Pragma:');			// 戻るボタンメッセージ対応
		$now = time();
		$lastreq = $this->get('lastreq', $now);		// 前回アクセス時刻を取得
		if(($lastreq + timeout) <= $now){			// セッションタイムアウト
			$this->over('Time out');				// セッション破棄
			$this->msgcd = 'S02';
			return false;
		}
		if ($token && $token != $this->get('token')) {	//TOKENチェック
			$this->msgcd = 'S03';
			return false;
		}
		$owner_ID = $this->get('owner_ID');		// IDチェック
		if (!$owner_ID) {
			$this->over('Lost ID');				// セッション破棄
			$this->msgcd = 'S05';
			return false;
		}
		if ($lastreq < $now - 7) {				// ダブルクリック以外の場合、セッション引越し
			$disp_name = $this->get('disp_name');	// メンバー名引越しIN
			session_regenerate_id(true);			// セッションIDを生成しなおす
			$this->set('lastreq', $now);			// アクセス時刻を保存
			$this->set('owner_ID', $owner_ID);		// メンバーID引越しOUT
			$this->set('disp_name', $disp_name);	// メンバー名引越しOUT
			$this->set('token',$this->saltpapper(session_id()));	// TOKEN生成
		}
		return true;
	}

	// セッション終了処理
	public function over($REC='Unknown out'){
		if (LOG_file) {
			$this->logging($this->get('owner_ID'),$REC);		// ロギング
		}

		$_SESSION[] = array();						// セッション変数を初期化
		session_unset();							// セッション変数を消去
		if (isset($_COOKIE[session_name()])) {
			setcookie(session_name(), '', time()-3600, '/');	// 負数ライフタイムでクッキー消去
		}
		$old_id = session_id();
		$old_session_file = session_save_path()."/sess_".$old_id;
		if ( file_exists($old_session_file) ) unlink($old_session_file);
		@session_destroy();							// セッション破棄関数

		return true;
	}

	# セッション終了処理をまとめて行う関数。自身のクラスのclearメソッドでセッション変数（$_SESSION）のデータをすべて破棄する。
	# セッションIDを保持しているクッキーを削除するようWebブラウザに要求し、
	# session_destroy関数でサーバー側に保存しているセッションデータを削除。

	// セッション変数設定
	// @param string $key キー
	// @param mixed $value 設定する値
	public function set($key, $value){
		$_SESSION[$key] = $value;
	}

	// セッション変数取得
	//	@param string $key キー
	//	@param mixed $default 存在しない場合のデフォルト値
	function get($key, $default = null){
		if(isset($_SESSION[$key])){
			return $_SESSION[$key];
		}
		return $default;
	}

	// セッション変数削除
	// @param string $key キー
	public function remove($key){
		if(isset($_SESSION[$key])){
			unset($_SESSION[$key]);
		}
	}

	// ソルトアンドペッパー
	private function saltpapper($key){
		$sp = MD5($key);
		$sp = SALT.$sp.PEPPER;
		$sp = strrev($sp);
		return hash('sha256',$sp);
	}

	// ロギング
	public function logging($ID,$REC){
		$log = fopen(LOG_file, 'a');
		fwrite($log, @date("Y-m-d H:i:s").' user:'.$ID.' '.$REC.".\r\n");
		fclose($log);
	}

}