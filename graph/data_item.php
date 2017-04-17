<?php
// 連想配列を作成するような感じ
/*$json = <<< JSON_DOC
    [
    {"name":"Google","url":"http://www.google.co.jp/"}
    ,{"name":"Yahoo!","url":"http://www.yahoo.co.jp/"}
    ]
JSON_DOC;

// JSON用のヘッダーを付けて出力
header("Content-Type: text/javascript; charset=utf-8");
echo $json;
*/

//外部化したファイルの呼び出し
	require_once("../database.php");
//文字エンコード
/*	mb_language("uni");
  mb_internal_encoding("utf-8"); //内部文字コードを変更
  mb_http_input("auto");
  mb_http_output("utf-8");
	*/
//SQL
	$sql = "SELECT * FROM rma_item  WHERE item_code IN ( '1036' ) ";
	$rst = mysql_query( $sql ) or die;
	$sum=$num=8;	//値を何番目まで取りだしたいか
	

	//start
	$y=0;
	$arrays ="[";
	while( $row =mysql_fetch_array($rst)){//一行ずつ読み込み
		$x=0;
		$arrays .= "[";
		for($x=0;$x<=$num;$x++){//フィールド数分、カンマ区切りで追加
			$arrays .= "'" . $row[$x] . "',";
		}
		$arrays = rtrim($arrays, ","); //最後のカンマが余るので削除
		$arrays .="],";//次の行に移るため、]を閉じる
		$y++;
	}
	$arrays = rtrim($arrays, ","); //最後のカンマが余るので削除
	$arrays .="]";//ここまででPHP側の基本的な処理は終了
	//end

	//出力	
	print $arrays;
	
	
	
	
//var_dump($ary);
	//print json_encode($ary);
	//print json_encode($totalAmount);
?>


