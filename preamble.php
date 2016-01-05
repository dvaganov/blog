<?php
ini_set('session.use_strict_mode', 'on');
ini_set('display_errors',1);
date_default_timezone_set('Europe/Moscow');

error_reporting(E_ALL ^E_NOTICE);

define('SCRIPT_DIR', ROOT_DIR.'scripts/');
define('STYLE_DIR', ROOT_DIR.'style/');
define('INCLUDE_DIR', ROOT_DIR.'includes/');
define('CLASS_DIR', INCLUDE_DIR.'class/');
define('SECTION_DIR', INCLUDE_DIR.'section/');
define('TEMPLATE_DIR', INCLUDE_DIR.'templates/');

require_once(CLASS_DIR.'authorization.php');

$db = new SQLite3(ROOT_DIR.'blog.db');
$auth = new Authorization($db);
?>
