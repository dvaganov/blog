<?php
$article = $blog->get_article($_GET['id']);
?>
<div class='article'>
<h3><?=$article['title']?></h3>
<p class='date'>Опубликовано: <?=$article['date']?></p>
<?php foreach ($article['content'] as $p) {
	echo "<p>$p</p>\r";
}
?>
</div>
