<?php
	$articles = $blog->list_articles();
	echo "
\t\t\t<table class='admin-table'>\r
\t\t\t\t<tr>\r
\t\t\t\t\t<th>Date</th>\r
\t\t\t\t\t<th>Title</th>\r
\t\t\t\t\t<th></th>\r
\t\t\t\t\t<th></th>\r
\t\t\t\t</tr>\r
	";
	foreach ($articles as $a) {
		echo "
\t\t\t\t<tr>\r
\t\t\t\t\t<th>".$a['date']."</th>\r
\t\t\t\t\t<th>".$a['title']."</th>\r
\t\t\t\t\t<th><a href='?section=admin&action=edit&id=".$a['id']."'>Edite</a></th>\r
\t\t\t\t\t<th><a href='?section=admin&action=delete&id=".$a['id']."'>Delete</a></th>\r
\t\t\t\t</tr>\r
		";
	}
	echo "
\t\t\t</table>\r
	";
?>
