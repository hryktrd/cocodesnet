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
<form action="" method="post" enctype="multipart/form-data">
<p>名前：<input type="text" name="name"></p>
<p>年齢：<input type="number" name="age"></p>
<p>身長：<input type="number" name="tall"></p>
<p>バスト：<input type="number" name="bust"></p>
<p>カップ：<input type="text" name="cup"></p>
<p>ウエスト：<input type="number" name="waist"></p>
<p>ヒップ：<input type="number" name="hip"></p>
<p>得意なプレイ：<select name="play_id">
					<?php
						foreach ($playKindArr as $id => $kind)
						{
							echo '<option value="' . $id . '">' . $kind . '</option>';
						}
					?>
				</select>
</p>

<p>価格帯（最大）：<input type="number" name="maxPrice"></p>
<p>価格帯（最小）：<input type="number" name="minPrice"></p>
<p>写真：<input type="file" name="castPhoto" accept="image/jpeg,image/png,image/gif"></p>

<input type="hidden" name="shopId" value="<?php echo $shopId; ?>">
<p><input type="submit" name="submit" value="登録"></p>
</form>
</body>
</html>

<?php

if(isset($_POST['submit'])){
	$castArr = array(
		'name' 		=> $_POST['name'],
		'age' 		=> (int)$_POST['age'],
		'tall'		=> (int)$_POST['tall'],
		'bust'		=> (int)$_POST['bust'],
		'cup'		=> $_POST['cup'],
		'waist'		=> (int)$_POST['waist'],
		'hip'		=> (int)$_POST['hip'],
		'play_id' 	=> (int)$_POST['play_id'],
		'maxPrice'	=> (int)$_POST['maxPrice'],
		'minPrice'	=> (int)$_POST['minPrice'],
		'shopId'	=> (int)$_POST['shopId']
	);

	if (is_uploaded_file($_FILES["castPhoto"]["tmp_name"])) {
		$castArr['castPhotoFile'] = $_FILES["castPhoto"]["tmp_name"];
	}

	addCast($castArr);

}

function addCast($castArr){
	var_dump($castArr);
	$dbhost = RDS_HOSTNAME;
	$dbport = RDS_PORT;
	$dbname = RDS_DB_NAME;

	$dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname}";
	$username = RDS_USERNAME;
	$password = RDS_PASSWORD;
	$dbh = new PDO($dsn, $username, $password);

	$stmt = $dbh->prepare("insert into cast_table (
													shop_id, name, age, tall,
													bust, cup, waist, hip,
													play_id, price_min, price_max, picture)
												)
									values(
											:shop_id, :name, :age, :tall,
											:bust, :cup, :waist, :hip,
											:play_id, :price_min, :price_max, :picture
										)");

	$stmt->bindValue(':shop_id', $castArr['shopId'], PDO::PARAM_INT);
	$stmt->bindValue(':name', $castArr['name'], PDO::PARAM_STR);
	$stmt->bindValue(':age', $castArr['age'], PDO::PARAM_INT);
	$stmt->bindValue(':tall', $castArr['tall'], PDO::PARAM_INT);
	$stmt->bindValue(':bust', $castArr['bust'], PDO::PARAM_INT);
	$stmt->bindValue(':cup', $castArr['cup'], PDO::PARAM_STR);
	$stmt->bindValue(':waist', $castArr['waist'], PDO::PARAM_INT);
	$stmt->bindValue(':hip', $castArr['hip'], PDO::PARAM_INT);
	$stmt->bindValue(':play_id', $castArr['play_id'], PDO::PARAM_INT);
	$stmt->bindValue(':price_min', $castArr['minPrice'], PDO::PARAM_INT);
	$stmt->bindValue(':price_max', $castArr['maxPrice'], PDO::PARAM_INT);
	$stmt->bindValue(':picture', $castArr['castPhotoFile'], PDO::PARAM_INT);

	$stmt->execute();

	var_dump($dbh->errorInfo());

	// $sql = "insert into cast_table (shop_id, name, age, tall,
	// 								bust, cup, waist, hip,
	// 								play_id, price_min, price_max, picture)
	// 		values ($castArr[\'shopId\'], $castArr[\'name\'], $castArr[\'age\'], $castArr[\'tall\'],
	// 				$castArr['bust'], $castArr['cup'], $castArr['waist'], $castArr['hip'],
	// 				$castArr['play_id'], $castArr['minPrice'], $castArr['maxPrice'])";

	// $stmt = $dbh->query($sql);
	$dbh = null;
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

	$dbh = null;
}
?>
