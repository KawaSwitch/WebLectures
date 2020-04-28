<!DOCTYPE html>
<html>
	<head>
		<title>アルバイト一覧</title>
	</head>
	<body>
		<?php 
			$dsn = 'mysql:dbname=assign_web_master;host=localhost';
			$user = 'kawakami';
			$password = 'kawakami';

			try
			{
				$dbh = new PDO($dsn, $user, $password);

				// データベースからアルバイトデータの全件読み出し
				$sql = 'select * from parttime';
				foreach ($dbh->query($sql) as $row)
				{
					print('id = '.htmlspecialchars($row['id']).': ');
					print('名前 = '.htmlspecialchars($row['name']).', ');
					print('勤務時間 = '.htmlspecialchars($row['hours']));
					print('<br />');
				}
			}
			catch (PDOExeption $e)
			{
				print('Error:'.$e->getMessage());
				die();
			}

			$dbh = null;

		?>
		<form action="input.html">
			<input type="submit" value="入力画面に戻る">
		</form>
	</body>
</html>