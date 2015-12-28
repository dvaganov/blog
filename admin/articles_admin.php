<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8"/>
    <title>Мой первый блог</title>
    <link rel="stylesheet" href="../style.css"/>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css"/>
 </head>
<body>
    <div class="container">
        <h1>Мой первый блог</h1>
        <a href="../">Home</a><br>
        <a href="./?action=add">Add article</a>
        <div>
            <table class="admin-table">
                <tr>
                    <th>Date</th>
                    <th>Title</th>
                    <th></th>
                    <th></th>
                </tr>
                <?php foreach($articles as $a): ?>
                <tr>
                    <th><?=$a['date']?></th>
                    <th><?=$a['title']?></th>
                    <th><a href="./?action=edit&id=<?=$a['id'] ?>">Edite</a></th>
                    <th><a href="./?action=delete&id=<?=$a['id'] ?>">Delete</a></th>
                </tr>
                <?php endforeach; ?>
            </table>
        </div>
        <footer>
            <p>Мой первый блог<br/>Copyright &copy; 2015</p>
        </footer>
    </div>
</body>
</html>