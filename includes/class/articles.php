<?php
class Articles {
	private $db;
	private $date_format;

	public function __construct($db, $date_format = 'd.m.Y H:i T') {
		$this->db = $db;
		$this->date_format = $date_format;
	}
	public function get_all() {
		$return = false;
		$query = "SELECT * FROM articles ORDER BY timestamp DESC;";
		$result = $this->db->query($query);
		if($result) {
			while (true) {
				$row = $result->fetchArray(SQLITE3_ASSOC);
				if ($row) {
					foreach ($row as &$item) {
						$item = htmlentities($item);
					}
					$row['date'] = date($this->date_format, $row['timestamp']);
					$return[] = $row;
				} else {
					break;
				}
			}
		}
		return $return;
	}
	public function get($id) {
		$return = false;
		$id = (int) $id;
		$query = "SELECT * FROM articles WHERE id='$id';";
		$result = $this->db->query($query);
		if ($result) {
			$return = $result->fetchArray(SQLITE3_ASSOC);
			foreach ($return as &$item) {
				$item = htmlentities($item);
			}
			$return['date'] = date($this->date_format, $return['timestamp']);
		}
		return $return;
	}
	public function add($title, $content) {
		$return = false;
		$title = $this->db->escapeString(trim($title));
		$content = $this->db->escapeString(trim($content));
		if ($title != '') {
			$query = "INSERT INTO articles (title, content, timestamp) VALUES ('$title', '$content', '".time()."');";
			if ($this->db->exec($query)) {
				$return = true;
			}
		}
		return $return;
	}
	public function edit($id, $title, $content) {
		$return = false;
		$id = (int) $id;
		$title = $this->db->escapeString(trim($title));
		$content = $this->db->escapeString(trim($content));
		if ($id > 0 && $title != '') {
			$query = "UPDATE articles SET title='$title', content='$content', timestamp='".time()."' WHERE id='$id';";
			if ($this->db->exec($query)) {
				$return = true;
			}
		}
		return $return;
	}
	public function delete($id){
		$return = false;
		$id = (int) $id;
		if ($id > 0) {
			$query = "DELETE FROM articles WHERE id = $id;";
			if ($this->db->exec($query)) {
				$return = true;
			}
		}
		return $return;
	}
}
?>
