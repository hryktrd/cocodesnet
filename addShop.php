<?php
require_once('define.php');

//ショップ種類取得
getShopKindArr($shopKindArr);

?>


<!DOCTYPE html>
<html>
<head>
<meta CHARSET="UTF-8">
<title>ここですねっと-店舗登録</title>
</head>
<body onload="gmapinit(34.689, 135.528);">
<script src="http://maps.google.com/maps/api/js?v=3&sensor=false"　type="text/javascript" charset="UTF-8"></script>
<script src="js/gmap.js"></script>
<p>店舗名<input type="text" name="shopName"></p>
<p>住所<input type="text" id="shopAddress" name="shopAddress"><input type="button" value="地図に反映" onclick="getLocationFromAdress();"></p>
<p>URL<input type="url" name="shopUrl"></p>
<p>電話番号<input type="tel" name="shopTel"></p>
<p>ショップ種別<select name="shopKindId">
				<?php
					foreach($shopKindArr as $id => $name){
						echo ('<option name=' . $id . '>');
						echo ($name);
						echo ('</option>');
					}
				?>
				</select></p>
<p>ログインID<input type="text" name="shopLoginId"></p>
<p>パスワード<input type="password" name="shopPassWord"></p>
<p>場所</p>
<div id="map" style="width:360px;height:360px;"></div>

<input type="hidden" id="shopLat" name="shopLat" value="">
<input type="hidden" id="shopLon" name="shopLon" value="">
</body>
</html>

<?php
function getShopKindArr(&$shopKindArr){
	// require_once('define.php');
	$dbhost = RDS_HOSTNAME;
	$dbport = RDS_PORT;
	$dbname = RDS_DB_NAME;

	$dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname}";
	$username = RDS_USERNAME;
	$password = RDS_PASSWORD;
	$dbh = new PDO($dsn, $username, $password);

	$sql = 'select shop_kind_id, kind from shop_kind';

	$stmt = $dbh->query($sql);

	while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
		$shopKindId = $result["shop_kind_id"];
		$shopKind = $result["kind"];
		$shopKindArr["$shopKindId"] = $shopKind;
	}

	$dbh = null;
}
?>