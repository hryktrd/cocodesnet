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
$dbh->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

$sql = 'select * from cast_table join play_kind on cast_table.play_id=play_kind.play_id
									join shop_table on cast_table.shop_id=shop_table.shop_id
									where shop_table.shop_id=' . $shopId;

$stmt = $dbh->query($sql);

while($result 	= $stmt->fetch(PDO::FETCH_ASSOC)){
	$castId[] 	= $result['cast_id'];
	$name[] 	= $result['name'];
	$age[]		= $result['age'];
	$tall[]		= $result['tall'];
	$bust[]		= $result['bust'];
	$cup[]		= $result['cup'] ;
	$waist[]	= $result['waist'];
	$hip[]		= $result['hip'];
	$playKind[]	= $result['kind'];
	$priceMin[] = $result['price_min'];
	$priceMax[] = $result['price_max'];
}

$dbh = null;

$jsonArr = array(
			'castId' 	=> $castId,
			'name' 		=>$name,
			'age' 		=> $age,
			'tall' 		=> $tall,
			'bust' 		=> $bust,
			'cup'		=> $cup,
			'waist'		=> $waist,
			'hip'		=> $hip,
			'playKind'	=> $playKind,
			'priceMin'	=> $priceMin,
			'priceMax'	=> $priceMax
			);

header("Content-Type: application/json; charset=utf-8");
echo json_encode($jsonArr);
?>