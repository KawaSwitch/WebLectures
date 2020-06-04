<?php

function prepareLogin($view)
{
	// 既入力データの再表示の準備
	$view['username'] = '';
	if (isset($_SESSION['username']))
		$view['username'] = $_SESSION['username'];
	
	return $view;
}

function checkLogin($view)
{
	// ユーザデータの設定（本課題ではハードコーディング...）
	$userData = array('manager'=>1111, 'guest'=>2222);
	$username = "";
	$password = "";

	$id_token = filter_input(INPUT_POST, 'id_token');
	if ($id_token)
	{
		$_SESSION['loginBy'] = 'google';
		define('CLIENT_ID', '282086877099-0tbur6mtoah3pb0co4ht3sooqkgi9612.apps.googleusercontent.com');
		
		$client = new Google_Client(['client_id' => CLIENT_ID]); 
		$client->addScope("email");
		$payload = $client->verifyIdToken($id_token);
		
		// 本課題ではGoogleログインではデータをチェックしない
		if ($payload) {
			$username = $payload['name'];
		}
	}
	else
	{
		// ログインデータのチェック
		$username = $_POST['username'];
		$password = $_POST['password'];

		if (!isset($userData[$username]))
		{
			$view['error_message'] = "ユーザ名が間違っています。";
			return $view;
		}
		if ($userData[$username] != $password)
		{
			$view['error_message'] = "パスワードが間違っています。";
			return $view;
		}
	}

	$_SESSION['username'] = $username;
	$_SESSION['isLoginned'] = true;
	return $view;
}

function logout()
{
	if (isset($_SESSION['loginBy']))
	{
		switch ($_SESSION['loginBy'])
		{
			case 'google':
				echo <<< EOM
					<script src="https://apis.google.com/js/platform.js"></script>
					<meta name="google-signin-client_id" content="282086877099-0tbur6mtoah3pb0co4ht3sooqkgi9612.apps.googleusercontent.com">
					<script src="js/signin.js"></script>
					<script type="text/javascript">
						signOut();
					</script>
				EOM;
			break;

			default:
				die("未定義のログイン情報です。");
		}
	}

	// セッション情報を削除
	$_SESSION = array();
	session_destroy();
}

function isLoginned()
{
	if(!isset($_SESSION['isLoginned']))
		return false;
	
	return $_SESSION['isLoginned'];
}

?>