<?php
class Authorization {
	private $db;

	public function __construct($db) {
		$this->db = $db;
		if ($_COOKIE['session']) {
			session_start();
			if ($_SESSION['user_id']) {
				// If session is already exist, check user id.
				if ($_SESSION['hash'] != md5($_SERVER['HTTP_USER_AGENT'])) {
					$this->logout();
				}
			} else {
				// Else do autologin. If faild - delete cookie;
				if (!$this->autologin()) {
					$this->logout();
				};
			}
			session_commit();
		}
	}
	private function autologin() {
		$return = false;
		$result = $this->db->query("SELECT users.id, group_id FROM session INNER JOIN users ON user_id = users.id WHERE session.id = '{$_COOKIE['session']}';");
		$result = gettype($result) === 'object' ? $result->fetchArray(SQLITE3_ASSOC) : $result;
		if ($result['id']) {
			$_SESSION['user_id'] = $result['id'];
			$_SESSION['group_id'] = $result['group_id'];
			$_SESSION['hash'] = $_COOKIE['session'];
			$return = true;
		}
		return $return;
	}
	public function add_user($username, $password) {
		$return = false;
		$hash = password_hash($password, PASSWORD_BCRYPT);
		if ($hash) {
			$username = $this->db->escapeString($username);
			$query = "INSERT INTO users (username, hash) VALUES ('$username', '$hash');";
			$return = $this->db->exec($query);
		}
		return $return;
	}
	public function get_user_info($username) {
		$return = false;
		$username = $this->db->escapeString($username);
		$query = "SELECT * FROM users WHERE username = '{$username}';";
		$result = $this->db->query($query);
		if ($result) {
			$return = $result->fetchArray(SQLITE3_ASSOC);
		}
		return $return;
	}
	public function login($username, $password, $autologin = false) {
		$return = false;
		$username = $this->db->escapeString(trim($username));
		$password = trim($password);
		if ($username && $password) {
			$result = $this->db->query("SELECT * FROM users WHERE username = '{$username}';");
			$result = gettype($result) === 'object' ? $result->fetchArray(SQLITE3_ASSOC) : $result;
			if ($result['hash']) {
				if (password_verify($password, $result['hash'])) {
					$hash = md5($_SERVER['HTTP_USER_AGENT']);
					$time = 0;
					if ($autologin) {
						$time += time() + 60*60*24*30; // If autologin is enable, create long-lived cookie
						$this->db->exec("INSERT INTO session (id, user_id) VALUES ('$hash', '{$result['id']}');");
					}
					setcookie('session', $hash, $time, '/'); // Cookie is needed for start session for authorized users
					session_start();
					$_SESSION['user_id'] = $result['id'];
					$_SESSION['group_id'] = $result['group_id'];
					$_SESSION['hash'] = $hash; // For safety
					session_commit();
					$return = true;
				}
			}
		}
		return $return;
	}
	public function logout() {
		$this->db->exec("DELETE FROM session WHERE id = '{$_SESSION['hash']}'");
		if (session_start()) {
			session_unset();
			session_destroy();
		}
		setcookie('session', false, -1, '/');
	}
	public function add_to_session($key, $value) {
		session_start();
		$_SESSION[$key] = $value;
		session_commit();
	}
	public function unset_session_key($key) {
		session_start();
		unset ($_SESSION[$key]);
		session_commit();
	}
	public function has_rights($group_id) {
		if ($_SESSION['group_id'] == ADMIN or $_SESSION['group_id'] == $group_id) {
			$return = true;
		} else {
			$return = false;
		}
		return $return;
	}
}
?>
