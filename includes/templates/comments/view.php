<?php // $comment[] ?>
<article class='comment'>
  <h5><strong><?=$comment['username']?></strong>: ответ на комментарий</h5>
  <div class='comment-body'>
<?php foreach ($comment['text'] as $string) : ?>
    <p><?=$string?></p>
<?php endforeach; ?>
  </div>
  <footer>
    <small>
      <a href='<?=$_SERVER['REQUEST_URI'].'&refer_to='.$comment['id']?>'>[ Ответить ]</a>
<?php if ($auth->has_rights(ADMIN)) : // Enable edit/delete refs ?>
      <a href='<?=ROOT_DIR.'?section=article&id='.$id.'&comment_id='.$comment['id']?>'>[ Редактировать ]</a>
      <a href='<?=SCRIPT_DIR.'actions.php?action=delete_comment&comment_id='.$comment['id']?>'>[ Удалить ]</a>
<?php endif; ?>
    </small>
    <span class='date'><?=$comment['date']?></span>
  </footer>
</article>
