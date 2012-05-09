<?php
if(!session_id()){
	session_start();
}
	
require_once "config.php";

$id			=		mysql_real_escape_string($_POST['id']);
$code		=		mysql_real_escape_string($_POST['code']);
$user		=		mysql_real_escape_string($_POST['user']);

$_SESSION['logged_user']	=	$user;
$_SESSION['timestamp']		=	time();

$sql		=	"SELECT coupons.`id` as coupons_id, `code`, `class`, gifts.`id` as gift_id, `gift`, `coupon_id` FROM 
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
	if($row['class'] == "gold") {
		$point = 75;
	}
	else if(($row['class'] == "silver")) {
		$point = 50;
	}
	else {
		$point = 25;
	}
	
	$prev_top_sql		=		"SELECT users.name,sum(point) as points FROM `redemptions`  JOIN users ON users.id = redemptions.user GROUP BY redemptions.user ORDER BY points DESC limit 0,10";
	$prev_top_res		=		mysql_query($prev_top_sql);
	while($row = mysql_fetch_array($prev_top_res)) {
		$prev_top_row[] = $row;
	}
	print_r($prev_top_row); exit;
	$coupon_id	=		$row['coupons_id'];
	$sql1		=		"INSERT INTO redemptions (user,point,type,referred_by,coupon_id) VALUES ($user,$point,'self_redemed',$user,'$coupon_id')";
	mysql_query($sql1);
	
	$after_top_sql		=		"SELECT users.name,sum(point) as points FROM `redemptions`  JOIN users ON users.id = redemptions.user GROUP BY redemptions.user ORDER BY points DESC limit 0,10";
	$after_top_res		=		mysql_query($after_top_sql);
	$after_top_row		=		mysql_fetch_array($after_top_res);
	print_r($after_top_row);
	print_r(array_diff($prev_top_row,$after_top_row));
}
if($row['gift']) {
	echo "<h1 style=\"color:green\">You have Won ".$row['gift']."</h1>";
}
?>