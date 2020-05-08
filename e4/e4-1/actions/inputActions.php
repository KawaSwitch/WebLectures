<?php

// inputコントローラから呼び出す
function prepareInput($view)
{
	// 各ラベルにチェックを紐づけた連想配列(uncheck)を取得
	function getCheckInitDict($labels)
	{
		$dict = array();
		foreach ($labels as $label)
			$dict += array($label => "");
		return $dict;
	}
	// セッションからラジオボタンの各項目のチェックを復元した連想配列を取得
	function getRadioCheckedDict($session_key, $labels)
	{
		$checked_dict = getCheckInitDict($labels);

		if (isset($_SESSION[$session_key]))
			$checked_dict[$_SESSION[$session_key]] = 'checked';
		else
			// 初見時は一番上にチェックを付ける
			$checked_dict[$labels[0]] = 'checked';

		return $checked_dict;
	}
	// セッションからチェックボックスの各項目のチェックを復元した連想配列を取得
	function getCheckboxCheckedDict($session_key, $labels, $delimiter='')
	{
		$checked_dict = getCheckInitDict($labels);
		if (isset($_SESSION[$session_key]))
		{
			foreach (explode($delimiter, $_SESSION[$session_key]) as $item)
				$checked_dict[$item] = 'checked';
		}
		return $checked_dict;
	}

	// 既入力データが存在するならセッションから復元する
	// 文字列の復元
	$view['name'] = (isset($_SESSION['name'])) ? $_SESSION['name'] : 'なまえ';

	if (isset($_SESSION['opinion']) && $_SESSION['opinion'] == '記述なし')
		$view['opinion'] = 'ご自由にどうぞ';
	elseif (isset($_SESSION['opinion']))
		$view['opinion'] = $_SESSION['opinion'];
	else
		$view['opinion'] = 'ご自由にどうぞ';

	// ラジオボタンの復元
	$view['gender_checked'] = getRadioCheckedDict('gender', array('男性', '女性', '無回答'));
	$view['known_checked'] = getRadioCheckedDict('known', array('はい', 'いいえ'));
	$view['played_checked'] = getRadioCheckedDict('played', array('1だけ', '2だけ', '1と2どっちも', 'ない'));
	$view['kind_checked'] = getRadioCheckedDict('kind', array('イカ', 'タコ'));

	// チェックボックスの復元
	$view['salmonid_checked'] = getCheckboxCheckedDict('salmonid', 
		array('ザコシャケ', 'タマヒロイ', 'コウモリ', 'カタパッド', 'モグラ', 'テッパン', 'ヘビ', 'バクダン', 'タワー', '選択なし'), ' / ');

	// セッション状態の設定
	$_SESSION['status'] = '登録前';

	return $view;
}

// receiveInputコントローラから呼び出す
function receiveInput($view)
{
	if ($_SESSION['status'] != "登録前")
		die('Error: receiveInputの不正な呼び出しです。');

	// 入力データの取得
	$view['name'] = $_POST['name'];		// アルバイトの名前
	$view['gender'] = $_POST['gender'];	// 性別
	$view['known'] = $_POST['known'];	// 質問1
	$view['played'] = $_POST['played'];	// 質問2
	$view['kind'] = $_POST['kind'];		// 質問3
	$view['opinion'] = $_POST['opinion'];	// 意見

	// 質問4（大物シャケ）
	$view['salmonid'] = '';
	if (isset($_POST['salmonid']) && is_array($_POST['salmonid']))
		$view['salmonid'] = implode(" / ", $_POST['salmonid']);
	else
		$view['salmonid'] = '選択なし';

	// 質問5
	if ($view['opinion'] == 'ご自由にどうぞ' || $view['opinion'] == '')
		$view['opinion'] = '記述なし';
	
	// CSV形式用に改行コードと,(カンマ)を取り除く(DBなので大丈夫だがCSV出力の可能性も考慮)
	$view['opinion'] = str_replace(array("\r", "\n"), '', $view['opinion']);
	$view['opinion'] = str_replace(',', '、', $view['opinion']);

	// 入力データをセッションにキャッシュ
	$_SESSION['name'] = $view['name'];
	$_SESSION['gender'] = $view['gender'];
	$_SESSION['known'] = $view['known'];
	$_SESSION['played'] = $view['played'];
	$_SESSION['kind'] = $view['kind'];
	$_SESSION['salmonid'] = $view['salmonid'];
	$_SESSION['opinion'] = $view['opinion'];

	// セッション状態の設定
	$_SESSION['status'] = '登録中';

	return $view;
}

// fixInputコントローラから呼び出す
function fixInput($view)
{
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

	return $view;
}

?>