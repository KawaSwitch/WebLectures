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
	// ユーザデータの設定
	$userData = array('manager'=>1111, 'guest'=>2222);

	// ログインデータのチェック
	$username = $_POST['username'];
	$password = $_POST['password'];
	$_SESSION['username'] = $username;

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