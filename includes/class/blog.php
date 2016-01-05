<?php
class Blog {
	private $db;
	private $title;
	private $menu;

	public function __construct($db) {
		$this->db = $db;
		$this->menu = array();
	}
	public function set_title($str) {
		$this->title = $str;
	}
	public function get_title() {
		return $this->title;
	}
	public function add_menu_entry($key, $name, $href, $visible = true) {
		$this->menu[$key] = array(
			'name' => $name,
			'href' => $href,
			'visible' => $visible
		);
	}
	public function set_menu_entry_visible($key, $visible) {
		$this->menu[$key]['visible'] = $visible;
	}
	public function get_menu() {
		return $this->menu;
	}
	public function parse($str) {
		$str_formated = explode("\r\n", $str);
		$tags_pseudo = array ('[b]', '[/b]', '[em]', '[/em]', '[url]', '[/url/]', '[/url]', '[img]', '[/img]');
		$tags_html = array ('<strong>', '</strong>', '<em>', '</em>', '<a href="', '">', '</a>', '<img src="', '">');
		foreach ($str_formated as &$p) {
			$p = str_ireplace($tags_pseudo, $tags_html, $p);
		}
		return $str_formated;
	}
}
?>
