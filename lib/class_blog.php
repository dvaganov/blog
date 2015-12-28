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
	public function set_title($str) {
		$this->title = $str;
	}
	public function get_title() {
		return $this->title;
	}
	public function connect() {
		$this->db = new mysqli($this->db_hostname, $this->db_username, $this->db_password, $this->db_database);
		if ($this->db->connect_error) {
			echo "Error: ".$this->db->connect_error;
		}
	}
	public function get_articles() {
		if (!$this->db) {
			echo "No connection to DB";
			return;
		}
		$query = "SELECT * FROM articles ORDER BY id DESC";
		$result = $this->db->query($query);
		if(!$result){
			echo "<p>".$this->db->error."</p>";
		}
		$rows = $result->num_rows;
		$articles = array();
		for ($i = 0; $i < $rows; $i++) {
			//$result->data_seek($i);
			$row = $result->fetch_array(MYSQLI_ASSOC);
			$articles[] = $row;
		}
		return $articles;
	}
}
?>
