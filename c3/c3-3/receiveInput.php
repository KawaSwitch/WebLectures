<?php
	// 1) セッションの開始
	session_start();

	// 2) セッション状態の確認
	if ($_SESSION['status'] != '登録前')
		die('Error:receiveInputの不正な呼び出しです。');

	// 3) 入力データをセッションにキャッシュ
	$_SESSION['name'] = $_POST['name'];
	$_SESSION['hours'] = $_POST['hours'];

	// 4) セッション状態の設定
	$_SESSION['status'] = "登録中";

	// 5) 確認ページの出力
?>

<html>
	<head>
		<title>入力確認画面</title>
	</head>
	<body>
		<center>
			<h2>アルバイトデータの確認</h2>

			名前 = <?= htmlspecialchars($_SESSION['name']) ?> <br>
			勤務時間 = <?= htmlspecialchars($_SESSION['hours']) ?> <br>

			<form method="POST" action="fixInput.php">
				<input type="submit" value="この内容で保存">
			</form>
			<form method="POST" action="input.php">
				<input type="submit" value="入力画面に戻る">
			</form>
		</center>
	</body>
</html>