<?php
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
        echo "<span id='aprovado'>Aprovado !</span>";
    } else {
        echo " <span id='reprovado'> Reprovado ! </span>";
    }
}
?>