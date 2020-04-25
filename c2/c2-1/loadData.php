<?php
	// データの再現と表示
	$fh = fopen('./myfile.csv', 'r');
	$line = fgets($fh);

	while (!empty($line))
	{
		$parttimer = explode(',', $line);
		echo '名前:'.$parttimer[0].',勤務時間:'.$parttimer[1].'<br>';
		$line = fgets($fh);
	}

	fclose($fh);
?>