<?php
	// アクションファイルの読み込み
	require_once './actions/inputActions.php';

	// セッションの開始
	session_start();

	// ビューデータの準備
	$view = array();

	// アクションの実行
	$view = fixInput($view);

	// HTMLの出力
	require './views/savedResult.phtml';
?>
