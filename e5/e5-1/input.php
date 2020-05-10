<?php
	// アクションファイルの読み込み
	require_once './actions/inputActions.php';

	// セッションの開始/再開
	session_start();

	// ビューデータの準備
	$view = array();

	// アクションの実行
	$view = prepareInput($view);

	// 画面表示
	require './views/input.phtml'
?>
