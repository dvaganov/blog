<?php
	require_once("preamble.php");

	$menu = "\t\t<a href='admin'>Панель Администратора</a>\r";
	if (isset($_GET['id'])) {
		$menu .= "\t\t<br><a href=\"./\">Главная</a>\n";
	}

	if (!isset($_GET['id'])) {
		$content = "content/all_articles.php";
	} else {
		$content = "content/article.php";
	}
	require_once("template.php");
?>
