<?php
// --------------------------------------------------
// メール送信 ver.1.0.3
// 2019/07/16 
// --------------------------------------------------

	class MS{

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
// タスクの登録
// --------------------------------------------------
	public function tasking($TKM_cd,$sts=0,$IN=array(),$to=null,$cc=null,$bcc=null){

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

			// 改行コード統一
			$body_i = str_replace(array("\r\n", "\r"), "\n", $body_i);
			$body_o = str_replace(array("\r\n", "\r"), "\n", $body_o);

			//メール送信
			if ($mail_i) {			//内部メール
				if ($TKM['prime_name']) $this->mailSender($TKM['prime_email'],$subject_i,$body_i,$adr_i,$name_i,$TKM['second_email'],$TKM['chief_email']);
			}
			if ($mail_o && $to) {	//対外メール
				$this->mailSender($to,$subject_o,$body_o.COMPANY_SIGN,$adr_o,$name_o,$cc,$bcc);
			}

			return true;
		}
		return false;
	}

	//メール送信関数
	private function mailSender($toadr,$subject,$body,$fromadr,$name,$ccadr=null,$bccadr=null) {
		$header="From:{$fromadr}";
		if ($ccadr) {
			$header.="\n";
			$header.="Cc:{$ccadr}";
		}
		if ($bccadr) {
			$header.="\n";
			$header.="Bcc:{$bccadr}";
		}
		mb_language("japanese");
		mb_internal_encoding("UTF-8");
		
		mb_send_mail($toadr, $subject, $body, $header, "-f{$fromadr}");
	}

	//タスク登録関数
	private function taskInserter($email,$TKM_cd,$member_ID,$sts,$IN=array()) {
		$Data = serialize($IN);
	}

}
?>