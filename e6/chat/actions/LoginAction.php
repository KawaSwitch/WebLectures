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
	// ログインデータのチェック
	$username = isset($_POST['username']) ? $_POST['username'] : '';

	if ($username == '')
	{
		$view['errorMessage'] = "ユーザ名を空にすることはできません。";
		return $view;
	}

	// 他, NGワード検査, 同名の検証などが考えられるが今回は設けない
	
	$view['username'] = $_SESSION['username'] = $username;
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