<?php
require_once "config.php";

$id			=		addslashes($_POST['id']);
$code		=		addslashes($_POST['code']);



$sql		=		"SELECT * FROM 
					 coupons LEFT JOIN gifts ON coupons.id = gifts.coupon_id
					 WHERE code='$code' LIMIT 0,1";
$res		=		mysql_query($sql);
$row 		=		mysql_fetch_assoc($res);
if($row['code'] == "") {
	echo "<h1 style=\"color:red\">Invalid Code.</h1>";
}
else {
	echo "<h1 style=\"color:blue\">Your coupon has been redeemed.</h1>";
}
if($row['gift']) {
	echo "<h1 style=\"color:green\">You have Won ".$row['gift']."</h1>";
}
?>