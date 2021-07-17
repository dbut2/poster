<?php
$req_rank = '0';

mysql_connect("", "", "");
mysql_select_db("");

if (isset($_COOKIE['user'])&&isset($_COOKIE['vericode'])) {
	$user = htmlspecialchars($_COOKIE['user'], ENT_QUOTES);
	$vericode = htmlspecialchars($_COOKIE['vericode'], ENT_QUOTES);
	$query = mysql_query("SELECT * FROM users WHERE user='$user' AND vericode='$vericode'");
	if ($query!=FALSE||mysql_num_rows($query)==1) {
		while ($row=mysql_fetch_array($query)) {
			$user_id = $row['id'];
			$rank = $row['rank'];
		}
	} else {
		echo '<meta http-equiv="refresh" content="0;../index.php?action=logout" />';
	}
} else {
	echo '<meta http-equiv="refresh" content="0;../index.php?action=logout" />';
}

if (isset($rank)) {
	if ($req_rank>$rank) {
		echo '<meta http-equiv="refresh" content="0;../index.php" />';
	}
}

if (isset($_GET['delete'])) {
	$id = $_GET['delete'];
	$query = mysql_query("SELECT * FROM posts WHERE id='$id'");
	if ($query!=FALSE) {
		mysql_query("UPDATE posts SET deleted='true' WHERE id='$id'");
		if (isset($_GET['redirect'])) {
			$poster = $_GET['redirect'];
			echo '<meta http-equiv="refresh" content="0;user.php?user='.$poster.'" />';
		} else {
			echo '<meta http-equiv="refresh" content="0;index.php" />';
		}
	}
}

if (isset($_GET['restore'])) {
	$id = $_GET['restore'];
	$query = mysql_query("SELECT * FROM posts WHERE id='$id'");
	if ($query!=FALSE) {
		mysql_query("UPDATE posts SET deleted='false' WHERE id='$id'");
		if (isset($_GET['redirect'])) {
			$poster = $_GET['redirect'];
			echo '<meta http-equiv="refresh" content="0;user.php?user='.$poster.'" />';
		} else {
			echo '<meta http-equiv="refresh" content="0;index.php" />';
		}
	}
}

if (isset($_POST['form'])) {
	$form = $_POST['form'];
	if ($form='user_edit'&&isset($_POST['poster'])) {
		$poster = $_POST['poster'];
		
		if (isset($_POST['pass'])&&$_POST['pass']!='') {
			$pass = $_POST['pass'];
			mysql_query("UPDATE users SET password='$pass' WHERE id='$poster'") or die(mysql_error());
		}
		if (isset($_POST['rank'])&&$_POST['rank']!='') {
			$rank = $_POST['rank'];
			mysql_query("UPDATE users SET rank='$rank' WHERE id='$poster'");
		}
		if (isset($_POST['user'])&&$_POST['user']!='') {
			$new_user = $_POST['user'];
			$query = mysql_query("SELECT * FROM users WHERE user='$new_user'") or die(mysql_error());
			if ($query!=FALSE&&mysql_num_rows($query)==0) {
				mysql_query("UPDATE users SET user='$new_user' WHERE id='$poster'") or die(mysql_error());
				//echo '<meta http-equiv="refresh" content="0;user.php?user='.$user.'" />';
			}
		} else {
		//echo '<meta http-equiv="refresh" content="0;user.php?user='.$poster.'" />';
		}
	}
}

include 'head.php';
include 'body.php';
?>