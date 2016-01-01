<?php
require_once("class/blog.php");
require_once("class/authorization.php");

$db = new SQLite3('blog.db');

$blog = new Blog($db);
$blog->set_title("My first blog");

$auth = new Authorization($db);
?>
