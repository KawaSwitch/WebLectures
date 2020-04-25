<?php
	// アルバイトデータの全件読み出し
	$parttimers = array();

	$filename = './db/myfile.csv';
	if (file_exists($filename))
	{
		$fh = fopen($filename, 'r');
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
		<form action="input.html">
			<input type="submit" value="入力画面に戻る">
		</form>
	</body>
</html>