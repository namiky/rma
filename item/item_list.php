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
					<hr>
					<span>商品リスト</span>
					
						<table border=1>
							<tr  bgcolor=#cccccc>
								<th>商品</th>
								<th>残数</th>
								<th>金額</th>
								<th>Type</th>
							</tr>
						<?php
							//ここから商品リスト表示
							//別verの書き方でprint("<td>" .$res["item_code"]. "<td>");という方法で書くパターンも考える
							$sql = "SELECT  * FROM rma_item WHERE del_flag = '0' ORDER BY item_time  DESC";
							$res = mysql_query( $sql );
							while( $item = mysql_fetch_array( $res ) ) {
						?>
							<tr >
								<td>
									<a href="item_detail.php?code=<?php print(htmlspecialchars( $item["item_code"] ) ); ?>">
									<?php print( $item["item_name"] ); ?><br />
									</a>
								</td>
								<td><span><?php print( number_format($item["item_stock"]) ); ?>個</span></td>
								<td><span><?php print( number_format($item["item_price"]) ); ?>円</span></td>
								<td><span>
									<?php 
										if($item["item_category"]=="飲み物")echo "飲物"; 
										if($item["item_category"]=="カップ麺")echo "麺"; 
										if($item["item_category"]=="お菓子")echo "菓子"; 
										if($item["item_category"]=="アイス")echo "Ice"; 
										if($item["item_category"]=="その他")echo "etc"; 
									?>
									
									</span></td>
								
							</tr>
							
						<?php
							}	//whilel文//ここまで商品リスト表示
						?>
						</table>
				<?php
					}//else文
				?>

				<hr>
				</div>
	</body>
</html>