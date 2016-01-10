<?php
define('ROOT_DIR', './');
require_once ROOT_DIR.'preamble.php';

require_once CLASS_DIR.'blog.php';
$blog = new Blog($db);
$blog->set_title("My first blog");

$section = isset($_GET['section']) ? $_GET['section'] : null;
$id = isset($_GET['id']) ? $_GET['id'] : null;

$blog->add_menu_entry('home', 'Главная', ROOT_DIR);

// Create menu
if ($user_id) {
	if ($user->hasRights($user_id, ADMIN)) {
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
		$section_template = TEMPLATE_DIR.'auth_form.php';
		$blog->set_menu_entry_visible('login', false);
		break;
	case 'profile':
		$section_template = TEMPLATE_DIR.'profile.php';
		break;
// Admin section
	case 'admin':
		$section_template = TEMPLATE_DIR.'admin.php';
		$blog->set_menu_entry_visible('admin', false);
		$blog->set_menu_entry_visible('add', true);
		break;
	case 'admin_form':
		$section_template = TEMPLATE_DIR.'admin_form.php';
		break;
// Articles' section
	case 'article':
		$section_template = TEMPLATE_DIR.'article.php';
		break;
	default:
		$section_template = TEMPLATE_DIR.'article_list.php';
		$blog->set_menu_entry_visible('home', false);
		break;
}
$menu = $blog->get_menu();

include TEMPLATE_DIR.'main.php';
?>
