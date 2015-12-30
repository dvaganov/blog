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
	private function safe_string($str) {
		if ($this->db) {
			$str = htmlentities($str);
			$str = $this->db->real_escape_string(trim($str));
		} else {
			$str = '';
		}
		return $str;
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
		$title = $this->safe_string($title);
		$date = $this->safe_string($date);
		$content = $this->safe_string($content);
		if ($title != '') {
			$query = "INSERT INTO articles (title, date, content) VALUES ('$title', '$date', '$content')";
			$result = $this->db->query($query);
			if (!$result) {
				echo "<p>".$result->error."</p>";
				$return = false;
			} else {
				$return = true;
			}
		} else {
			$return = false;
		}
		$this->disconnect();
		return $return;
	}
	public function edit_article($id, $title, $date, $content) {
		$this->connect();
		$return = null;
		$title = $this->safe_string($title);
		$date = $this->safe_string($date);
		$content = $this->safe_string($content);
		$id = (int) $id;
		if ($id > 0 && $title != '') {
			$query = "UPDATE articles SET title='$title', content='$content', date='$date' WHERE id='$id'";
			$result = $this->db->query($query);
			if(!$result){
				echo "<p>".$result->error."</p>";
				$return = false;
			} else {
				$return = $this->db->affected_rows;
			}
		} else {
			$return = false;
		}
		$this->disconnect();
		return $return;
	}
	public function delete_article($id){
		$this->connect();
		$return = null;
		$id = (int) $id;
		if ($id > 0) {
			$query = "DELETE FROM articles WHERE id='$id'";
			$result = $this->db->query($query);
			if (!$result) {
				echo "<p>".$result->error."</p>";
				$return = false;
			}
			$return = $this->db->affected_rows;
		} else {
			$return = false;
		}
		$this->disconnect();
		return $return;
	}
	public function check_user($uname, $password) {
		$this->connect();
		$result = false;
		$uname = $this->safe_string($uname);
		$salt1 = 'Dw43@';
		$salt2 = 'dfKle';
		$token = hash('ripemd128', "$salt1$uname$salt2");
		$query = "SELECT password FROM users WHERE username='$uname'";
		$result = $this->db->query($query);
		if (!$result) {
			echo "<p>".$result->error."</p>";
		} else {
			if ($result == $token) {
				$return = true;
			}
		}
		$this->disconnect();
		return $result;
	}
	/*public function add_user($uname, $password) {
		$this->connect();
		$result = false;
		$uname = $this->safe_string($uname);
		$salt1 = 'Dw43@';
		$salt2 = 'dfKle';
		$token = hash('ripemd128', "$salt1$uname$salt2");
		$query = "INSERT INTO users (username, password) VALUES ('$uname', '$token')";
		$result = $this->db->query($query);
		if (!$result) {
			echo "<p>".$result->error."</p>";
		} else {
			$return = true;
		}
		$this->disconnect();
		return $result;
	}*/
}
?>
