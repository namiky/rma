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
				return confirm("変更してよろしいですか？");
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
							if(!isset($_GET["code"]) ){
								if($error||$finish){//edit_fから帰ってきたよう
								 if ($error) echo "<span class=\"error\">[エラーメッセージ]<br />$error<br /><a href=\"../index.php\">Topに戻る</a></span>"; 
								 else if ($finish) echo "<span class=\"finish\">情報更新が完了しました。<br /><br /></span>"; 									
								}else{	///誰も選択していないとき、自分の編集を行う									
									$code=$_SESSION["member_code"];
									header("Location:" . $_SERVER['PHP_SELF'] . "?code=" . $code);
									
								}
								exit;
							}
							else $code = $_GET["code"];		//アドレスに記載されているcodeをcodeに代入
							
							$sql = "select * from rma_member where member_code = '$code' ";
							$res = mysql_query( $sql ) or die("error1");
							$member = mysql_fetch_array( $res ) or die("error2"); 
						?>
						<hr>
						<span>設定</span><br>		
						<form action="member_edit_f.php" method="post" onSubmit="return FormCheck() ;">
							<table border=1>
								<tr bgcolor=#cccccc>
									<th><br></th><th>変更前</th><th>変更後</th>
								</tr>
								<tr>
									<th>ID</th>
									<td><span><?php print( $member["member_code"] ); ?> </span></td> 
								</tr>
								<tr>	
									<th>PASS</td>
									<td><span><?php print( $member["member_pass"] ); ?> </span></td> 
									<td><input type="text" name="member_pass" value="<?php print($member["member_pass"]); ?>" size=""/></td>
								</tr>
								<tr>
									<th>名前</th>
									<td><span><?php print( $member["member_name"] ); ?> </span></td>
									<td><input type="text" name="member_name" value="<?php print($member["member_name"]); ?>" size="" /></td>
								</tr>	
								<tr>	
									<th>del_flag</th>
									<td><span><?php print( $member["del_flag"] ); ?></span></td>
									<?php if($account == "admin") {
											print("<td>"
												 ."<select name='del_flag' value='"
												 ."$member[del_flag]"
												 ."' />");
											if( $member[del_flag]==1 ){
												print("<option>0:(未)</option>
													 <option selected=\"selected\">1:(済)</option>"
													 ."</td>");
											}
											else{
												print("<option  selected=\"selected\">0:(未)</option>
													 <option>1:(済)</option>"
													 ."</td>");												
											}
									}
									?>
								</tr>
								<tr>	
									<th>totalAmount</th>
									<td><span><?php print( $member["totalAmount"] ); ?>円</span></td>
									<?php	if($account == "admin") {	
											print("<td>"
												 ."<input type='text' name='totalAmount' value='"
												 ."$member[totalAmount]"
												 ."' />"
												 ."円</td>");
										}
									?>
								</tr>
																	

									<?php
									//del_flagとtotalAmountの動作
									//adminかuserで場合分け
										if( $account != "admin" ){
												print("<input type=\"hidden\" name=\"del_flag\" value=\"".$member["del_flag"]."\" />");
												print("<input type=\"hidden\" name=\"totalAmount\" value=\"".$member["totalAmount"]."\" />");
										}
										?>
									
							
							</table>
							<input type="hidden" name="member_code" value="<?php print($member[member_code]); ?>" size="" />
							<input type ="submit" value="変更" />
							</form>
							
				<?php
					}//else文
				?>
				<hr>
		</div>
	</body>
	</html>