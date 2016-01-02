<?php
if ($_SESSION['username'] == 'admin') {
	if (isset($_GET['id'])) {
		$article = $blog->get_article($_GET['id']);
	}
} else {
	header("Location: ./?section=auth");
}
?>
<div class='form'>
	<form method='post' action='?section=admin&action=<?=$_GET['action']?>&id=<?=$_GET['id']?>'>
		<label>Название<br>
			<input type='text' name='title' value='<?=$article['title']?>' class='form-item' autofocus required>
		</label><br>
		<label>Дата<br>
			<input type='date' name='date' value='<?=$article['date']?>' class='form-item' required>
		</label><br>
		<label>Сожержание<br>
			<textarea name='content' class='form-item' required><?=$article['content']?></textarea>
		</label><br>
		<input type='submit' value='Сохранить' class='btn'>
	</form>
</div>
