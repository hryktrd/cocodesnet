<!DOCTYPE html>
<html>
<head>
  <meta CHARSET="UTF-8">
  <meta http-equiv="pragma" content="no-cache">
  <meta http-equiv="cache-control" content="no-cache">
  <meta http-equiv="expires" content="0">
  <title>店舗ログイン登録</title>
<body>
<?php
//店舗ログイン用ページ
require_once("define.php");
session_start();

//テスト用
	// $_POST['shopLoginId'] = "cocodes";
	// $_POST['shopPassword'] = "1234568";

//ログイン済みだった場合
if($_SESSION['shopId']){
	header("Location: addCastForm.php");
}else if(isset($_POST['shopLoginId'])){
	//ログイン済みでなかった場合のログイン処理
	if($shopId = getShopId($_POST['shopLoginId'], $_POST['shopPassword']) != FALSE){
		$_SESSION['shopId'] = $shopId;
		header("Location: addCastForm.php");
	}else{
		echo "ログイン名またはパスワードが違います";
	}

}

?>
<form action="" method="post">
<p><input type="text" name="shopLoginId"></p>
<p><input type="password" name="shopPassword"></p>
<p><input type="submit" value="ログイン"></p>
</form>
</body>
</html>

<?php
function getShopId($loginId, $shopPassword){
	$dbhost = RDS_HOSTNAME;
	$dbport = RDS_PORT;
	$dbname = RDS_DB_NAME;

	$dsn = "mysql:host={$dbhost};port={$dbport};dbname={$dbname}";
	$username = RDS_USERNAME;
	$password = RDS_PASSWORD;

	try{
		$dbh = new PDO($dsn, $username, $password);
	}catch(PDOException $e){
		exit('データベースに接続できません' . $e->getMessage());
	}

	$stmt = $dbh->prepare("SELECT shop_id FROM shop_table where shop_login_id=:shop_login_id AND shop_login_passwd=:shop_login_passwd");
	$stmt->bindValue(':shop_login_id'		, $loginId, PDO::PARAM_STR);
	$stmt->bindValue(':shop_login_passwd'	, $shopPassword, PDO::PARAM_STR);
	$stmt->execute();
	$result = $stmt->fetch(PDO::FETCH_ASSOC);
	if($result == NULL){
		return FALSE;
	}else{
		return $result['shop_id'];
	}
}
?>