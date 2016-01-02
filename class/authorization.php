<?php
class Authorization {
	private $db;

	public function __construct($db) {
		$this->db = $db;
		if ($_COOKIE['user_id'] == md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT'])) {
			session_start();
		} else {
			$this->logout();
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
	public function login($username, $password, $autologin = false) {
		$result = false;
		if ($this->db) {
			$username = $this->db->escapeString($username);
			$query = "SELECT hash FROM users WHERE username = '{$username}';";
			$result = $this->db->query($query)->fetchArray(SQLITE3_ASSOC);
			if ($result['hash']) {
				if (password_verify($password, $result['hash'])) {
					$time = $autologin ? time() + 60*60*24*30 : null; // Делаем долгий cookie, если включён автологин.
					setcookie('user_id', md5($_SERVER['REMOTE_ADDR'].$_SERVER['HTTP_USER_AGENT']), $time); // Для надёжной идентификации пользователя
					session_start();
					$_SESSION['username'] = $username;
					$return = true;
				}
			}
		}
		return $return;
	}
	public function logout() {
		setcookie('user_id', false);
		if (session_status() == PHP_SESSION_ACTIVE) {
			session_destroy();
		}
	}
}
?>
