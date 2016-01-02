<?php
$menu = new Menu();

switch ($section) {
	case 'admin':
		$menu->add_entry('home', 'Главная', './');
		$menu->add_entry('add', 'Добавить статью', '?section=admin_form&action=add');
		break;
	case 'auth':
		$menu->add_entry('home', 'Главная', './');
		break;
	default:
		$menu->add_entry('home', 'Главная', './');
		$menu->add_entry('admin', 'Панель Администратора', '?section=admin', false);
		break;
}

if ($_SESSION['username'] == null) {
	if ($section != 'auth') {
		$menu->add_entry('login', 'Вход/Регистрация', '?section=auth');
	}
} else {
	$menu->add_entry('profile', 'Профиль', '?section=profile');
	$menu->add_entry('logout', 'Выход', '?action=logout');
	if ($_SESSION['username'] == 'admin') {
		$menu->set_visible('admin', true);
	}
}
?>
