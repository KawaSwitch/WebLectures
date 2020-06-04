<?php

	// アクションファイルの読み込み
	require_once './actions/inputActions.php';
	require_once './actions/showActions.php';
	require_once './actions/loginActions.php';

	// セッションの開始
	session_start();

	// ビューデータの準備
	$view = array();
	$view['error_message'] = '';

	// イベントの取得
	$event = 'showLoginPage';
	if (isset($_GET['event']))
		$event = $_GET['event'];

	// ログイン済みチェック
	if ((!isLoginned()) && $event != 'checkLogin')
		$event = 'showLoginPage';

	// イベントに応じたアクションの選択・実行
	while (!is_null($event))
	{
		$next_event = null;

		switch ($event)
		{
			case 'logout':
				logout();
				$view['error_message'] = '';
				$next_event = 'showLoginPage';
			break;

			case 'showLoginPage':
				$view = prepareLogin($view);
				require './views/login.phtml';
			break;

			case 'checkLogin':
				$view = checkLogin($view);
				if ($view['error_message'] == '')
					$next_event = 'showInputPage';
				else
					$next_event = 'showLoginPage';
			break;

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
	
			case 'upload':
				$view = upload($view);
				$view = getUploadedImages($view);
				require './views/uploaded.phtml';
			break;

			default:
				die("イベント（<? $event ?>）は未定義です。");
		}

		$event = $next_event;
	}

?>