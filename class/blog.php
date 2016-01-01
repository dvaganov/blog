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
						$row['content'] = explode("\r\n", $row['content']);
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
			if($result) {
				$return = $result->fetchArray(SQLITE3_ASSOC);
				$return['content'] = explode("\r\n", $return['content']);
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
				$result = $this->db->exec($query);
				if ($result) {
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
				$result = $this->db->query($query);
				if($result) {
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
				$result = $this->db->exec($query);
				if ($result) {
					$return = true;
				}
			}
		}
		return $return;
	}
}
?>
