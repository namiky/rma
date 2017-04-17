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
				return confirm("追加してよろしいですか？");
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
				<span>アカウント作成<br></span>			
						
				
			<form action="member_add_f.php" method="post" onSubmit="return FormCheck();">
				<table>
					<tr>
						<td>ID</td>
						<td><input type="text" name="member_code"></td>
					</tr>
					<tr>
						<td>パスワード</td>
						<td><input type="text" name="member_pass"></td>
					</tr>
					<tr>
						<td>名前</td>
						<td><input type="text" name="member_name"></td>
					</tr>
				</table>
				<input type="hidden" name="CONFIRM" value="" />
				<input type ="submit" value="追加" />
											
				
				<?php if ($error) echo "<span class=\"error\"><br />[エラーメッセージ]<br />$error<br /></span>" ?>
				<?php if ($finish) echo "<span class=\"finish\">登録が完了しました。<br /><br /></span>" ?>
				
			</form>
			
				
		<?php
			}//else文
		?>
		<hr>
</div>
	</body>
</html>

