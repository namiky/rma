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
						//ここからメンバーリスト表示
							$member_code = $_SESSION["member_code"];
							//①アクターが会計
							if($member_code == "management" ) $sql = "SELECT * FROM rma_history";
							//②アクターが一般
							else $sql = "SELECT * FROM rma_history WHERE member_code = $member_code ORDER BY history_code DESC";
							$res = mysql_query( $sql );
							
							/*
							 * 
							 * 未削除の項目
							 * 
							 */
							 
							print ("<hr>精算(未)一覧<br>");
							//ここからテーブル作成
							print("<table border=1 cellpadding=5>");
								//ここからテーブルの1番
								print("<tr bgcolor=#cccccc>");
									if($account=="management")print("<th>購入者</th>");
									print("<th>商品</th>");
									print("<th>値段</th>");
									print("<th>詳細</th>");
								print("</tr>");
								//ここまでテーブルの1番
								
							//ここからwhile文で1人ずつテーブルに書き込む
							while( $history = mysql_fetch_array( $res ) ) {
								if($history["del_flag"]==0){
									//rma_memberを$memberに呼び出し
									$h_m_c = $history["member_code"] ;
									$sql="SELECT * FROM rma_member WHERE member_code = '$h_m_c'";
									$m_res =  mysql_query( $sql ) or die("error2");
									$member = mysql_fetch_array( $m_res );
									//rma_memberを$itemに呼び出し
									$h_i_c = $history["item_code"] ;
									$sql="SELECT * FROM rma_item WHERE item_code = $h_i_c ";
									$i_res = mysql_query( $sql ) or die();
									$item = mysql_fetch_array( $i_res );
									print("<tr>");
										
										//もしもｔっと必要・チェックタグ使いたいなら過去のverから持ってきてifで分ける
										if($account=="management")print("<td>" .$member["member_name"]. "</td>");
										print("<td>" .$item["item_name"]. "</td>");
										print("<td>" .number_format($history["item_price"]). "円</td>");
								
										//詳細
										print(" <td><a href='history_detail.php?code=");
										print( htmlspecialchars($history["history_code"]) ); 
										print("'> →詳細</a>" . "</td>" );
	
									print("</tr>");
								}
							}
							//ここまでwhile文で1人ずつテーブルに書き込む
							print("</table>");
							//ここまでテーブル作成
							
							/*
							 * 
							 *(済)削除の項目
							 *  
							 */
							 //ここからメンバーリスト表示
							$member_code = $_SESSION["member_code"];
							 //①アクターが会計
							if($member_code == "management" ) $sql = "SELECT  * FROM rma_history";
							//②アクターが一般
							else $sql = "SELECT * FROM rma_history WHERE member_code = $member_code ORDER BY history_code DESC";
							$res = mysql_query( $sql );
							
							print ("<hr>精算(済)一覧<br>");
							//ここからテーブル作成
							print("<table border=1 cellpadding=5>");
								//ここからテーブルの1番
								print("<tr bgcolor=#cccccc>");
									if($account=="management")print("<th>購入者</th>");
									print("<th>商品</th>");
									print("<th>値段</th>");
									print("<th>詳細</th>");
								print("</tr>");
								//ここまでテーブルの1番
								
							//ここからwhile文で1人ずつテーブルに書き込む
							while( $history = mysql_fetch_array( $res ) ) {
								if( $history["del_flag"]=="1" ){//rma_memberを$memberに呼び出し
									$h_m_c = $history["member_code"] ;
									$sql="SELECT * FROM rma_member WHERE member_code = '$h_m_c' ";
									$m_res =  mysql_query( $sql ) or die("error2");
									$member = mysql_fetch_array( $m_res );
									//rma_memberを$itemに呼び出し
									$h_i_c = $history["item_code"] ;
									$sql="SELECT * FROM rma_item WHERE item_code = $h_i_c ";
									$i_res = mysql_query( $sql ) or die();
									$item = mysql_fetch_array( $i_res );
									print("<tr>");
										
									//もしもｔっと必要・チェックタグ使いたいなら過去のverから持ってきてifで分ける
									if($account=="management")print("<td>" .$member["member_name"]. "</td>");
									print("<td>" .$item["item_name"]. "</td>");
									print("<td>" .number_format($history["item_price"]). "円</td>");
							
									//詳細
									print(" <td><a href='history_detail.php?code=");
									print( htmlspecialchars($history["history_code"]) ); 
									print("'> →詳細</a>" . "</td>" );
	
									print("</tr>");
									}
							}
							//ここまでwhile文で1人ずつテーブルに書き込む
							print("</table>");
							//ここまでテーブル作成							
							
						//ここまでメンバーリスト表示
						?>
				<?php
					}//else文
				?>
			<hr>	
			</div>

	</body>
</html>