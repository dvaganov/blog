<?php
class Comments {
	private $db;
	private $date_format;

	public function __construct($db, $date_format = 'd.m.Y H:i T') {
		$this->db = $db;
		$this->date_format = $date_format;
	}
	public function get_all($article_id) {
		$return = false;
		$article_id = (int) $article_id;
		$query = "SELECT comments.id, text, refer_to, timestamp, username FROM comments INNER JOIN users ON comments.user_id = users.id WHERE article_id = '$article_id' ORDER BY timestamp DESC;";
		$result = $this->db->query($query);
		if($result) {
			while (true) {
				$row = $result->fetchArray(SQLITE3_ASSOC);
				if ($row) {
					$row['text'] = htmlentities($row['text']);
					$row['date'] = date($this->date_format, $row['timestamp']);
					$return[] = $row;
				} else {
					break;
				}
			}
		}
		return $return;
	}
	/*public function get($id) {
		$return = false;
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
		return $return;
	}*/
	public function add($text, $article_id, $user_id, $refer_to = null) {
		$return = false;
		$article_id = (int) $article_id;
		$user_id = (int) $user_id;
		$text = $this->db->escapeString(trim($text));
		$time = time();
		if ($text != '') {
			$query = "INSERT INTO comments (text, refer_to, timestamp, article_id, user_id) VALUES ('$text', '$refer_to', '$time', '$article_id', '$user_id');";
			if ($this->db->exec($query)) {
				$return = true;
			}
		}
		return $return;
	}
	/*public function edit($id, $text) {
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
	}*/
	public function delete($id){
		$return = false;
		$id = (int) $id;
		if ($id > 0) {
			$query = "DELETE FROM comments WHERE id = $id;";
			if ($this->db->exec($query)) {
				$return = true;
			}
		}
		return $return;
	}
}
?>
