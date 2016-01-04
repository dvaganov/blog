<?php
$article = $blog->get_article($_GET['id']);
$article['content'] = Blog::parse($article['content']);
?>
<div class='article'>
	<h3><?=$article['title']?></h3>
	<p class='date'>Опубликовано: <?=$article['date']?></p>
<?php foreach ($article['content'] as $p) {
	echo "\t".$p;
}
?>
</div>
