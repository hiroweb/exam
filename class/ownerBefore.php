<?php
// --------------------------------------------------
// システム 前処理
// 2021/02/12 
// --------------------------------------------------

// --------------------------------------------------
// OWNER個別STREAM確認
// --------------------------------------------------

if ($IN['ID']) {

	/* ログ書き出し */
	$log = fopen(LOG_file, 'a');
	if ($this->exc) {
		$prg = ' STM:'.$this->stm.'_'.$this->exc;
	}else{
		$prg = ' STM:'.$this->stm;
	}
	fwrite($log, @date("Y-m-d H:i:s").' ID:'.$IN['ID'].$prg.".\r\n");
	fclose($log);

	/* 「管理者」読み込み */
	$sql = "SELECT OMS_streams FROM owner WHERE owner_ID='{$IN["ID"]}'";
	if ($DB->query($sql)) {
		$OMS = $DB->fetch_assoc();
		$streams = unserialize($OMS['OMS_streams']);
		if ($this->stm!='index' && $this->exc!='api' &&  !$streams[$this->stm]) {
echo '権限エラー';
}else{
echo '権限OK';
		}
	}
}

?>