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
			function FormCheck(){
				return confirm("決算してよろしいですか？");
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
					<hr>
					<span>アカウントリスト<br></span>
						<?php
							//ここからメンバーリスト表示
							$sql = "SELECT * FROM rma_member";
							$res = mysql_query( $sql );
							//ここからテーブル作成
							print("<table border=1 cellpadding=5>");
							//ここからテーブルの1番
							print("<tr bgcolor=#cccccc>");
								print("<td>ID</td>");
								if($account=="admin")print("<td>PW</td>");
								print("<td>名前</td>");
								print("<td>削除フラグ</td>");
								print("<td>未支払総額</td>");
								if($account=="admin"){
									print("<td>詳細</td>");
									print("<td>編集</td>");
								}
								else{
									print("<td>決算</td>");
								}
									
								
							print("</tr>");
							//ここまでテーブルの1番
							//ここからwhile文で1人ずつテーブルに書き込む
							while( $member = mysql_fetch_array( $res ) ) {
									print("<tr>");
										print("<td>" .$member["member_code"]. "</td>");
										//パスワード
										if($account=="admin")print("<td>" .$member["member_pass"]. "</td>");
										print("<td>" .$member["member_name"]. "</td>");
										print("<td>" .$member["del_flag"]. "</td>");
										print("<td>" .$member["totalAmount"]." 円</td>");
										if($account=="admin"){
											//詳細
											print(" <td><a href='member_detail.php?code=");
											print( htmlspecialchars($member["member_code"]) ); 
											print("'> →詳細</a>" . "</td>" );
											
											//編集
											print(" <td><a href='member_edit.php?code=");
											print( htmlspecialchars($member["member_code"]) ); 
											print("'> →編集</a>" . "</td>" );
										}
										else{
										?>
										<!-- 決算-->
										<td>
											<form action="member_settlement.php?code=<?php print( htmlspecialchars($member["member_code"]) ); ?>" method="post" onSubmit="return FormCheck();">
												<input type="hidden" name="CONFIRM" value="" />
												<input type ="submit" value="決算" />
											</form>
										</td>												

										<?php
										}
										
									print("</tr>");
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