<?php
define('ROOT_DIR', '../');
require_once ROOT_DIR.'preamble.php';
require_once CLASS_DIR.'articles.php';
require_once CLASS_DIR.'comments.php';

$action = isset($_GET['action']) ? $_GET['action'] : null;

// For protection: block actions from other groups
if (!$user->hasRights($user_id, ADMIN)) {
	switch ($action) {
		case 'addArticle':
		case 'editArticle':
		case 'deleteArticle':
		case 'deleteComment':
			return_back();
			break;
	}
}

switch ($action) {
// User actions
	case 'addUser':
		if ($user->check($_POST['username'])) {
			header('Location: '.ROOT_DIR.'?section=auth&auth_error=2'); // Account with the username is not empty
		} else {
			$user->add($_POST['username'], $_POST['password']);
			$user->login($_POST['username'], $_POST['password']);
			header('Location: '.ROOT_DIR);
		}
		break;
	case 'login':
		if ($user->login($_POST['username'], $_POST['password'], $_POST['autologin'])) {
			header('Location: '.ROOT_DIR);
		} else {
			header('Location: '.ROOT_DIR.'?section=auth&auth_error=1'); // Incorrect login/password
		}
		break;
	case 'logout':
		$user->logout();
		return_back();
		break;
// Article actions
	case 'addArticle':
		(new Articles($db))->add($_POST['title'], $_POST['content']);
		header('Location: '.ROOT_DIR.'?section=admin');
		break;
	case 'editArticle':
		(new Articles($db))->edit($_GET['id'], $_POST['title'], $_POST['content']);
		header('Location: '.ROOT_DIR.'?section=admin');
		break;
	case 'deleteArticle':
		(new Articles($db))->delete($_GET['id']);
		header('Location: '.ROOT_DIR.'?section=admin');
		break;
// Comments actions
	case 'addComment':
		$result = (new Comments($db))->add($_POST['text'], $_GET['id'], $session->get('user_id'));
		if (!$result) {
			if (trim($_POST['text']) == '') {
				$error_comment = '&error_comment=1'; // Empty comment
			} else {
				$error_comment = '&error_comment=2'; // Error in DataBase
				Session\set('post_text', $_POST['text']);
			}
		}
		header('Location: '.ROOT_DIR.'?section=article&id='.$_GET['id'].$error_comment);
		break;
	case 'deleteComment':
		$result = (new Comments($db))->delete($_GET['comment_id']);
		return_back();
		break;
	case 'editComment':
		break;
}
?>
