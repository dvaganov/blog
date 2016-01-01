<?php
	$article = $blog->get_article($_GET['id']);
	echo "
\t\t<div class='form'>
\t\t\t<form method='post' action='?section=admin&action=".$_GET['action']."&id=".$_GET['id']."'>
\t\t\t\t<label>Название<br>
\t\t\t\t<input type='text' name='title' value='".$article['title']."' class='form-item' autofocus required>
\t\t\t\t</label><br>
\t\t\t\t <label>Дата<br>
\t\t\t\t<input type='date' name='date' value='".$article['date']."' class='form-item' required>
\t\t\t\t</label><br>
\t\t\t\t<label>Сожержание<br>
\t\t\t\t<textarea name='content' class='form-item' required>".$article['content']."</textarea>
\t\t\t\t</label><br>
\t\t\t\t<input type='submit' value='Сохранить' class='btn'>
\t\t\t</form>
\t\t</div>
";
?>
