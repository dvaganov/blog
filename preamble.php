<?php
ini_set('session.use_strict_mode', 'on');
ini_set('display_errors',1);
date_default_timezone_set('Europe/Moscow');

error_reporting(E_ALL ^E_NOTICE);
// Define directories
define('SCRIPT_DIR', ROOT_DIR.'scripts/');
define('STYLE_DIR', ROOT_DIR.'style/');
define('INCLUDE_DIR', ROOT_DIR.'includes/');
define('CLASS_DIR', INCLUDE_DIR.'class/');
define('SECTION_DIR', INCLUDE_DIR.'section/');
define('TEMPLATE_DIR', INCLUDE_DIR.'templates/');
// Define groups id
define('ADMIN', 1);
define('USER', 100);

$db = new SQLite3(ROOT_DIR.'blog.db');
if ($db == false) {
	header ('Location: ./error.html'); // DB connection error
}

require_once(CLASS_DIR.'session.php');
require_once CLASS_DIR.'user.php';
$user = new User($db);
$user_id = Session\get('user_id');

function return_back() {
	if ($_SERVER['HTTP_REFERER']) {
		header('Location: '.$_SERVER['HTTP_REFERER']);
	} else {
		header('Location: '.ROOT_DIR);
	}
}
?>
