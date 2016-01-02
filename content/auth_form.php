<?php
if ($auth_error) {
	echo "<p>$auth_error</p>";
}
?>
<form method='post' action='?section=auth&action=login'>
	<label>Имя пользователя:<br>
		<input type='text' name='username'>
	</label><br>
	<label>Пароль:<br>
		<input type='password' name='password'>
	</label><br>
	<input type='submit' value='Войти' class='btn'>
	<input type='submit' value='Зарегистрироваться' class='btn' formaction='?section=auth&action=registration'>
</form>
