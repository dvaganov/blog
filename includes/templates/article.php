<?php
if ($id) {
	// Article section
	require_once(CLASS_DIR.'articles.php');
	$article = (new Articles($db))->get($id);
	$article['content'] = $blog->parse($article['content']);

	// Comments section
	require_once(CLASS_DIR.'comments.php');
	$comment_list = (new Comments($db))->get_all($id);

	// Comment's error handle
	switch ($_GET['error_comment']) {
		case 1:
			$error_comment = 'Пустой комментарий';
			break;
		case 2:
			$error_comment = 'Произошла ошибка. Повторите позже.';
			$comment_text = $session->get('post_text');
			Session\remove('post_text');
			break;
	}
} else {
	return_back();
}
?>
<!--
Article section
-->
<article class='article'>
  <h3><?=$article['title']?></h3>
<?php foreach ($article['content'] as $string) : ?>
  <p><?=$string?></p>
<?php endforeach; ?>
  <p class='date'>Опубликовано: <?=$article['date']?></p>
</article>
<!--
Comment section
-->
<div class='comment-list'>
<?php
// Error message
if ($error_comment) {
	echo '  <p>'.$error_comment.'</p>';
}
// Comment's form
if ($user_id) {
	$comment_form_action = SCRIPT_DIR.'actions.php?action=addComment&id='.$id;
	$comment_btn_value = 'Отправить';
include TEMPLATE_DIR.'comments/form.php';
}
// Comment's view
if ($comment_list) {
	foreach ($comment_list as $comment) {
	// Make comment editable by admin
		if ($user->hasRights($user_id, ADMIN) and $_GET['comment_id'] == $comment['id']) {
			$comment_form_action = SCRIPT_DIR.'actions.php?action=editComment&comment_id='.$comment['id'];
			$comment_text = $comment['text'];
			$comment_btn_value = 'Изменить';
include TEMPLATE_DIR.'comments/form.php';
		// Else as usual
		} else {
		$comment['text'] = $blog->parse($comment['text']);
include TEMPLATE_DIR.'comments/view.php';
		}
	}
}
?>
</div>
