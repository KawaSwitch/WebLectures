<?php
	// セッションの開始/再開
	session_start();

	// 各ラベルにチェックを紐づけた連想配列(uncheck)を取得
	function getCheckInitDict($labels)
	{
		$dict = array();
		foreach ($labels as $label)
			$dict += array($label => "");
		return $dict;
	}
	// セッションからラジオボタンの各項目のチェックを復元した連想配列を取得
	function getRadioCheckedDict($session_key, $labels)
	{
		$checked_dict = getCheckInitDict($labels);

		if (isset($_SESSION[$session_key]))
			$checked_dict[$_SESSION[$session_key]] = 'checked';
		else
			// 初見時は一番上にチェックを付ける
			$checked_dict[$labels[0]] = 'checked';

		return $checked_dict;
	}
	// セッションからチェックボックスの各項目のチェックを復元した連想配列を取得
	function getCheckboxCheckedDict($session_key, $labels, $delimiter='')
	{
		$checked_dict = getCheckInitDict($labels);
		if (isset($_SESSION[$session_key]))
		{
			foreach (explode($delimiter, $_SESSION[$session_key]) as $item)
				$checked_dict[$item] = 'checked';
		}
		return $checked_dict;
	}

	// 既入力データが存在するならセッションから復元する
	// 文字列の復元
	$name = (isset($_SESSION['name'])) ? $_SESSION['name'] : 'なまえ';

	if (isset($_SESSION['opinion']) && $_SESSION['opinion'] == '記述なし')
		$opinion = 'ご自由にどうぞ';
	elseif (isset($_SESSION['opinion']))
		$opinion = $_SESSION['opinion'];
	else
		$opinion = 'ご自由にどうぞ';

	// ラジオボタンの復元
	$gender_checked = getRadioCheckedDict('gender', array('男性', '女性', '無回答'));
	$known_checked = getRadioCheckedDict('known', array('はい', 'いいえ'));
	$played_checked = getRadioCheckedDict('played', array('1だけ', '2だけ', '1と2どっちも', 'ない'));
	$kind_checked = getRadioCheckedDict('kind', array('イカ', 'タコ'));

	// チェックボックスの復元
	$salmonid_checked = getCheckboxCheckedDict('salmonid', 
		array('ザコシャケ', 'タマヒロイ', 'コウモリ', 'カタパッド', 'モグラ', 'テッパン', 'ヘビ', 'バクダン', 'タワー', '選択なし'), ' / ');


	// セッション状態の設定
	$_SESSION['status'] = '登録前';
?>

