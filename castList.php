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

$sql = 'select * from cast_table where shop_id=' . $shopId . ' and cast_no=8';

$stmt = $dbh->query($sql);

while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
	// print($result['name']);
	// print($result['age']);
	// print("<br>");
	header("Content-Type: image/jpeg");
	// header("Content-Disposition: inline;");
	// header("Content-Transfer-Encoding: binary");
	echo($result['picture']);
	break;
	$fp = fopen('/tmp/test.jpg' , 'wb');
	fwrite($fp, $result['picture']);
	fclose($fp);
	// print("<br>");
	// header("Content-Type: text/html");
}

?>