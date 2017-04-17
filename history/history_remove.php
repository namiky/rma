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
							
							//ここから取消行動
							//item_price、member_codeを取得しておく
							$sql ="SELECT * FROM rma_history WHERE history_code='$code' ";
							$res = mysql_query( $sql ) or die("データの取得失敗");
							$row = mysql_fetch_array($res) or die("error");
							$i_p = $row["item_price"];
							$i_c = $row["item_code"];
							$i_cost = $row["item_cost"];
							$m_c = $row["member_code"];
							$del_flag = $row["del_flag"];
							
							//現在時刻の取得
							date_default_timezone_set('Asia/Tokyo'); 
							$i_t = $row["history_time"];
							$yearAndMounthAndDay = substr("$i_t", 0, 10);	//年と月と日の値
							
							
							
							//「現在の時刻」と「購入時刻」とを比較し”＝”でない、かつ、会計でないなら取消が出来ない仕様→その日内でないなら取消不可
							if( (strcmp(date("Y/m/d"), $yearAndMounthAndDay)==1) && ($_SESSION["member_code"]!="management") )print("取消可能日時を超えています。取消できません。");
							
							//del_flagのチェック
							else if( $del_flag == 1)print("すでに取消済みです。");
							
							//取消実行
							else{
								//totalAmountとtotalCostの更新
								//※現状マイナスに対するデバッグは未
								$sql = "UPDATE rma_member SET totalAmount=totalAmount-'$i_p' WHERE member_code= '$m_c' ";
								$res = mysql_query( $sql ) or die(error);
								
								$sql = "UPDATE rma_member SET totalCost = totalCost-'$i_cost' WHERE member_code= '$m_c' ";
								$res = mysql_query( $sql ) or die(error);			
								//アイテムストック＋１
								$sql = "UPDATE rma_item SET item_stock = (item_stock+1) , del_flag=0 WHERE item_code= '$i_c' ";
								$res = mysql_query( $sql ) or die(error);
								//取消
								$sql = "UPDATE rma_history SET del_flag=1 WHERE history_code= '$code' ";
								$res = mysql_query( $sql ) ;
								if (!$res)die("取消失敗しました。<br />（原因）:".mysql_error());
								
								
								
								print("取消完了しました。");
							//ここまで取消行動
							}
							
						?>
				<?php
					}//else文
				?>
				<hr>
				</div>
	</body>
</html>