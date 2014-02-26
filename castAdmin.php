<?php
//キャスト用時間管理画面
$castId = 8;	//テスト用

require_once("define.php");
$shopId = 1;
$dbhost = RDS_HOSTNAME;
$dbport = RDS_PORT;
$dbname = RDS_DB_NAME;

$dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname}";
$username = RDS_USERNAME;
$password = RDS_PASSWORD;

$dbh = new PDO($dsn, $username, $password);

//待ち時間が入力されていたら現在時刻に加えて
if(isset($_POST['waittime'])){
	$nextTime = new DateTime("Now");
	$nextTime->modify('+'.$_POST['waittime'].' minutes');
	$stmt = $dbh->prepare("UPDATE cast_table SET next_time=:nextTime WHERE cast_id=:castId");
	$stmt->bindParam(':nextTime', $nextTime->format('Y-m-d H:i:s'), PDO::PARAM_STR);
	$stmt->bindParam(':castId', $castId, PDO::PARAM_INT);

	$stmt->execute();
}
$sql = 'select name,next_time from cast_table  where cast_id=' . $castId;

$stmt = $dbh->query($sql);
$result = $stmt->fetch(PDO::FETCH_ASSOC);
$dbh = null;


?>
<!DOCTYPE html>
<html>
<head>
<meta CHARSET="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.css" />
<script src="http://code.jquery.com/jquery-1.9.1.min.js"></script>
<script src="http://code.jquery.com/mobile/1.3.2/jquery.mobile-1.3.2.min.js"></script>
<title>ここですねっと</title>
</head>
<body>
<form action="" method="post">
	<div data-role="page">

		<div data-role="header">
			<h1>ここですねっと</h1>
		</div><!-- /header -->

		<div data-role="content">
			<?php
			echo "<p>";
			echo '<img src="loadCastPicture.php?cast_id=' . $castId . '" width="300">';
			echo "</p>";
			echo "<p>";
			echo "氏名：" . $result['name'];
			echo "</p>";
			echo "<p>";
			echo "何分後に入れる？";
			echo "</p>";
			echo "<p>";
			echo '<input type="number" name="waittime">';
			echo '<input type="submit" value="OK">';
			echo "</p>";
			echo "<p>";
			echo "次の空き時間設定：";
			echo $result['next_time'];
			echo "</p>";
			?>
		</div><!-- /content -->

	</div><!-- /page -->
</form>
</body>
</html>
