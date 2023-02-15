<?php

    $nome = "cotil";
    echo $nome;
    echo "<br><br>";

    unset($nome);

    var_dump($nome);
    echo "<br><br>";

    if(isset($nome)){
        echo $nome;
        echo "<br><br>";
    }
    else{
        echo " a variável está vazia!";
    }

    $valor = 50.5;
    echo $valor;
    echo "<br><br>";

    $aprovado = true;
    echo $aprovado;
    echo "<br><br>";

    $disciplina = array ("30", "LP", "Daw");
    echo $disciplina[2];
    echo "<br><br>";

    define("PI", 3.14);
    define("NOME_ALUNA", "Maria");

    $resultado = PI * 3;
    echo $resultado . "<br><br>";
    echo "Nome do Aluno: " . NOME_ALUNA . "<br><br>";

    echo "<br><br><hr>";
    echo $_SERVER["SERVER_ADDR"] . "<br><br>";
    echo $_SERVER["SERVER_NAME"] . "<br><br>";
    echo $_SERVER["HTTP_USER_AGENT"] . "<br><br>";
    echo $_SERVER["SCRIPT_NAME"] . "<br><br>";

    echo "<hr>";

// -- condição --
    $media = 3.4;
    if ($media >=6) {
        echo "Aluno aprovado";
    } else if (($media >=3) && ($media <= 5)) {
        echo "Dependencia";
    } else {
        echo "reprovado !";
    }
?>