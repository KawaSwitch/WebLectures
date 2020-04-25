<?php
	// データの生成
	$taro['name'] = '国際太郎';
	$taro['hours'] = 50;
	$hanako['name'] = '国際花子';
	$hanako['hours'] = 120;

	// データの保存
	$fh = fopen('./myfile.csv', 'w');
	$line = $taro['name'].','.$taro['hours']."\n";
	fwrite($fh, $line);
	$line = $hanako['name'].','.$hanako['hours']."\n";
	fwrite($fh, $line);
	fclose($fh);

	echo "ファイル保存が終了しました";
?>