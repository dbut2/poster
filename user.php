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
		if (isset($_GET['user'])) {
			$poster_id = $_GET['user'];
			$query = mysql_query("SELECT * FROM users WHERE id='$poster_id'");
			while ($row=mysql_fetch_array($query)) {
				$poster = $row['user'];
			}
			echo '<div class="title">'.$poster.'</div>';
			$query = mysql_query("SELECT * FROM posts WHERE user_id='$poster_id' AND deleted='FALSE'");
			if ($query!=FALSE) {			
				while ($row=mysql_fetch_array($query)) {
					if ($user_id==$row['user_id']) {
						$options = '<a href="index.php?delete='.$row['id'].'&redirect=user">Delete</a> ~ ';
					} else {
						$options = '';
					}
					
					$options = $options.date('jS \o\f F, Y \a\t g:ia', $row['timestamp']+10*3600);
					
					echo '<div class="post"><div class="left">'.$poster.'</div><div class="right">'.$options.'</div><div class="content">'.$row['content'].'</div></div><br />';
				}
			}
		}
		?>
		<?php echo $body_end; ?>
	</body>
</html>