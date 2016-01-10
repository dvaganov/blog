<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8'/>
  <title><?=$blog->get_title()?></title>
  <link rel='stylesheet' href='<?=STYLE_DIR.'bootstrap.min.css'?>'>
  <link rel='stylesheet' href='<?=STYLE_DIR.'style.css'?>'>
</head>
<body>
<div class='container'>
  <h1><?=$blog->get_title()?></h1>
  <nav>
<?php foreach ($menu as $item) : ?>
<?php if ($item['visible']) : ?>
    <a href='<?=$item['href']?>'><?=$item['name']?></a><br>
<?php endif; ?>
<?php endforeach; ?>
  </nav>
<?php include $section_template; ?>
<!--
Footer section
-->
  <footer>
    <p>Мой первый блог<br/>Copyright &copy; 2015</p>
  </footer>
</div>
</body>
</html>
