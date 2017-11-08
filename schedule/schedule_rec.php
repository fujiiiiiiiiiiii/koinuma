<?php

$link = mysql_connect('localhost', 'root');
$db_selected = mysql_select_db('schedule', $link);
print($link);

$year = $_POST['year'];
$month = $_POST['month'];
$day = $_POST['day'];

//テキストエリアに入力がなければ書き込みせずに終わり
if($_POST['content'] === '' || $_POST['view'] === '表示'){
	header("Location: schedule.php?year=$year&month=$month");
}else{
	$contents = htmlspecialchars($_POST['content']);
	$sql = "INSERT INTO record (year, month, day, content) VALUES ('$year', '$month', '$day', '$contents')";
	$result_flag = mysql_query($sql);
	if (!$result_flag) {
		die('INSERTクエリーが失敗しました。'.mysql_error());
	}
}

//DB切断
mysql_close($link);
header("Location: schedule.php?year=$year&month=$month");