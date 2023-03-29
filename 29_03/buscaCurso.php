<?php
$turmas = array(
    "3DSD" => array(
        "34214" => "Pinwoe",
        "4342" => "Unbicei",
        "13231" => "Guarloxi"
    ),
    "3QPD" => array(
        "1233" => "Ponooin",
        "9856" => "Haion",
        "342" => "Calivu"
    )
);

$turma = trim(strtoupper($_GET["turma"]));

if (!isset($turma) || $turma == "" || !in_array($turma, $turmas)) {
    echo "Turma vazia...";
} else {
    echo "<h1>Alunos da turma:" . $turma . "</h1>";
    echo "<table border='1px'>";

    foreach ($turmas[$turma] as $aluno) {
        echo "<tr><td></td><td>$aluno</td></tr>";
    }

    echo "</table>";
}

?>