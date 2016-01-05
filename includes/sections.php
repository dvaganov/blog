<?php
$section = isset($_GET['section']) ? $_GET['section'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;

// Menu formation
$blog->add_menu_entry('home', 'Главная', ROOT_DIR);
if ($_SESSION['username'] != null) {
	if ($_SESSION['username'] == 'admin') {
		$blog->add_menu_entry('admin', 'Панель Администратора', ROOT_DIR.'?section=admin');
		$blog->add_menu_entry('add', 'Добавить статью', ROOT_DIR.'?section=admin_form', false);
	}
	$blog->add_menu_entry('profile', 'Профиль', ROOT_DIR.'?section=profile');
	$blog->add_menu_entry('logout', 'Выход', SCRIPT_DIR.'actions.php?action=logout');
} else {
	$blog->add_menu_entry('login', 'Вход/Регистрация', ROOT_DIR.'?section=auth');
}

switch ($section) {
// Authorization & profile section
	case 'auth':
		if ($_SESSION['username'] == null) {
			$section_template = TEMPLATE_DIR.'auth_form.php';
			$blog->set_menu_entry_visible('login', false);
			switch ($_GET['auth_error']) {
				case 1:
					$auth_error = 'Неверный логин/пароль';
					break;
				case 2:
					$auth_error = 'Аккаут с данным именем пользователя уже существует';
					break;
				default:
					$auth_error = null;
					break;
			}
		} else {
			header('Location: '.ROOT_DIR);
		}
		break;
	case 'profile':
		if ($_SESSION['username'] != null) {
			$section_template = TEMPLATE_DIR.'profile.php';
			$user_info = $auth->get_user_info($_SESSION['username']);
		} else {
			header ('Location: '.ROOT_DIR);
		}
		break;
// Admin section
	case 'admin':
		if ($_SESSION['username'] == 'admin') {
			$section_template = TEMPLATE_DIR.'admin.php';
			$blog->set_menu_entry_visible('admin', false);
			$blog->set_menu_entry_visible('add', true);
			require_once(CLASS_DIR.'articles.php');
			$article_list = (new Articles($db))->get_all();
		} else {
			header('Location: '.ROOT_DIR);
		}
		break;
	case 'admin_form':
		if ($_SESSION['username'] == 'admin') {
			$section_template = TEMPLATE_DIR.'admin_form.php';
			if ($id) {
				require_once(CLASS_DIR.'articles.php');
				$article = (new Articles($db))->get($id);
				$form_action = SCRIPT_DIR.'actions.php?action=edit&id='.$id;
				$text = "Редактирование статьи";
				$btn_text = "Редактировать";
			} else {
				$form_action = SCRIPT_DIR.'actions.php?action=add';
				$text = "Добавление статьи";
				$btn_text = "Добавить";
			}
		} else {
			header('Location: '.ROOT_DIR);
		}
		break;
// Articles' section
	case 'article':
		if ($id) {
			$section_template = TEMPLATE_DIR.'article.php';
			// Article section
			require_once(CLASS_DIR.'articles.php');
			$article = (new Articles($db))->get($id);
			$article['content'] = $blog->parse($article['content']);
			// Comments section
			require_once(CLASS_DIR.'comments.php');
			$comment_list = (new Comments($db))->get_all($id);
			switch ($_GET['error_comment']) {
				case 1:
					$error_comment = 'Пустой комментарий';
					break;
				case 2:
					$error_comment = 'Произошла ошибка. Повторите позже.';
					$post_text = $_SESSION['post_text'];
					$auth->unset_session_key('post_text');
					break;
			}
		} else {
			header('Location: '.ROOT_DIR);
		}
		break;
	default:
		$section_template = TEMPLATE_DIR.'article_list.php';
		$blog->set_menu_entry_visible('home', false);
		require_once(CLASS_DIR.'articles.php');
		$article_list = (new Articles($db))->get_all();
		break;
}
$menu = $blog->get_menu();
?>
