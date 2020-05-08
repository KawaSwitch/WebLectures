<?php
	// アクションファイルの読み込み
	require_once './actions/inputActions.php';

	// セッションの開始
	session_start();

	// ビューデータの準備
	$view = array();

	// アクションの実行
	$view = receiveInput($view);

	// HTMLの出力
	require './views/confirmInput.phtml';
?>
