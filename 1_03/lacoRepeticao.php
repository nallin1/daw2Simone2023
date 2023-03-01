<?php
$n = 1;
$tabuada=7;

while($n<=10) {
    echo $n. "  x " . $tabuada . " = " . ($n*$tabuada) . "<br>";
    $n++;
}

for($n=1; $n<=10; $n++){
    echo $n . " x " . $tabuada . " = " . ($n * $tabuada) . "<br><br>";
}
$cores = array("branco", "verde", "azul", "amarelo");
foreach($cores as $cor) {
    echo $cor . "<br>";
}


?>