<?php
	echo "
<!DOCTYPE html>\r
<html>\r
<head>\r
\t<meta charset='utf-8'/>\r
\t<title>".$blog->get_title()."</title>\r
\t<link rel='stylesheet' href='https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css'>\r
\t<link rel='stylesheet' href='/blog/style.css'>\r
</head>\r
<body>\r
\t<div class='container'>\r
\t\t<h1>".$blog->get_title()."</h1>\r
".get_menu($menu)."
\t\t<div>\r
	";
	include($content);
	echo "
\t\t</div>\r
\t\t<footer>\r
\t\t\t<p>Мой первый блог<br/>Copyright &copy; 2015</p>\r
\t\t</footer>\r
\t</div>\r
</body>\r
</html>
	";
?>
