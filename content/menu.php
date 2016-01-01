<?php
$menu = array(
	'home' => array('visible' => false, 'name' => 'Главная', 'href' => './'),
	'admin' => array('visible' => false, 'name' => 'Панель Администратора', 'href' => '?section=admin'),
	'add' => array('visible' => false, 'name' => 'Добавить статью', 'href' => '?section=admin&action=add'),
	'exit' => array('visible' => false, 'name' => 'Выход', 'href' => '?action=exit')
);
function get_menu($menu) {
	$return = '';
	foreach ($menu as $a) {
		if ($a['visible']) {
			$return .= "<a href='".$a['href']."'>".$a['name']."</a><br>";
		}
	}
	return $return;
}
?>
