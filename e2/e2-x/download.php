<?php
	// ファイル内容の読み出し
	$text = "年齢,性別,好きな飲料\n";
	$text .= file_get_contents('./db/myfile.csv');

	// ダウンロードの実行
	$size = strlen($text);
	header("Content-Type: application/octet-stream");
	header("Content-Disposition: attachment; filename=answers.csv");
	header("Content-length: $size");
	echo $text;
?>