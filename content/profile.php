<?php
if ($_SESSION['username'] != null) {
	$user_info = $auth->get_user_info($_SESSION['username']);
} else {
	header ("Location: ./");
}
?>
<div>
	<p>Привет <?=$user_info['username']?></p>
	<p><?=$user_info['info']?></p>
</div>
