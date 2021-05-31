<?php
var_dump($_POST);
// exit();

$date = date("Y-m-d H:i:s");// データ受け取り
$height = $_POST["height"];
$weight = $_POST["weight"];
// $bmi = floor( $_POST["weight"] / (($_POST["height"] * $_POST["height"])/10000));  //floor小数点以下を切り捨てて整数の数字を返す
// 身長からBMIの計算により、適正な標準体重の最大と最小を求める
$tekisei_max = floor( 25 * (($_POST["height"] * $_POST["height"])/10000)); //floor小数点以下を切り捨てて整数の数字を返す
$tekisei_min = ceil( 18.5 * (($_POST["height"] * $_POST["height"])/10000)); //ceil小数点以下を切り上げて整数の数字を返す


$write_data = "{$date},{$height},{$weight},{$tekisei_max},{$tekisei_min}\n";  // 変数をカンマ区切りで、最後に改行\n csvの形にする

$file = fopen('data/test.csv', 'a');  // ファイルを開く 引数はa(追加書き込み􏰁みで開く→ファイルがなければ作成)
flock($file, LOCK_EX);  // ファイルをロック
fwrite($file, $write_data);  // データに書き込み
flock($file, LOCK_UN);  // ロック解除
fclose($file);  // ファイルを閉じる

header("Location:floating.php");  // 入力画面に移動


?>
