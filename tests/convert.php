<?php // convert.php
$f = $c = NULL;
if (isset($_POST['f'])) {
	$f = sanitizeString($_POST['f']);
}
if (isset($_POST['c'])) {
	$c = sanitizeString($_POST['c']);
}
if ($f != '') {
	$c = intval((5 / 9)* ($f - 32));
	$out = $f."°F равно ".$c."°C";
} elseif($c != '') {
	$f = intval((9 / 5) * $c + 32);
	$out = $c."°C равно ".$f."°F";
} else {
	$out = NULL;
}
echo <<<_END
<!DOCTYPE html>
<html>
	<head>
		<title>Программа перевода температуры</title>
	</head>
	<body>
		<pre>
			Введите температуру по Фаренгейту или по Цельсию и нажмите кнопку Перевести
			<b>$out</b>
			<form method="post" action="convert.php">
				По Фаренгейту <input type="text" name="f" size="7" placeholder='Temp'>
				По Цельсию <input type="text" name="c" size="7">
				<input type="submit" value="Перевести">
			</form>
			Выберите цвет <input type='color' name='color'>
			<input type='number' name='age'>
			<input type='range' name='num' min='0' max='100' value='50' step='1'>
		</pre>
	</body>
</html>
_END;

function sanitizeString($var) {
	$var = stripslashes($var);
	$var = htmlentities($var);
	$var = strip_tags($var);
	return $var;
}
?>
