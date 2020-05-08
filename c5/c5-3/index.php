<?php
	// アクションファイルの読み込み
	require_once './actions/InputParttimerAction.php';
	require_once './actions/SearchParttimerAction.php';
	require_once './actions/LoginAction.php';

	// セッションの開始
	session_start();

	// ビューデータの準備
	$view = array();
	$view['errorMessage'] = '';

	// イベントの取得
	$event = 'showLoginPage';
	if (isset($_GET['event'])) $event = $_GET['event'];

	// ログイン済みチェック
	if ((!isLoginned()) && ($event != 'checkLogin'))
		$event = 'showLoginPage';

	// イベントに応じたアクションの選択・実行
	while (!is_null($event))
	{
		$nextEvent = null;

		switch ($event)
		{
			case 'logout':
				logout();
				$view['errorMessage'] = '';
				$nextEvent = 'showLoginPage';
			break;

			case 'showLoginPage':
				$view = prepareLogin($view);
				require './views/login.phtml';
			break;
	
			case 'checkLogin':
				$view = checkLogin($view);
				if ($view['errorMessage'] == '')
				{
					$nextEvent = 'showInputPage';
				}
				else
				{
					$nextEvent = 'showLoginPage';
				}
			break;

			case 'showInputPage':
				$view = prepareInput($view);
				require './views/input.phtml';
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
				$view = loadAll($view);
				require './views/showAll.phtml';
			break;
	
			default:
				die("イベント($event)は未定義です。");
		}

		$event = $nextEvent;
	}
?>