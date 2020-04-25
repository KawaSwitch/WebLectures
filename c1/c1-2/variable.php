<?php
	// 変数の定義
	$name = "川上大器";	// 名前
	$hours = 73;		// 勤務時間
	$hourlyWage = 880;	// 時給
	$pay = $hourlyWage * $hours;	// 支給額
	$tax_rate = 0.21; // 税金
	$tax = (int)($pay * $tax_rate); // 控除金額
	// $actual_pay = $pay - $tax; // 控除後の実際に支払われるバイト代
?>

<html>
	<head>
		<!-- <meta charset="utf-8"> -->
		<title>アルバイト料計算結果</title>
	</head>

	<body>
		名前 = <?= $name ?> <br>
		勤務時間 = <?= $hours ?> <br>
		支給額 = <?= $pay ?> <br>
		税率 = <?= $tax_rate * 100 ?> % <br>
		控除金額 = <?= $tax ?> <br>
		控除後のバイト代 = <?= $pay - $tax ?> <br>
	</body>
</html>