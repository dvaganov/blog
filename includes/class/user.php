<?php
class User {
	private $db;

	public function __construct($db) {
		$this->db = $db;
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
	public function get($user_id) {
		$return = false;
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
}
?>
