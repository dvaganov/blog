<?php
require_once(CLASS_DIR.'articles.php');
$article_list = (new Articles($db))->get_all();
?>
<?php foreach($article_list as $article) : ?>
<div class='article'>
  <a href='<?=ROOT_DIR.'?section=article&id='.$article['id']?>'><h3><?=$article['title']?></h3></a>
  <?=$blog->parse($article['content'])[0]?>
  <p class='date'>Опубликовано: <?=$article['date']?></p>
</div>
<?php endforeach; ?>
