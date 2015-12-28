<?php
	require_once("../database.php");
	require_once("../lib/articles.php");
	
   $link = db_connect();
	$article = article_get($link, $_GET['id']);
?>
<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8"/>
    <title>Мой первый блог</title>    
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
    <link rel="stylesheet" href="../style.css"/>  
  </head>
  <body>
    <div class="container">
      <h1>Мой первый блог</h1>
      <a href="../">Главная</a>
      <div>
			<div class="article">
				<h3><?=$article["title"]?></h3>
				<p class="date">Опубликовано: <?=$article["date"]?></p>
				<p><?=$article["content"] ?></p>
        </div>
      </div>
      <footer>
        <p>Мой первый блог<br/>Copyright &copy; 2015</p>
      </footer>
    </div>
  </body>
</html>