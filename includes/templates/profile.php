<?php
if ($user_id) {
	$user_info = $user->get($user_id);
} else {
	return_back();
}
?>
<div>
	<p>Привет <?=$user_info['username']?></p>
	<p><?=$user_info['info']?></p>
</div>
