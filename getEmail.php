<?php
require_once "config.php";

$id			=		addslashes($_POST['id']);
$code		=		addslashes($_POST['code']);



$sql		=		"SELECT * FROM 
					 coupons LEFT JOIN gifts ON coupons.id = gifts.coupon_id
					 WHERE code='$code' LIMIT 0,1";
$res		=		mysql_query($sql);
print_r(mysql_fetch_assoc($res));
?>