<?php
define('ROOT_DIR', './');
require_once ROOT_DIR.'preamble.php';

require_once CLASS_DIR.'blog.php';
$blog = new Blog($db);
$blog->set_title("My first blog");

require_once INCLUDE_DIR.'sections.php';

include TEMPLATE_DIR.'main.php';
?>
