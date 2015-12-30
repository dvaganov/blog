<?php
	if ($_POST['username'] != null) {
		if ($blog->check_user($_POST['username'], $_POST['password'])) {
			$_SESSION['auth'] = true;
			header("Location: ./?section=admin");
		} else {
			$_POST['username'] = null;
		}
	} else {
		echo
		"
\t\t\t<form method='post' action='?section=admin'>
\t\t\t\t<label>Имя пользователя:<br>
\t\t\t\t\t<input type='text' name='username'>
\t\t\t\t</label><br>
\t\t\t\t<label>Пароль:<br>
\t\t\t\t\t<input type='password' name='password'>
\t\t\t\t</label><br>
\t\t\t\t<input type='submit' value='Войти' class='btn'>
\t\t\t</form>
		";
	}
?>
