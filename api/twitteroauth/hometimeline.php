<?php
//twitteroauth.phpをインクルードします。ファイルへのパスはご自分で決めて下さい。
//同じディレクトリにファイルがある場合は以下でOKです。
require_once("twitteroauth.php");
 
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
 
//home_timelineを取得するAPIを利用。TwitterからXML形式でデータが返ってくる
$vRequest = $twObj->OAuthRequest("http://api.twitter.com/1/statuses/home_timeline.xml","GET",array("count"=>"10"));
 
//XMLデータをsimplexml_load_string関数を使用してオブジェクトに変換する
$oXml = simplexml_load_string($vRequest);
 
//foreachでオブジェクトを展開
foreach($oXml->status as $oStatus){
	$iStatusId = 		$oStatus->id; //つぶやきステータスID
	$sText = 		$oStatus->text; //つぶやき
	$iUserId = 		$oStatus->user->id; //ユーザーID
	$sScreenName = 		$oStatus->user->screen_name; //screen_name
	$sUserName = 		$oStatus->user->name; //ユーザー名
 
	echo "<p><b>".$sScreenName."(".$iUserId.") / ".$sUserName."</b> <a href=\"http://twitter.com/".$sScreenName."/status/".$iStatusId."\">このつぶやきのパーマリンク</a><br />\n".$sText."</p>\n";
}
?>