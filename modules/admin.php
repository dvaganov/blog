<?php
if ($section == 'admin') {
	switch ($action) {
		case 'add':
			if (!empty($_POST)) {
				$blog->add_article($_POST['title'], $_POST['content'], $_POST['date']);
			}
			break;
		case 'edit':
			if (!empty($_POST)) {
				$blog->edit_article($_GET['id'], $_POST['title'], $_POST['content'], $_POST['date']);
			}
			break;
		case 'delete':
			$blog->delete_article($_GET['id']);
			break;
	}
}
?>
