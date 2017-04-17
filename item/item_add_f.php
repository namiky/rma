<?php
//外部化したファイルの呼び出し
	require_once("../database.php");
	
	//初期化
		$error = '';
		$finish= '';
		
		//空欄チェック
		if($_POST["item_name"] == "")$error.="商品名称がありません。<br />";
		if($_POST["item_price"] == "")$error.="商品価格がありません。<br />";
		if($_POST["item_cost"] == "")$error.="仕入れ値がありません。<br />";
		if($_POST["item_stock"] == "")$error.="商品在庫数がありません。<br />";
		if($_POST["item_category"] == "")$error.="商品カテゴリがありません。<br />";
		if($_POST["item_detail"] == "")$error.="商品詳細がありません。<br />";
		//文字数チェック
		if(strlen($_POST['item_name']) >= 30)$error.="商品名称の文字数を30以下にしてください。<br />";
		//半角数字チェック
		//if(preg_match("(^[0-9]+$)", $_POST["item_price"]) )$error.="price:半角数字以外も含まれています。";
		
		
		//check
		if(!$error){
			//現在の時刻の取得
			date_default_timezone_set('Asia/Tokyo'); 
			$item_time=date("Y/m/d/H/i/s");

			//SQL処理
			$sql = "insert into rma_item(item_name , item_price , item_cost , item_stock , item_category , item_detail , item_time) values(";
			$sql .= "\"".$_POST['item_name']. "\" , ";
			$sql .= "\"".$_POST['item_price']. "\" , ";
			$sql .= "\"".$_POST['item_cost']. "\" , ";
			$sql .= "\"".$_POST['item_stock']. "\" , ";
			$sql .= "\"".$_POST['item_category']. "\" , ";
			$sql .= "\"".$_POST['item_detail']. "\" , ";
			$sql .= "\"".$item_time. "\" ) ";
			$res = mysql_query($sql) or die("ERROR:追加できませんでした");
			
		
		
			//************************************************
			//****************ここからTwitter*****************
			//Error:2重投稿される。おそらく2回add()関数が回っているかと思われる。
			//************************************************
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
			$tweet_message=$_POST['item_name']."(".$_POST['item_price']."円)を(". $_POST['item_stock'] ."個)追加しました。(".date('Y/m/d/H:i:s').")";
			
			
			//ここから取得したデータを展開
			//API実行データ取得
			$vRequest = $twObj->OAuthRequest("https://api.twitter.com/1/statuses/update.xml","POST",array('status' => $tweet_message));
			 
			//XMLデータをsimplexml_load_string関数を使用してオブジェクトに変換する
			$oXml = simplexml_load_string($vRequest);
			 
			//オブジェクトを展開
			if(isset($oXml->error) && $oXml->error != ''){
				$finish .= "投稿できませんでした。<br/>\n";
				$finish .= "アプリケーションの「Read Write Delete」設定を確認して下さい。<br/>\n";
				$finish .= "パラメーターの指定を確認して下さい。<br/>\n";
				$finish .= "投稿直後には同じ内容を投稿できません。<br/>\n";
				$finish .= "エラーメッセージ:".$oXml->error."<br/>\n";
			}else{
				$sCreateAt =				$oXml->created_at; //つぶやき時刻
				$iStatusId =				$oXml->id; //つぶやきステータスID
				$sText =					$oXml->text; //つぶやき
				
				$iUserId =					$oXml->user->id; //ユーザーID
				$sScreenName =				$oXml->user->screen_name; //screen_name
				
				//完了メッセージをfinishに代入
				$finish .= "商品の追加が完了しました。<br>";
				$finish .= "商品:".$_POST['item_name']."<br>"; 
				$finish .= "値段:".$_POST['item_price']."<br>"; 
				$finish .= "仕入れ値:".$_POST['item_cost']."<br>"; 
				$finish .= "数:".$_POST['item_stock']."<br>"; 
				$finish .= "カテゴリ:".$_POST['item_category']."<br>"; 
				$finish .= "詳細:".$_POST['item_detail']."<br><br>"; 
				$finish .= "Twetterでつぶやきました<br>「".$sText."」<br>";
				//echo "<p><b>日時(".$sCreateAt.") statusid(".$iStatusId.") text(".$sText.")</b>
				//<br/><a href=\"http://twitter.com/".$sScreenName."/status/".$iStatusId."\">このつぶやきのリンク</a><br/>\n".$sText."</p>\n";
			}
			
			
			
			
		}

	//リダイレクト
	 require '../result.php';
?>
