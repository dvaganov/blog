<?php
require_once("preamble.php");
session_start();

$section = $_GET['section'] ? $_GET['section'] : null;
if ($_GET['action'] == 'exit') {
	session_destroy();
	header("Location: ./");
}

require_once('content/menu.php');
$menu['admin']['visible'] = true;
$menu['home']['visible'] = true;

switch ($section) {
	default:
		$content = "content/all_articles.php";
		$menu['home']['visible'] = false;
		break;
	case 'article':
		$content = "content/article.php";
		break;
	case 'admin':
		if (isset($_SESSION['username'])) {
			$menu['exit']['visible'] = true;
			switch ($_GET['action']) {
				case 'add':
					if (empty($_POST)) {
						$content = "content/admin_form.php";
					} else {
						$blog->add_article($_POST['title'], $_POST['content'], $_POST['date']);
						header("Location: ./?section=admin");
					}
					break;
				case 'edit':
					if (empty($_POST)) {
						$content = "content/admin_form.php";
					} else {
						$blog->edit_article($_GET['id'], $_POST['title'], $_POST['content'], $_POST['date']);
						header("Location: ./?section=admin");
					}
					break;
				case 'delete':
					$blog->delete_article($_GET['id']);
					header("Location: ./?section=admin");
					break;
				default:
					$content = "content/admin.php";
					$menu['admin']['visible'] = false;
					$menu['add']['visible'] = true;
					break;
			}
		} else {
			$menu['admin']['visible'] = false;
			$content = 'content/auth.php';
		}
		break;
}
require_once("template.php");
?>
