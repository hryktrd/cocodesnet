<!DOCTYPE html>
<html>
<head>
<meta CHARSET="UTF-8">
</head>
<html>
<body>
<?php

require_once("define.php");
$shopId = 1;
$dbhost = RDS_HOSTNAME;
$dbport = RDS_PORT;
$dbname = RDS_DB_NAME;

$dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname}";
$username = RDS_USERNAME;
$password = RDS_PASSWORD;

$dbh = new PDO($dsn, $username, $password);

$sql = 'select * from cast_table join play_kind on cast_table.play_id=play_kind.play_id where shop_id=' . $shopId;

$stmt = $dbh->query($sql);

echo "<table>";
while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
	echo "<tr>";
	echo '<td><img src="loadCastPicture.php?cast_id=' . $result['cast_id'] . '" width="300"></td>';
	echo "<td>";
	echo "<p>名前：" . $result['name'] . "</p>";
	echo "<p>年齢：" . $result['age'] . "</p>";
	echo "<p>身長：" . $result['tall'] . "</p>";
	echo "<p>バスト：" . $result['bust'] . "cm " . $result['cup'] . "カップ</p>";
	echo "<p>ウエスト：" . $result['waist'] . "</p>";
	echo "<p>ヒップ：" . $result['hip'] . "</p>";
	echo "<p>得意プレイ：" . $result['kind'] . "</p>";
	echo "<p>価格帯：" . $result['price_min'] . "〜" . $result['price_max'] . "</p>";
	echo "</td>";
	echo "</tr>";
}
echo "</table>";

$dbh = null;
?>

</body>
</html>
