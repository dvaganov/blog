<?php
ini_set('session.use_strict_mode', 'on');
ini_set('display_errors',1);
date_default_timezone_set('Europe/Moscow');

error_reporting(E_ALL ^E_NOTICE);

define('STYLE_DIR', ROOT_DIR.'style/');
define('SCRIPT_DIR', ROOT_DIR.'scripts/');
define('INCLUDE_DIR', ROOT_DIR.'includes/');
define('CLASS_DIR', INCLUDE_DIR.'class/');
define('SECTION_DIR', INCLUDE_DIR.'section/');

require_once(CLASS_DIR.'blog.php');
require_once(CLASS_DIR.'authorization.php');

$db = new SQLite3(ROOT_DIR.'blog.db');

$blog = new Blog($db, 'd.m.Y H:i T');
$blog->set_title("My first blog");

$auth = new Authorization($db);

$section = isset($_GET['section']) ? $_GET['section'] : null;
?>
