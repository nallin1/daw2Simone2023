<!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- <link rel="stylesheet" href="global.css"> -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
    <title>🌼</title>
    <style></style>
</head>

<body>

    <form>
        <div class="container-md">
            <br>
            <h1>Cadastro de Planta 🍁🔥</h1>
            <br>
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" class="form-control" id="nome" aria-describedby="nome">
            </div>
            <div class="mb-3">
                <label for="especie" class="form-label">Espécie:</label>
                <input type="password" class="form-control" id="especie">
            </div>
            <div class="mb-3">
                <label for="altura" class="form-label">Altura:</label>
                <input type="password" class="form-control" id="altura">
            </div>
            <div class="mb-3">
                <label for="peso" class="form-label">Peso:</label>
                <input type="password" class="form-control" id="peso">
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto:</label>
                <input type="file" class="form-control" id="foto" accept="image/*">
            </div>
            <br>
            <div>
                <label for="categoria" class="form-label">Categoria:</label>
                <select class="form-select" aria-label="categoria">
                    <option selected>Categoria</option>
                    <option value="1">Suculenta</option>
                    <option value="2">Cacto</option>
                    <option value="3">Flor</option>
                    <option value="4">Outro...</option>
                </select>
            </div>
            <br><br>
            <input type="submit" onclick="window.open('cadastra.php', '_top');"
                style="background-color: lightgreen;padding: 15px;border:none;border-radius:10px;">
        </div>

    </form>
</body>

</html>


<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $cod = $_POST["cod"];
        $especie = $_POST["especie"];
        $altura = $_POST["altura"];
        $peso = $_POST["peso"];
        $tipo_planta = $_POST["tipo_planta"];
        $foto = $_FILES["foto"];

        include_once("conexaoBD.php");

        if ((trim($cod) != "") || (trim($especie) != "")) {
            $stmt = $pdo->prepare("select from flores * where cod = :cod");
            $stmt->bindParam(':cod', $cod);
            $stmt->execute();

            $rows = $stmt->rowCount();

            if ($rows > 0) {
                echo "<script>alert('Código já cadastrado!');</script>";
            } else {
                $sql = "INSERT INTO flores (cod, especie, altura, peso, tipo_planta, foto) VALUES ('$cod', '$especie', '$altura', '$peso', '$tipo_planta', '$caminho_salvar')";
                $stmt = $pdo->prepare($sql);
                $stmt->bindParam(':cod', $cod);
                $stmt->bindParam(':especie', $especie);
                $stmt->bindParam(':altura', $altura);
                $stmt->bindParam(':peso', $peso);
                $stmt->bindParam(':tipo_planta', $tipo_planta);
                $stmt->bindParam(':foto', $caminho_salvar);
                $stmt->execute();

                echo "<script>alert('Cadastro realizado com sucesso!');</script>";
            }

        } else {
            echo "<script>alert('Código e espécie são obrigatórios!');</script>";
        }

    } catch (PDOException $e) {
        echo "Erro ao cadastrar: " . $e->getMessage();
    }
}

?>