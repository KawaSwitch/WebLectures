<?php
// 入力データの取得
$name = $_POST['name'];		// アルバイトの名前
$hours = $_POST['hours'];	// 勤務時間

// 支給額の計算
$hourlyWage = 1000;	// 時給
$pay = $hourlyWage * $hours; // 支給額

// 出力用データに変換
$name = htmlspecialchars($name);
$hours = htmlspecialchars($hours);
$pay = htmlspecialchars($pay);

// HTMLの出力
?>

<html>
	<head>
		<title>アルバイトの入力結果</title>
	</head>
	<body>
		名前 = <?= $name ?> <br>
		勤務時間 = <?= $hours ?> <br>
		支給額 = <?= $pay ?> <br>
	</body>
</html>