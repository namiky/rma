<?php
	//外部化したファイルの呼び出し
	require_once("../database.php");
	
	//初期化
	$finish = '';
	$error  = '';

	
	//デバッグ
	if($_POST["member_code"] == "")$error.="Member_codeのテキストエラー<br />";
	if($_POST["member_pass"] == "")$error.="Member_passのテキストエラー<br />";
	if($_POST["member_name"] == "")$error.="Member_nameのテキストエラー<br />";
	
	if(!$error){
		//SQL処理
		$sql = "insert into rma_member(member_code,member_pass , 
			member_name ) values(" ;
		$sql .= "\"".$_POST["member_code"]. "\" , ";
		$sql .= "\"".$_POST["member_pass"]. "\" , ";
		$sql .= "\"".$_POST["member_name"]. "\" ) ";
		$res = mysql_query($sql) or die("追加できませんでした");
		//完了報告
		$finish .= "アカウントの追加が完了しました。<br>";

	}

	

		
	//リダイレクト
	 require 'member_add.php';
	
?>