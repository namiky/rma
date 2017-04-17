
<?php
//************************************************************************************
//**	「連想配列の作成」															**
//**	"アカウント"が"PHP"をするためのアクセス権限を"$php_account"に格納する。		**
//**																				**
//**	配列名：$php_account														**
//**	第1引数：.PHP																**
//**	第2引数：アカウント															**
//**	格納データ：1 or 0															**
//**	→1:使用可																	**
//**	→0:使用不可																**
//************************************************************************************
$php_account = array(
	//その他
	"index" => array(
				"user" => "1",
				"management" => "1" ,
				"purchase" => "1" ,
				"admin" => "1"
				) ,
	//アイテム
	"item_add" => array(
				"user" => "0",
				"management" => "0" ,
				"purchase" => "1" ,
				"admin" => "0"
				) ,
	"item_detail" => array(
				"user" => "1",
				"management" => "1" ,
				"purchase" => "1" ,
				"admin" => "0"
				) ,
	"item_edit" => array(
				"user" => "0",
				"management" => "0" ,
				"purchase" => "1" ,
				"admin" => "0"
				) ,
	"item_list" => array(
				"user" => "1",
				"management" => "1" ,
				"purchase" => "1" ,
				"admin" => "0"
				) ,
	"item_delete" => array(
				"user" => "0",
				"management" => "0" ,
				"purchase" => "1" ,
				"admin" => "0"
				) ,
	"item_remove" => array(
				"user" => "0",
				"management" => "0" ,
				"purchase" => "1" ,
				"admin" => "0"
				) ,
	"item_purchase" => array(
				"user" => "1",
				"management" => "0" ,
				"purchase" => "0" ,
				"admin" => "0"
				) ,
	//人間
	"member_add" => array(
				"user" => "0",
				"management" => "0" ,
				"purchase" => "0" ,
				"admin" => "1"
				) ,
	"member_detail" => array(
				"user" => "1",
				"management" => "0" ,
				"purchase" => "0" ,
				"admin" => "1"
				) ,
	"member_edit" => array(
				"user" => "1",
				"management" => "1" ,
				"purchase" => "1" ,
				"admin" => "1"
				) ,
	"member_list" => array(
				"user" => "0",
				"management" => "1" ,
				"purchase" => "0" ,
				"admin" => "1"
				) ,
	"member_delete" => array(
				"user" => "0",
				"management" => "0" ,
				"purchase" => "0" ,
				"admin" => "1"
				) ,
	"member_remove" => array(
				"user" => "0",
				"management" => "0" ,
				"purchase" => "0" ,
				"admin" => "1"
				) ,
	"member_settlement" => array(
				"user" => "0",
				"management" => "1" ,
				"purchase" => "0" ,
				"admin" => "0"
				) ,
	"member_bill" => array(
				"user" => "0",
				"management" => "1" ,
				"purchase" => "0" ,
				"admin" => "0"
				) ,
	//履歴
	"history_detail" => array(
				"user" => "1",
				"management" => "1" ,
				"purchase" => "0" ,
				"admin" => "0"
				) ,
	"history_list" => array(
				"user" => "1",
				"management" => "1" ,
				"purchase" => "0" ,
				"admin" => "0"
				) ,
	"history_delete" => array(
				"user" => "0",
				"management" => "1" ,
				"purchase" => "0" ,
				"admin" => "0"
				) ,
	"history_remove" => array(
				"user" => "1",
				"management" => "1" ,
				"purchase" => "0" ,
				"admin" => "0"
				) 
	);
	
	//アカウントの種類分け	$accountにアクターに対応した値を入れる。
	$account="user";
	if($_SESSION["member_code"] == "management")$account="management";
	if($_SESSION["member_code"] == "purchase")$account="purchase";
	if($_SESSION["member_code"] == "admin")$account="admin";
	
	
	
	//**************************************************************
	//****														****
	//****	リンク作成												****
	//****	$accountによって表示する内容を変動させる						****
	//****														****
	//**************************************************************	
	?>
		<?php	
	print("<div class=\"content\">");
	if($account=="management"){?>
		<h1><a class="psLeft" href="#nav">Menu</a>会計用ページ</h1>
			<ul id="nav">
    			<li><a href="/rma/">TOP</a></li>
			    <li><a href="/rma/member/member_list.php">アカウントリスト</a></li>
			    <li><a href="/rma/history/history_list.php">履歴</a></li>
			<?php
	}else if($account=="purchase"){?>
		<h1><a class="psLeft" href="#nav">Menu</a>買い出し用ページ</h1>
			<ul id="nav">
    			<li><a href="/rma/">TOP</a></li>
			    <li><a href="/rma/item/item_add.php">商品追加</a></li> 
			    <li><a href="/rma/item/item_list.php">商品リスト</a></li>
			 <?php
	}else if($account=="admin"){?>
		<h1><a class="psLeft" href="#nav">Menu</a>Admin用ページ</h1>
			<ul id="nav">
    			<li><a href="/rma/">TOP</a></li>
			    <li><a href="/rma/member/member_add.php">アカウント作成</a></li>
			    <li><a href="/rma/member/member_list.php">アカウントリスト</a></li>
			<?php
	}	else{?>
		<h1><a class="psLeft" href="#nav">Menu</a><?php print($_SESSION["member_name"]."のページ"); ?></h1>
			<ul id="nav">
    			<li><a href="/rma/">TOP</a></li>
			    <li><a href="/rma/item/item_list.php">商品リスト</a></li>
			    <li><a href="/rma/history/history_list.php">履歴</a></li>
			<?php
	}
	?>
		<!--共通部分 -->
					<li><a href="/rma/mashUp/main.php">グラフ/Tweet</a></li>
			    <li><a href="/rma/member/member_edit.php">情報/設定</a></li>
			</ul>
		</div>
	
	<?php
	
	
	
	/*
	//ファイルの名前の取得→「.php」の文字列削除
	//①
	//！！問題点
	//ファイル名がstart.phpになってしまう
	$fileName = basename(__FILE__);
	$fileName = str_replace(".php","",$fileName);
	print("$fileName<br />");
	//②
	//呼び出し元の方のファイル名を取得する
	$rensou = debug_backtrace();
	echo $rensou[0]["file"];
	
	*/
?>