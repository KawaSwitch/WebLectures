<?php

	// アクションファイルの読み込み
	require_once './actions/inputActions.php';
	require_once './actions/showActions.php';

	// セッションの開始
	session_start();

	// ビューデータの準備
	$view = array();

	// イベントの取得
	$event = 'showInputPage';
	if (isset($_GET['event'])) $event = $_GET['event'];

	// イベントに応じたアクションの選択・実行
	switch ($event)
	{
		case 'showInputPage':
			$view = prepareInput($view);
			require './views/input.phtml';
		break;

		case 'receiveInput':
			$view = receiveInput($view);
			require './views/confirmInput.phtml';
		break;

		case 'fixInput':
			$view = fixInput($view);
			require './views/savedResult.phtml';
		break;

		case 'showAll':
			$view = showGraphs($view);
			require './views/showAll.phtml';
		break;
	
		case 'showTable':
			$view = showTable($view);
			require './views/showTable.phtml';
		break;

		case 'download':
			download();
		break;

		default:
		die("イベント（<? $event ?>）は未定義です。");
	}

?>