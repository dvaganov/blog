<?php
class User {
	private $db;
	private $user_id;
	private $sess_id;

	public function __construct($db) {
		$this->db = $db;
		if ($_COOKIE['sess_id']) {
			$this->user_id = Session\get('user_id');
			$this->sess_id = Session\get('sess_id');
			if ($this->user_id) {
				// If session is already exist, check user id.
				if ($this->sess_id != $_COOKIE['sess_id']) {
					$this->logout(); // Prevent stealing session
				}
			} else {
				$machine = explode('|', $_COOKIE['sess_id'])[0];
				if ($machine == 'm:'.md5($_SERVER['HTTP_USER_AGENT'])) {
					$this->sess_id = $_COOKIE['sess_id'];
					$result = $this->db->query("SELECT user_id FROM session WHERE id = '{$this->sess_id}';");
					$result = gettype($result) === 'object' ? $result->fetchArray(SQLITE3_ASSOC) : $result;
					$this->user_id = $result['user_id'];
					$this->setSessionParams();
				} else {
					$this->logout(); // Prevent stealing cookie
				}
			}
		}
	}
	private function setSessionParams() {
		Session\set('user_id', $this->user_id);
		Session\set('sess_id', $this->sess_id);
	}
	public function add($username, $password) {
		$return = false;
		$hash = password_hash($password, PASSWORD_BCRYPT);
		if ($hash) {
			$username = $this->db->escapeString($username);
			$query = "INSERT INTO users (username, hash) VALUES ('$username', '$hash');";
			$return = $this->db->exec($query);
		}
		return $return;
	}
	public function check($username) {
		$return = false;
		$username = $this->db->escapeString($username);
		$query = "SELECT id FROM users WHERE username = '$username';";
		$result = $this->db->query($query);
		if ($result) {
			$return = true;
		}
		return $return;
	}
	public function getAll() {
	}
	public function delete($user_id) {
	}
	public function get($user_id = null) {
		$return = false;
		if (!$user_id) {
			$user_id = $this->user_id;
		}
		$user_id = (int) $user_id;
		$query = "SELECT * FROM users WHERE id = '$user_id';";
		$result = $this->db->query($query);
		if ($result) {
			$return = $result->fetchArray(SQLITE3_ASSOC);
		}
		return $return;
	}
	public function changeInfo($user_id, $field, $value) {
	}
	public function hasRights($user_id, $group_id) {
		$return = false;
		$result = $this->db->query("SELECT group_id FROM users WHERE id = '$user_id';");
		if ($result) {
			$result = $result->fetchArray(SQLITE3_ASSOC);
			if ($result['group_id'] == ADMIN or $result['group_id'] == $group_id) {
				$return = true;
			}
		}
		return $return;
	}
	public function login($username, $password, $autologin = false) {
		$return = false;
		$username = $this->db->escapeString(trim($username));
		$password = trim($password);
		if ($username && $password) {
			$result = $this->db->query("SELECT * FROM users WHERE username = '$username';");
			$result = gettype($result) === 'object' ? $result->fetchArray(SQLITE3_ASSOC) : $result;
			if ($result['hash']) {
				if (password_verify($password, $result['hash'])) {
					$this->user_id = $result['id'];
					$this->sess_id = 'm:'.md5($_SERVER['HTTP_USER_AGENT']).'|u:'.$this->user_id;
					$time = 0;
					if ($autologin) {
						$time += time() + 60*60*24*30; // If autologin is enable, create long-lived cookie
						$this->db->exec("INSERT INTO session (id, user_id) VALUES ('{$this->sess_id}', '{$this->user_id}');");
					}
					setcookie('sess_id', $this->sess_id, $time, '/'); // Cookie is needed for start session for authorized users
					$this->setSessionParams();
					$return = true;
				}
			}
		}
		return $return;
	}
	public function logout() {
		$this->db->exec("DELETE FROM session WHERE id = '{$this->sess_id}'");
		Session\close();
		setcookie('sess_id', false, -1, '/');
		$this->user_id = $this->sess_id = null;
	}
}
?>
