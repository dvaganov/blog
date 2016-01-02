<?php
if ($username != null) {
	$user_info = $auth->get_user_info($username);
} else {
	header ("Location: ./");
}
?>
<div>
	<p>Привет <?=$user_info['username']?></p>
	<p><?=$user_info['info']?></p>
</div>
