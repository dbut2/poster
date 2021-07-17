<?php
include 'global.php';
?>
<html>
	<head>
		<?php echo $head; ?>
	</head>
	<body>
		<?php echo $body_start; ?>
		<?php
		$query = mysql_query("SELECT * FROM posts WHERE deleted='false' ORDER BY id DESC");
		if ($query!=FALSE) {
			while ($row=mysql_fetch_array($query)) {
				if ($user_id==$row['user_id']) {
					$options = '<a href="index.php?delete='.$row['id'].'">Delete</a> ~ ';
				} else {
					$options = '';
				}
								
				$options = $options.date('jS \o\f F, Y \a\t g:ia', $row['timestamp']+10*3600);
				
				$poster_id = $row['user_id'];
				$info_query = mysql_query("SELECT * FROM users WHERE id='$poster_id'");
				while($info=mysql_fetch_array($info_query)) {
					$poster = $info['user'];
				}
				
				echo '<div class="post"><div class="left"><a href="user.php?user='.$poster_id.'">'.$poster.'</a></div><div class="right">'.$options.'</div><div class="content">'.$row['content'].'</div></div><br />';
			}
		}
		?>
		<?php echo $body_end; ?>
	</body>
</html>