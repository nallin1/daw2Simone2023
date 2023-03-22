<?php
    $exemplo = array("ra"=>1231, "serie"=>3, "aluno"=>array("nome"=>"Guilherme", "sobrenome"=>"Nallin"));
    echo $exemplo["ra"] . "\n" . $exemplo["aluno"]["nome"];
    echo "<br><br>";

    $exemplo2 = array("joaozin", 2131, 22.3);
    print_r($exemplo2);
    echo "<br><br>";
    $exemplo2Sort = sort($exemplo2);
    print_r($exemplo2Sort);

    echo "<br><br>";
    foreach($exemplo2 as $valor) {
        echo $valor . ",";
    }

    function insereDelimitador($valor) {
        return "fruta: " . $valor;
    }
    /*
    
    $exemploMapFrutas = array_map("insereDelimitador()", $frutas);
    echo $exemploMapFrutas;
    */
    echo "<br><br>";
    $frutas = array("Maçã", "Banana", "Laranja");
    $key = array_search("Laranja", $frutas);
    echo $key;

    echo "<br><br>";

    $key = in_array("Banana", $frutas);
    echo $key;

    echo "<br><br>";
    echo array_key_exists(0, $frutas);
?>