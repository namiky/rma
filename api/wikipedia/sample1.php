<?php
	//ここにキーワード
	$keyword="日本";
	
	//URLの文字エンコード
	$keyword4url=urlencode($keyword);
	
	//
	//http://wikipedia.simpleapi.net/api
	//?keyword=キーワード
	//&output=出力方法
	//
	$url="http://wikipedia.simpleapi.net/api?keyword=$keyword4url&output=xml";
	
	//// ユーザーによるエラー処理を有効にします
	libxml_use_internal_errors(true);
	
	if( $xml = simplexml_load_file($url) ) {
		echo '<pre>';
		print_r($xml);
		echo '</pre>';
	} else {
		echo $url;
		echo '<br />取得失敗';
	}
	libxml_use_internal_errors(false);
?>