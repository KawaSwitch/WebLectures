<?php
	// 1) セッションの開始
	session_start();

	// 2) セッションからデータを復元
	$name = $_SESSION['name'];
	$hours = $_SESSION['hours'];

	// データをファイルに保存
	$filepath = './db/answers.csv';
	if (file_exists($filepath))
		chmod($filepath, 0666);	// 全ユーザにrwの権限付与

	$fh = fopen($filepath, 'a');
	flock($fh, LOCK_EX);
	{
		$line = $name.','.$hours."\n";
		fwrite($fh, $line);
	}
	flock($fh, LOCK_UN);
	fclose($fh);

	// 不要になったセッションデータの廃棄
	unset($_SESSION['name']);
	unset($_SESSION['hours']);
?>

<html>
	<head>
		<title>アルバイトの入力結果</title>
	</head>
	<body>
		名前 = <?= htmlspecialchars($name) ?> <br>
		勤務時間 = <?= htmlspecialchars($hours) ?> <br>

		<form method="POST" action="input.php">
			<input type="submit" value="入力画面に戻る">
		</form>
	</body>
</html>