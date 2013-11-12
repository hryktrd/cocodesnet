<?php
require_once('define.php');
$shopId = 1;

//得意なプレイ一覧取得
getPlayKindArr($playKindArr);

?>
<!DOCTYPE html>
<html>
<head>
  <meta CHARSET="UTF-8">
  <meta http-equiv="pragma" content="no-cache">
  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="expires" content="0">
  <title>キャスト登録</title>
</head>

<body>
<form action="addCast.php" method="post">
<p>名前：<input type="text" name="name"></p>
<p>年齢：<input type="number" name="age"></p>
<p>身長：<input type="number" name="tall"></p>
<p>バスト：<input type="text" name="bust"></p>
<p>カップ：<input type="text" name="cup"></p>
<p>ウエスト：<input type="number" name="waist"></p>
<p>ヒップ：<input type="number" name="hip"></p>
<p>得意なプレイ：<select name="play">
					<?php
						foreach ($playKindArr as $id => $kind)
						{
							echo '<option name="play_id" value="' . $id . '">' . $kind . '</option>';
						}
					?>
				</select>
</p>

<p>価格帯（最大）：<input type="number" name="maxPrice"></p>
<p>価格帯（最小）：<input type="number" name="minPrice"></p>
<p>写真：<input type="file" name="photo" accept="image/jpeg,image/png,image/gif"></p>

<p><input type="submit" name="submit" value="登録"></p>
</form>
</body>
</html>

<?php

if(isset($_POST['submit'])){
	$name 	= $_POST['namem'];
	$age 	= $_POST['age'];
}

function getPlayKindArr(&$playKindArr){
	// require_once('define.php');
	$dbhost = RDS_HOSTNAME;
	$dbport = RDS_PORT;
	$dbname = RDS_DB_NAME;

	$dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname}";
	$username = RDS_USERNAME;
	$password = RDS_PASSWORD;
	$dbh = new PDO($dsn, $username, $password);

	$sql = 'select play_id, kind from play_kind';

	$stmt = $dbh->query($sql);

	while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
		$playId = $result["play_id"];
		$playKind = $result["kind"];
		$playKindArr["$playId"] = $playKind;
	}

}
?>
