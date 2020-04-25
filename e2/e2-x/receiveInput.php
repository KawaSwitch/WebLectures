<?php
	// 入力データの取得
	$name = $_POST['name'];
	$hours = $_POST['hours'];

	$filename = './db/myfile.csv';

	if (file_exists($filename))
		chmod('./db/myfile.csv', 0666); // 権限付与

	// データをファイルに保存
	$fh = fopen('./db/myfile.csv', 'a');
	flock($fh, LOCK_EX);
	$line = $name.','.$hours."\n";
	fwrite($fh, $line);
	flock($fh, LOCK_UN);
	fclose($fh);
?>

<html>
	<head>
		<title>アルバイトの入力結果</title>
	</head>
	<body>
		名前 = <?= $name ?> <br>
		勤務時間 = <?= $hours ?> <br>
	</body>
</html>