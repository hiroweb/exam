<?php
// --------------------------------------------------
// タスク登録
// 2015/05/22 
// --------------------------------------------------

	class TQ{

// --------------------------------------------------
// 変数宣言
// --------------------------------------------------

	//DBクラス
	var $DB;

// --------------------------------------------------
// コンストラクタ
// --------------------------------------------------

	public function __construct(){
		/* CONFIG */
		include('config.php');

		/* DB class リクエスト */
		require_once(DB_path);
		$this->DB = new DB();
	}

// --------------------------------------------------
// タスクの登録
// --------------------------------------------------
	public function tasking($TKM_cd,$sts=0,$IN=array()){

		//タスク管理の取得
		if ($TKM_cd) {

			$sql = "SELECT * FROM task_m WHERE `TKMsts`='1' AND `TKM_cd`='{$TKM_cd}'";

			$res = $this->DB->query($sql);
			if (!$res) return false;
			$TKM = $this->DB->fetch_assoc();

			//内部対応ステータスの調査
			$MTS_no = $TKM['sts_'.$sts.'i'];
			$sql = "SELECT * FROM mail_templates WHERE `MTS_no`='{$MTS_no}'";
			$mail_i = $this->DB->query($sql);
			if ($mail_i) {
				$MTS = $this->DB->fetch_assoc();
				$adr_i = $MTS['from_adr'];
				$name_i = $MTS['from_name'];
				$subject_i = $MTS['mail_subject'];
				$body_i = $MTS['mail_body'];
			}

			//対外対応ステータスの調査
			$MTS_no = $TKM['sts_'.$sts.'o'];
			$sql = "SELECT * FROM mail_templates WHERE `MTS_no`='{$MTS_no}'";
			$mail_o = $this->DB->query($sql);
			if ($mail_o) {
				$MTS = $this->DB->fetch_assoc();
				$adr_o = $MTS['from_adr'];
				$name_o = $MTS['from_name'];
				$subject_o = $MTS['mail_subject'];
				$body_o = $MTS['mail_body'];
			}

			//メール件名、メール本文の置き換え加工
			foreach ($IN as $key => $val){
				if (!is_array($val)) {
					$key = '|'.$key.'|';
					$val = htmlspecialchars_decode($val,ENT_QUOTES);
					if ($mail_i) {
						$subject_i = str_replace($key, $val, $subject_i);
						$body_i = str_replace($key, $val, $body_i);
					}
					if ($mail_o) {
						$subject_o = str_replace($key, $val, $subject_o);
						$body_o = str_replace($key, $val, $body_o);
					}
				}
			}

			//メール送信
			if ($mail_i) {
				if ($TKM['prime_name']) $this->mailSender($TKM['prime_email'],$subject_i,$body_i,$adr_i,$name_i);		//内部主担当者メール
				if ($TKM['second_name']) $this->mailSender($TKM['second_email'],$subject_i,$body_i,$adr_i,$name_i);		//内部副担当者メール
				if ($TKM['chief_name']) $this->mailSender($TKM['chief_email'],$subject_i,$body_i,$adr_i,$name_i);		//内部責任者メール
			}
			if ($mail_o) {
				if ($IN[email_o_address]) {
					$this->mailSender($IN[email_o_address],$subject_o,$body_o.COMPANY_SIGN,$adr_o,$name_o);							//対外メール
				}else{
					$this->mailSender($IN['email'],$subject_o,$body_o.COMPANY_SIGN,$adr_o,$name_o);									//対外メール
				}
			}
			return true;
		}
		return false;
	}

	//メール送信関数
	private function mailSender($toadr,$subject,$body,$fromadr,$name) {
		mb_language("japanese");
		mb_internal_encoding("UTF-8");
		
		$from = mb_encode_mimeheader(mb_convert_encoding($name, "JIS", "UTF-8")) . "<{$fromadr}>";
		mb_send_mail($toadr, $subject, $body, "From:{$from}");
	}

	//タスク登録関数
	private function taskInserter($email,$TKM_cd,$member_ID,$sts,$IN=array()) {
		$Data = serialize($IN);
	}

}
?>