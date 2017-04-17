<?php
	//外部化したファイルの呼び出し
	require_once("../database.php");
	
	//初期化
	$finish = '';
	$error  = '';

	
	//rma_settlementのdel_flagを0にする
	$sql = "UPDATE rma_settlement SET del_flag =1   ";
	$res = mysql_query( $sql ) ;
	if (!$res)$error=("失敗しました。<br />（原因）:".mysql_error());
	else $finish = "Resetしました。";

		
	//リダイレクト
	 require '../result.php';
	
?>

							
							
							
							