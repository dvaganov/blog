<?php
class Authorization {
	private $db;

	public function __construct($db) {
		$this->db = $db;
	}
	public function add_user($username, $password) {
		$result = false;
		$hash = password_hash($password, PASSWORD_BCRYPT);
		if ($hash) {
			if ($this->db) {
				$username = $this->db->escapeString($username);
				$query = "INSERT INTO users (username, hash) VALUES ('$username', '$hash');";
				$result = $this->db->query($query);
				if (!$result) {
					echo "<p>".$result->error."</p>";
				} else {
					$return = true;
				}
			}
		}
		return $return;
	}
	public function login($username, $password) {
		$result = false;
		if ($this->db) {
			$username = $this->db->escapeString($username);
			$query = "SELECT hash FROM users WHERE username='$username';";
			$result = $this->db->query($query);
			if ($result) {
				if (password_verify($password, $result)) {
					$return = true;
				}
			} else {
				echo "<p>".$result->error."</p>";
			}
		}
		return $result;
	}
	public function create_session($username) {
		$_SESSION['username'] = $username;
	}
}
?>
