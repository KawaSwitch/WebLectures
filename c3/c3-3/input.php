<?php
	// 1) セッションの開始・再開
	session_start();

	// 2) 既入力データの再表示の準備
	$name = "";
	if (isset($_SESSION['name'])) $name = $_SESSION['name'];
	$hours = "";
	if (isset($_SESSION['hours'])) $hours = $_SESSION['hours'];

	// 3) セッション状態の設定
	$_SESSION['status'] = '登録前';

	// 4) 入力ページの出力
?>

<html>
	<head>
		<meta charset='utf-8'>
		<title>アルバイトデータの入力</title>
	</head>
	<body>
		<center>
			<h1>アルバイトデータの入力</h1>
			<form method="POST" action="receiveInput.php">
				名前:<input type="text" name="name"
					value="<?= htmlspecialchars($name) ?>"><br>
				勤務時間:<input type="text" name="hours"
					value="<?= htmlspecialchars($hours)?>"><br><br>
				<input type="submit" value="入力">
			</form>
			<form method="POST" action="showAll.php">
				<input type="submit" value="一覧表示">
			</form>
		</center>
	</body>
</html>