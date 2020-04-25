<?php
	// 入力データの取得
	$name = $_POST['name'];		// アルバイトの名前
	$gender = $_POST['gender'];	// 性別
	$known = $_POST['known'];	// 質問1
	$played = $_POST['played'];	// 質問2
	$kind = $_POST['kind'];		// 質問3
	$opinion = $_POST['opinion'];	// 意見

	// 質問4（大物シャケ）
	$salmonid = '';
	if (isset($_POST['salmonid']) && is_array($_POST['salmonid']))
		$salmonid = implode(" / ", $_POST['salmonid']);
	else
		$salmonid = '選択なし';

	// 質問5
	if ($opinion == 'ご自由にどうぞ' || $opinion == '')
		$opinion = '記述なし';

	// データをファイルに保存
	$filepath = './db/answers.csv';
	if (file_exists($filepath))
		chmod($filepath, 0666);	// 全ユーザにrwの権限付与

	$fh = fopen($filepath, 'a');
	flock($fh, LOCK_EX);
	{
		$line = $name.','.
				$gender.','.
				$known.','.
				$played.','.
				$kind.','.
				$salmonid.','.
				$opinion."\n";
		fwrite($fh, $line);
	}
	flock($fh, LOCK_UN);
	fclose($fh);

	// 出力用データに変換
	$name = htmlspecialchars($name);
	$gender = htmlspecialchars($gender);
	$known = htmlspecialchars($known);
	$played = htmlspecialchars($played);
	$kind = htmlspecialchars($kind);
	$salmonid = htmlspecialchars($salmonid);
	$opinion = htmlspecialchars($opinion);

// HTMLの出力
?>

<html>
	<head>
		<meta charset=utf-8>
		<link rel="stylesheet" type="text/css" href="base.css">
		<link rel="stylesheet" type="text/css" href="questionnaire.css">
		<title>アンケート調査の入力結果</title>
	</head>
	
	<body>
		<header>
			<div class='header-inner'>
				Questionnaire
			</div>
		</header>

		<div id="contents">
			<p>
				ご協力ありがとうございました！<br>
			</p>

			名前 = <?= $name ?> <br>
			性別 = <?= $gender ?> <br>

			<h3>#1. あなたはスプラトゥーンを知っていますか？</h3>
			<?= $known ?> <br>

			<h3>#2. スプラトゥーンをプレイしたことはありますか？</h3>
			<?= $played ?> <br>

			<h3>#3. イカとタコはどちらが好みですか？</h3>
			<?= $kind ?> <br>

			<h3>#4. 強いと思う（もしくは強そうな）大物シャケを選んでください</h3>
			<?= $salmonid ?> <br>

			<h3>#5. スプラトゥーンに対する意見をお聞かせください</h3>
			<?= $opinion ?> <br>

			<!-- 画面遷移 -->
			<div class="clearfix">
				<div class='float-left'>
					<form action="input.html">
						<input class="submit" type="submit" value="入力画面に戻る">
					</form>
				</div>
				<div class='float-right'>
					<form method="POST" action="showAll.php">
						<input class="friend-submit" type="submit" value="みんなの結果を見る">
					</form>
				</div>
			</div>
		</div>
	</body>
</html>