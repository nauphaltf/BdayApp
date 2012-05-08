<?php
if(!session_id()){
	session_start();
}
	
require_once "config.php";

$id			=		addslashes($_POST['id']);
$code		=		addslashes($_POST['code']);
$user		=		addslashes($_POST['user']);

$_SESSION['logged_user']	=	$user;
$_SESSION['timestamp']		=	time();

$sql		=	"SELECT * FROM 
					 coupons LEFT JOIN gifts ON coupons.id = gifts.coupon_id
					 WHERE code='$code'
					 AND coupons.id NOT IN (SELECT coupon_id FROM redemptions)
					 LIMIT 0,1";
$res		=		mysql_query($sql);
$row 		=		mysql_fetch_assoc($res);

if($row['code'] == "") {
	echo "<h1 style=\"color:red\">Invalid Code.</h1>";
}
else {
	echo "<h1 style=\"color:blue\">Your coupon has been redeemed.</h1>";
	//$sql1		=		"INSERT INTO redemptions (user,point)";
}
if($row['gift']) {
	echo "<h1 style=\"color:green\">You have Won ".$row['gift']."</h1>";
}
?>