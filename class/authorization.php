<?php
class Authorization {
	private $db;

	public function __construct($db) {
		$this->db = $db;
		if ($_COOKIE['session_start']) {
			session_start();
		}
	}
	public function add_user($username, $password) {
		$result = false;
		$hash = password_hash($password, PASSWORD_BCRYPT);
		if ($hash) {
			if ($this->db) {
				$username = $this->db->escapeString($username);
				$query = "INSERT INTO users (username, hash) VALUES ('$username', '$hash');";
				if ($this->db->exec($query)) {
					$return = true;
				} else {
					echo "<p>".$this->db->lastErrorMsg()."</p>";
				}
			}
		}
		return $return;
	}
	public function get_user_info($username) {
		$result = false;
		if ($this->db) {
			$username = $this->db->escapeString($username);
			$query = "SELECT * FROM users WHERE username = '{$username}';";
			$result = $this->db->query($query);
			if ($result) {
				$return = $result->fetchArray(SQLITE3_ASSOC);
			}
		}
		return $return;
	}
	public function login($username, $password) {
		$result = false;
		if ($this->db) {
			$username = $this->db->escapeString($username);
			$query = "SELECT hash FROM users WHERE username = '{$username}';";
			$result = $this->db->query($query)->fetchArray(SQLITE3_ASSOC);
			if ($result['hash']) {
				if (password_verify($password, $result['hash'])) {
					session_start();
					$_SESSION['username'] = $username;
					setcookie('session_start', true);
					$return = true;
				}
			}
		}
		return $return;
	}
	public function logout() {
		setcookie('session_start', false);
		if (isset($_SESSION['username'])) {
			$_SESSION['username'] = null;
			session_destroy();
		}
	}
}
?>
