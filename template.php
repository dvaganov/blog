<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'/>
<title><?=$blog->get_title()?></title>
<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>
<link rel='stylesheet' href='/blog/style.css'>
</head>
<body>
<div class='container'>
<h1><?=$blog->get_title()?></h1>
<?=get_menu($menu)?>
<div>
<?php include($content) ?>
</div>
<footer>
<p>Мой первый блог<br/>Copyright &copy; 2015</p>
</footer>
</div>
</body>
</html>
