<?php
define('ROOT_DIR', './');

require_once(ROOT_DIR.'preamble.php');
require_once(INCLUDE_DIR.'menu.php');

$section_path = array (
	'' => SECTION_DIR.'articles_list.php',
	'article' => SECTION_DIR.'article.php',
	'admin' => SECTION_DIR.'admin.php',
	'admin_form' => SECTION_DIR.'admin_form.php',
	'auth' => SECTION_DIR.'auth_form.php',
	'profile' => SECTION_DIR.'profile.php'
);

$section_include = $section_path[$section];
?>

<!DOCTYPE html>
<html>
	<head>
<?php include($location.'includes/head.php') ?>
	</head>
<body>
	<div class='container'>
		<h1><?=$blog->get_title()?></h1>
		<nav>
<?php $menu->show() ?>
		</nav>
<?php include($section_include) ?>
		<footer>
			<p>Мой первый блог<br/>Copyright &copy; 2015</p>
		</footer>
	</div>
</body>
</html>
