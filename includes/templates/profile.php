<?php
if ($auth->has_rights(USER)) {
	$user_info = $auth->get_user_info($_SESSION['username']);
} else {
	header ('Location: '.ROOT_DIR);
}
?>
<div>
	<p>Привет <?=$user_info['username']?></p>
	<p><?=$user_info['info']?></p>
</div>
