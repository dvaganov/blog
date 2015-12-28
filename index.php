<?php
	require_once("database.php");
	require_once("lib/articles.php");

   $link = db_connect();
	$articles = article_all($link);
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Мой первый блог</title>
    <link rel="stylesheet" href="style.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
 </head>
<body>
    <div class="container">
        <h1>Мой первый блог</h1>
        <a href="admin">Панель Администратора</a>
        <div>
            <?php foreach($articles as $a): ?>
            <div class="article">
                <h3><a href="article/?id=<?=$a["id"] ?>"><?=$a["title"] ?></a></h3>
                <p class="date">Опубликовано: <?=$a["date"] ?></p>
                <p><?=article_intro($a["content"]) ?></p>
            </div>
            <?php endforeach; ?>
        </div>
        <footer>
            <p>Мой первый блог<br/>Copyright &copy; 2015</p>
        </footer>
    </div>
</body>
</html>
