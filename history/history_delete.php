<?php
//初期設定群
//sessionを始める
	session_start();
//外部化したファイルの呼び出し
	require_once("../database.php");
//Noticeメッセージを非表示にする。
	error_reporting(E_ALL ^ E_NOTICE);
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<meta name="viewport" content="width=device-width; initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />
		<link rel="stylesheet" href="../pageslide.css">
		<script type='text/javascript' src='http://ajax.microsoft.com/ajax/jquery/jquery-1.7.min.js'></script>
		<title>RMA_α版_vol.1.1</title>
	</head>
	<body>
	<?php
		// loginCheck.php
		// ①ログイン(未)の時は、以下の if 文に入ります。
		if( $_SESSION["member_code"] == "" )print("ログアウトしています。");
		// ②ログイン(済)の時は、以下の else 文に入ります。
		else{ ?>
			<form name="login_form" action="../index.php" method="post">
				<input type="hidden" name="cmd" value="do_logout"/>
				<div class="content">
					<span class="person">ようこそ<?php print($_SESSION["member_name"])?>さん！</span>
					<input type="submit" value="ログアウト" />
				</div>
			</form>
			<?php require_once("../start.php"); ?>
			<script src="../js/jquery.pageslide.min.js"></script>
			<script>
			    $(".psLeft").pageslide();
			</script>
			<?php
				//アクターチェック：現状のページ・アカウントとphp_accountとの使用権限のチェック
				$fileName = basename(__FILE__);
				$fileName = str_replace(".php","",$fileName);
				if($php_account["$fileName"]["$account"]==0)die("あなたのアクターでは使用権限はありません。<br />");
			?>
			<!--ここまでテンプレ -->	
			
			<div class="content">	
			<?php
				//****ここから商品詳細情報****
				// 商品が選択されると各商品に対応したitem_codeをcodeに入れ、GET方式で送信する。
				// GET送信されていない場合、つまり、codeがセットされていないときはエラーとなる。
				if(!isset($_GET["code"]) ){
					print("error1:人間が選択されていないです。");
					$code="0";
					die;
				}else{
					$code = $_GET["code"];		//アドレスに記載されているcodeをcodeに代入
				}
				
				//ここから削除行動
				//item_price、member_codeを取得しておく
				$sql ="SELECT * FROM rma_history WHERE history_code='$code' ";
				$res = mysql_query( $sql ) or die("データの取得失敗");
				$row = mysql_fetch_array($res) or die("error");
				$i_p = $row["item_price"];
				$m_c = $row["member_code"];
				$del_flag = $row["del_flag"];
				
				if( $del_flag !=1 )print("除去されていないものは削除できません。");
				else{
					//削除
					$sql = "DELETE FROM rma_history WHERE history_code= '$code' ";
					$res = mysql_query( $sql ) or die("削除失敗しました。<br />（原因）:".mysql_error());
					print("削除完了しました。");
				}
				//ここまで削除行動
			?>
			<?php
				}//else文
			?>
		</div>
		<hr>
	</body>
</html>