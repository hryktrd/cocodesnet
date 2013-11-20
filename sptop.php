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

$sql = 'select * from cast_table join play_kind on cast_table.play_id=play_kind.play_id where shop_id=' . $shopId;

$stmt = $dbh->query($sql);

while($result = $stmt->fetch(PDO::FETCH_ASSOC)){
	$castId[] = $result['cast_id'];
}

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
<script src="js/flipsnap.min.js"></script>
<title>ここですねっと</title>
</head>
<body>
	<div data-role="page">

		<div data-role="header">
			<h1>ここですねっと</h1>
		</div><!-- /header -->

		<div data-role="content">
			<p>いまいけるキャスト</p>
			<section class="picture" id="castpicture">
			<div class="viewport">
				<div class="flipsnap">
					<?php
					foreach($castId as $id){
						print '<div class="item">';
						print '<img src="loadCastPicture.php?cast_id=' . $id . '" width="300">';
						print '</div>';
					}
					?>
				</div>
			</div>
			</section>

		</div><!-- /content -->

	</div><!-- /page -->
	<script>
	window.load(function() {
		Flipsnap('#castpicture.flipsnap');
	});

	</script>
</body>
</html>