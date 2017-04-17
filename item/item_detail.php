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
			function FormCheckPurchase(){
				return confirm("購入してよろしいですか？");
			}
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
							
							
							$sql = "select * from rma_item where item_code = $code ";
							$res = mysql_query( $sql ) or die;
							while( $item = mysql_fetch_array( $res ) ) {
								?>
								<table border=1>
									<tr  bgcolor=#cccccc>
										<th>商品</th>
										<th>残数</th>
										<th>金額</th>
										<th>詳細</th>
										<th>作成日</th>
									</tr>
									<tr>
										<td>
											<?php print( $item["item_name"] ); ?>
										</td>
										
										<td><span><?php print( number_format($item["item_stock"]) ); ?>個</span></td>
										<td><span><?php print( number_format($item["item_price"]) ); ?>円</span></td>
										<td><span><?php print( $item["item_detail"] ); ?> </span>
										<td><span><?php print( $item["item_time"] ); ?> </span>
										
										<?php
										//編集
										if( $php_account["item_edit"]["$account"] ){
											print(" <td><a href='item_edit.php?code=");
											print( htmlspecialchars($item["item_code"]) ); 
											print("'> →編集</a>" . "</td>" );
										}
										?>
										
										<!-- 購入-->
										<?php if("$account"==user){ ?>
										<td>
											<form action="item_purchase.php?code=<?php print( htmlspecialchars($item[item_code]) ); ?>" method="post" onSubmit="return FormCheckPurchase();">
												<input type="hidden" name="CONFIRM" value="" />
												<input type ="submit" value="購入" />
											</form>
										</td>	
										<?php } ?>
										<!-- 取り消し-->
										<?php if("$account"==purchase && $item["del_flag"] == 0){ ?>
										<td>
											<form action="item_remove.php?code=<?php print( htmlspecialchars($item[item_code]) ); ?>" method="post" onSubmit="return FormCheckRemove();">
												<input type="hidden" name="CONFIRM" value="" />
												<input type ="submit" value="取消" />
											</form>
										</td>	
										<?php } ?>								
										<!-- 削除-->
										<?php if("$account"==purchase && $item["del_flag"] == 1){ ?>
										<td>
											<form action="item_delete.php?code=<?php print( htmlspecialchars($item[item_code]) ); ?>" method="post" onSubmit="return FormCheckDelete();">
												<input type="hidden" name="CONFIRM" value="" />
												<input type ="submit" value="削除" />
											</form>
										</td>	
										<?php } ?>
																												
									</tr>
								</table>
						<?php
							}//while文
						?>
				<?php
					}//else文
				?>
				<hr>
				</div>
	</body>
</html>