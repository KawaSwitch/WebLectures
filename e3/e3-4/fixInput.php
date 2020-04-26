<?php
	// セッションの開始
	session_start();

	// セッション状態の確認
	if ($_SESSION['status'] == '登録済')
		die('Error: 「この内容で保存」ボタンを2度押さないでください。');
	elseif ($_SESSION['status'] != '登録中')
		die('Error: fixInputの不正な呼び出しです。');

	// セッションからデータを復元
	$session_keys = array('name', 'gender', 'known', 'played', 'kind', 'salmonid', 'opinion');
	$name = $_SESSION['name'];
	$gender = $_SESSION['gender'];
	$known = $_SESSION['known'];
	$played = $_SESSION['played'];
	$kind = $_SESSION['kind'];
	$salmonid = $_SESSION['salmonid'];
	$opinion = $_SESSION['opinion'];

	// DBへデータを保存
	{
		$dsn = 'mysql:dbname=assign_web_master;host=localhost';
		$user = 'kawakami';
		$password = 'kawakami';

		try
		{
			$dbh = new PDO($dsn, $user, $password);
	
			// データベースへデータを登録
			$sql = "INSERT INTO questionnaire (".implode(', ', $session_keys).")
				VALUES ('$name', '$gender', '$known', '$played', '$kind', '$salmonid', '$opinion')";
			$res = $dbh->query($sql);
	
			if ($res == false)
				echo 'INSERT failed'.'<br />';
		}
		catch (PDOExeption $e)
		{
			print('Error:'.$e->getMessage());
			die();
		}
	
		$dbh = null;
	}

	// 不要になったセッションデータの破棄
	foreach ($session_keys as $key)
		unset($_SESSION[$key]);

	// セッション状態の設定
	$_SESSION['status'] = '登録済';

// HTMLの出力
?>

<html>
	<head>
		<meta charset=utf-8>
		<link rel="stylesheet" type="text/css" href="base.css">
		<link rel="stylesheet" type="text/css" href="questionnaire.css">
		<title>アンケート調査の入力完了</title>
	</head>
	
	<body>
		<header>
			<div class='header-inner'>
				Questionnaire
			</div>
		</header>

		<div id="contents">
			<p class="attention-center splatoon">
				ごキョウリョクありがとうございました！<br>
				みんなのケッカもミてみよう！
			</p>

			<!-- 画面遷移 -->
			<div class="clearfix">
				<div class='float-left'>
					<form method="POST" action="input.php">
						<input class="submit" type="submit" value="入力画面に戻る">
					</form>
				</div>
				<div class='float-right'>
					<form method="POST" action="showAll.php">
						<input class="friend-submit" type="submit" value="みんなの結果を見る">
					</form>
				</div>
			</div>
		</div>
	</body>
</html>