<?php
define('ROOT_DIR', '../');
require_once(ROOT_DIR.'preamble.php');
require_once(CLASS_DIR.'articles.php');
require_once(CLASS_DIR.'comments.php');

$action = isset($_GET['action']) ? $_GET['action'] : null;

// For protection: block actions from other groups
if (!$auth->has_rights(ADMIN)) {
	switch ($action) {
		case 'add_article':
		case 'edit_article':
		case 'delete_article':
		case 'delete_comment':
			return_back();
			break;
	}
}

switch ($action) {
// Article actions
	case 'add_article':
		(new Articles($db))->add($_POST['title'], $_POST['content']);
		header('Location: '.ROOT_DIR.'?section=admin');
		break;
	case 'edit_article':
		(new Articles($db))->edit($_GET['id'], $_POST['title'], $_POST['content']);
		header('Location: '.ROOT_DIR.'?section=admin');
		break;
	case 'delete_article':
		(new Articles($db))->delete($_GET['id']);
		header('Location: '.ROOT_DIR.'?section=admin');
		break;
// Authorization actions
	case 'login':
		if ($auth->login($_POST['username'], $_POST['password'], $_POST['autologin'])) {
			header('Location: '.ROOT_DIR);
		} else {
			header('Location: '.ROOT_DIR.'?section=auth&auth_error=1'); // Incorrect login/password
		}
		break;
	case 'add_user':
		if ($auth->get_user_info($_POST['username'])) {
			header('Location: '.ROOT_DIR.'?section=auth&auth_error=2'); // Account with the username is not empty
		} else {
			$auth->add_user($_POST['username'], $_POST['password']);
			$auth->login($_POST['username'], $_POST['password']);
			header('Location: '.ROOT_DIR);
		}
		break;
	case 'logout':
		$auth->logout();
		return_back();
		break;
// Comments actions
	case 'add_comment':
		$result = (new Comments($db))->add($_POST['text'], $_GET['id'], $_SESSION['user_id']);
		if (!$result) {
			if (trim($_POST['text']) == '') {
				$error_comment = '&error_comment=1'; // Empty comment
			} else {
				$error_comment = '&error_comment=2'; // Error in DataBase
				$auth->add_to_session('post_text', $_POST['text']);
			}
		}
		header('Location: '.ROOT_DIR.'?section=article&id='.$_GET['id'].$error_comment);
		break;
	case 'delete_comment':
		$result = (new Comments($db))->delete($_GET['comment_id']);
		return_back();
		break;
}
?>
