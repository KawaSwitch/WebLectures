<?php
	// アンケート結果の読み出し
	$answers = array();
	$filepath = './db/answers.csv';

	if (file_exists($filepath))
	{
		$fh = fopen($filepath, 'r');
		flock($fh, LOCK_SH);

		$line = fgets($fh);
		while (!empty($line))
		{
			$answer = explode(',', $line);
			array_push($answers, $answer);

			$line = fgets($fh);
		}

		flock($fh, LOCK_UN);
		fclose($fh);
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
	function convertToDataPointsDict($datas)
	{
		$graph_datas = array();
		$sum = 0;
		foreach ($datas as $data_key => $data_value)
			$sum += $data_value;

		foreach ($datas as $data_key => $data_value)
			array_push($graph_datas, array('label'=>$data_key, 'y'=>((double)$data_value / $sum) * 100));
		return $graph_datas;
	}

	$show_datas = array(
		getInitDataDict(array('男性', '女性', '無回答')),
		getInitDataDict(array('はい', 'いいえ')),
		getInitDataDict(array('1だけ', '2だけ', '1と2どっちも', 'ない')),
		getInitDataDict(array('イカ', 'タコ')),
	);

	// グラフ表示用のデータ生成
	foreach ($answers as $answer)
	{
		// 円グラフ
		for ($i = 1; $i < 5; $i++)
			$show_datas[$i - 1][$answer[$i]]++;

	}

	$data_points_list = array();
	foreach ($show_datas as $show_data)
		// canvasJS用のデータへ変換
		array_push($data_points_list, convertToDataPointsDict($show_data));

	$dataPoints = array( 
		array("label"=>"Industrial", "y"=>51.7),
		array("label"=>"Transportation", "y"=>26.6),
		array("label"=>"Residential", "y"=>13.9),
		array("label"=>"Commercial", "y"=>7.8)
	);

	$dataPoints2 = array( 
		array("label"=>"Chrome", "y"=>64.02),
		array("label"=>"Firefox", "y"=>12.55),
		array("label"=>"IE", "y"=>8.47),
		array("label"=>"Safari", "y"=>6.08),
		array("label"=>"Edge", "y"=>4.29),
		array("label"=>"Others", "y"=>4.59)
	);
?>

<html>
	<head>
		<meta charset=utf-8>
		<link rel="stylesheet" type="text/css" href="base.css">
		<link rel="stylesheet" type="text/css" href="questionnaire.css">
		<title>みんなのアンケート調査の結果</title>

		<script>
			function createChart(id, title, dataPoints)
			{
				return new CanvasJS.Chart(id, {
					animationEnabled: true,
					title: {
						text: title
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

			window.onload = function() {

			var charts = [
				createChart('gender_chart', '回答者の性別比', <?php echo json_encode($data_points_list[0], JSON_NUMERIC_CHECK); ?>),
				createChart('known_chart', '#1. あなたはスプラトゥーンを知っていますか？', <?php echo json_encode($data_points_list[1], JSON_NUMERIC_CHECK); ?>),
				createChart('played_chart', '#2. スプラトゥーンをプレイしたことはありますか？', <?php echo json_encode($data_points_list[2], JSON_NUMERIC_CHECK); ?>),
				createChart('kind_chart', '#3. イカとタコはどちらが好みですか？', <?php echo json_encode($data_points_list[3], JSON_NUMERIC_CHECK); ?>),
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
			<p>
				みんなの入力結果<br>
			</p>

			<!-- 名前 = <?= $name ?> <br>
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
			<?= $opinion ?> <br> -->

			<div id="gender_chart" class="pie-chart"></div>
			<div id="known_chart" class="pie-chart"></div>
			<div id="played_chart" class="pie-chart"></div>
			<div id="kind_chart" class="pie-chart"></div>

			<form class='q-submit' action="input.html">
				<input class="submit" type="submit" value="入力画面に戻る">
			</form>
		</div>
	</body>
</html>