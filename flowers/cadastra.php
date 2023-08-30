<?php

include("conexaoBD.php");

// Constante para o tam máximo de arquivo de foto
define('TAMANHO_MAXIMO', (2 * 1024 * 1024));

if ($_SERVER["REQUEST_METHOD"] === 'POST') {

    try {
        //inserindo dados
        $ra = $_POST["ra"];
        $nome = $_POST["nome"];
        $curso = $_POST["curso"];

        //upload dir
        $uploaddir = 'upload/fotos/'; //diretório onde será gravado a imagem

        //foto
        $foto = $_FILES['foto'];
        $nomeFoto = $foto['name'];
        $tipoFoto = $foto['type'];
        $tamanhoFoto = $foto['size'];

        //gerando novo nome para a foto evitando sobrescrita
        $info = new SplFileInfo($nomeFoto);
        $extensaoArq = $info->getExtension();
        $novoNomeFoto = $ra . "." . $extensaoArq;

        if ((trim($ra) == "") || (trim($nome) == "")) {
            echo "<span id='warning'>RA e nome são obrigatórios!</span>";

        } else if (($nomeFoto != "") && (!preg_match('/^image\/(jpeg|png|gif)$/', $tipoFoto))) { //validção tipo arquivo
            echo "<span id='error'>Isso não é uma imagem válida</span>";

        } else if (($nomeFoto != "") && ($tamanhoFoto > TAMANHO_MAXIMO)) { //validação tamanho arquivo
            echo "<span id='error'>A imagem deve possuir no máximo 2 MB</span>";

        } else {
            //verificando se o RA informado já existe no BD para não dar exception
            $stmt = $pdo->prepare("select * from alunos where ra = :ra");
            $stmt->bindParam(':ra', $ra);
            $stmt->execute();

            $rows = $stmt->rowCount();

            if ($rows <= 0) {

                if (
                    ($nomeFoto != "") &&
                    (
                        move_uploaded_file(
                            $_FILES['foto']['tmp_name'],
                            $uploaddir . $novoNomeFoto
                        )
                    )
                ) {
                    // caminho/nome da imagem p/ gravar no BD
                    $uploadfile = $uploaddir . $novoNomeFoto;
                } else {
                    $uploadfile = null;
                    echo "Sem upload de imagem.";
                }

                $stmt = $pdo->prepare("insert into alunos (ra, nome, curso, arquivoFoto) values(:ra, :nome, :curso, :arquivoFoto)");
                $stmt->bindParam(':ra', $ra);
                $stmt->bindParam(':nome', $nome);
                $stmt->bindParam(':curso', $curso);
                $stmt->bindParam(':arquivoFoto', $uploadfile);
                $stmt->execute();

                echo "<span id='sucess'>Aluno Cadastrado!</span>";
            } else {
                echo "<span id='error'>Ra já existente!</span>";
            }
        }

    } catch (PDOException $e) {
        echo 'Error: ' . $e->getMessage();
    }
}
?>