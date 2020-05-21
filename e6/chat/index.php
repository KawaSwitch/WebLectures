<?php
	// アクションファイルの読み込み
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
					$nextEvent = 'showChatPage';
				}
				else
				{
					$nextEvent = 'showLoginPage';
				}
			break;

			case 'showChatPage':
				require './views/chat_client.phtml';
			break;
	
			default:
				die("イベント($event)は未定義です。");
		}

		$event = $nextEvent;
	}
?>