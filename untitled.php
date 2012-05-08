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
</head>

<body>

<?php 
$listCount = 0;

foreach($usersRand as $list){ 
$listCount++;
?>
<form method="post">
List <?php echo $listCount ?>
<ul>
<?php foreach($list as $item){ ?>
	<li>  <?php echo $item['name'] ?> <input name="users[<?php echo $item['id'] ?>]" type="text" /> </li>
    <input type="hidden" value="<?php echo $listCount ?>" name="list" />
<?php } ?>
<li>  <input name="submit" type="submit" /> </li>
</ul>
</form>
<?php } ?>
</body>
</html>

