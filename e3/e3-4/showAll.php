<?php
	// DBからアンケート結果の読み出し
	$answers = array();
	{
		$dsn = 'mysql:dbname=assign_web_master;host=localhost';
		$user = 'kawakami';
		$password = 'kawakami';

		try
		{
			$dbh = new PDO($dsn, $user, $password);
	
			// データベースからアルバイトデータの全件読み出し
			$sql = 'select * from questionnaire';
			foreach ($dbh->query($sql) as $row)
				array_push($answers, $row);
		}
		catch (PDOExeption $e)
		{
			print('Error:'.$e->getMessage());
			die();
		}
	
		$dbh = null;
	}

	// データのラベル配列から数値が初期化された連想配列を取得する
	function getInitDataDict($labels)
	{
		$datas = array();
		foreach ($labels as $label)
			$datas[$label] = 0;
		return $datas;
	}

	// データの連想配列からパーセントグラフ表示用の連想配列を作成し戻す
	function convertToPercentageDataPointsDict($datas)
	{
		$graph_datas = array();
		$sum = 0;
		foreach ($datas as $data_key => $data_value)
			$sum += $data_value;

		foreach ($datas as $data_key => $data_value)
			array_push($graph_datas, array('label'=>$data_key, 'y'=>((double)$data_value / $sum) * 100));
		return $graph_datas;
	}

	// データの連想配列からカウントグラフ(棒グラフとか)表示用の連想配列を作成し戻す
	function convertToCountDataPointsDict($datas)
	{
		$graph_datas = array();
		foreach ($datas as $data_key => $data_value)
			array_push($graph_datas, array('label'=>$data_key, 'y'=>$data_value));
		return $graph_datas;
	}

	$show_datas = array(
		'gender' => getInitDataDict(array('男性', '女性', '無回答')),
		'known' => getInitDataDict(array('はい', 'いいえ')),
		'played' => getInitDataDict(array('1だけ', '2だけ', '1と2どっちも', 'ない')),
		'kind' => getInitDataDict(array('イカ', 'タコ')),
		'salmonid' => getInitDataDict(array('ザコシャケ', 'タマヒロイ', 'コウモリ', 'カタパッド', 'モグラ', 'テッパン', 'ヘビ', 'バクダン', 'タワー', '選択なし')),
	);

	// グラフ表示用のデータ生成
	foreach ($answers as $answer)
	{
		// 円グラフ
		$show_datas['gender'][$answer['gender']]++;
		$show_datas['known'][$answer['known']]++;
		$show_datas['played'][$answer['played']]++;
		$show_datas['kind'][$answer['kind']]++;

		// 棒グラフ
		foreach (explode(' / ', $answer['salmonid']) as $boss_name)
			$show_datas['salmonid'][$boss_name]++;
	}

	// canvasJS用のデータへ変換
	$data_points_list = array();
	foreach ($show_datas as $show_data_key => $show_data_value)
	{
		if ($show_data_key == 'salmonid')
			array_push($data_points_list, convertToCountDataPointsDict($show_data_value));
		else
			array_push($data_points_list, convertToPercentageDataPointsDict($show_data_value));
	}
?>

<html>
	<head>
		<meta charset='utf-8'>
		<link rel="stylesheet" type="text/css" href="base.css">
		<link rel="stylesheet" type="text/css" href="questionnaire.css">
		<title>みんなのアンケート調査の結果</title>

		<script>
			function createPieChart(id, title, dataPoints)
			{
				return new CanvasJS.Chart(id, {
					animationEnabled: true,
					title: {
						text: title,
						fontSize: 25,
						fontFamily: 'sans-serif',
						fontWeight: "bold"
					},
					data: [{
						type: "pie",
						indexLabel: "{y}",
						yValueFormatString: "#,##0.00\"%\"",
						indexLabelPlacement: "inside",
						indexLabelFontColor: "#36454F",
						indexLabelFontSize: 18,
						indexLabelFontWeight: "bolder",
						showInLegend: true,
						legendText: "{label}",
						dataPoints: dataPoints
					}]
				});
			}
			function createBarChart(id, title, ytitle, legend, dataPoints)
			{
				return new CanvasJS.Chart(id, {
					animationEnabled: true,
					theme: "light2", // "light1", "light2", "dark1", "dark2"
					title:{
						text: title,
						fontSize: 25,
						fontFamily: 'sans-serif'
					},
					axisY: {
						title: ytitle
					},
					dataPointMaxWidth: 40,
					data: [{        
						type: "column",  
						showInLegend: true, 
						legendMarkerColor: "grey",
						legendText: legend,
						dataPoints: dataPoints
					}]
				});
			}

			window.onload = function() 
			{
				var charts = [
					createPieChart('gender_chart', '回答者の性別比', <?php echo json_encode($data_points_list[0], JSON_NUMERIC_CHECK); ?>),
					createPieChart('known_chart', '#1. あなたはスプラトゥーンを知っていますか？', <?php echo json_encode($data_points_list[1], JSON_NUMERIC_CHECK); ?>),
					createPieChart('played_chart', '#2. スプラトゥーンをプレイしたことはありますか？', <?php echo json_encode($data_points_list[2], JSON_NUMERIC_CHECK); ?>),
					createPieChart('kind_chart', '#3. イカとタコはどちらが好みですか？', <?php echo json_encode($data_points_list[3], JSON_NUMERIC_CHECK); ?>),
					createBarChart('salmonid_chart', '#4. 強いと思う（もしくは強そうな）シャケを選んでください', '投票数', '種類', <?php echo json_encode($data_points_list[4], JSON_NUMERIC_CHECK); ?>)
				];

				charts.forEach(function(chart) { chart.render(); });		
			}
		</script>
		<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>
	</head>
	
	<body>

		<header>
			<div class='header-inner'>
				Questionnaire
			</div>
		</header>

		<div id="contents">
			<h3>みんなの回答結果</h3>

			<!-- グラフ表示 -->
			<div id="gender_chart" class="pie-chart"></div>
			<div id="known_chart" class="pie-chart"></div>
			<div id="played_chart" class="pie-chart"></div>
			<div id="kind_chart" class="pie-chart"></div>
			<div id="salmonid_chart" class="bar-chart"></div>

			<!-- 意見 -->
			<h3>みんなのスプラトゥーンに関する意見</h3>
			<p>
				<ul>
					<?php
						$valid_ans = array();
						foreach ($answers as $answer)
						{
							if (strcmp(rtrim($answer['opinion']), '記述なし'))
								array_push($valid_ans, $answer['opinion']);					
						}

						if (count($valid_ans) == 0)
							echo '意見はまだありませんでした。';
						else
						{
							// 意見があれば最新の5つを表示する
							$cnt = count($valid_ans);
							for ($i = $cnt; $i > ($cnt-5 > 0 ? $cnt-5 : 0); $i--)
							{?>
								<li>
									<?php echo htmlspecialchars($valid_ans[$i - 1]); ?>
								</li>
								<?php
							}
							echo 'など';
						}
					?>
				</ul>
			</p>

			<!-- 画面遷移 -->
			<div class="clearfix">
				<div class='float-left'>
					<form method="POST" action="input.php">
						<input class="submit" type="submit" value="入力画面に戻る">
					</form>
				</div>
				<div class='float-right'>
					<form method="POST" action="showTable.php">
						<input class="friend-submit" type="submit" value="表形式でみんなの投票を見る">
					</form>
				</div>
			</div>
		</div>
	</body>
</html>