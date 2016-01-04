<?php
if ($_SESSION['username'] == 'admin') {
	if (isset($_GET['id'])) {
		$article = $blog->get_article($_GET['id']);
		$form_action = SCRIPT_DIR.'actions.php?action=edit&id='.$_GET['id'];
		$text = "Редактирование статьи";
		$btn_text = "Редактировать";
	} else {
		$form_action = SCRIPT_DIR.'actions.php?action=add';
		$text = "Добавление статьи";
		$btn_text = "Добавить";
	}
} else {
	header('Location: '.ROOT_DIR.'?section=auth');
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
