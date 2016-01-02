<?php
class Menu {
	private $menu;

	public function __construct() {
		$this->menu = array();
	}
	public function add_entry($key, $name, $href, $visible = true) {
		$this->menu[$key] = array(
			'name' => $name,
			'href' => $href,
			'visible' => $visible
		);
	}
	public function set_visible($key, $visible) {
		$this->menu[$key]['visible'] = $visible;
	}
	public function show() {
		foreach ($this->menu as $a) {
			if ($a['visible']) {
				echo "\t\t\t<a href='".$a['href']."'>".$a['name']."</a><br>\r";
			}
		}
	}
}
?>
