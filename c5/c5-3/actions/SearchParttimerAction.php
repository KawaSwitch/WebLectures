<?php

function loadAll($view)
{
	// アルバイトデータの全件読み出し
	$filepath = './db/answers.csv';
	$view['parttimers'] = array();

	if (file_exists($filepath))
	{
		$fh = fopen($filepath, 'r');
		flock($fh, LOCK_SH);
		$line = fgets($fh);

		while (!empty($line))
		{
			$parttimer = explode(',', $line);
			array_push($view['parttimers'], $parttimer);
			$line = fgets($fh);
		}

		flock($fh, LOCK_UN);
		fclose($fh);
	}
	else
		die('Error: file not exist -> '.$filepath);
	
	return $view;
}

?>