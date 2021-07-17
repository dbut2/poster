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
			<table>
				<tr>
					<td colspan="2">
						<form action="global.php?redirect" method="POST">
						<input type="hidden" name="form" value="login" />
						<input type="text" class="input" name="user" placeholder="Username" />
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<input type="password" class="input" name="pass" placeholder="Password" />
					</td>
				</tr>
				<tr>
					<td>
						<input type="submit" class="submit" value="Login" />
						</form>
					</td>
					<td>
						<form action="register.php?redirect" method="POST">
						<input type="submit" class="submit" value="Register" />
						</form>
					</td>
				</tr>
			</table>
		</div>
		<?php echo $body_end; ?>
	</body>
</html>