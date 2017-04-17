<?php
//外部化したファイルの呼び出し
	require_once("../database.php");

//SQL
	$sql = "SELECT * FROM rma_settlement WHERE del_flag='0' ";
	$rst = mysql_query( $sql ) or die;
	$sum=$num=5;	//値を何番目まで取りだしたいか
	

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


