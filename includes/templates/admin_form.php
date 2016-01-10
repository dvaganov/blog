<?php
if ($user->hasRights($user_id, ADMIN)) {
	if ($id) {
		require_once(CLASS_DIR.'articles.php');
		$article = (new Articles($db))->get($id);
		$form_action = SCRIPT_DIR.'actions.php?action=editArticle&id='.$id;
		$text = "Редактирование статьи";
		$btn_text = "Редактировать";
	} else {
		$form_action = SCRIPT_DIR.'actions.php?action=addArticle';
		$text = "Добавление статьи";
		$btn_text = "Добавить";
	}
} else {
	return_back();
}
?>
<div class='form'>
  <h5><?=$text?></h5>
  <form method='post' action='<?=$form_action?>'>
    <label>Название<br>
      <input type='text' name='title' value='<?=$article['title']?>' class='form-item' autofocus required>
    </label><br>
    <label>Сожержание<br>
      <textarea name='content' class='form-item' required><?=$article['content']?></textarea>
    </label><br>
    <input type='submit' value='<?=$btn_text?>' class='btn'>
  </form>
</div>
