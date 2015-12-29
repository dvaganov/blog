<?php
	require_once("login.php");
	require_once("lib/class_blog.php");

	$blog = new Blog($db_hostname, $db_username, $db_password, $db_database);
	$blog->set_title("My first blog");
?>
