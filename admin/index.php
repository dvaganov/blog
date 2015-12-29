<?php
	require_once("../preamble.php");

	if (isset($_GET['action'])) {
		$action = $_GET['action'];
	} else {
		$action = null;
	}
	$menu = "\t\t<a href='../'>Главная</a><br>\r";
	if (!$action) {
		$menu .= "\t\t<a href='?action=add'>Добавить статью</a>\r";
		$content = "../content/admin.php";
	} else {
		$menu .= "\t\t<a href='./'>Назад</a>\r";
		if($action == 'add') {
			if(!empty($_POST)) {
				$blog->add_article($_POST['title'], $_POST['date'], $_POST['content']);
				header("Location: ./");
			} else {
				$content = "../content/admin_form.php";
			}
		} else if ($action == 'edit') {
			$id = (int) $_GET['id'];
			if ($id < 1) {
				header("Location: ./");
			} else if (!empty($_POST)) {
				$blog->edit_article($id, $_POST['title'], $_POST['date'], $_POST['content']	);
				header("Location: ./");
			}
			$content = "../content/admin_form.php";
		} else if ($action == 'delete') {
			$id = (int) $_GET['id'];
			$blog->delete_article($id);
			header("Location: ./");
		}
	}

	require_once("../template.php");
?>
