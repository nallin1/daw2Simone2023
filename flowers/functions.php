<?php
// faça uma funçao para cadastrar um flor 
/*
function cadastrarFlor($nome, $preco, $quantidade, $descricao, $imagem){
    $sql = "INSERT INTO flores (nome, preco, quantidade, descricao, imagem) VALUES ('$nome', '$preco', '$quantidade', '$descricao', '$imagem')";
    $resultado = mysqli_query($cnx = conn(), $sql);
    if(!$resultado) { die('Erro ao cadastrar flor' . mysqli_error($cnx)); }
    return 'Flor cadastrada com sucesso!';
}
*/

function cadastrarFlor($nome, $especie, $altura, $peso, $categoria, $foto) {
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

    if (trim($nome) || trim($especie) || trim($altura) || trim($peso)) {
        echo "<span id='warning'>Todos os campos são obrigatórios!</span>";
    } else if (($nome_foto != "") && (!preg_match('/^image\/(jpeg|png|gif)$/', $tipo_foto))) {
        echo "<span id='error'>Isso não é uma imagem válida</span>";
    } else if (($nome_foto != "") && ($tamanho_foto > TAMANHO_MAXIMO)) {
        echo "<span id='error'>A imagem deve possuir no máximo 2MB</span>";
    } else {
        if ($nome_foto != "") {
            if (move_uploaded_file($foto['tmp_name'], $upload_dir . $novo_nome_foto)) {
                $stmt = $pdo->prepare("select * from flores where nome = :nome");
                $stmt->bindParam(':nome', $nome);
                $stmt->execute();

                $rows = $stmt->rowCount();

                if ($rows <= 0) {
                    $sql = "INSERT INTO flores (nome, especie, altura, peso, categoria, foto) VALUES ('$nome', '$especie', '$altura', '$peso', '$categoria', '$novo_nome_foto')";
                    
                    $stmt = $pdo->prepare($sql);
                    $stmt->bindParam(':nome', $nome);
                    $stmt->bindParam(':especie', $especie);
                    $stmt->bindParam(':altura', $altura);
                    $stmt->bindParam(':peso', $peso);
                    $stmt->bindParam(':categoria', $categoria);
                    $stmt->bindParam(':foto', $novo_nome_foto);
                    $stmt->execute();

                    echo "<span id='success'>Flor cadastrada com sucesso!</span>";

                    if (!$resultado) {
                        die('Erro ao cadastrar flor' . mysqli_error($cnx));
                    }
                } else {
                    echo "<span id='warning'>Flor já cadastrada!</span>";
                }
                echo "<span id='success'>Imagem enviada com sucesso!</span>";
            } else {
                echo "<span id='error'>Erro ao enviar imagem!</span>";
            }
        } else {
            echo "<span id='warning'>Imagem não enviada!</span>";
        }
    }
}
?>