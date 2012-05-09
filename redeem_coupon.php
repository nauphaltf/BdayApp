<?php
require_once "config.php";

$sql		=		"SELECT * FROM users";
$res		=		mysql_query($sql);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<title>Untitled Document</title>
<script>
$(document).ready(function() {
	$("input[type=button]").click(function() {
		user	=	$("select").val();
		code	=	$("input[type=text]").val();
		id		=	$(".users").val();
		$.ajax({
			data: "id="+id+"&code="+code+"&user="+user,
			url : "getEmail.php",
			type: "POST",
			success: function(resp) {
				$(".msg").html(resp);
			}
		})
	})
})

</script>
</head>

<body>
<div align="center">
<table>
<tr>
    <td>Name</td>
    <td>
    	<select name="name" class="users">
        	<?php
				while($row = mysql_fetch_array($res)) {
					echo '<option value="'.$row['id'].'">'.$row['name'].'</option>';
				}
			?>
        </select>
    </td>
</tr>
<tr>
	<td>Coupon Code</td>
    <td><input type="text" name="code" />
</tr>
<tr>
<td></td>
<td><input type="button" value="Redeem" /></td>
</tr>
</table>
<div class="msg"></div>
</div>
</body>
</html>