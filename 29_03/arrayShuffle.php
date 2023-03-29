<?php

$exemplo = array("ra" => 1231, "serie" => 3, "aluno" => array("nome" => "Guilherme", "sobrenome" => "Nallin"));
echo $exemplo["ra"] . "\n" . $exemplo["aluno"]["nome"];
echo "<br><br>";

$exemploEmbaralhado = shuffle($exemplo);
echo $exemploEmbaralhado;

$exemploEmbaralhadoReverso = rsort($exemplo);

$str = "curso=enfermagem&nome=guilherme&idade=25";
parse_str($str, $curso);
print_r($curso);