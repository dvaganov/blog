<?php
	$article = $blog->get_article($_GET['id']);
	echo "
\t\t\t<div class='article'>\r
\t\t\t\t<h3>".$article['title']."</h3>\r
\t\t\t\t<p class='date'>Опубликовано: ".$article['date']."</p>\r
\t\t\t\t<p>".$article['content']."</p>\r
\t\t\t</div>\r
	";
?>
