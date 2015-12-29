<?php
class Blog {
	private $db;
	private $title;
	private $db_hostname;
	private $db_username;
	private $db_password;
	private $db_database;

	public function Blog($db_hostname, $db_username, $db_password, $db_database) {
		$this->db_hostname = $db_hostname;
		$this->db_username = $db_username;
		$this->db_password = $db_password;
		$this->db_database = $db_database;
	}
	private function connect() {
		$this->db = new mysqli($this->db_hostname, $this->db_username, $this->db_password, $this->db_database);
		if ($this->db->connect_error) {
			echo "Error: ".$this->db->connect_error;
		}
	}
	private function disconnect() {
		if ($this->db) {
			if ($this->db->close()) {
				$this->db = null;
			} else {
				echo "Can't close database";
			}
		}
	}
	public function set_title($str) {
		$this->title = $str;
	}
	public function get_title() {
		return $this->title;
	}
	public function get_articles() {
		$this->connect();
		$return = null;
		if (!$this->db) {
			echo "No connection to DB";
			$return = false;
		} else {
			$query = "SELECT * FROM articles ORDER BY id DESC";
			$result = $this->db->query($query);
			if(!$result) {
				echo "<p>".$this->db->error."</p>";
				$return = false;
			} else {
				$rows = $result->num_rows;
				$return = array();
				for ($i = 0; $i < $rows; $i++) {
					$row = $result->fetch_array(MYSQLI_ASSOC);
					$return[] = $row;
				}
			}
		}
		$this->disconnect();
		return $return;
	}
	public function get_article ($id) {
		$this->connect();
		$return = null;
		$query = sprintf("SELECT * FROM articles WHERE id=%d", (int)$id);
		$result = $this->db->query($query);
		if(!$result) {
			echo "<p>".$this->db->error."</p>";
			$return = false;
		} else {
			$return = $result->fetch_array(MYSQLI_ASSOC);
		}
		$this->disconnect();
		return $return;
	}
	public function add_article($title, $date, $content) {
		$this->connect();
		$return = null;
		$title = $this->db->real_escape_string(trim($title));
		$date = $this->db->real_escape_string(trim($date));
		$content = $this->db->real_escape_string(trim($content));
		if($title == ''){
			$return = false;
		} else {
			$temp = "INSERT INTO articles (title, date, content) VALUES ('%s', '%s', '%s')";
			$query = sprintf($temp, $title, $date, $content);
			$result = $this->db->query($query);
			if(!$result) {
				echo "<p>".$result->error."</p>";
				$return = false;
			} else {
				$return = true;
			}
		}
		$this->disconnect();
		return $return;
	}
	public function edit_article($id, $title, $date, $content) {
		$this->connect();
		$return = null;
		$title = $this->db->real_escape_string(trim($title));
		$date = $this->db->real_escape_string(trim($date));
		$content = $this->db->real_escape_string(trim($content));
		$id = (int)$id;
		if($title == ''){
			$return = false;
		} else {
			$temp = "UPDATE articles SET title='%s', content='%s', date='%s' WHERE id='%d'";
			$query = sprintf($temp, $title, $content, $date, $id);
			$result = $this->db->query($query);
			if(!$result){
				echo "<p>".$result->error."</p>";
				$return = false;
			} else {
				$return = $this->db->affected_rows;
			}
		}
		$this->disconnect();
		return $return;
	}
	public function delete_article($id){
		$this->connect();
		$return = null;
		$id = (int)$id;
		if ($id < 1) {
			$return = false;
		} else {
			$query = sprintf("DELETE FROM articles WHERE id='%d'", $id);
			$result = $this->db->query($query);

			if (!$result) {
				echo "<p>".$result->error."</p>";
				$return = false;
			}
			$return = $this->db->affected_rows;
		}
		$this->disconnect();
		return $return;
	}
}
?>
