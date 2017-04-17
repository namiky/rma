<?php
//初期設定群
//sessionを始める
	session_start();
//外部化したファイルの呼び出し
	require_once("database.php");
//Noticeメッセージを非表示にする。
	error_reporting(E_ALL ^ E_NOTICE);
?>



<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
	<head>
		<meta name="viewport" content="width=device-width; initial-scale=1, minimum-scale=1, maximum-scale=1, user-scalable=no" />
		<link rel="apple-touch-icon" href="apple-touch-icon-precomposed.png" />
		<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
		<title>RMA_α版_vol.1.1</title>
		<link rel="stylesheet" href="pageslide.css">
		<script type='text/javascript' src='http://ajax.microsoft.com/ajax/jquery/jquery-1.7.min.js'></script>



		
		
        
	</head>
	<body>
		<?php
			/**-----------------------------------------------------------
			 *
			 * 【ログイン】
			 * 「ログイン」ボタンが押された時にこの if 文に入ります。
			 *
			 ------------------------------------------------------------*/
			if( $_REQUEST["cmd"] == "do_login" )
			{
				//ログイン成功・失敗を判断するためのSELECT文
				$sql = "select * from rma_member ";
				$sql.= "where member_code = '" . $_REQUEST["login_id"] . "'";
				$sql.= "and member_pass='" . $_REQUEST["login_pass"] . "'";
				
				$res = mysql_query( $sql );
				$is_login = 0;
				// 検索結果が取れた場合(つまり、ログインに成功した場合)以下の if 文に入る。
				if( $row = mysql_fetch_array( $res ) ) 
				{
					$_SESSION["member_code"] = $_REQUEST["login_id"];
					$_SESSION["member_name"] = $row["member_name"];
					$_SESSION["totalAmount"] = $row["totalAmount"];
					$is_login = 1;
				}
				mysql_free_result($res);
			}

			/**-----------------------------------------------------------
			 *
			 * 【ログインアウト】
			 * ログイン後に、画面左側の「ログアウト」ボタンが押された時に
			 * この if 文に入ります。unset 命令は変数の中身を破棄する命令です。
			 *
			 ------------------------------------------------------------*/
			if( $_REQUEST["cmd"] == "do_logout" )
			{
				unset( $_SESSION["member_code"] );
				unset( $_SESSION["member_name"] );
			}
		?>





				<?php
					// ログイン済/未の判定if文。
					// ①ログイン(未)の時は、以下の if 文に入ります。
					if( $_SESSION["member_code"] == "" )
					{?>
						<!-- ログインフォーム（非ログイン時） -->
						<div class="content">
						<form name="login_form" action="index.php" method="post">
							<input type="hidden" name="cmd" value="do_login"/>
							<div class="box">
								<div class="top"><p>ログイン画面</p></div>
								<dl class="clearfix">
									<?php
										// ログインに失敗した時のエラー表示。
										if( $is_login == 0 and $_REQUEST["cmd"] == "do_login" )print("ログインに失敗しました。");
									?>
									<dt>ID:</dt>
									<dd><input name="login_id" type="text" class="text" /></dd>
									<dt>PASS:</dt>
									<dd><input name="login_pass" type="password" class="text" /></dd>
								</dl>
								<div class="bottom">
									<input name="" type="submit" value="ログイン" />
								</div>
							</div>
						</form>
					</div>
				<?php 
					// ②ログイン(済)の時は、以下の else 文に入ります。
					} else
					{?>
						<form name="login_form" action="index.php" method="post">
							<input type="hidden" name="cmd" value="do_logout"/>
							<div class="content">
								<span class="person">ようこそ<?php print($_SESSION["member_name"]); ?>さん！</span>
			 					<input name="id3" type="submit" value="ログアウト" />
							</div>
						</form>
							<?php 
							//初期動作↓
								require_once("start.php");
								//現状のページ・アカウントとphp_accountとの使用権限のチェック
								$fileName = basename(__FILE__);
								$fileName = str_replace(".php","",$fileName);
								if($php_account["$fileName"]["$account"]==0)die("あなたのアクターでは使用権限はありません。");
							?>
					
						<!--ここから index -->			
						<div class="content">
						</div>

						
				<?php }//else文  ?>

		
		<script src="js/jquery.pageslide.min.js"></script>
		<script>
		    $(".psLeft").pageslide({direction:"right",modal: true });
		    $(".psRight").pageslide({ direction: "left", modal: true });
		</script>
	</body>
</html>