<?php
$menu_left = '<a href="index.php?redirect">Poster</a>';
$menu_right = '';

if ($user!='guest') {
	$menu_right = $menu_right.'<a href="post.php">Post</a> ~ <a href="user.php?user='.$user_id.'">'.$user.'</a> ~ <a href="index.php?action=logout">Logout</a>';
	if ($rank<=0) {
		$menu_right = '<a href="admin/index.php">Admin</a> ~ '.$menu_right;
	}
}

$body_start = '<div class="menu"><div class="left">'.$menu_left.'</div><div class="right">'.$menu_right.'</div></div><div class="container">';

$body_end = '</div>';
?>