<html>
	<head>
		<meta charset=utf-8>
		<link rel="stylesheet" type="text/css" href="base.css">
		<link rel="stylesheet" type="text/css" href="questionnaire.css">
		<link href="https://use.fontawesome.com/releases/v5.6.1/css/all.css" rel="stylesheet">
		<title>アンケート調査</title>
	</head>
	<body>
		<header>
			<div class='header-inner'>
				Questionnaire
			</div>
		</header>
		
		<div id="contents">
			<h2>スプラトゥーンに関するアンケート</h2>

			<form method="POST" action="receiveInput.php">
				お名前（ニックネームも可）:<br>
				<input type="text" name="name" value="<?= htmlspecialchars($name) ?>"> <br>
				性別:
				<div class="select-gender">
					<input type="radio" name="gender" id="male" class="male" value="男性" <?= $gender_checked['男性'] ?> />
					<label for="male">
						<i class="fas fa-male male"></i> 男性
					</label>
					<input type="radio" name="gender" id="female" class="female" value="女性" <?= $gender_checked['女性'] ?> />
					<label for="female">
						<i class="fas fa-female female"></i> 女性
					</label>
					<input type="radio" name="gender" id="others" class="others" value="無回答" <?= $gender_checked['無回答'] ?> />
					<label for="others">
						無回答
					</label> <br><br>
				</div>
				
				<div class="question">
					<h3>#1. あなたはスプラトゥーンを知っていますか？</h3>
					<div class="answer radio-box">
						<input type="radio" id="yes" name="known" value="はい" <?= $known_checked['はい'] ?> />
						<label for="yes" class="answer-container">はい</label>

						<input type="radio" id="no" name="known" value="いいえ" <?= $known_checked['いいえ'] ?> />
						<label for="no" class="answer-container">いいえ</label>
					</div>
				</div>

				<div class="question">
					<h3>#2. スプラトゥーンをプレイしたことはありますか？</h3>
					<div class="answer radio-box">
						<input type="radio" id="one" name="played" value="1だけ" <?= $played_checked['1だけ'] ?> />
						<label for="one" class="answer-container">1 だけ</label>

						<input type="radio" id="two" name="played" value="2だけ" <?= $played_checked['2だけ'] ?> />
						<label for="two" class="answer-container">2 だけ</label>

						<input type="radio" id="both" name="played" value="1と2どっちも" <?= $played_checked['1と2どっちも'] ?> />
						<label for ="both" class="answer-container">1 と 2 どっちも</label>

						<input type="radio" id="never" name="played" value="ない" <?= $played_checked['ない'] ?> />
						<label for="never" class="answer-container">ないです...</label>
					</div>	
				</div>

				<div class="question clearfix">
					<h3>#3. イカとタコはどちらが好みですか？</h3>
					<div class="answer radio-box">
						<input type="radio" id="squid" name="kind" value="イカ" <?= $kind_checked['イカ'] ?> />
						<label for="squid" class="answer-container">
							<figure>
								<img class="border-radius" src='./images/inkling.png' alt='イカ(メス)'>
								<figcaption>イカ</figcaption>
							</figure>
						</label>

						<input type="radio" id="octo" name="kind" value="タコ" <?= $kind_checked['タコ'] ?> />
						<label for="octo" class="answer-container">
							<figure>
								<img class="border-radius" src='./images/octoling.png' alt='タコ(メス)'>
								<figcaption>タコ</figcaption>
							</figure>
						</label>
					</div>	
				</div>

				<div class="question clearfix">
					<h3>#4. 強いと思う（もしくは強そうな）シャケを選んでください</h3>
					<div class="answer select-box">
						<label class="answer-container">
							<input type="checkbox" name="salmonid[]" value="ザコシャケ" <?= $salmonid_checked['ザコシャケ'] ?> />
							<figure>
								<img src='./images/boss_salmonids/lesser_salmonids.png' alt='コジャケ・シャケ・ドスコイ'>
								<figcaption>ザコシャケ</figcaption>
							</figure>
						</label>
						<label class="answer-container">
							<input type="checkbox" name="salmonid[]" value="タマヒロイ" <?= $salmonid_checked['タマヒロイ'] ?> />
							<figure>
								<img src='./images/boss_salmonids/snatcher.png' alt='タマヒロイ'>
								<figcaption>タマヒロイ</figcaption>
							</figure>
						</label>
						<label class="answer-container">
							<input type="checkbox" name="salmonid[]" value="コウモリ" <?= $salmonid_checked['コウモリ'] ?> />
							<figure>
								<img src='./images/boss_salmonids/drizzler.png' alt='コウモリ'>
								<figcaption>コウモリ</figcaption>
							</figure>
						</label>
						<label class="answer-container">
							<input type="checkbox" name="salmonid[]" value="カタパッド" <?= $salmonid_checked['カタパッド'] ?> />
							<figure>
								<img src='./images/boss_salmonids/flyfish.png' alt='カタパッド'>
								<figcaption>カタパッド</figcaption>
							</figure>
						</label>
						<label class="answer-container">
							<input type="checkbox" name="salmonid[]" value="モグラ" <?= $salmonid_checked['モグラ'] ?> />
							<figure>
								<img src='./images/boss_salmonids/maws.png' alt='モグラ'>
								<figcaption>モグラ</figcaption>
							</figure>
						</label>				
						<label class="answer-container">
							<input type="checkbox" name="salmonid[]" value="テッパン" <?= $salmonid_checked['テッパン'] ?> />
							<figure>
								<img src='./images/boss_salmonids/scrapper.png' alt='テッパン'>
								<figcaption>テッパン</figcaption>
							</figure>
						</label>
						<label class="answer-container">
							<input type="checkbox" name="salmonid[]" value="ヘビ" <?= $salmonid_checked['ヘビ'] ?> />
							<figure>
								<img src='./images/boss_salmonids/steel_eel.png' alt='ヘビ'>
								<figcaption>ヘビ</figcaption>
							</figure>
						</label>
						<label class="answer-container">
							<input type="checkbox" name="salmonid[]" value="バクダン" <?= $salmonid_checked['バクダン'] ?> />
							<figure>
								<img src='./images/boss_salmonids/steel_head.png' alt='バクダン'>
								<figcaption>バクダン</figcaption>
							</figure>
						</label>
						<label class="answer-container">
							<input type="checkbox" name="salmonid[]" value="タワー" <?= $salmonid_checked['タワー'] ?> />
							<figure>
								<img src='./images/boss_salmonids/stinger.png' alt='タワー'>
								<figcaption>タワー</figcaption>
							</figure>
						</label>
					</div>	
				</div>

				<div class="question">
					<h3>#5. スプラトゥーンに対する意見をお聞かせください</h3>
					<textarea name="opinion"><?= htmlspecialchars($opinion) ?></textarea>
				</div>

				<div class="q-submit">
					<input class="submit" type="submit" value="回答">
				</div>
			</form>
		</div>

		<footer>
			
		</footer>
	</body>
</html>