<?php
// 検索キーワードの取得
    $target_kw = $_POST['target_kw'];  //検索キーワード

//  $enc_keyword=mb_convert_encoding($target_kw,"UTF-8","auto");
    $enc_keyword = $target_kw;
//  var_dump($enc_keyword);

    $req='http://ja.dbpedia.org/data/'.$enc_keyword.'.json';

    $first = 'http://ja.dbpedia.org/resource/'.$enc_keyword;

//  var_dump($req);

    //後で戻せるように設定を取得しておく
    $org_timeout = ini_get('default_socket_timeout');
    //3秒以上かかったらタイムアウトする設定に変更
    $timeout_second = 3;
    ini_set('default_socket_timeout', $timeout_second);

    $json = file_get_contents($req, true);
	if ($json == false) {

		$resw = "DBpediaから情報を取得できませんでした．";

	}else{
		$xml=json_decode($json, true);

		if (!$xml) {
		}

		$resw = $xml[$first]['http://dbpedia.org/ontology/abstract'][0]['value'];
		$address = $xml[$first]['http://ja.dbpedia.org/property/所在地'][0]['value'];
		$image = $xml[$first]['http://dbpedia.org/ontology/thumbnail'][0]['value'];
	}

    //設定を戻す
    ini_set('default_socket_timeout', $org_timeout);
?>

<html>
	<head>
		<meta charset="utf-8">
		<title>検索結果</title>
	</head>
	<body>
		<p>DBpedia 検索結果</p>
		<p>【取得内容】</p>
		<?php
			echo $resw;
		?><br>
		<p>【住所】</p>
		<?php
			echo $address;
		?><br>
		<p>【イメージ】</p>
		<img src="<?php echo $image ?>" alt="">
		<br>
		<br><br>
		<form method="POST" action="input.html">
			<input type="submit" value="入力画面に戻る">
		</form>
	</body>
</html>
