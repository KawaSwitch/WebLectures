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
	$name = (isset($_SESSION['name'])) ? $_SESSION['name'] : "なまえ";
	$opinion = (isset($_SESSION['opinion'])) ? $_SESSION['opinion'] : "";

	// ラジオボタンの復元
	$gender_checked = getRadioCheckedDict('gender', array('男性', '女性', '無回答'));
	$known_checked = getRadioCheckedDict('known', array('はい', 'いいえ'));
	$played_checked = getRadioCheckedDict('played', array('1だけ', '2だけ', '1と2どっちも', 'ない'));
	$kind_checked = getRadioCheckedDict('kind', array('イカ', 'タコ'));

	// チェックボックスの復元
	$salmonid_checked = getCheckboxCheckedDict('salmonid', array('コウモリ', 'カタパッド', 'モグラ', 'テッパン', 'ヘビ', 'バクダン', 'タワー', '選択なし'), ' / ');

	
	// セッション状態の設定
	$_SESSION['status'] = '登録前';
?>

<html>
	<head>
		<meta charset=utf-8>
		<link rel="stylesheet" type="text/css" href="base.css">
		<link rel="stylesheet" type="text/css" href="questionnaire.css">
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
				<div>
					<label><input type="radio" name="gender" value="男性" <?= $gender_checked['男性'] ?> />男性</label>
					<label><input type="radio" name="gender" value="女性" <?= $gender_checked['女性'] ?> />女性</label>
					<label><input type="radio" name="gender" value="無回答" <?= $gender_checked['無回答'] ?> />無回答</label> <br><br>
				</div>
				
				<div class="question">
					<h3>#1. あなたはスプラトゥーンを知っていますか？</h3>
					<div class="answer">
						<label><input type="radio" name="known" value="はい" <?= $known_checked['はい'] ?> />はい</label>
						<label><input type="radio" name="known" value="いいえ" <?= $known_checked['いいえ'] ?> />いいえ</label>
					</div>
				</div>

				<div class="question">
					<h3>#2. スプラトゥーンをプレイしたことはありますか？</h3>
					<div class="answer">
						<label><input type="radio" name="played" value="1だけ" <?= $played_checked['1だけ'] ?> />1 だけ</label>
						<label><input type="radio" name="played" value="2だけ" <?= $played_checked['2だけ'] ?> />2 だけ</label>
						<label><input type="radio" name="played" value="1と2どっちも" <?= $played_checked['1と2どっちも'] ?> />1 と 2 どっちも</label>
						<label><input type="radio" name="played" value="ない" <?= $played_checked['ない'] ?> />ないです...</label>
					</div>	
				</div>

				<div class="question clearfix">
					<h3>#3. イカとタコはどちらが好みですか？</h3>
					<div class="answer">
						<label class="answer-container">
							<input type="radio" name="kind" value="イカ" <?= $kind_checked['イカ'] ?> />
							<figure class='image-box'>
								<img src='./images/ika.jpg' alt='イカ(メス)'>
								<figcaption>イカ</figcaption>
							</figure>
						</label>

						<label class="answer-container">
							<input type="radio" name="kind" value="タコ" <?= $kind_checked['タコ'] ?> />
							<figure class='image-box'>
								<img src='./images/tako.jpg' alt='タコ(メス)'>
								<figcaption>タコ</figcaption>
							</figure>
						</label>
					</div>	
				</div>

				<div class="question clearfix">
					<h3>#4. 強いと思う（もしくは強そうな）大物シャケを選んでください</h3>
					<div class="answer">
						<label class="answer-container">
							<input type="checkbox" name="salmonid[]" value="コウモリ" <?= $salmonid_checked['コウモリ'] ?> />
							<figure class='image-box'>
								<img src='./images/boss_salmonids/drizzler.png' alt='コウモリ'>
								<figcaption>コウモリ</figcaption>
							</figure>
						</label>
						<label class="answer-container">
							<input type="checkbox" name="salmonid[]" value="カタパッド" <?= $salmonid_checked['カタパッド'] ?> />
							<figure class='image-box'>
								<img src='./images/boss_salmonids/flyfish.png' alt='カタパッド'>
								<figcaption>カタパッド</figcaption>
							</figure>
						</label>
						<label class="answer-container">
							<input type="checkbox" name="salmonid[]" value="モグラ" <?= $salmonid_checked['モグラ'] ?> />
							<figure class='image-box'>
								<img src='./images/boss_salmonids/maws.png' alt='モグラ'>
								<figcaption>モグラ</figcaption>
							</figure>
						</label>				
						<label class="answer-container">
							<input type="checkbox" name="salmonid[]" value="テッパン" <?= $salmonid_checked['テッパン'] ?> />
							<figure class='image-box'>
								<img src='./images/boss_salmonids/scrapper.png' alt='テッパン'>
								<figcaption>テッパン</figcaption>
							</figure>
						</label>
						<label class="answer-container">
							<input type="checkbox" name="salmonid[]" value="ヘビ" <?= $salmonid_checked['ヘビ'] ?> />
							<figure class='image-box'>
								<img src='./images/boss_salmonids/steel_eel.png' alt='ヘビ'>
								<figcaption>ヘビ</figcaption>
							</figure>
						</label>
						<label class="answer-container">
							<input type="checkbox" name="salmonid[]" value="バクダン" <?= $salmonid_checked['バクダン'] ?> />
							<figure class='image-box'>
								<img src='./images/boss_salmonids/steel_head.png' alt='バクダン'>
								<figcaption>バクダン</figcaption>
							</figure>
						</label>
						<label class="answer-container">
							<input type="checkbox" name="salmonid[]" value="タワー" <?= $salmonid_checked['タワー'] ?> />
							<figure class='image-box'>
								<img src='./images/boss_salmonids/stinger.png' alt='タワー'>
								<figcaption>タワー</figcaption>
							</figure>
						</label>
					</div>	
				</div>

				<div class="question">
					<h3>#5. スプラトゥーンに対する意見をお聞かせください</h3>
					<textarea name="opinion">ご自由にどうぞ</textarea>
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