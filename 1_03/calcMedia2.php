<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <style>
        #aprovado {
            background-color: lime;
        }

        #reprovado {
            background-color: red;
        }
    </style>
    <title>Calcular Media</title>
</head>

<body>
    <h1>:: Calcular Média ::</h1>
    <form method="post">
        Nota 1: <br>
        <input type="number" name="nota1">
        <br><br>

        Nota 2: <br>
        <input type="number" name="nota2">
        <br><br>
        <input type="submit" value="calcular">
    </form>
</body>

</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    function calcMedia($n1, $n2)
    {
        $media = ($n1 + $n2) / 2;
        return $media;
    }

    $n1 = $_REQUEST["nota1"];
    $n2 = $_REQUEST["nota2"];


    $media = calcMedia($n1, $n2);
    echo "Media = " . $media;

    if ((!isset($n1)) || (!isset($n2))) {
        echo "<span id='reprovado'>Informe as duas notas corretamente...</span>";
    } else {
        if ($media >= 6) {
            echo "<span id='aprovado'><br>Aprovado !</span>";
        } else {
            echo " <span id='reprovado'> <br>Reprovado ! </span>";
        }
    }
}
?>