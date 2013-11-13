<?php
require_once("define.php");
$cast_id = $_GET['cast_id'];

$shopId = 1;
$dbhost = RDS_HOSTNAME;
$dbport = RDS_PORT;
$dbname = RDS_DB_NAME;

$dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname}";
$username = RDS_USERNAME;
$password = RDS_PASSWORD;

$dbh = new PDO($dsn, $username, $password);

$sql = 'select picture, picture_type from cast_table where cast_id=' . $cast_id;

$stmt = $dbh->query($sql);

while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
	header("Content-Type: image/" . $result['picture_type']);
	echo($result['picture']);
}

?>