<?php
function cadastrarFlor($nome, $especie, $altura, $peso, $categoria, $foto)
{
    include("conexaoBD.php");

    // Constante para o tam máximo de arquivo de foto
    define('TAMANHO_MAXIMO', (2 * 1024 * 1024));

    $upload_dir = 'img/';

    $nome_foto = $foto['name'];
    $tipo_foto = $foto['type'];
    $tamanho_foto = $foto['size'];

    $info = new SplFileInfo($nome_foto);
    $extensao_arq = $info->getExtension();
    $novo_nome_foto = $nome . "." . $extensao_arq;

    if (trim($nome) == "" || trim($especie) == "" || trim($altura) == "" || trim($peso) == "") {
        echo "<div class='alert alert-danger' role='alert'>Todos os campos são obrigatórios ! ❌</div>";
    } else if (($nome_foto != "") && (!preg_match('/^image\/(jpeg|png|gif)$/', $tipo_foto))) {
        echo "<div class='alert alert-danger' role='alert'>Imagem inválida ! ❌</div>";
    } else if (($nome_foto != "") && ($tamanho_foto > TAMANHO_MAXIMO)) {
        echo "<div class='alert alert-danger' role='alert'>A imagem deve ser menor que 2MB ! ❌</div>";
    } else {
        if ($nome_foto != "") {
            if (move_uploaded_file($foto['tmp_name'], $upload_dir . $novo_nome_foto)) {
                $stmt = $pdo->prepare("select * from flores where nome = :nome");
                $stmt->bindValue(':nome', $nome);
                $stmt->execute();

                $rows = $stmt->rowCount();

                if ($rows <= 0) {
                    $sql = "INSERT INTO flores (nome, especie, altura, peso, categoria, foto) VALUES (:nome, :especie, :altura, :peso, :categoria, :foto)";

                    $stmt = $pdo->prepare($sql);
                    $stmt->bindValue(':nome', $nome);
                    $stmt->bindValue(':especie', $especie);
                    $stmt->bindValue(':altura', $altura);
                    $stmt->bindValue(':peso', $peso);
                    $stmt->bindValue(':categoria', $categoria);
                    $stmt->bindValue(':foto', $novo_nome_foto);

                    $stmt->execute();



                    echo "<div class='alert alert-success' role='alert'>Flor cadastrada com sucesso ! 💚</div>";

                    if (!$stmt) {
                        die('Erro ao cadastrar flor');
                    }
                } else {
                    echo "<div class='alert alert-danger' role='alert'>Erro ao cadastrar flor ! ❌</div>";
                }
                echo "<div class='alert alert-success' role='alert'>Imagem enviada com sucesso ! 💚</div>";
            } else {
                echo "<div class='alert alert-danger' role='alert'>Erro ao enviar imagem ! ❌</div>";
            }
        } else {
            echo "<div class='alert alert-danger' role='alert'>Erro ao enviar imagem ! ❌</div>";
        }
    }
}

function consultarFlores($especie) {
    include("conexaoBD.php");

    if (isset($_POST["especie"]) && $_POST["especie"] != "") {
        $stmt = $pdo->prepare("select * from flores where especie= :especie order by nome");
        $stmt->bindParam(':especie', $especie);
    } else {
        $stmt = $pdo->prepare("select * from flores order by nome");
    }

    try {
        $stmt->execute();

        
    }
}
?>