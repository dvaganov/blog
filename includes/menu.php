<?php
require_once(CLASS_DIR.'menu.php');
$menu = new Menu();

switch ($section) {
	case 'admin':
		$menu->add_entry('home', 'Главная', ROOT_DIR);
		$menu->add_entry('add', 'Добавить статью', ROOT_DIR.'?section=admin_form');
		break;
	case 'auth':
		$menu->add_entry('home', 'Главная', ROOT_DIR);
		break;
	default:
		$menu->add_entry('home', 'Главная', ROOT_DIR);
		$menu->add_entry('admin', 'Панель Администратора', ROOT_DIR.'?section=admin', false);
		break;
}

if ($_SESSION['username'] == null) {
	if ($section != 'auth') {
		$menu->add_entry('login', 'Вход/Регистрация', ROOT_DIR.'?section=auth');
	}
} else {
	$menu->add_entry('profile', 'Профиль', ROOT_DIR.'?section=profile');
	$menu->add_entry('logout', 'Выход', SCRIPT_DIR.'actions.php?action=logout');
	if ($_SESSION['username'] == 'admin') {
		$menu->set_visible('admin', true);
	}
}
?>
