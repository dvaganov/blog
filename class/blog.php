<?php
class Blog {
	private $db;
	private $title;

	public function __construct($db) {
		$this->db = $db;
	}
	public function set_title($str) {
		$this->title = $str;
	}
	public function get_title() {
		return $this->title;
	}
	public function list_articles() {
		$return = false;
		if ($this->db) {
			$query = "SELECT * FROM articles ORDER BY id DESC;";
			$result = $this->db->query($query);
			if($result) {
				while (true) {
					$row = $result->fetchArray(SQLITE3_ASSOC);
					if ($row) {
						foreach ($row as &$item) {
							$item = htmlentities($item);
						}
						$return[] = $row;
					} else {
						break;
					}
				}
			}
		}
		return $return;
	}
	public function get_article ($id) {
		$return = false;
		if ($this->db) {
			$id = (int) $id;
			$query = "SELECT * FROM articles WHERE id='$id';";
			$result = $this->db->query($query);
			if ($result) {
				$return = $result->fetchArray(SQLITE3_ASSOC);
				foreach ($return as &$item) {
					$item = htmlentities($item);
				}
			}
		}
		return $return;
	}
	public function add_article($title, $content, $date) {
		$return = false;
		if ($this->db) {
			$title = $this->db->escapeString(trim($title));
			$content = $this->db->escapeString(trim($content));
			$date = $this->db->escapeString(trim($date));
			if ($title != '') {
				$query = "INSERT INTO articles (title, date, content) VALUES ('$title', '$date', '$content');";
				if ($this->db->exec($query)) {
					$return = true;
				}
			}
		}
		return $return;
	}
	public function edit_article($id, $title, $content, $date) {
		$return = false;
		if ($this->db) {
			$id = (int) $id;
			$title = $this->db->escapeString(trim($title));
			$content = $this->db->escapeString(trim($content));
			$date = $this->db->escapeString(trim($date));
			if ($id > 0 && $title != '') {
				$query = "UPDATE articles SET title='$title', content='$content', date='$date' WHERE id='$id';";
				if ($this->db->exec($query)) {
					$return = true;
				}
			}
		}
		return $return;
	}
	public function delete_article($id){
		$return = false;
		if ($this->db) {
			$id = (int) $id;
			if ($id > 0) {
				$query = "DELETE FROM articles WHERE id = $id;";
				if ($this->db->exec($query)) {
					$return = true;
				}
			}
		}
		return $return;
	}
	static public function parse($str) {
		$str_formated = explode("\r\n", $str);
		$tags_pseudo = array ('[b]', '[/b]', '[em]', '[/em]', '[url]', '[/url/]', '[/url]', '[img]', '[/img]');
		$tags_html = array ('<strong>', '</strong>', '<em>', '</em>', '<a href="', '">', '</a>', '<img src="', '">');
		foreach ($str_formated as &$p) {
			$p = str_ireplace($tags_pseudo, $tags_html, $p);
			$p = "<p>$p</p>\r";
		}
		return $str_formated;
	}
}
?>
