<?php
/***************************************:
 * 
 * 					Bilty API
 *					 
 * 
 **************************************/
//要PHP5.2.xかjson_decode関数
function short_url($sLongURL,$sApiLogin,$sApiKey){
    //see http://code.google.com/p/bitly-api/wiki/ApiDocumentation
    $sApiVersion = "2.0.1";
    $sUrl        = rawurlencode($sLongURL);
    $sFormat     = "json";

    //$sRequestURL = "http://api.bit.ly/shorten?version={$sApiVersion}&longUrl={$sUrl}&login={$sApiLogin}&apiKey={$sApiKey}&format={$sFormat}";
    $sRequestURL = "http://api.bit.ly/shorten?version={$sApiVersion}&longUrl={$sUrl}&login={$sApiLogin}&apiKey={$sApiKey}";
    
    //print_r("<pre>" . $sRequestURL . "</pre>");
    $jResult     = file_get_contents($sRequestURL);
    $aResult     = json_decode($jResult,TRUE);

    if($aResult['statusCode']=="OK"){
        $aItem = array_pop($aResult['results']);
				//追記：「http://」の削除
				//$aItem['shortUrl'] = str_replace("http://","",$aItem['shortUrl']);
        return $aItem['shortUrl'];
    }
    else{
        return $aResult['errorMessage'];
    }
}

/* 使い方 */
//短くしたいURL
  $sLongUrl = $_POST["phpURL"];
//bit.lyのログイン名
  $sLogin = "soturon";
//bit.lyのAPIキー
  $sApiKey = "R_9dfd4c9cd17fee992b6ae2450eb70005";

echo short_url($sLongUrl,$sLogin,$sApiKey );
?>