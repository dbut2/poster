<?php
mysql_connect ("", "", "");
mysql_select_db ("");

date_default_timezone_set('UTC');

include 'variables.php';

if (isset($_COOKIE['user'])&&isset($_COOKIE['vericode'])) {
	$user = htmlspecialchars($_COOKIE['user'], ENT_QUOTES);
	$vericode = htmlspecialchars($_COOKIE['vericode'], ENT_QUOTES);
	$query = mysql_query ("SELECT * FROM users WHERE user='$user' AND vericode='$vericode'");
	if ($query!=FALSE&&mysql_num_rows($query)==1) {
		while ($row=mysql_fetch_array($query)) {
			$user_id = $row['id'];
			$rank = $row['rank'];
		}
	} else {
		echo '<meta http-equiv="refresh" content="0;login.php?action=logout" />';
	}
} elseif (isset($_POST['form'])&&isset($_POST['user'])&&isset($_POST['pass'])) {
	$user = htmlspecialchars($_POST['user'], ENT_QUOTES);
	$pass = htmlspecialchars($_POST['pass'], ENT_QUOTES);
	$query = mysql_query ("SELECT * FROM users WHERE user='$user' AND password='$pass'");
	if ($query!=FALSE&&mysql_num_rows($query)==1) {
		#Login Success
		while ($row=mysql_fetch_array($query)) {
			$vericode = $row['vericode'];
			setcookie("user", $_POST['user'], time()+31556926);
			setcookie("vericode", $vericode, time()+31556926);
			echo '<meta http-equiv="refresh" content="0;index.php" />';
		}
	} elseif ($_POST['form']=='register') {
		$n = 0;
		$vericode = '';
		while ($n<32) {
			$vericode = $vericode.''.dechex(rand(0,15));
			$n++;
		}
		mysql_query("INSERT INTO users (user, password, vericode) VALUES ('$user', '$pass', '$vericode')");
		setcookie("user", $_POST['user'], time()+31556926);
		setcookie("vericode", $vericode, time()+31556926);
		echo '<meta http-equiv="refresh" content="0;index.php" />';
	} else {
		echo '<meta http-equiv="refresh" content="0;login.php" />';
	}
} elseif (!isset($_GET['redirect'])) {
	echo '<meta http-equiv="refresh" content="0;login.php?redirect" />';
}

if (!isset($user)) {
	$user = 'guest';
}

if (isset($_POST['form'])) {
	if ($_POST['form']=='post'&&isset($_POST['content'])) {
		$content = htmlspecialchars($_POST['content'], ENT_QUOTES);
		$timestamp = time();
		mysql_query("INSERT INTO posts (user_id, content, timestamp, deleted) VALUES ('$user_id', '$content', '$timestamp', 'false')") or die(mysql_error());
		echo '<meta http-equiv="refresh" content="0;index.php" />';
	}
}

if (isset($_GET['action'])) {
	if ($_GET['action']=='logout') {
		setcookie('user', '', time()-1);
		setcookie('vericode', '', time()-1);
		echo '<meta http-equiv="refresh" content="0;index.php" />';
	}
}

if (isset($_GET['delete'])) {
	$id = $_GET['delete'];
	$query = mysql_query("SELECT * FROM posts WHERE id='$id'");
	if ($query!=FALSE) {
		while ($row=mysql_fetch_array($query)) {
			if ($user_id==$row['user_id']) {
				mysql_query("UPDATE posts SET deleted='true' WHERE id='$id'");
				if (isset($_GET['redirect'])) {
					$redirect = $_GET['redirect'];
					if ($redirect=='user') {
						echo '<meta http-equiv="refresh" content="0;user.php?user='.$user_id.'" />';
					}
				} else {
					echo '<meta http-equiv="refresh" content="0;index.php" />';
				}
			}
		}
	}
}

if (isset($req_rank)) {
	if ($rank>$req_rank) {
		echo '<meta http-equiv="refresh" content="0;index.php" />';
	}
}

include 'head.php';
include 'body.php';
?>