<?php
	// アルバイトデータの全件読み出し
	$filepath = './db/answers.csv';
	$parttimers = array();

	if (file_exists($filepath))
	{
		$fh = fopen($filepath, 'r');
		flock($fh, LOCK_SH);
		$line = fgets($fh);

		while (!empty($line))
		{
			$parttimer = explode(',', $line);
			array_push($parttimers, $parttimer);
			$line = fgets($fh);
		}

		flock($fh, LOCK_UN);
		fclose($fh);
	}
	else
		die('Error: file not exist -> '.$filepath);
?>

<html>
	<head>
		<title>アルバイト一覧</title>
	</head>
	<body>
		<?php 
			foreach ($parttimers as $parttimer)
			{?>
				名前 = <?= htmlspecialchars($parttimer[0]); ?>,
				勤務時間 = <?= htmlspecialchars($parttimer[1]); ?><br>
			<?php
			}
		?>
		<form method="POST" action="input.php">
			<input type="submit" value="入力画面に戻る">
		</form>
	</body>
</html>