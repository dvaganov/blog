<?php
if ($_GET['auth_error']) {
	echo "<p>{$_GET['auth_error']}</p>";
}
?>
<form method='post' action='<?=SCRIPT_DIR.'actions.php?action=login'?>'>
	<table>
		<tr>
			<th>Имя пользователя:</th>
			<th><input type='text' name='username' required></th>
		</tr>
		<tr>
			<th>Пароль:</th>
			<th><input type='password' name='password' required></th>
		</tr>
		<tr>
			<th></th>
			<th><input type='checkbox' name='autologin' checked='checked' value='1'> запомнить</th>
		</tr>
		<tr>
			<th><input type='submit' value='Войти' class='btn'></th>
			<th><input type='submit' value='Зарегистрироваться' class='btn' formaction='<?=SCRIPT_DIR.'actions.php?action=registration'?>'></th>
		</tr>
	</table>
</form>
