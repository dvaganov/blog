<?php namespace Session;
function set($key, $value) {
	session_start();
	$_SESSION[$key] = $value;
	session_commit();
}
function get($key) {
	session_start();
	return $_SESSION[$key];
	session_commit();
}
function remove($key) {
	session_start();
	unset ($_SESSION[$key]);
	session_commit();
}
function close() {
	if (session_start()) {
		session_unset();
		session_destroy();
	}
}
?>
