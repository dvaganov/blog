<!-- Article section -->
<article class='article'>
  <h3><?=$article['title']?></h3>
<?php foreach ($article['content'] as $string) : ?>
  <p><?=$string?></p>
<?php endforeach; ?>
  <p class='date'>Опубликовано: <?=$article['date']?></p>
</article>
<!-- Comment section -->
<section class='comment-list'>
<?php if ($error_comment) : ?>
  <p><?=$error_comment?></p>
<?php endif; ?>
<?php if ($_SESSION['username']) : ?>
  <form method='post' action='<?=SCRIPT_DIR.'actions.php?action=add_comment&id='.$_GET['id']?>'>
    <textarea name='text' required><?=$post_text?></textarea>
    <input type='submit' class='btn' value='Отправить'>
  </form>
<?php endif; ?>
<?php if ($comment_list) : ?>
<?php foreach ($comment_list as $comment) : ?>
  <article class='comment'>
    <section class='comment-body'>
<?php $comment['text'] = $blog->parse($comment['text']) ?>
<?php foreach ($comment['text'] as $string) : ?>
      <p><?=$string?></p>
<?php endforeach; ?>
    </section>
    <small>
      <span class='username'><?=$comment['username']?></span><span class='date'><?=$comment['date']?></span>
    </small>
  </article>
<?php endforeach; ?>
<?php endif; ?>
</section>
