<?php
define('ROOT_DIR', '../');
require_once(ROOT_DIR.'preamble.php');

$action = isset($_GET['action']) ? $_GET['action'] : null;

switch ($action) {
	case 'add':
		$blog->add_article($_POST['title'], $_POST['content']);
		header('Location: '.ROOT_DIR.'?section=admin');
		break;
	case 'edit':
		$blog->edit_article($_GET['id'], $_POST['title'], $_POST['content']);
		header('Location: '.ROOT_DIR.'?section=admin');
		break;
	case 'delete':
		$blog->delete_article($_GET['id']);
		header('Location: '.ROOT_DIR.'?section=admin');
		break;
	case 'login':
		if ($auth->login($_POST['username'], $_POST['password'], $_POST['autologin'])) {
			header('Location: '.ROOT_DIR);
		} else {
			header('Location: '.ROOT_DIR.'?section==auth&auth_error=0'); // Incorrect login/password
		}
		break;
	case 'registration':
		if ($auth->get_user_info($_POST['username'])) {
			header('Location: '.ROOT_DIR.'?section==auth&auth_error=1'); // Account with the username is not empty
		} else {
			$auth->add_user($_POST['username'], $_POST['password']);
			$auth->login($_POST['username'], $_POST['password']);
			header('Location: '.ROOT_DIR);
		}
		break;
	case 'logout':
		$auth->logout();
		header('Location: '.ROOT_DIR);
		break;
}
?>
