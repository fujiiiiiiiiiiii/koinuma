<?php

$link = mysql_connect('localhost', 'root');
$db_selected = mysql_select_db('schedule', $link);

if(isset($_GET['year'])){
	$year = $_GET['year'];
}else{
	$year = '2017';
}

if(isset($_GET['month'])){
	$month = $_GET['month'];
}else{
	$month = '1';
}

//表示年月のデータを抽出
$result = mysql_query("SELECT * FROM record WHERE year = $year AND month = $month");

while($row = mysql_fetch_assoc($result)){
	$tmparr[] = $row;
}


//月の日数計算
$day = date('t', mktime(0, 0, 0, $month, 1, $year));
?>

<!DOCTYPE html>
<html lang="ja">
	<head>
		<meta http-equiv="Content-Type" content="text/html;charset=utf-8">
		<title>スケジュール帳</title>
	</head>
	<body>
		<h2>
			<!--選択している年月を表示-->
			<?=$year?>年 <?=$month?>月
		</h2>
		
		<!--表示用年月-->
		<form method = "post" action = "schedule_rec.php">
			<select name = "year">
				<?php
					//2017年から好きな年まで
					for($i=2017; $i<=2030; $i++){
						//選択を送信したデータのままにする
						$year == $i ? $selected = 'selected' : $selected = '';
						print("<option value = '{$i}' $selected>" . $i . "</option>");
					}
				?>
			</select>
			年
			<select name = "month">
				<?php
					//1~12月までの表示
					for($j=1; $j<=12; $j++){
						//選択を送信したデータのままにする
						$month == $j ? $selected = 'selected' : $selected = '';
						print("<option value = '{$j}' $selected>" . $j . "</option>");
					}
				?>
			</select>
			月
			<input type = "submit" name = "view" value = "表示">
		
			<br>
		
			<!--登録用日、テキストボックス-->
			<select name = "day">
				<?php
					for($k=1; $k<=$day; $k++){
						print("<option value = $k>" . $k . "</option>");
					}
				?>
			</select>
			日
			<input type = "text" name = "content">
			<input type = "submit" value = "登録">
		</form>
		
		
		<br>
		<br>
		
		<!--表示部分-->
		<table border="1">
			<tr>
				<td>
					日付
				</td>
				<td>
					内容
				</td>
			</tr>
				<?php
				
					//10より小さければ0つける
					$month = str_pad($month, 2, 0, STR_PAD_LEFT);
					
					for($k=1; $k<=$day; $k++){
					
						//10より小さければ0つける
						$k = str_pad($k, 2, 0, STR_PAD_LEFT);
						
						//変数用意
						$text = null;
						
						if(isset($tmparr)){
							foreach($tmparr as $v){
								if($k == $v['day']){
									$text .= $v['content'] . "<br>";
								}
							}
						}

						print("<tr>");
						print("<td width='50px'>" . $k . "</td>");
						print("<td width='500px'>" . $text . "</td>");
						print("</tr>");	
					}
				?>
		</table>
	</body>
</html>

<?php
//DB切断
mysql_close($link);