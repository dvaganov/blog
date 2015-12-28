<?php // query.php
	require_once 'login.php';

	$db_server = mysql_connect($db_hostname, $db_username, $db_password);
	if (!$db_server) die("Невозможно подключиться к MySQL: " . mysql_error());

	mysql_select_db($db_database)
	or die("Невозможно выбрать базу данных: ".mysql_error());

	$query = "SELECT * FROM classics";
	$result = mysql_query($query);
	if (!$result) die ("Сбой при доступе к базе данных: ".mysql_error());

	$rows = mysql_num_rows($result);
	for ($j = 0 ; $j < $rows ; ++$j)
	{
		$row = mysql_fetch_row($result);
		echo 'Author: '.$row[0]."<br>";
		echo 'Title: '.$row[1]."<br>";
		echo 'Category: '.$row[2]."<br>";
		echo 'Year: '.$row[3]."<br>";
		echo 'ISBN: '.$row[4]."<br><br>";
	}
?>
