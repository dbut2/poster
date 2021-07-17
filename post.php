<?php
include 'global.php';
?>
<html>
	<head>
		<?php echo $head; ?>
	</head>
	<body>
		<?php echo $body_start; ?>
		<div class="table">
			<form action="index.php?redirect" method="POST">
			<input type="hidden" name="form" value="post" />
			<input type="text" class="input" name="content" placeholder="Content" />
			<input type="submit" class="submit" value="Post" />
			</form>
		</div>
		<?php echo $body_end; ?>
	</body>
</html>