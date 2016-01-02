<?php
$auth = new Authorization($db);
print_R ($_SESSION['username']);

if ($_SESSION['username'] == null) {
	if ($_POST['username'] != null) {
		if ($action == 'login') {
			if ($auth->login($_POST['username'], $_POST['password'], $_POST['autologin'])) {
				header("Location: ./");
			} else {
				$_POST['username'] = null;
				$auth_error = "Неверно введены логин/пароль.";
			}
		} else if ($action == 'registration') {
			if ($_POST['password'] != null) {
				if ($auth->get_user_info($_POST['username'])) {
					$auth_error = "Аккаунт с таким именем существует.";
				} else {
					$auth->add_user($_POST['username'], $_POST['password']);
					$auth->login($_POST['username'], $_POST['password']);
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
		header('Location: ./');
	}
}
?>
