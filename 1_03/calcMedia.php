<?php
    function calcMedia($n1, $n2) {
        $media = ($n1 + $n2)/2;
        return $media;
    }
    
    $n1 = $_REQUEST["nota1"];
    $n2 = $_REQUEST["nota2"];

    
    $media = calcMedia($n1, $n2);
    echo "Media = " . $media;
    if ($media >= 6) {
        echo "Aprovado !";
    } else {
        echo "Reprovado !";
    }
?>