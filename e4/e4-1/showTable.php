<?php
	// アクションファイルの読み込み
	require_once './actions/showActions.php';

	// アクションの実行
	$view = array();
	$view = showTable($view);

	// 画面表示
	require './views/showTable.phtml';
?>
