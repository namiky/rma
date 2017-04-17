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
		<script type="text/javascript">
			function FormCheckRemove(){
				return confirm("取消してよろしいですか？");
			}
			function FormCheckDelete(){
				return confirm("削除してよろしいですか？");
			}
		</script> 
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
						print("error1:商品が選択されていないです。");
						$code="0";
						die;
					}else{
						$code = $_GET["code"];		//アドレスに記載されているcodeをcodeに代入
					}
					
					
					$sql = "select * from rma_history where history_code = $code ";
					$res = mysql_query( $sql ) or die;
					$history = mysql_fetch_array( $res ); 
					//rma_memberを$memberに呼び出し
					$h_m_c = $history["member_code"] ;
					$sql="SELECT * FROM rma_member WHERE member_code = $h_m_c ";
					$m_res =  mysql_query( $sql );
					$member = mysql_fetch_array( $m_res );
					//rma_memberを$itemに呼び出し
					$h_i_c = $history["item_code"] ;
					$sql="SELECT * FROM rma_item WHERE item_code = $h_i_c ";
					$i_res = mysql_query( $sql ) or die();
					$item = mysql_fetch_array( $i_res );
					
					
					
					//ここからテーブル作成
					print("<table border=1 cellpadding=5>");
					//ここからテーブルの1番
					print("<tr>");
						print("<th style=\"background:#cccccc;\">履歴ID</th>");
						print("<td>" .$history["history_code"]. "</td>");
					print("</tr>");					
					
					print("<tr>");
						print("<th style=\"background:#cccccc;\">購入者ID</th>");
						print("<td>" .$history["member_code"]. "</td>");						
					print("</tr>");
											
					print("<tr>");
						print("<th style=\"background:#cccccc;\">購入者NAME</th>");
						print("<td>" .$member["member_name"]. "</td>");
					print("</tr>");						
					
					
					print("<tr>");
						print("<th style=\"background:#cccccc;\">商品ID</th>");
						print("<td>" .$history["item_code"]. "</td>");
					print("</tr>");			
					
								
					print("<tr>");
						print("<th style=\"background:#cccccc;\">商品NAME</th>");
						print("<td>" .$item["item_name"]. "</td>");
					print("</tr>");		
					
									
					print("<tr>");
						print("<th style=\"background:#cccccc;\">商品の値段</th>");
							print("<td>" .number_format($history["item_price"]). "</td>");
					print("</tr>");			
					
								
					print("<tr>");
						print("<th style=\"background:#cccccc;\">購入時間</th>");
						print("<td>" .$history["history_time"]. "</td>");
					print("</tr>");			
					
								
					print("<tr>");
						print("<th style=\"background:#cccccc;\">1:(済)/0:(未)</th>");
						print("<td>" .$history["del_flag"]. "</td>");
					print("</tr>");			

					//ここまでテーブルの1番
					//ここからwhile文で1人ずつテーブルに書き込む
					//rma_memberを$memberに呼び出し
						
					
							
							
						?>	
				
				
					<!-- 取消-->
						<?php if( $history[del_flag]!=1 ){ ?>
						
							<form action="history_remove.php?code=<?php print( htmlspecialchars($history[history_code]) ); ?>" method="post" onSubmit="return FormCheckRemove();">
								<input type="hidden" name="CONFIRM" value="" />
								<input type ="submit" value="取消" />
							</form>
						
						<?php } ?>
							
					<!-- 削除-->
						<?php if($history[del_flag]==1  && $account=="management"){ ?>
						
							<form action="history_delete.php?code=<?php print( htmlspecialchars($history[history_code]) ); ?>" method="post" onSubmit="return FormCheckDelete();">
								<input type="hidden" name="CONFIRM" value="" />
								<input type ="submit" value="削除" />
							</form>
						
						<?php } ?>

			<?php
				}//else文
			?>
		</div>
		<hr>
	</body>
</html>