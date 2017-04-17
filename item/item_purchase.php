<?php
//初期設定群
//sessionを始める
	session_start();
//外部化したファイルの呼び出し
	require_once("../database.php");
//Noticeメッセージを非表示にする。
	//error_reporting(E_ALL ^ E_NOTICE);
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
					// 商品が選択されると各商品に対応したitem_codeをcodeに入れ、GET方式で送信する。
					// GET送信されていない場合、つまり、codeがセットされていないときはエラーとなる。
					if(!isset($_GET["code"]) ){
						$code="0";
						die("error1:商品が選択されていないです。");
					}else{
						$code = $_GET["code"];		//アドレスに記載されているcodeをcodeに代入
					}
					//ここから商品リスト表示
					$sql = "SELECT * FROM rma_item  where item_code = $code";
					$res = mysql_query( $sql ) or die("商品が選択されていません。");
					$item = mysql_fetch_array( $res );

					?>
						<dl class="products">
							<!--ここからpurchase-->
							<?php 
								//item_stockをi_sに移し替える
								$i_s =$item["item_stock"];
							?>
							<?php
								//「アイテム」ここから
								//アイテム数が0個・1以上かをチェックし場合分けをする。
								//0以下のとき
								if("$i_s" <= 0)die("→ストック数が0以下です。購入できません。");
								//1以上のとき
								else{
									$i_s--;
									$flag = 0 ; //デリートフラグ
									if("$i_s" == 0 ){//もしアイテム数が0になったら
										print("アイテム数が0になりました。");
										$flag = 1 ;//デリートフラグを１に
									}
									$sql = "UPDATE rma_item SET item_stock = $i_s , del_flag = $flag WHERE item_code = $code ";
									$res = mysql_query( $sql ) or die("error");
								}
								//「アイテム」ここまで
								
								
								
								//「人」ここから
								//変数に代入しておく
								$i_p = $item["item_price"];
								$i_code = $item["item_cost"];
								$m_c = $_SESSION["member_code"];
								
								$sql="SELECT * FROM rma_member WHERE member_code = '$m_c' ";
								$res = mysql_query( $sql ) or die("error");
								$row = mysql_fetch_array($res)or die("error");
								
								$t_a = $row["totalAmount"];
								$t_c = $row["totalCost"];
								
								//totalAmount = totalAmount + item_price
								$t_a = $t_a + $i_p + 0;
								$t_c = $t_c + $i_code + 0;
								
								//更新
								//****************************************************************
								//******** member_codeが数字以外だと現状通らない！！**************
								//****************************************************************
								//totalAmount
								$sql = "UPDATE rma_member SET totalAmount = $t_a  WHERE member_code = '$m_c' ";
								$res = mysql_query( $sql ) or die("error");
								//totalCost
								$sql = "UPDATE rma_member SET totalCost = $t_c  WHERE member_code = '$m_c' ";
								$res = mysql_query( $sql ) or die("error");
																//「人」ここまで
								
								
								//「履歴」ここから
								history_add("$m_c","$code","$i_p","$i_code");
								//「履歴」ここまで
								
								//結果表示
								print("<hr>");
								print("購入完了<br />");
								print("現在の累計購入金額 ：". "$t_a" . "円<br />");
								
							?>
							<!--ここまでpurchase-->
						</dl>
				<?php
					//ここまで商品リスト表示
				?>
				<?php
					}
				?>
				
				
				<?php
					//************************************************
					//****************ここからTwitter*****************
					//************************************************
					//現在の時刻の取得
					date_default_timezone_set('Asia/Tokyo'); 
					############################################ 初期設定
					//twitteroauth.phpをインクルードします。ファイルへのパスは環境に合わせて記述下さい。
					require_once("../api/twitteroauth/twitteroauth.php");
					//Consumer keyの値をTwitterAPI開発者ページでご確認下さい。
					$consumerKey = "i06e6MTJChd1FvrEh7HJ5g";
					//Consumer secretの値を格納
					$consumerSecret = "QllZUaxYKBuZkIgLHOmnNBuPqXBiKG0Ee3aVLZDbYc";
					//Access Tokenの値を格納
					$accessToken = "1023958974-PGNLQvWwJ4byRTZhIK4wXBKWRXBcWs7VpC62sXF";
					//Access Token Secretの値を格納
					$accessTokenSecret = "gXnG0WiirucpJ5cAJKGKbdwmnNQA6PhhD7S1HLK444";
					//OAuthオブジェクトを生成する
					$twObj = new TwitterOAuth($consumerKey,$consumerSecret,$accessToken,$accessTokenSecret);
					//ここにtweetする内容
					$tweet_message=$_SESSION['member_name']."さんが".$item['item_name']."(".$item['item_price']."円)を購入しました。(".date('Y/m/d/H:i:s').")";
					
				?>
				
				<div>
				 
					<!-- // =========================== ここから取得したデータを展開========================= -->
					 
					<?php
						//API実行データ取得
						$vRequest = $twObj->OAuthRequest("https://api.twitter.com/1/statuses/update.xml","POST",array('status' => $tweet_message));
						 
						//XMLデータをsimplexml_load_string関数を使用してオブジェクトに変換する
						$oXml = simplexml_load_string($vRequest);
						 
						//オブジェクトを展開
						if(isset($oXml->error) && $oXml->error != ''){
							echo "投稿できませんでした。<br/>\n";
							echo "アプリケーションの「Read Write Delete」設定を確認して下さい。<br/>\n";
							echo "パラメーターの指定を確認して下さい。<br/>\n";
							echo "投稿直後には同じ内容を投稿できません。<br/>\n";
							echo "エラーメッセージ:".$oXml->error."<br/>\n";
						}else{
							$sCreateAt =				$oXml->created_at; //つぶやき時刻
							$iStatusId =				$oXml->id; //つぶやきステータスID
							$sText =					$oXml->text; //つぶやき
							
							$iUserId =					$oXml->user->id; //ユーザーID
							$sScreenName =				$oXml->user->screen_name; //screen_name
							echo "Twetterでつぶやきました<br>「".$sText."」<br>";
							//echo "<p><b>日時(".$sCreateAt.") statusid(".$iStatusId.") text(".$sText.")</b>
							//<br/><a href=\"http://twitter.com/".$sScreenName."/status/".$iStatusId."\">このつぶやきのリンク</a><br/>\n".$sText."</p>\n";
						}
					?>
					
					<!-- =========================== ここまで =========================== // -->
				</div>
				
				
				
				
					<!--/* (デバッグ用)取得したオブジェクトの内容 */
					<pre>
	 					<?php var_dump($oXml); ?>
					<\/pre>
					-->
				<!--ここまでTwitter-->
				
				
				
			<hr>
		</div>
			<!-- /ウェルカム -->
</body>
</html>

<!--history_add関数-->
<?php
	function history_add($m_c,$i_c,$i_p,$i_code){
		//history_time
		//現在の時刻の取得
		date_default_timezone_set('Asia/Tokyo'); 
		$time=date("Y/m/d/H/i/s");
		
		$sql = "INSERT
					INTO rma_history( member_code , item_code , item_price , item_cost ,history_time , del_flag )
					VALUES( '$m_c' , '$i_c' , '$i_p' , '$i_code' , '$time' , 0 )";

		$res = mysql_query($sql) or die("追加できませんでした");
		
		
		
?>
		<table border=1>
			<tr bgcolor=#cccccc>
				<th>購入者のID</th>
				<th>商品のID</th>
				<th>商品の値段</th>
				<th>購入時間</th>
			</tr>
			<tr>
				<td><?php print("$m_c"); ?></td>
				<td><?php print("$i_c"); ?></td>
				<td><?php print("$i_p"); ?></td>
				<td><?php print("$time"); ?></td>
			</tr>
		</table>
		
<?php
	}
?>
<!--;add関数-->

