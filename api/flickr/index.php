
<?php
define ("APIKEY" , "99bd54b3e4361537566b9a43397bd215");

$searchWord = "piano";	//検索したい画像のキーワード
$pictureSize = "t";	//画像サイズ

$url = "http://www.flickr.com/services/rest/?"
	 . "method=flickr.photos.search"
	 . "&format=rest"
	 . "&api_key=".APIKEY
	 . "&per_page=20"
	 . "&license=2,3,4,5,6"
	 . "&extras=owner_name"
	 . "&text=".urlencode($searchWord);

$xml = @simplexml_load_file($url);
//print_r($xml);

$iLoop = 0;
echo "$searchWord";
echo "<table>";
foreach($xml->photos->photo as $photoValue){
	if( $iLoop == 0){
		echo "<tr><td>";
	} else {
		echo "<td>";
	}
	$farmId = $photoValue['farm'];
	$serverId = $photoValue['server'];
	$photoId = $photoValue['id'];
	$secret = $photoValue['secret'];
	$owner = $photoValue['owner'];
	$ownername = $photoValue['ownername'];
	//改行はレイアウトのため
	echo "<a href=\"http://www.flickr.com/photos/{$owner}/{$photoId}/\">
	<img src=\"http://farm{$farmId}.static.flickr.com/{$serverId}/
	{$photoId}_{$secret}_{$pictureSize}.jpg\" /></a><br>";
	echo "author by <a href=\"http://www.flickr.com/photos/{$owner}/\">
	{$ownername}</a>";
	$iLoop++;
	if( $iLoop == 4){
		echo "</td></tr>";
		$iLoop = 0;
	} else {
		echo "</td>";
	}
}
if( $iLoop != 0 ){
	echo "</tr>";
}
echo "</table>";

?>