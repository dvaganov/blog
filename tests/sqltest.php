<?php // sqltest.php
require_once 'login.php';

$db_connection = new mysqli($db_hostname, $db_username, $db_password, $db_database);
if ($db_connection->connect_error) die($db_connection->connect_error);

if (isset($_POST['delete']) && isset($_POST['isbn'])) {
	$isbn = get_post('isbn');
	$query = "DELETE FROM classics WHERE isbn='$isbn'";
	if (!$db_connection->query($query)) {
		echo "Сбой при удалении данных: $query<br>".$db_connection->error."<br><br>";
	}
}
if (isset($_POST['author']) && isset($_POST['title']) && isset($_POST['category']) && isset($_POST['year']) && isset($_POST['isbn'])) {
	$author = get_post('author');
	$title = get_post('title');
	$category = get_post('category');
	$year = get_post('year');
	$isbn = get_post('isbn');
	$query = "INSERT INTO classics VALUES"."('$author', '$title', '$category', '$year', '$isbn')";
	if (!$db_connection->query($query)) {
		echo "Сбой при вставке данных: $query<br>".$db_connection->error."<br><br>";
	}
}
echo <<< _END
	<form action="sqltest.php" method="post">
		<pre>
			Author <input type="text" name="author">
			Title <input type="text" name="title">
			Category <input type="text" name="category">
			Year <input type="text" name="year">
			ISBN <input type="text" name="isbn">
			<input type="submit" value="ADD RECORD">
		</pre>
	</form>

_END;

$query = "SELECT * FROM classics";
$result = $db_connection->query($query);
if (!$result) die ("Сбой при доступе к базе данных: ".$db_connection->error());

$rows = $result->num_rows;

for ($i = 0 ; $i < $rows ; $i++) {
	$result->data_seek($i);
	$row = $result->fetch_array(MYSQLI_NUM);
	echo <<< _END
	<pre>
		Author $row[0]
		Title $row[1]
		Category $row[2]
		Year $row[3]
		ISBN $row[4]
	</pre>
	<form action="sqltest.php" method="post">
		<input type="hidden" name="delete" value="yes">
		<input type="hidden" name="isbn" value="$row[4]">
		<input type="submit" value="DELETE RECORD">
	</form>
_END;
}

$result->close();
$db_connection->close();

function get_post($var)
{
	return $db_connection->real_escape_string($_POST[$var]);
}
?>
