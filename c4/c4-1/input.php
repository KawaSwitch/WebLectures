<?php
	// セッションの開始・再開
	session_start();

	// ビューデータの準備
	$view = array();

	// 既入力データの再表示の準備
	$view['name'] = '';
	if (isset($_SESSION['name'])) $view['name'] = $_SESSION['name'];
	$view['hours'] = '';
	if (isset($_SESSION['hours'])) $view['hours'] = $_SESSION['hours'];

	// セッション状態の設定
	$_SESSION['status'] = '登録前';
?>

<html>
	<head>
		<title>アルバイトデータの入力</title>
	</head>
</html>