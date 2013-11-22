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
<script src="js/jquery.flexslider-min.js"></script>
<link rel="stylesheet" href="css/flexslider.css"/>
<title>ここですねっと</title>
</head>
<body>
	<div data-role="page">

		<div data-role="header">
			<h1>ここですねっと</h1>
		</div><!-- /header -->

		<div data-role="content">
			<p>いまいけるキャスト</p>
			<!-- <section class="picture" id="castpicture"> -->
			<!-- <div class="viewport"> -->
			<div id="photoSlider" class="flexslider">
				<ul class="slides">
				<?php
				foreach($castId as $id){
					print '<li>';
					print '<img src="loadCastPicture.php?cast_id=' . $id . '">';
					print '</li>';
				}
				?>
				</ul>
			</div>
			<div id="thumbSlider" class="flexslider">
				<ul class="slides">
				<?php
				foreach($castId as $id){
					print '<li>';
					print '<img src="loadCastPicture.php?cast_id=' . $id . '">';
					print '</li>';
				}
				?>
				</ul>
			</div>
			<!-- </div> -->
			<!-- </section> -->

		</div><!-- /content -->

	</div><!-- /page -->

	<script>
		$(window).load(function() {
			$('#thumbSlider').flexslider({
				animation: "slide",
				controlNav: false,
				directionNav: false,
				animationLoop: false,
				slideshow: false,
				itemWidth: 60,
				itemMargin: 5,
				asNavFor: '#photoSlider',
			});
			$('#photoSlider').flexslider({
				animation: "slide",
				controlNav: false,
				directionNav: false,
				animationLoop: false,
				slideshow: false,
				sync: '#thumbSlider'
			});
		});

	</script>

</body>
</html>
