<?php
	// 入力データの取得
	$name = $_POST['name'];
	$hours = $_POST['hours'];

	// データをファイルに保存
	$filepath = './db/answers.csv';
	if (file_exists($filepath))
		chmod($filepath, 0666);	// 全ユーザにrwの権限付与

	$fh = fopen('./myfile.csv', 'a');
	flock($fh, LOCK_EX);
	{
		$line = $name.','.$hours."\n";
		fwrite($fh, $line);
	}
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