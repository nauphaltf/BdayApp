<?php require_once('Connections/bday.php'); ?>
<?php

if(isset($_POST['users']) && isset($_POST['list'])){
	$postUser = $_POST['users'];
	$sessionUsers = $_SESSION['randomUsers'];
	foreach($sessionUsers[$_POST['list']] as $sessionUser){
		$rep_user = $sessionUser['id'];
		$rep_value = $postUser[$sessionUser['id']];
		if(!($rep_value>0 && $rep_value<6)){
			$rep_value = 0;
		}
		$rep_value*=5;
		$insertSQL = sprintf("INSERT INTO redemptions (`user`, point, type, referred_by) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($rep_user, "int"),
                       GetSQLValueString($rep_value, "int"),
                       GetSQLValueString("Refferal", "text"),
                       GetSQLValueString(1, "int"));

					  mysql_select_db($database_bday, $bday);
					  $Result1 = mysql_query($insertSQL, $bday) or die(mysql_error());
	}
	echo "done";
	$_SESSION['randomUsers'] = NULL;
	exit;
}

if(!isset($_SESSION['randomUsers'])){
	mysql_select_db($database_bday, $bday);
	$query_randselectUser = "select * from users order by rand() limit 9";
	$randselectUser = mysql_query($query_randselectUser, $bday) or die(mysql_error());
	$row_randselectUser = mysql_fetch_assoc($randselectUser);
	$totalRows_randselectUser = mysql_num_rows($randselectUser);
	$usersRand = array();
	$i=0;
	$k=0;
	do { 
		if($i%3==0){
			$k++;
		}
		$usersRand[$k][] = $row_randselectUser;
		$i++;
	 } while ($row_randselectUser = mysql_fetch_assoc($randselectUser)); 
	//print_r($usersRand);exit;
	$_SESSION['randomUsers'] = $usersRand;
}
$usersRand = $_SESSION['randomUsers'] ;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Untitled Document</title>
<link href="lib/jrating_v2.2/jquery/jRating.jquery.css" type="text/css" />
<link href="lib/jrating_v2.2/jquery/jNotify.jquery.css" type="text/css" />
</head>

<body>
<style type="text/css">
/*********************/
/** jRating CSS **/
/*********************/

/**Div containing the color of the stars */
.jRatingAverage {
	background-color:#f62929;
	position:relative;
	top:0;
	left:0;
	z-index:2;
	height:100%;
}
.jRatingColor {
	background-color:#f4c239; /* bgcolor of the stars*/
	position:relative;
	top:0;
	left:0;
	z-index:2;
	height:100%;
}

/** Div containing the stars **/
.jStar {
	position:relative;
	left:0;
	z-index:3;
}

/** P containing the rate informations **/
p.jRatingInfos {
	position:		absolute;
	z-index:9999;
	background:	transparent url('icons/bg_jRatingInfos.png') no-repeat;
	color:			#FFF;
	display:		none;
	width:			91px;
	height:			29px;	
	font-size:16px;
	text-align:center;
	padding-top:5px;
}
	p.jRatingInfos span.maxRate {
		color:#c9c9c9;
		font-size:14px;
	}
	ul.roundabout-wrapper {
				list-style: none;
				padding: 0;
				margin: 0 auto;
				width: 42em;
				height: 24em;
			}
			ul.roundabout-wrapper>li {
				height: 20em;
				width: 30em;
				background-color: #ccc;
				text-align: center;
				cursor: pointer;
			}
				ul.roundabout-wrapper>li.roundabout-in-focus {
					cursor: default;
				}
			ul.roundabout-wrapper span {
				display: block;
				padding-top: 6em;
			}
</style>
<ul class="roundabout-wrapper">
<?php 
$listCount = 0;

foreach($usersRand as $list){ 
$listCount++;
?>
<li>
<form method="post">
List <?php echo $listCount ?>
<ul>
<?php foreach($list as $item){ ?>
	<li>  <?php echo $item['name'] ?> 
    <div class="rating-box" id="rating-<?php echo $item['name'] ?>">  </div>
	<input type="hidden" name="users[<?php echo $item['id'] ?>]" value="" />
    <input type="hidden" value="<?php echo $listCount ?>" name="list" />
<?php } ?>
<li>  <input name="submit" type="submit" /> </li>
</ul>
</form>
</li>
<?php } ?>
</ul>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<script type="text/javascript" src="lib/jrating_v2.2/jquery/jRating.jquery.js"></script>
<script type="text/javascript" src="lib/jrating_v2.2/jquery/jNotify.jquery.js"></script>
<script type="text/javascript" src="lib/roundabout/jquery.roundabout.js"></script>
<script type="text/javascript">
$(document).ready(function(){
	$(".rating-box").jRating();
	$('ul.roundabout-wrapper').roundabout();
});
</script>
</body>
</html>

