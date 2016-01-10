<?php // $comment_form_action, $comment_text, $comment_btn_value ?>
<form method='post' action='<?=$comment_form_action?>'>
  <textarea name='text' required><?=$comment_text?></textarea>
  <input type='submit' class='btn' value='<?=$comment_btn_value?>'>
</form>
