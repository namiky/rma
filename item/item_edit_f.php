<?php
	//外部化したファイルの呼び出し
	require_once("../database.php");
		//初期化
		$error = '';
		$finish='';

		//空欄チェック
		if($_POST["item_name"] == "")$error.=("商品nameのテキストエラー<br />");
		if($_POST["item_price"] == "")$error.=("商品価格のテキストエラー");
		if($_POST["item_price"] == "")$error.=("仕入れ値のテキストエラー");
		if($_POST["item_stock"] == "")$error.=("商品stockのテキストエラー");
		if($_POST["item_category"] == "")$error.=("商品categoryのテキストエラー");
		if($_POST["item_detail"] == "")$error.=("商品detailのテキストエラー");
		
		//文字数チェック
		if(strlen($_POST['item_name']) >= 30)$error.=("商品nameの文字数を30以下にしてください。<br />");
		

		//error
		if(!$error){			//現在の時刻の取得
			date_default_timezone_set('Asia/Tokyo'); 
			$item_time=date("Y/m/d/H/i/s");
			
			//各値を代入
			$item_code=$_POST["item_code"];
			$item_name=$_POST["item_name"];
			$item_price=$_POST["item_price"];
			$item_cost=$_POST["item_cost"];
			$item_stock=$_POST["item_stock"];
			$item_category=$_POST["item_category"];
			$item_detail=$_POST["item_detail"];
			
			
			//SQL処理
			$sql ="UPDATE rma_item 
				SET item_name='$item_name' ,
					item_stock='$item_stock' ,
					item_price='$item_price' ,
					item_cost='$item_cost' ,
					item_detail='$item_detail' ,
					item_category='$item_category' ,
					item_time='$item_time' 
				WHERE item_code=$item_code ";
			$res = mysql_query($sql) or die("更新できませんでした");
			
			//完了フラグ
			$finish .= "変更が完了しました。";
			
		}
		
	//リダイレクト
	 require '../result.php';
	
?>
<!--;edit関数-->