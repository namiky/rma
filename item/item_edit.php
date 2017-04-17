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
				return confirm("更新してよろしいですか？");
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
								
								//edit_fから帰ってきたとき用
								 if ($error) echo "<span class=\"error\">[エラーメッセージ]<br />$error<br /></span>"; 
								 else if ($finish) echo "<span class=\"finish\">商品の更新が完了しました。<br /><br /></span>"; 
								 else print("商品を選択してください。<br>");
								print("<a href=\"item_list.php\">リストに戻る</a>");
								
								$code="0";
								die;
							}else{
								$code = $_GET["code"];		//アドレスに記載されているcodeをcodeに代入
							}
							
							
							$sql = "select * from rma_item where item_code = $code ";
							$res = mysql_query( $sql ) or die;
							$item = mysql_fetch_array( $res ); 
						?>
								
						<form action="item_edit_f.php" method="post" onSubmit="return FormCheck();">
							<table border=1>
								<tr>
									<th><br></th>
									<th>現在</th>
									<th>変更後</th>
								</tr>
								<tr>
									<th>名称</th>
									<td><span><?php print( $item["item_name"] ); ?> </span></td>
									<td><input type="text" name="item_name" value="<?php print($item[item_name]) ?>" size="" /></td>
								</tr>
								<tr>	
									<th>残数</th>
									<td><span><?php print( $item["item_stock"] ); ?>個</span></td>
									<td><input type="text" name="item_stock" value="<?php print($item[item_stock]) ?>" size="" /></td>
								</tr>
								<tr>	
									<th>金額</th>
									<td><span><?php print( $item["item_price"] ); ?>円</span></td>
									<td><input type="text" name="item_price" value="<?php print($item[item_price]) ?>" size="" /></td>
								</tr>
								<tr>	
									<th>仕入れ値</th>
									<td><span><?php print( $item["item_cost"] ); ?>円</span></td>
									<td><input type="text" name="item_cost" value="<?php print($item[item_cost]) ?>" size="" /></td>
								</tr>								<tr>	
									<th>詳細</th>
									<td><span><?php print( $item["item_detail"] ); ?> </span></td>
									<td><input type="text" name="item_detail" value="<?php print($item[item_detail]) ?>" size="" /></td>
								</tr>
								<tr>
									<th>カテゴリ</th>
									<td><span><?php print( $item["item_category"] ); ?> </span></td>
									<td><select  name="item_category">
											<option value="飲み物"  <?php if($item["item_category"]=="飲み物")echo "selected=\"selected\"";?>>飲み物</option>
											<option value="カップ麺"  <?php if($item["item_category"]=="カップ麺")echo "selected=\"selected\"";?> >カップ麺</option>
											<option value="お菓子"  <?php if($item["item_category"]=="お菓子")echo "selected=\"selected\"";?> >お菓子</option>
											<option value="アイス"   <?php if($item["item_category"]=="アイスｔ")echo "selected=\"selected\"";?> >アイス</option>
											<option value="その他"  <?php if($item["item_category"]=="その他")echo "selected=\"selected\"";?> >その他</option>
										</select></td>								</tr>
								<tr>
									<th>作成日</th>
									<td><span><?php print( $item["item_time"] ); ?> </span></td>
								</tr>
							</table>

							<input type="hidden" name="CONFIRM" value="" />
							<input type="hidden" name="item_code" value="<?php print($code); ?>" />
							<input type ="submit" value="更新" />
							</form>
							
				<?php
					}//else文
				?>
				<hr>
		</div>
	</body>
</html>


