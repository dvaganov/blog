<?php
if ($auth_error) {
	echo "<p>$auth_error</p>";
}
?>
<form method='post' action='?section=auth&action=login'>
	<table>
		<tr>
			<th>Имя пользователя:</th>
			<th><input type='text' name='username'></th>
		</tr>
		<tr>
			<th>Пароль:</th>
			<th><input type='password' name='password'></th>
		</tr>
		<tr>
			<th></th>
			<th><input type='checkbox' name='autologin' checked='checked' value='1'> Запомнить</th>
		</tr>
		<tr>
			<th><input type='submit' value='Войти' class='btn'></th>
			<th><input type='submit' value='Зарегистрироваться' class='btn' formaction='?section=auth&action=registration'></th>
		</tr>
	</table>
</form>
