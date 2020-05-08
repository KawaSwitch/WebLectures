<?php 

function checkLogin($view)
{
	// ユーザデータの設定
	$userData = array('manager'=>1111, 'guest'=>2222);

	// ログインデータのチェック
	$username = $_POST['username'];
	$password = $_POST['password'];
	$_SESSION['username'] = $username;

	if (!isset($userData[$username]))
	{
		die("ユーザ名が間違っています。");
		// $view['error_message'] = "ユーザ名が間違っています。";
		// return $view;
	}
	if ($userData[$username] != $password)
	{
		die("パスワードが間違っています。");
		// $view['error_message'] = "パスワードが間違っています。";
		// return $view;
	}
	
	$_SESSION['isLoginned'] = true;
	return $view;
}

function logout()
{
	$_SESSION = array();
}

function isLoginned()
{
	if(!isset($_SESSION['isLoginned']))
		return false;
	
	return $_SESSION['isLoginned'];
}

?>