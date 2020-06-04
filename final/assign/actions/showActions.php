<?php

// showAllコントローラから呼び出す
function showGraphs($view)
{
	// DBからアンケート結果の読み出し
	$view['answers'] = array();
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
				array_push($view['answers'], $row);
		}
		catch (PDOExeption $e)
		{
			print('Error:'.$e->getMessage());
			die();
		}
	
		$dbh = null;
	}

	// データのラベル配列から数値が初期化された連想配列を取得する
	function getInitDataDict($labels)
	{
		$datas = array();
		foreach ($labels as $label)
			$datas[$label] = 0;
		return $datas;
	}

	// データの連想配列からパーセントグラフ表示用の連想配列を作成し戻す
	function convertToPercentageDataPointsDict($datas)
	{
		$graph_datas = array();
		$sum = 0;
		foreach ($datas as $data_key => $data_value)
			$sum += $data_value;

		foreach ($datas as $data_key => $data_value)
			array_push($graph_datas, array('label'=>$data_key, 'y'=>((double)$data_value / $sum) * 100));
		return $graph_datas;
	}

	// データの連想配列からカウントグラフ(棒グラフとか)表示用の連想配列を作成し戻す
	function convertToCountDataPointsDict($datas)
	{
		$graph_datas = array();
		foreach ($datas as $data_key => $data_value)
			array_push($graph_datas, array('label'=>$data_key, 'y'=>$data_value));
		return $graph_datas;
	}

	$show_datas = array(
		'gender' => getInitDataDict(array('男性', '女性', '無回答')),
		'known' => getInitDataDict(array('はい', 'いいえ')),
		'played' => getInitDataDict(array('1だけ', '2だけ', '1と2どっちも', 'ない')),
		'kind' => getInitDataDict(array('イカ', 'タコ')),
		'salmonid' => getInitDataDict(array('ザコシャケ', 'タマヒロイ', 'コウモリ', 'カタパッド', 'モグラ', 'テッパン', 'ヘビ', 'バクダン', 'タワー', '選択なし')),
	);

	// グラフ表示用のデータ生成
	foreach ($view['answers'] as $answer)
	{
		// 円グラフ
		$show_datas['gender'][$answer['gender']]++;
		$show_datas['known'][$answer['known']]++;
		$show_datas['played'][$answer['played']]++;
		$show_datas['kind'][$answer['kind']]++;

		// 棒グラフ
		foreach (explode(' / ', $answer['salmonid']) as $boss_name)
			$show_datas['salmonid'][$boss_name]++;
	}

	// canvasJS用のデータへ変換
	$view['data_points_list'] = array();
	foreach ($show_datas as $show_data_key => $show_data_value)
	{
		if ($show_data_key == 'salmonid')
			array_push($view['data_points_list'], convertToCountDataPointsDict($show_data_value));
		else
			array_push($view['data_points_list'], convertToPercentageDataPointsDict($show_data_value));
	}

	return $view;
}

// showTableコントローラから呼び出す
function showTable($view)
{
	// TODO: 現在は未実装

	// DBからアンケート結果の読み出し
	$view['answers'] = array();
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
				array_push($view['answers'], $row);
		}
		catch (PDOExeption $e)
		{
			print('Error:'.$e->getMessage());
			die();
		}
	
		$dbh = null;
	}

	return $view;
}

function download()
{
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
}

function upload($view)
{
	$view['upload_message'] = "";
	$uploads_dir = './images/top_images';

	foreach ($_FILES["capture"]["error"] as $key => $error)
	{
		if ($error == UPLOAD_ERR_OK) 
		{
			$tmp_name = $_FILES["capture"]["tmp_name"][$key];

			// ディレクトリトラバーサル攻撃への対処
			$name = basename($_FILES["capture"]["name"][$key]);

			$name = str_replace(' ', '_', $name);
			move_uploaded_file($tmp_name, "$uploads_dir/$name");
			$view['upload_message'] .= $name." 成功\\n";
		}
		else
		{
			$view['upload_message'] .= "失敗\\n";
		}
	}

	return $view;
}

function getUploadedImages($view)
{
	if (!isset($view['shared_images']))
		$view['shared_images'] = array();

	foreach (glob('./images/top_images/{*.jpg,*.png}', GLOB_BRACE) as $file)
	{
		if (is_file($file))
		{
			$view['shared_images'][] = str_replace(' ', '_', basename($file));
		}
	}

	return $view;
}

?>