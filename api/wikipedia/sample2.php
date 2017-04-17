<?php

	/* WikipediaAPI 超簡易サンプル */
	// ※あくまでも簡易サンプルにつき、各環境に合わせて修正してください。

	// PEARなどのモジュールは不要。ただし、PHPからHTTPアクセスが許可されていること。
	// UTF-8で動くようになっている。他の文字コードの場合変換が必要。


	// キーワード指定
	$keyword = "コカコーラ";

	// APIのURL
	$url = "http://wikipedia.simpleapi.net/api?keyword=".urlencode($keyword)."&output=php";

	// データを取得
	$data = file_get_contents($url) ;

	// PHPシリアライズパーサーを利用して解析し、配列に入れる
	$array = unserialize($data);
	
	//配列チェック
	if ( is_array($array) ) echo 'これは配列です。';
	else die("配列ではありません。");
	
	
	//デバッグ
	$n = count($array);
	echo "要素数は{$n}個です。";



	//理解用
	/*
	echo "キー：".key($array);
	echo "値：".current("$array[title]");
	next($array);
	
	echo "キー：".key($array);
	echo "値：".$array[title]."ZzzzZ";
	*/
	
	
	// 配列をforeachで表示するデモ
	/*
	print "<H1>Wikipedia情報</H1>";
		$value = $array;
		print "Url:"."$value[url]"
			."<br>Title:"."$value[title]"
			."<br>Body:"."$value[body]". " <br>";
	*/


	//配列をforeachで表示。表示回数を１回にして１つの記事のみ抽出
	print "<H1>Wikipedia情報</H1>";
	foreach ($array as $key  => $value) {
		if( 1 == $key)break;
		else{
		echo "キー<--" .$key. "--> <br>";
		
		
		print "Url:"."$value[url]"
			."<br>Title:"."$value[title]"
			."<br>Body:"."$value[body]". " <br>";
		}
	}
	
	
	
	


	print '(by <a href="http://www.simpleapi.net">SimpleAPI</a>:<a href="http://wikipedia.simpleapi.net">WikipediaAPI</a>)';

?>