<?php
$auth = new Authorization($db);
$username = isset ($_SESSION['username']) ? $_SESSION['username'] : null;

if (!isset($_COOKIE['test'])) {
	$auth_error = "Отключены cookie. Авторизация не будет работать.";
} else {
	if ($username == null) {
		$uname = isset($_POST['username']) ? $_POST['username'] : null;
		if ($uname != null) {
			if ($action == 'login') {
				if ($auth->login($uname, $_POST['password'])) {
					header("Location: ./");
				} else {
					$_POST['username'] = null;
					$auth_error = "Неверно введены логин/пароль.";
				}
			} else if ($action == 'registration') {
				if ($_POST['password'] != null) {
					if ($auth->get_user_info($uname)) {
						$auth_error = "Аккаунт с таким именем существует.";
					} else {
						$auth->add_user($uname, $_POST['password']);
						$auth->login($uname, $_POST['password']);
						header("Location: ./");
					}
				} else {
					$auth_error = "Отсутствует пароль";
				}
			}
		}
	} else {
		if ($action == 'logout') {
			$auth->logout();
			$username = null;
		}
	}
}
?>
