<?php
if ($_SESSION['username'] == 'admin') {
	$articles = $blog->list_articles();
} else {
	header('Location: '.ROOT_DIR.'?section=auth');
}
?>
<table class='admin-table'>
	<tr>
		<th>Date</th>
		<th>Title</th>
		<th></th>
		<th></th>
	</tr>
<?php foreach ($articles as $a) : ?>
	<tr>
		<th><?=$a['date']?></th>
		<th><?=$a['title']?></th>
		<th><a href='<?=ROOT_DIR.'?section=admin_form&id='.$a['id']?>'>Edite</a></th>
		<th><a href='<?=SCRIPT_DIR.'actions.php?action=delete&id='.$a['id']?>'>Delete</a></th>
	</tr>
<?php endforeach; ?>
</table>
