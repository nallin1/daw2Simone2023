<?php
function selectFlor($id)
{
    include("conexaoBD.php");

    $stmt = $pdo->prepare("select * from flores where id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    $rows = $stmt->rowCount();

    if ($rows > 0) {
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    } else {
        return false;
    }
}

function selectFlorNome($nome)
{
    include("conexaoBD.php");

    $stmt = $pdo->prepare("select * from flores where nome like :nome");
    $stmt->bindValue(':nome', $nome);
    $stmt->execute();

    $rows = $stmt->rowCount();

    if ($rows > 0) {
        $result = $stmt->fetch();
        return $result;
    } else {
        return false;
    }
}

function cadastrarFlor($nome, $especie, $altura, $peso, $categoria, $foto)
{
    session_start();
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
    $acao = true; // true consulta, false deleta
    include("conexaoBD.php");

    if ($_POST["especie"] != "") {
        $stmt = $pdo->prepare("select * from flores where especie= :especie order by nome");
        $stmt->bindParam(':especie', $especie);
    } else {
        $stmt = $pdo->prepare("select * from flores order by nome");
    }

    try {
        $stmt->execute();
        $acao = false;
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
                echo "<td class='table table-bordered'> <span style='padding:10px;'>" . $linha["nome"] . "</span><button type='submit' class='btn btn-danger' name='acaoDeletar' value='" . $idFlor . "'>Excluir Flor</button><button type='submit' class='btn btn-warning' name='acaoAlterar' value='" . $idFlor . "' style='margin:10px'>Alterar Dados</button></td>";
                echo "<td class='table table-bordered'>" . $linha["especie"] . "</td>";
                echo "<td class='table table-bordered'>" . $linha["altura"] . "</td>";
                echo "<td class='table table-bordered'>" . $linha["peso"] . "</td>";
                echo "<td class='table table-bordered'>" . $linha["categoria"] . "</td>";
                echo "<td class='table table-bordered'><img src='img/" . $linha["foto"] . "' width='100px' height='100px'></td>";
                echo "</tr>";
            }

            echo "</table>";
            echo "<br><br>";
            if ($_SERVER["REQUEST_METHOD"] === 'POST') {
                if (isset($_POST["acaoDeletar"]) && !$acao) {
                    $acao = true;
                    deletarFlor($_POST["acaoDeletar"]);
                } else if (isset($_POST["acaoAlterar"]) && !$acao) {
                    $acao = true;
                    $florAlterar = selectFlor($_POST["acaoAlterar"]);
                    $_POST["florAlterarid"] = $florAlterar["id"];
                    $_POST["florAlterarnome"] = $florAlterar["nome"];
                    $_POST["florAlterarespecie"] = $florAlterar["especie"];
                    $_POST["florAlteraraltura"] = $florAlterar["altura"];
                    $_POST["florAlterarpeso"] = $florAlterar["peso"];

                    header("Location: alterar.php");
                }
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
    //error_reporting(0);
    include("conexaoBD.php");

    // selecionar nome da foto na coluna foto cujo id é igual ao id da flor
    $stmt = $pdo->prepare("select foto from flores where id = :id");
    $stmt->bindValue(':id', $id);
    $nomeFoto = $stmt->execute();
    $row = $stmt->fetch();
    $arquivoFoto = $row["foto"];

    unlink("./img/" . $arquivoFoto);

    // deletar flor do banco de dados
    $stmt = $pdo->prepare("delete from flores where id = :id");
    $stmt->bindValue(':id', $id);
    $stmt->execute();

    echo "<div class='alert alert-success' role='alert'>Flor deletada com sucesso ! 💚</div>";

    $pdo = null;
}
function alterarFlor($nome, $especie, $peso, $altura, $novaFoto)
{
    try {

        include("conexaoBD.php");

        define('TAMANHO_MAXIMO', (2 * 1024 * 1024));
        $uploaddir = './img/';
        $nomeFoto = $novaFoto["name"];
        $tipoFoto = $novaFoto["type"];
        $tamanhoFoto = $novaFoto["size"];

        //gerando novo nome para a foto
        $info = new SplFileInfo($nomeFoto);
        $extensaoArq = $info->getExtension();
        $nomeFoto = $nomeFoto . "." . $extensaoArq;
        /*
        $stmt = $pdo->prepare("update flores set especie = :especie, peso = :peso, altura = :altura where nome like :nome");
        $stmt->bindValue(':nome', $nome);
        $stmt->bindValue(':especie', $especie);
        $stmt->bindValue(':peso', $peso);
        $stmt->bindValue(':altura', $altura);
        $stmt->execute();
        */

        if (($nomeFoto != "") && (!preg_match('/^image\/(jpeg|png|gif)$/', $tipoFoto))) {
            echo "<span id='error'>Isso não é uma imagem válida</span>";

        } else if (($nomeFoto != "") && ($tamanhoFoto > TAMANHO_MAXIMO)) { //validação tamanho arquivo
            echo "<span id='error'>A imagem deve possuir no máximo 2 MB</span>";
        } else if (($nomeFoto != "") && (move_uploaded_file($_FILES['foto']['tmp_name'], $uploaddir . $nomeFoto))) {
            $uploadfile = $uploaddir . $nomeFoto; // caminho/nome da imagem

            //só altera a foto se for feito um novo upload
            $stmt = $pdo->prepare("update flores set especie = :especie, peso = :peso, altura = :altura, foto = :foto where nome like :nome");
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':especie', $especie);
            $stmt->bindValue(':peso', $peso);
            $stmt->bindValue(':altura', $altura);
            $stmt->bindValue(':foto', $nomeFoto);
            $stmt->execute();

        } else {
            //senão mantem a foto anterior, não fazendo update do campo arquivoFoto
            $stmt = $pdo->prepare("update flores set especie = :especie, peso = :peso, altura = :altura where nome like :nome");
            $stmt->bindValue(':nome', $nome);
            $stmt->bindValue(':especie', $especie);
            $stmt->bindValue(':peso', $peso);
            $stmt->bindValue(':altura', $altura);
            $stmt->execute();
        }
        // Adicione aqui qualquer código adicional que você deseja executar após a atualização bem-sucedida.

    } catch (Exception $e) {
        echo "Erro genérico ao atualizar a flor: " . $e->getMessage();
    }
}