<?php
	require '../vendor/autoload.php';
	use Google\GTrends;
	$options = [
		'hl' => 'ja-JP',
		'tz' => -540,
		'geo' => 'JP',
	];
	/** @var Google\GTrends $gt */
	$gt = new GTrends($options);

	$res = $gt->getDailySearchTrends();
	//var_dump($res['default']['trendingSearchesDays'][0]['formattedDate']);

	// 0か1かで分かれていたので選択式に
	$day_option = array
	(
		'today' => 0,
		'yesterday' => 1
	);

	// Google Trendsの公開APIを用いて今日の急上昇ワードを取得する
	// 今日の日付
	$date = $res['default']['trendingSearchesDays'][$day_option['today']]['formattedDate'];

	// 今日の急上昇ワード
	$trends = $res['default']['trendingSearchesDays'][$day_option['today']]['trendingSearches'];
	$trend_words = array();
	foreach ($trends as $trend)
	{
		array_push($trend_words, $trend['title']['query']);
		//var_dump($trend_words);
	}
	$trend_words_str = implode(', ', $trend_words);
?>
<!doctype html>

<html lang="ja">
	<head>
		<meta charset="utf-8">

		<title>GTrends</title>
		<meta name="description" content="">
		<meta name="author" content="">

		<link rel="stylesheet" href="">

		<!--[if lt IE 9]>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/html5shiv/3.7.3/html5shiv.js"></script>
		<![endif]-->
	</head>

	<body>
		<h1><?php echo $date ?>の急上昇ワード</h1>
		<p>
			<?php echo $trend_words_str ?>
		</p><br>
		<script src=""></script>
	</body>
</html>