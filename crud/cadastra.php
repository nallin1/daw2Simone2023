<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>🐘</title>
    <link rel="stylesheet" href="global.css">
</head>

<body>
    <nav style="display: flex;">
        <ul style="display: flex;">
            <li>🐘</li>
            <li>|</li>
            <li><a href="./index.html">Home</a></li>
        </ul>
    </nav>
    <form method="post">

        RA:
        <input type="text" size="10" name="ra"><br><br>

        Nome:
        <input type="text" size="30" name="nome"><br><br>

        Curso:
        <select name="curso">
            <option></option>
            <option value="Edificações">Edificações</option>
            <option value="Enfermagem">Enfermagem</option>
            <option value="GeoCart">Geodésia e Cartografia</option>
            <option value="Informática">Informática</option>
            <option value="Mecânica">Mecânica</option>
            <option value="Qualidade">Qualidade</option>
        </select><br><br>

        <input type="submit" value="Cadastrar">
    </form>
</body>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    try {
        $ra = $_POST['ra'];
        $nome = $_POST['nome'];
        $curso = $_POST['curso'];

        if (trim($ra) == "" || trim($nome) == "" || trim($curso) == "") {
            echo "Campos vázio !";
        } else {
            include('db_con.php');

            $stmt = $pdo->prepare("SELECT * FROM php_crud WHERE ra = :ra");
            $stmt->bindParam(":ra", $ra);
            $stmt->execute();


            if ($stmt->rowCount() <= 0) {
                $stmt = $pdo->prepare("INSERT INTO php_crud (ra, nome, curso) VALUES (:ra, :nome, :curso)");
                $stmt->bindParam(":ra", $ra);
                $stmt->bindParam(":nome", $nome);
                $stmt->bindParam(":curso", $curso);
                $stmt->execute();

                echo "Aluno cadastrado ! ✔";

            } else {
                echo "O aluno já existe ! ❌";
            }


        }
    } catch (PDOException $e) {
        echo "\nErro: $e";
    }
    $pdo = null;
}

?>