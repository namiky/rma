<?php
	$search_query = $_POST['q']; // 検索クエリ
	$account_key = ["mGG/I2pE3/QBl9wYbNyzrOi1AM7FqX4KTp9QoR8zIzY="]; // アカウント キー
	$site_domain = 'example.com'; // 設置するサイトのドメイン
	$headers = array(
		'Content-type: application/x-www-form-urlencoded', // Content-typeヘッダ
		'User-Agent: php', // ユーザーエージェント
		'Authorization: Basic '.base64_encode('example:' . $account_key), // BASIC認証
	); // HTTPヘッダー
	$options = array('http' => array(
		'method' => 'GET', // GET通信
		'header' => implode("\r\n", $headers), // ヘッダーの指定
	));
	$contents = file_get_contents(
		sprintf(
			"https://api.datamarket.azure.com/Data.ashx/Bing/Search/Web?Query='site%%3A%s+%s'&amp;Market='ja-JP'",
			$site_domain,
			urlencode($search_query)
		),
		false, stream_context_create($options)
	); // クエリ送信 Atomで返却
	$xml_dom = new DOMDocument(); // DOMの作成
	$xml_dom -> loadXML($contents); // Atomのパース
	foreach ($xml_dom -> documentElement -> getElementsByTagName('properties') as $item) {
		printf(
			'<div><a href="%s">%s</a><br>%s</div>',
			$item -> getElementsByTagName('Url') -> item(0) -> nodeValue,
			$item -> getElementsByTagName('Title') -> item(0) -> nodeValue,
			$item -> getElementsByTagName('Description') -> item(0) -> nodeValue
		);
	}

?>