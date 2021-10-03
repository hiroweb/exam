<?php
// --------------------------------------------------
// 緯度･経度取得
// 2015/04/30 
// --------------------------------------------------

	class getLatLng{

// --------------------------------------------------
// 変数宣言
// --------------------------------------------------

// --------------------------------------------------
// コンストラクタ
// --------------------------------------------------

	function getLatLng(){
	}

// --------------------------------------------------
// APIリクエスト
// --------------------------------------------------

	function reqLatLng($API_key,$adr){
		// Google Map API geocode リクエスト
		$adr = urlencode($adr);
		$params = array( 
			'key' => $API_key,
			'address' => $adr,
			'sensor' => 'false'
		);
		$url = "https://maps.google.com/maps/api/geocode/json?key={$API_key}&address={$adr}&sensor=false";
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
		$res  = curl_exec($ch); 
		curl_close($ch);

		// JSON形式から連想配列へ変換する
		$geo_array = json_decode($res, TRUE);
		if ($geo_array['status'] == 'OK') {
			$latlng = array(
				'lat' => $geo_array['results'][0]['geometry']['location']['lat'],
				'lng' => $geo_array['results'][0]['geometry']['location']['lng']
			);
		}else{
			$latlng = array(
				'lat' => '0',
				'lng' => '0'
			);
		}
		return $latlng;
	}
}
?>