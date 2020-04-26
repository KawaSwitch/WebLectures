<?php
	// セッションの開始
	session_start();

	if ($_SESSION['status'] != "登録前")
		die('Error: receiveInputの不正な呼び出しです。');

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
	
	// CSV形式用に改行コードと,(カンマ)を取り除く(DBなので大丈夫だがCSV出力の可能性も考慮)
	$opinion = str_replace(array("\r", "\n"), '', $opinion);
	$opinion = str_replace(',', '、', $opinion);

	// 入力データをセッションにキャッシュ
	$_SESSION['name'] = $name;
	$_SESSION['gender'] = $gender;
	$_SESSION['known'] = $known;
	$_SESSION['played'] = $played;
	$_SESSION['kind'] = $kind;
	$_SESSION['salmonid'] = $salmonid;
	$_SESSION['opinion'] = $opinion;

	// 出力用データに変換
	$name = htmlspecialchars($name);
	$gender = htmlspecialchars($gender);
	$known = htmlspecialchars($known);
	$played = htmlspecialchars($played);
	$kind = htmlspecialchars($kind);
	$salmonid = htmlspecialchars($salmonid);
	$opinion = htmlspecialchars($opinion);

	// とりあえずここ
	$kind_img_path = array(
		'イカ' => './images/inkling.png',
		'タコ' => './images/octoling.png',
	);
	$salmonid_img_path = array(
		'ザコシャケ' => './images/boss_salmonids/lesser_salmonids.png',
		'タマヒロイ' => './images/boss_salmonids/snatcher.png',
		'コウモリ' => './images/boss_salmonids/drizzler.png',
		'カタパッド' => './images/boss_salmonids/flyfish.png',
		'モグラ' => './images/boss_salmonids/maws.png',
		'テッパン' => './images/boss_salmonids/scrapper.png',
		'ヘビ' => './images/boss_salmonids/steel_eel.png',
		'バクダン' => './images/boss_salmonids/steel_head.png',
		'タワー' => './images/boss_salmonids/stinger.png',
	);


	// セッション状態の設定
	$_SESSION['status'] = '登録中';
// HTMLの出力
?>

<html>
	<head>
		<meta charset=utf-8>
		<link rel="stylesheet" type="text/css" href="base.css">
		<link rel="stylesheet" type="text/css" href="questionnaire.css">
		<title>アンケート調査の入力確認画面</title>
	</head>
	
	<body>
		<header>
			<div class='header-inner'>
				Questionnaire
			</div>
		</header>

		<div id="contents">
			<p>
				回答内容を確認してください<br>
			</p>

			名前: <?= $name ?> <br>
			性別: <?= $gender ?> <br>

			<h3>#1. あなたはスプラトゥーンを知っていますか？</h3>
			<div class="splatoon"><?= $known ?></div> <br>

			<h3>#2. スプラトゥーンをプレイしたことはありますか？</h3>
			<div class="splatoon"><?= $played ?></div> <br>

			<h3>#3. イカとタコはどちらが好みですか？</h3>
			<div class="splatoon">
				<figure>
					<img class="" src=<?= $kind_img_path[$kind] ?>>
					<figcaption><?= $kind ?></figcaption>
				</figure>
			</div>

			<h3>#4. 強いと思う（もしくは強そうな）シャケを選んでください</h3>
			<div class="splatoon select-box">
				<?php
					foreach (explode(' / ', $salmonid) as $salmonid_name)
					{
						print('<figure>'."\n");
						print('<img class="answering-container" src='.$salmonid_img_path[$salmonid_name].'>'."\n");
						print('<figcaption>'.$salmonid_name.'</figcaption>'."\n");
						print('</figure>'."\n");
					}
				?>
			</div>

			<h3>#5. スプラトゥーンに対する意見をお聞かせください</h3>
			<?= $opinion ?> <br>

			<!-- 画面遷移 -->
			<div class="clearfix">
				<div class='float-left'>
					<form method="POST" action="input.php">
						<input class="submit" type="submit" value="入力画面に戻る">
					</form>
				</div>
				<div class='float-right'>
					<form method="POST" action="fixInput.php">
						<input class="ok-submit" type="submit" value="この内容でOK！">
					</form>
				</div>
			</div>
		</div>
	</body>
</html>