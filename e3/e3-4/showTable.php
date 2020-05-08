<?php
	// DBからアンケート結果の読み出し
	$answers = array();
	{
		$dsn = 'mysql:dbname=assign_web_master;host=localhost';
		$user = 'kawakami';
		$password = 'kawakami';

		try
		{
			$dbh = new PDO($dsn, $user, $password);
	
			// データベースからアルバイトデータの全件読み出し
			$sql = 'select * from questionnaire';
			foreach ($dbh->query($sql) as $row)
				array_push($answers, $row);
		}
		catch (PDOExeption $e)
		{
			print('Error:'.$e->getMessage());
			die();
		}
	
		$dbh = null;
	}
?>

<html>
	<head>
		<meta charset='utf-8'>
		<link rel="stylesheet" type="text/css" href="base.css">
		<link rel="stylesheet" type="text/css" href="questionnaire.css">
		<title>みんなのアンケート調査の投票内容</title>
	</head>
	
	<body>

		<header>
			<div class='header-inner'>
				Questionnaire
			</div>
		</header>

		<div id="contents">
			<h3>みんなの回答内容</h3>

			<!-- 表形式の表示 -->
			<div id="gender_chart" class="pie-chart"></div>
			<div id="known_chart" class="pie-chart"></div>
			<div id="played_chart" class="pie-chart"></div>
			<div id="kind_chart" class="pie-chart"></div>
			<div id="salmonid_chart" class="bar-chart"></div>

			<!-- 画面遷移 -->
			<div class="clearfix">
				<div class='float-left'>
					<form method="POST" action="input.php">
						<input class="submit" type="submit" value="入力画面に戻る">
					</form>
				</div>
				<div class='float-right'>
					<form method="POST" action="download.php">
						<input class="friend-submit" type="submit" value="CSV形式でダウンロード">
					</form>
				</div>
			</div>
		</div>
	</body>
</html>