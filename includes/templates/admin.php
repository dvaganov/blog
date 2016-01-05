<table class='admin-table'>
	<tr>
		<th>Date</th>
		<th>Title</th>
		<th></th>
		<th></th>
	</tr>
<?php foreach ($article_list as $article) : ?>
	<tr>
		<th><?=$article['date']?></th>
		<th><?=$article['title']?></th>
		<th><a href='<?=ROOT_DIR.'?section=admin_form&id='.$article['id']?>'>Edite</a></th>
		<th><a href='<?=SCRIPT_DIR.'actions.php?action=delete&id='.$article['id']?>'>Delete</a></th>
	</tr>
<?php endforeach; ?>
</table>
