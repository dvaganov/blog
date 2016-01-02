<?php
$section = isset($_GET['section']) ? $_GET['section'] : null;
$action = isset($_GET['action']) ? $_GET['action'] : null;

require_once('preamble.php');
require_once('modules/auth.php');
require_once('modules/admin.php');
require_once('modules/menu.php');

$content_list = array (
	'' => 'content/articles_list.php',
	'article' => 'content/article.php',
	'admin' => 'content/admin.php',
	'admin_form' => 'content/admin_form.php',
	'auth' => 'content/auth_form.php',
	'profile' => 'content/profile.php'
);

$content = $content_list[$section];

require_once("template.php");
?>
