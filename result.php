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
					<?php 
					//初期動作
						require_once("../start.php");
					?>
					<!--ここまでテンプレ -->	
						<div class="content">									
						<?php
							
						?>
				<?php
					}//else文
				?>
				<hr>
		<?php if ($error) echo "<span class=\"error\"><br />[エラーメッセージ]<br />$error<br /></span>" ?>
		<?php if ($finish) echo "<span class=\"finish\">$finish<br /></span>" ?>
		<hr>
		</div>
	</body>
</html>