<?php
$articles = $blog->list_articles();
foreach($articles as $a) :
?>
<div class='article'>
<a href='?section=article&id=<?=$a['id']?>'><h3><?=$a['title']?></h3></a>
<p class='date'>Опубликовано: <?=$a['date']?></p>
<p><?=Blog::parse($a['content'])[0]?></p>
</div>
<?php
endforeach;
?>
