<?php
	require_once("database.php");
	//require_once("lib/articles.php");
	require_once("lib/class_blog.php");

	$blog = new Blog(MYSQL_SERVER, MYSQL_USER, MYSQL_PASSWORD, MYSQL_DB);
	$blog->set_title("My first blog");
	$blog->connect();
	$articles = $blog->get_articles();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<title><?php echo $blog->get_title(); ?></title>
	<link rel="stylesheet" href="style.css"/>
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
</head>
<body>
	<div class="container">
		<h1><?php echo $blog->get_title(); ?></h1>
		<a href="admin">Панель Администратора</a>
		<div>
			<?php foreach($articles as $a): ?>
			<div class="article">
				<a href="article?id=<?php echo $a['id']; ?>"><h3><?php echo $a['title']; ?></h3></a>
				<p class="date">Опубликовано: <?php echo $a['date']; ?></p>
				<p><?php echo $a['content']; ?></p>
			</div>
			<?php endforeach; ?>
		</div>
		<footer>
			<p>Мой первый блог<br/>Copyright &copy; 2015</p>
		</footer>
	</div>
</body>
</html>
