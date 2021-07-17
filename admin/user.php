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
			$poster_id = $_GET['user'];;
			$query = mysql_query("SELECT * FROM users WHERE id='$poster_id'");
			if ($query!=FALSE) {
				while($row=mysql_fetch_array($query)) {
					$poster = $row['user'];
					$poster_pass = $row['password'];
					$poster_rank = $row['rank'];
				}
			}
			
			echo '<div class="title">'.$poster.'</div>';
			
			$query = mysql_query("SELECT * FROM posts WHERE user_id='$poster_id'");
			if ($query!=FALSE) {
				$n = 0;
				$pass_placeholder = '';
				while($n<strlen($poster_pass)) {
					$pass_placeholder = $pass_placeholder.'•';
					$n++;
				}
				$poster_pass = $pass_placeholder;
				echo '<div class="post"><div class="left"></div><div class="right"></div><div class="content"><table><tr><td>Username</td><td>Password</td><td>Rank</td><td></td></tr><tr><td><form action="user.php?user='.$poster_id.'" method="POST" autocomplete="false"><input type="hidden" name="form" value="user_edit" /><input type="hidden" name="poster" value="'.$poster_id.'" /><input type="text" class="input" name="user" placeholder="'.$poster.'" /></td><td><input type="password" class="input" name="pass" placeholder="'.$poster_pass.'" /></td><td><input type="text" class="input" name="rank" placeholder="'.$poster_rank.'" /></td><td><input type="submit" style="display:none" /></form></td></table></div></div>';
				while ($row=mysql_fetch_array($query)) {
					if ($row['deleted']=='false') {
						$options = '<a href="index.php?delete='.$row['id'].'&redirect='.$poster_id.'">Delete</a> ~ ';
					} else {
						$options = '<a href="index.php?restore='.$row['id'].'&redirect='.$poster_id.'">Restore</a> ~ ';
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