<?php
	//外部化したファイルの呼び出し
	require_once("../database.php");
	//POSTされる値を取得
	$tweetURL = $_POST['phpURL'];
	


	
		
	//************************************************
	//****************ここからTwitter*****************
	//Error:2重投稿される。おそらく2回add()関数が回っているかと思われる。
	//************************************************
	//現在の時刻の取得
	date_default_timezone_set('Asia/Tokyo'); 
	############################################ 初期設定
	//twitteroauth.phpをインクルードします。ファイルへのパスは環境に合わせて記述下さい。
	require_once("../api/twitteroauth/twitteroauth.php");
	//Consumer keyの値をTwitterAPI開発者ページでご確認下さい。
	$consumerKey = "i06e6MTJChd1FvrEh7HJ5g";
	//Consumer secretの値を格納
	$consumerSecret = "QllZUaxYKBuZkIgLHOmnNBuPqXBiKG0Ee3aVLZDbYc";
	//Access Tokenの値を格納
	$accessToken = "1023958974-PGNLQvWwJ4byRTZhIK4wXBKWRXBcWs7VpC62sXF";
	//Access Token Secretの値を格納
	$accessTokenSecret = "gXnG0WiirucpJ5cAJKGKbdwmnNQA6PhhD7S1HLK444";
	//OAuthオブジェクトを生成する
	$twObj = new TwitterOAuth($consumerKey,$consumerSecret,$accessToken,$accessTokenSecret);
	//ここにtweetする内容
	//$tweet_message="未支払金額のグラフデータ(".date('Y/m/d/H:i:s').")".$tweetURL;
	$tweet_message  =  $_POST["comment"];
	if(isset($_POST["name"]))
		$tweet_message .= "by".$_POST["name"];	
	$tweet_message .= "(".date('Y/m/d/H:i:s').")".$tweetURL;
	
	
	
	//ここから取得したデータを展開
	//API実行データ取得
	$vRequest = $twObj->OAuthRequest("https://api.twitter.com/1/statuses/update.xml","POST",array('status' => $tweet_message));
	 
	//XMLデータをsimplexml_load_string関数を使用してオブジェクトに変換する
	$oXml = simplexml_load_string($vRequest);
	 
	//オブジェクトを展開
	if(isset($oXml->error) && $oXml->error != ''){
		$finish .= "投稿できませんでした。<br/>\n";
		$finish .= "アプリケーションの「Read Write Delete」設定を確認して下さい。<br/>\n";
		$finish .= "パラメーターの指定を確認して下さい。<br/>\n";
		$finish .= "投稿直後には同じ内容を投稿できません。<br/>\n";
		$finish .= "エラーメッセージ:".$oXml->error."<br/>\n";
		echo $finish;
	}else{
		$sCreateAt =				$oXml->created_at; //つぶやき時刻
		$iStatusId =				$oXml->id; //つぶやきステータスID
		$sText =					$oXml->text; //つぶやき
		
		$iUserId =					$oXml->user->id; //ユーザーID
		$sScreenName =				$oXml->user->screen_name; //screen_name
		
		echo $tweet_message;
	}
			
		

?>
