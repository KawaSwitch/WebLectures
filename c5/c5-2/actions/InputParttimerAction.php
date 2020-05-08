<?php

function prepareInput($view)
{
	// 既入力データの再表示の準備
	$view['name'] = '';
	if (isset($_SESSION['name'])) $view['name'] = $_SESSION['name'];
	$view['hours'] = '';
	if (isset($_SESSION['hours'])) $view['hours'] = $_SESSION['hours'];

	// セッション状態の設定
	$_SESSION['status'] = '登録前';

	return $view;
}

function receiveInput($view)
{
	// 2) セッション状態の確認
	if ($_SESSION['status'] != '登録前')
		die('Error:receiveInputの不正な呼び出しです。');

	// 3) 入力データをセッションにキャッシュ
	$_SESSION['name'] = $_POST['name'];
	$_SESSION['hours'] = $_POST['hours'];

	// ビューデータの設定
	$view['name'] = $_SESSION['name'];
	$view['hours'] = $_SESSION['hours'];

	// 4) セッション状態の設定
	$_SESSION['status'] = "登録中";
	
	return $view;
}

function fixInput($view)
{
	// 2) セッション状態の確認
	if ($_SESSION['status'] == '登録済')
		die('Error:「この内容で保存」ボタンを2度押さないでください');
	elseif ($_SESSION['status'] != '登録中')
		die('Error:fixInputの不正な呼び出しです。');

	// 3) セッションからデータを復元
	$view['name'] = $_SESSION['name'];
	$view['hours'] = $_SESSION['hours'];

	// 4) データをファイルに保存
	$filepath = './db/answers.csv';
	if (file_exists($filepath))
		chmod($filepath, 0666);	// 全ユーザにrwの権限付与

	$fh = fopen($filepath, 'a');
	flock($fh, LOCK_EX);
	{
		$line = $view['name'].','.$view['hours']."\n";
		fwrite($fh, $line);
	}
	flock($fh, LOCK_UN);
	fclose($fh);

	// 6) セッション状態の設定
	$_SESSION['status'] = '登録済';
	
	return $view;
}


?>