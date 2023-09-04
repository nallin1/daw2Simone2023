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

    <form method="POST" enctype="multipart/form-data">
        <div class="container-md">
            <br>
            <h1>Cadastro de Planta 🌷</h1>
            <br>
            <div class="mb-3">
                <label for="nome" class="form-label">Nome:</label>
                <input type="text" class="form-control" id="nome" aria-describedby="nome" name="nome">
            </div>
            <div class="mb-3">
                <label for="especie" class="form-label">Espécie:</label>
                <input type="text" class="form-control" id="especie" name="especie">
            </div>
            <div class="mb-3">
                <label for="altura" class="form-label">Altura:</label>
                <input type="number" class="form-control" id="altura" name="altura">
            </div>
            <div class="mb-3">
                <label for="peso" class="form-label">Peso:</label>
                <input type="number" class="form-control" id="peso", name="peso">
            </div>
            <div class="mb-3">
                <label for="foto" class="form-label">Foto:</label>
                <input type="file" class="form-control" id="foto" accept="image/*" name="foto">
            </div>
            <br>
            <div>
                <label for="categoria" class="form-label">Categoria:</label>
                <select class="form-select" aria-label="categoria" name="categoria">
                    <option selected>Categoria</option>
                    <option value="1">Suculenta</option>
                    <option value="2">Cacto</option>
                    <option value="3">Flor</option>
                    <option value="4">Outro...</option>
                </select>
            </div>
            <br><br>
            <input type="submit"
                style="background-color: lightgreen;padding: 15px;border:none;border-radius:10px;">
        </div>
    </form>
</body>

</html>


<?php
if ($_SERVER["REQUEST_METHOD"] === 'POST') {
    try {
        $nome = $_POST["nome"];
        $especie = $_POST["especie"];
        $altura = $_POST["altura"];
        $peso = $_POST["peso"];
        $categoria = $_POST["categoria"];
        $foto = $_FILES["foto"];

        require_once("functions.php");
        cadastrarFlor($nome, $especie, $altura, $peso, $categoria, $foto);
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>