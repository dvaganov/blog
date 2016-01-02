<!DOCTYPE html>
<html>
	<head>
<?php include('content/head.php') ?>
	</head>
<body>
	<div class='container'>
		<h1><?=$blog->get_title()?></h1>
		<nav>
<?php $menu->show() ?>
		</nav>
<?php include($content) ?>
		<footer>
			<p>Мой первый блог<br/>Copyright &copy; 2015</p>
		</footer>
	</div>
</body>
</html>
