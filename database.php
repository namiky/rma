<?php
	// データベースに接続する処理。
	// 環境に応じて以下の変数を書き換えます。
	$host = "localhost";	// 接続先ホスト名
	$user = "root";			// 接続ユーザ名
	$pass = "password";		// 接続パスワード
	$dbname = "rma";			// データベース名
	if( !$conn = mysql_connect( $host, $user, $pass ) )
	{
		die("MySQL 接続エラー");
	}
	mysql_select_db( $dbname );
	mysql_set_charset("utf8");		// 文字コードを指定します。
?>
