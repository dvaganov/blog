<?php
$username = $_POST['username'] ? $_POST['username'] : null;
if ($username != null) {
	if ($auth->login($_POST['username'], $_POST['password'])) {
		$_SESSION['username'] = $username;
		header("Location: ./?section=admin");
	} else {
		$_POST['username'] = null;
	}
}
?>
<form method='post' action='?section=admin'>
<label>Имя пользователя:<br>
<input type='text' name='username'>
</label><br>
<label>Пароль:<br>
<input type='password' name='password'>
</label><br>
<input type='submit' value='Войти' class='btn'>
</form>
