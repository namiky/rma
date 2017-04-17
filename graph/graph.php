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

						</div>
						    <!-- AJAX API のロード -->
				    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
				    <script type="text/javascript">

								//php→js
								$.ajax({
									type:"post",
									url:"data_member.php",
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
								var member = data2;
								

								
								// Visualization API と折れ線グラフ用のパッケージのロード
								google.load("visualization", "1", {packages:["corechart"]});
					      // Google Visualization API ロード時のコールバック関数の設定
					      google.setOnLoadCallback(
						      // グラフ作成用のコールバック関数
						      function() {
						        // データテーブルの作成
										var data = google.visualization.arrayToDataTable([
										    [       '', '金額'],
										    ['NAME',  0  ],
										]);
										
										
										
										for( var j=0 ; j<member.length ; j++){
											//数字が文字列として認識されているので、整数に変換
											member[j][4] = parseInt(data2[j][4]);
											//GoogleAPIに追加
											data.addRow([member[j][2],member[j][4] ]);
										}
						        // グラフのオプションを設定
						        var options = {
						            title: '未支払金額',
						            vAxis: {title: 'アカウント'}
						        };
						        // LineChart のオブジェクトの作成
						        var chart = new google.visualization.BarChart(document.getElementById('gct_sample_column'));        // データテーブルとオプションを渡して、グラフを描画
						        chart.draw(data, options);
						      }
								);
								
					    </script>
				<div class="content">	

					 <!-- グラフを描く div 要素 -->
					 <hr>
					<div id="gct_sample_column" style="width:100%; height:250pt" ></div>				

							
	<?php
		}//else文
	?>
					<hr>
				</div>
	</body>
</html>


