<?php
class Blog {
	private $db;
	private $title;
	private $timedate_format;

	public function __construct($db, $timedate_format) {
		$this->db = $db;
		$this->timedate_format = $timedate_format;
	}
	public function set_title($str) {
		$this->title = $str;
	}
	public function get_title() {
		return $this->title;
	}
	public function get_db_error() {
		return $this->db->lastErrorMsg();
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
						$row['date'] = date($this->timedate_format, $row['timestamp']);
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
				$return['date'] = date($this->timedate_format, $return['timestamp']);
			}
		}
		return $return;
	}
	public function add_article($title, $content) {
		$return = false;
		if ($this->db) {
			$title = $this->db->escapeString(trim($title));
			$content = $this->db->escapeString(trim($content));
			if ($title != '') {
				$query = "INSERT INTO articles (title, content, timestamp) VALUES ('$title', '$content', '".time()."');";
				if ($this->db->exec($query)) {
					$return = true;
				}
			}
		}
		return $return;
	}
	public function edit_article($id, $title, $content) {
		$return = false;
		if ($this->db) {
			$id = (int) $id;
			$title = $this->db->escapeString(trim($title));
			$content = $this->db->escapeString(trim($content));
			if ($id > 0 && $title != '') {
				$query = "UPDATE articles SET title='$title', content='$content', timestamp='".time()."' WHERE id='$id';";
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
