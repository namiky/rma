# refrigerator management application
## Overview
部室／ゼミ室の冷蔵庫貯蔵アイテムの管理アプリ

## Business Requirement
1. 買い出し係が購入してきた商品を冷蔵庫に保管
2. 消費者は好きなタイミングで冷蔵庫から商品を取得し記録を残しておく
3. 冷蔵庫の商品の補充時期にて購入履歴の記録を元に、会計係が消費者から利用した金額分を徴収
4. 徴収した金銭をもとにして再度[1]に戻る

## Features
* ユーザの追加、編集、削除、購入
* 商品の追加、編集、削除、購入
* 未決済金額のグラフ化
* 決済金額計算処理
* TwitterAPI：商品の購入/追加時にTweet
* GoogleChartToolsImageAPI：商品購入履歴のグラフ化

