<?php
ini_set('display_errors',1);
error_reporting(E_ALL ^E_NOTICE);

require_once("class/blog.php");
require_once("class/authorization.php");
require_once('class/menu.php');

$db = new SQLite3('blog.db');

$blog = new Blog($db);
$blog->set_title("My first blog");
?>
