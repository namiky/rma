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
				//if($php_account["$fileName"]["$account"]==0)die("あなたのアクターでは使用権限はありません。<br />");
			?>
			<!--ここまでテンプレ -->	
			<div class="content">	
				<hr>
						<!-- AJAX API のロード -->
				    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
				    <script type="text/javascript">
				    /*	使用する外部ファイル
				     * 
				     * DB_history.php
				     * bitly.php
				     * tweet.php
				     * 
				     */
				    		var member_code = "<?php echo $_SESSION[member_code]; ?>";
								//php→js
								$.ajax({
									type:"post",
									url:"DB_history.php",
									data: {
                    member_code: member_code
                	},
 									async:false,
									cache:false,
									dataType:"text",
									success: function(data1){
										data2 = eval("(" + data1 + ")" );
									console.log(data2);
									}
								});		
								/***********************************
								**		rma_historyのデータ（詳しくはphpMyAdminで見ること）
								**		[x][0]	code
								**		[x][1]	member_code
								**		[x][2]	item_code
								**		[x][3]	item_price
								**		[x][4]	item_cost
								**		[x][5]	Time
								**		[x][6]	del_flag  
								***************************************/
								var history = data2;
								//totalAmount算出
								var totalAmount=totalCost=0;
								for(var i=0;i<history.length;i++){
									if(!parseInt(history[i][6])){
										totalAmount = totalAmount + parseInt(history[i][3]); 								
										totalCost	  = totalCost   + parseInt(history[i][4]);
									}
								}
								//利益
								var AAA = totalAmount-totalCost;
								/*利益率*/
								var BBB = AAA /totalAmount *100 ; 
								BBB = Math.round(BBB);//小数点四捨五入
								//利益の％表示
								var AAAP = Math.round((AAA/totalAmount)*100);
								var totalCostP = Math.round((totalCost/totalAmount)*100);
								/*imageChart*/
								var chs = "280x150" ;								/* ここにキャンバスの大きさ*/
								var chtt = "購入金額(" + totalAmount + "円)|利益率("+BBB+"%)";							/* タイトル */
								var chl = "利益("+AAA+"円)|原価("+totalCost+"円)|";										/* ラベルの名称 */			
								var chd = "t:"+AAAP+","+totalCostP;		/* ここにグラフの座標*/
								var cht = "p";											/* グラフの種類*/						
								//ＵＲＬの格納
								var url="http://chart.apis.google.com/chart?chs="+chs+"&chd="+chd+"&cht="+cht+"&chtt="+chtt+"&chl="+chl;
								//図の作成
								document.write("<img src=" + url +"/>");
								
								
								//ＵＲＬの短縮
								$.ajax({
									type:"post",
									url:"bilty.php",
									data: {
                    phpURL: url,
                	},
									async:false,
									cache:false,
									dataType:"text",
									success: function(url1){
										URL=url1
									}
								});

								//Tweet用にurlを短縮し ＵＲＬ に結果を返す。
								var comment = "【Graph】利益表";
								var name 		= "<?php print($_SESSION[member_name]); ?> ";	
								$.ajax({
									type:"post",
									url:"tweet.php",
									data: {
                    phpURL: URL,
                    comment:comment,
                    name:name
                	},
									async:false,
									cache:false,
									dataType:"text", 								  
 								  success: function(tweetMessage){
										alert("「"+tweetMessage+"」でTweetしました。");
									}
								});
								
					    </script>
				

					 <!-- グラフを描く div 要素 -->
					 <hr>
					<div id="gct_sample_column" style="width:100%; height:250pt" ></div>			
				<hr>
				</div>
	<?php
		}//else文
	?>
					
				
				
	</body>
</html>


