<?php
	// 入力データの取得
	$name = $_POST['name'];
	$hours = $_POST['hours'];

	$dsn = 'mysql:dbname=assign_web_master;host=localhost';
	$user = 'kawakami';
	$password = 'kawakami';

	try
	{
		$dbh = new PDO($dsn, $user, $password);

		// データベースへデータを登録
		$sql = "INSERT INTO parttime (name, hours)
			VALUES ('$name', $hours)";
		$res = $dbh->query($sql);

		if ($res == false)
			echo 'failed'.'<br />';
	}
	catch (PDOExeption $e)
	{
		print('Error:'.$e->getMessage());
		die();
	}

	$dbh = null;
?>

<html>
	<head>
		<title>アルバイトの入力結果</title>
	</head>
	<body>
		名前 = <?= htmlspecialchars($name) ?> <br>
		勤務時間 = <?= htmlspecialchars($hours) ?> <br>

		<form action="input.html">
			<input type="submit" value="入力画面に戻る">
		</form>
	</body>
</html>