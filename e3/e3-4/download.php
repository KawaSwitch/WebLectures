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

	// DBの内容を.csvへ変換
	$keys = array('id', 'name', 'gender', 'known', 'played', 'kind', 'salmonid', 'opinion');
	$text = implode(', ', $keys)."\n";
	foreach ($answers as $answer)
	{
		// DBから持ってきたとき, 添え字と名前のキーがそれぞれ入った配列が返ってくるので片方に絞っておく
		$arr = array();
		foreach ($keys as $key)
			array_push($arr, $answer[$key]);
		
		$text .= implode(', ', $arr)."\n";
	}
	
	// ダウンロードの実行
	$size = strlen($text);
	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=answers.csv");
	header("Content-length: $size");
	echo $text;
?>
