<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>TRYPHP!　Twitter API 認証ユーザーのステータス情報を更新します。 POST statuses/update</title>
</head>
<body>
 
 
 
<?php
############################################ 初期設定
//twitteroauth.phpをインクルードします。ファイルへのパスは環境に合わせて記述下さい。
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
?>
 
 
 
<?php
############################################ ページ説明
?>
 
<h1>Twitter API 認証ユーザーのステータス情報を更新します。 POST statuses/update</h1>
<!-- 説明ページurl -->
<h3><a href="http://www.tryphp.net/2012/01/11/phpapptwitter-update/">→説明はこちら</a></h3>
<hr/>
 
 
 
<?php
############################################ 取得したデータを展開
?>
 
<h2>取得したデータを展開</h2>
<div style="background-color:#f8f8f8;margin:20px; padding:20px; border:solid #cccccc 1px;">
 
<!-- // =========================== ここから =========================== -->
 
<?php
//API実行データ取得
$vRequest = $twObj->OAuthRequest("https://api.twitter.com/1/statuses/update.xml","POST",array('status' => 'test tweeeet!'));
 
//XMLデータをsimplexml_load_string関数を使用してオブジェクトに変換する
$oXml = simplexml_load_string($vRequest);
 
//オブジェクトを展開
if(isset($oXml->error) && $oXml->error != ''){
    echo "投稿できませんでした。<br/>\n";
    echo "アプリケーションの「Read Write Delete」設定を確認して下さい。<br/>\n";
    echo "パラメーターの指定を確認して下さい。<br/>\n";
    echo "投稿直後には同じ内容を投稿できません。<br/>\n";
    echo "エラーメッセージ:".$oXml->error."<br/>\n";
}else{
    $sCreateAt =             $oXml->created_at; //つぶやき時刻
    $iStatusId =             $oXml->id; //つぶやきステータスID
    $sText =                 $oXml->text; //つぶやき
 
    $iUserId =                 $oXml->user->id; //ユーザーID
    $sScreenName =             $oXml->user->screen_name; //screen_name
 
    echo "<p><b>日時(".$sCreateAt.") statusid(".$iStatusId.") text(".$sText.")</b>
    <br/><a href=\"http://twitter.com/".$sScreenName."/status/".$iStatusId."\">このつぶやきのパーマリンク</a><br/>\n".$sText."</p>\n";
}
?>
 
<!-- =========================== ここまで =========================== // -->
</div>
<hr/>
 
 
 
<?php
#########################################
### 取得したオブジェクトの内容
?>
 
<h1>取得したオブジェクトの内容</h1>
<pre>
<?php
var_dump($oXml);
?>
<\/pre>
<hr/>
 
 
 
</body>
</html>