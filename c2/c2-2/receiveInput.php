<?php
	// 入力データの取得
	$name = $_POST['name'];
	$hours = $_POST['hours'];

	// データをファイルに保存
	chmod('./myfile.csv', 0666); // 権限付与
	$fh = fopen('./myfile.csv', 'a');
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