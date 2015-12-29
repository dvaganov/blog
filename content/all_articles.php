<?php
	$articles = $blog->get_articles();
	foreach($articles as $a) {
		echo "
\t\t\t<div class='article'>\r
\t\t\t\t<a href='?id=".$a['id']."'><h3>".$a['title']."</h3></a>\r
\t\t\t\t<p class='date'>Опубликовано: ".$a['date']."</p>\r
\t\t\t\t<p>".mb_substr($a['content'], 0, 250)."</p>\r
\t\t\t</div>\r
		";
	}
?>
