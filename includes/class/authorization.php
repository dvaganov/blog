<?php
class Authorization {
	private $db;

	public function __construct($db) {
		$this->db = $db;
		if ($_COOKIE['session']) {
			session_start();
			if ($_SESSION['username']) {
				// If session is already exist, check user id.
				if ($_SESSION['user_id'] != md5($_SERVER['HTTP_USER_AGENT'])) {
					$this->logout();
				}
			} else {
				// Else do autologin.
				$this->autologin();
			}
			session_commit();
		}
	}
	private function autologin() {
		$return = false;
		if ($this->db) {
			$result = $this->db->query("SELECT username FROM users WHERE hash = '{$_COOKIE['session']}';");
			$result = gettype($result) === 'object' ? $result->fetchArray(SQLITE3_ASSOC) : $result;
			if ($result['username']) {
				$_SESSION['username'] = $result['username'];
				$_SESSION['user_id'] = md5($_SERVER['HTTP_USER_AGENT']);
				$return = true;
			}
		}
		return $return;
	}
	public function add_user($username, $password) {
		$return = false;
		if ($this->db) {
			$hash = password_hash($password, PASSWORD_BCRYPT);
			if ($hash) {
				$username = $this->db->escapeString($username);
				$query = "INSERT INTO users (username, hash) VALUES ('$username', '$hash');";
				$return = $this->db->exec($query);
			}
		}
		return $return;
	}
	public function get_user_info($username) {
		$return = false;
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
		$return = false;
		if ($this->db) {
			$username = $this->db->escapeString(trim($username));
			$password = trim($password);
			if ($username && $password) {
				$result = $this->db->query("SELECT hash FROM users WHERE username = '{$username}';");
				$result = gettype($result) === 'object' ? $result->fetchArray(SQLITE3_ASSOC) : $result;
				if ($result['hash']) {
					if (password_verify($password, $result['hash'])) {
						$time = $autologin ? time() + 60*60*24*30 : null; // Делаем долгий cookie, если включён автологин.
						setcookie('session', $result['hash'], $time, '/'); // Для запуска сессии при каждом обращении.
						session_start();
						$_SESSION['username'] = $username;
						$_SESSION['user_id'] = md5($_SERVER['HTTP_USER_AGENT']); // От перехвата.
						session_commit();
						$return = true;
					}
				}
			}
		}
		return $return;
	}
	public function logout() {
		setcookie('session', false, -1, '/');
		if (session_start()) {
			session_unset();
			session_destroy();
		}
	}
}
?>
