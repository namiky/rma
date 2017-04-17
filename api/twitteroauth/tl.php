<?php
require_once("twitteroauth.php");
 
$consumerKey = "i06e6MTJChd1FvrEh7HJ5g";
$consumerSecret = "QllZUaxYKBuZkIgLHOmnNBuPqXBiKG0Ee3aVLZDbYc";
$accessToken = "1023958974-PGNLQvWwJ4byRTZhIK4wXBKWRXBcWs7VpC62sXF";
$accessTokenSecret = "gXnG0WiirucpJ5cAJKGKbdwmnNQA6PhhD7S1HLK444";
 
$twObj = new TwitterOAuth($consumerKey,$consumerSecret,$accessToken,$accessTokenSecret);
$req = $twObj->OAuthRequest("https://api.twitter.com/1.1/statuses/user_timeline.json","GET",array("count"=>"10"));
$tw_arr = json_decode($req);

if (isset($tw_arr)) {
	foreach ($tw_arr as $key => $val) {
		echo $tw_arr[$key]->text;
		echo date('Y-m-d H:i:s', strtotime($tw_arr[$key]->created_at));
		echo '<br>';
	}
} else {
	echo '‚Â‚Ô‚â‚«‚Í‚ ‚è‚Ü‚¹‚ñB';
}
