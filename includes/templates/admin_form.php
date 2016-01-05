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
