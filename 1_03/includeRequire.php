<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Include & Require</title>
</head>
<body>
    <?php require("menu.html") ?>
    <br><hr>
    <?php include("menu.html") ?>

    <form action="calcMedia.php" method="get">
        Nota 1: <br>
        <input type="text" name="nota1">
        <br><br>

        Nota 2: <br>
        <input type="text" name="nota2">
        <br><br>
    </form>

</body>
</html>