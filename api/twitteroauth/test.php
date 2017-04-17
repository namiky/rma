<?php
// 準備
require_once('twitteroauth.php');
$consumer_key = 'i06e6MTJChd1FvrEh7HJ5g';
$consumer_secret = 'QllZUaxYKBuZkIgLHOmnNBuPqXBiKG0Ee3aVLZDbYc';
$access_token = '1023958974-PGNLQvWwJ4byRTZhIK4wXBKWRXBcWs7VpC62sXF';
$access_token_secret = 'gXnG0WiirucpJ5cAJKGKbdwmnNQA6PhhD7S1HLK444';
$message = '初めまして。PHPから呟きを投稿してみました(*´∇｀*)';

// OAuth認証
$twitter = new TwitterOAuth($consumer_key
    ,$consumer_secret, $access_token, $access_token_secret);

// メッセージを投稿する
$twitter->format = 'xml';
$tweet = $twitter->post('statuses/update', array('status' => $message));
echo $tweet;
?>