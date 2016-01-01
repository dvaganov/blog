<?php
$article = $blog->get_article($_GET['id']);
?>
<div class='article'>
<h3><?=$article['title']?></h3>
<p class='date'>Опубликовано: <?=$article['date']?></p>
<p><?=$article['content']?></p>
</div>
