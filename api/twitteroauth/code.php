<?php
//twitteroauth.phpを読み込む。
//パスはあなたが置いた適切な場所に変更してください
//cronなどで実行する場合はフルパスで書いてあげたほうが良いと思う…
require_once("twitteroauth.php");
 
//hogemogeアプリのアプリ情報
//これはTwitterのDeveloperサイトで登録すると取得できます。
// Consumer keyの値
$consumer_key = "i06e6MTJChd1FvrEh7HJ5g";
// Consumer secretの値
$consumer_secret = "QllZUaxYKBuZkIgLHOmnNBuPqXBiKG0Ee3aVLZDbYc";
 
//@hogemoge_botのアカウント情報
//これもTwitterのDeveloperサイトで登録すると取得できます。
// Access Tokenの値
$access_token = "1023958974-PGNLQvWwJ4byRTZhIK4wXBKWRXBcWs7VpC62sXF";
// Access Token Secretの値
$access_token_secret = "gXnG0WiirucpJ5cAJKGKbdwmnNQA6PhhD7S1HLK444";
 
// OAuthオブジェクト生成
$to = new TwitterOAuth(
        $consumer_key,
        $consumer_secret,
        $access_token,
        $access_token_secret);
 
// TwitterへPOSTする。パラメーターは配列に格納する
$req = $to->OAuthRequest(
    "http://api.twitter.com/1/statuses/update.xml",
    "POST",
    array("status"=>"※ここに投稿したい内容を記述。")
        );
        ?>