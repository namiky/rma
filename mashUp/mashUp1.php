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
				return confirm("実行しますか？");
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
				//if($php_account["$fileName"]["$account"]==0)die("あなたのアクターでは使用権限はありません。<br />");
			?>
			<!--ここまでテンプレ -->	
		
			<div class="content">	
				<hr>
			 <!-- AJAX API のロード -->
				    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
				    <script type="text/javascript">
				    	/* 使用する外部ファイル
				    	 * 
				    	 * DB_member.php
				    	 * bitly.php
				    	 * tweet.php
				    	 * 
				    	 */
								//MemberのデータをDBから取得する
								//DB→php→js
								$.ajax({
									type:"post",
									url:"DB_member.php",
									async:false,
									cache:false,
									dataType:"text",
									success: function(data1){
										data2 = eval("(" + data1 + ")" );
									console.log(data2);
									}
								});		
								/***********************************
								**		rma_memberのデータ（詳しくはphpMyAdminで見ること）
								**		[x][0]	code
								**		[x][1]	pass
								**		[x][2]	name
								**		[x][3]	del_flag
								**		[x][4]	totalAmount(まだ文字列なのであとで整数化すること)
								***************************************/
								//値の初期化・初期値
								var member = data2;
								var chs = "280x" ;					/* ここにキャンバスの大きさ*/
								var yLength = parseInt(10)+ parseInt(31)*parseInt(member.length);	/*縦の長さを取得*/ 
								chs = chs + yLength;				/* ここにキャンバスの大きさ*/
								var chd = "t:";	/* ここにグラフの座標*/
								var cht = "bhg";							/* グラフの種類*/
								var chxt = "x,y";						/* 軸ラベルの表示位置*/
								var chxl = "1:|";/*縦軸に名前を表示させる：個数分aキチンとおくこおと*/
								//ＤＢの情報を加える(左箇所)
								for( var j=0 ; j<member.length ; j++){
									chxl = chxl + member[j][2] +"("+member[j][4]+ "円)|";
								}
								//数字の調整
								//数字が文字列として認識されているので、整数に変換
								//imageChartでは１００以下しか読み込んでくれないので(/10)(/100)(/1000)を行う
								for( var j=0 ; j<member.length ; j++){
									if( member[j][4] < 100 ) {
										member[j][4] = parseInt(data2[j][4]) ;
									}
									else if( member[j][4] < 1000 ){
										member[j][4] = parseInt(data2[j][4]) / 10;
									}
									else if(member[j][4] < 10000 ){
										member[j][4] = parseInt(data2[j][4]) / 100;
									}
									else{
										member[j][4] = parseInt(data2[j][4]) / 1000;
									}						
								}		
								////図がbhgのとき逆順
								for( var j = member.length-1 ; j>=0; j--){
									chd = chd + member[j][4] + ",";
								}
								//最後のコンマを削除
								chd  = chd.slice(0, -1);
								//ＵＲＬの格納
								var url="http://chart.apis.google.com/chart?chs="+chs+"&chd="+chd+"&cht="+cht+"&chxt="+chxt+"&chxl="+chxl;
								//図の作成
								document.write("<img src=" + url +"/>");
								
								
								//ＵＲＬの短縮
								$.ajax({
									type:"post",
									url:"bilty.php",
									data: {
                    phpURL: url
                	},
									async:false,
									cache:false,
									dataType:"text",
									success: function(url1){
										URL=url1
									}
								});
								//Tweet用にurlを短縮し ＵＲＬ に結果を返す。
								var comment = "【Graph】未支払金額一覧";
								$.ajax({
									type:"post",
									url:"tweet.php",
									data: {
                    phpURL	: URL,
                    comment	:	comment
                	},
									async:false,
									cache:false,
									dataType:"text", 								  
 								  success: function(tweetMessage){
										alert("「"+tweetMessage+"」でTweetしました。");
									}
								});
							
							
						</script>
	
	

	<?php
		}//else文
	?>
				<hr>

	</div>
	</body>
	
</html>
