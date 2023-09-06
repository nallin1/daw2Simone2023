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
    $pdo = null;
}

function consultarFlores($especie)
{
    include("conexaoBD.php");

    if ($_POST["especie"] != "") {
        $stmt = $pdo->prepare("select * from flores where especie= :especie order by nome");
        $stmt->bindParam(':especie', $especie);
    } else {
        $stmt = $pdo->prepare("select * from flores order by nome");
    }

    try {
        $stmt->execute();
        echo "<form method='post'>";
        echo "<table class='table table-bordered'>";
        echo "<tr class='table table-bordered'>";
        echo "<th class='table table-bordered'>Nome</th>";
        echo "<th class='table table-bordered'>Espécie</th>";
        echo "<th class='table table-bordered'>Altura</th>";
        echo "<th class='table table-bordered'>Peso</th>";
        echo "<th class='table table-bordered'>Categoria</th>";
        echo "<th class='table table-bordered'>Foto</th>";
        echo "</tr>";

        if ($stmt->rowCount() == 0) {
            echo "<div class='alert alert-danger' role='alert'>Não foi possível encontrar uma flor! ❌</div>";
        } else {
            
            while ($linha = $stmt->fetch()) {
                $idFlor = $linha["id"];
                echo "<tr class='table table-bordered'>";
                echo "<td class='table table-bordered'>
                <input class='form-check-input' type='checkbox' value='" . $idFlor ."' id='flexCheckDefault'>" . $linha["nome"] . "</td>";
                echo "<td class='table table-bordered'>" . $linha["especie"] . "</td>";
                echo "<td class='table table-bordered'>" . $linha["altura"] . "</td>";
                echo "<td class='table table-bordered'>" . $linha["peso"] . "</td>";
                echo "<td class='table table-bordered'>" . $linha["categoria"] . "</td>";
                echo "<td class='table table-bordered'><img src='img/" . $linha["foto"] . "' width='100px' height='100px'></td>";
                echo "</tr>";
            }

            echo "</table>";
            echo "<br><br>";
            echo "<input type='submit' class='btn btn-danger' value='Deletar'>";
            if ($_SERVER["REQUEST_METHOD"] === 'POST') {
                deletarFlor($idFlor);
            }
            echo "</form>";
        }

    } catch (PDOException $e) {
        echo "<div class='alert alert-danger' role='alert'>Não foi possível encontrar uma flor! ❌</div>";
        die("Erro: " . $e->getMessage());
    }
    $pdo = null;
}

function deletarFlor($id)
{
    include("conexaoBD.php");

    $stmt = $pdo->prepare("select * from flores where id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    $rows = $stmt->rowCount();

    if ($rows <= 0) {
        echo "<div class='alert alert-danger' role='alert'>Erro ao deletar flor ! ❌</div>";
    } else {
        $stmt = $pdo->prepare("delete from flores where id = :id");
        $stmt->bindValue(':id', $id);
        $stmt->execute();

        echo "<div class='alert alert-success' role='alert'>Flor deletada com sucesso ! 💚</div>";
    }
    $pdo = null;
}
?>