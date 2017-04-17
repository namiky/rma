<?php
	//外部化したファイルの呼び出し
	require_once("../database.php");

	//初期化
	$error='';
	$finish='';
	
	//各値の代入(if内だとデバッグが出来ないので)
	$member_code=$_POST["member_code"];
	$member_pass=$_POST["member_pass"];
	$member_name=$_POST["member_name"];
	$del_flag=$_POST["del_flag"];
	$totalAmount=$_POST["totalAmount"];	
	
	//フォーム内のデータ別デバッグ
	//※現状 デバッグがバグになってるのでコメントアウト
	
	if($_POST["member_pass"] == "")$error.=("メンバーのpassのテキストエラー<br />");
	if($_POST["member_name"] == "")$error.=("メンバーのnameのテキストエラー<br />");
	if($_POST["del_flag"] == "")$error.=("del_flagのテキストエラー<br />");
	if($_POST["totalAmount"] == "")$error.=("メンバーの価格のテキストエラー<br />");
	//文字数チェック
	if(strlen($_POST['member_name']) >= 30)$error.=("商品nameの文字数を30以下にしてください。<br />");
	//user以外のチェック
	if($member_code=="admin" || $member_code=="purchase" || $member_code=="management"){
		if($_POST["del_flag"]!=0)$error.=("このユーザーのdel_flagは0にしてください。<br />");
		if($_POST["totalAmount"]!=0)$error.=("このユーザーのtotalAmountは0にしてください。");
	}

	
	
	if(!$error){
		//SQL処理
		$sql ="UPDATE rma_member 
			SET member_pass='$member_pass' ,
				member_name='$member_name' ,
				del_flag='$del_flag' ,
				totalAmount='$totalAmount' 
			WHERE member_code='$member_code' ";
		$res = mysql_query($sql) or die("更新できませんでした");
		
		//終了フラグ
		$finish .= "1";

	}
	//リダイレクト
	 require 'member_edit.php';
	
	
?>