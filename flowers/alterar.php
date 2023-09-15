<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-4bw+/aepP/YC94hEpVNVgiZdgIC5+VKNBQNGCHeKRQN+PtmoHDEXuppvnDJzQIu9" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.1/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-HwwvtgBNo3bZJJLYd8oVXjrBZt8cqVSpeBNS5n7C8IVInixGAoxmnlMuBnhbgrkm"
        crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.5/font/bootstrap-icons.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>💐🌷🌼🌸🌹</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand" href="#">🌷</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNavAltMarkup"
                aria-controls="navbarNavAltMarkup" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNavAltMarkup">
                <div class="navbar-nav">
                    <a class="nav-link" href="index.php">Cadastro</a>
                    <a class="nav-link" href="consulta.php" aria-current="page">Consulta</a>
                    <a class="nav-link active" href="#">Alterar</a>
                </div>
            </div>
        </div>
    </nav>

    <form method="POST" enctype="multipart/form-data" autocomplete="off">
        <div class="container-md">
            <br>
            <h1>Cadastro de Flores 🌷</h1>
            <br>
            <div class="mb-3">
                <label for="nome" class="form-label">Nome da flor que será alterada:</label>
                <input type="text" class="form-control" id="nome" aria-describedby="nome" name="nome" required>
            </div>
            <div class="mb-3">
                <label for="especie" class="form-label">Espécie:</label>
                <input type="text" class="form-control" id="especie" name="especie" required>
            </div>
            <div class="mb-3">
                <label for="altura" class="form-label">Altura:</label>
                <input type="number" step="0.1" min="0.1" class="form-control" id="altura" name="altura" required>
            </div>
            <div class="mb-3">
                <label for="peso" class="form-label">Peso:</label>
                <input type="number" step="0.1" min="0.1" class="form-control" id="peso" , name="peso" required>
            </div>
            <!-- botão para enviar -->
            <button type="submit" class="btn btn-warning">Alterar</button>

            <?php
            if ($_SERVER["REQUEST_METHOD"] === 'POST') {
                try {
                    include("conexaoBD.php");

                    $stmt = $pdo->prepare("update flores set especie=:especie, altura=:altura, peso=:peso where nome=:nome");
                    $stmt->bindParam(':nome', $_POST["nome"]);
                    $stmt->bindParam(':especie', $_POST["especie"]);
                    $stmt->bindParam(':altura', $_POST["altura"]);
                    $stmt->bindParam(':peso', $_POST["peso"]);

                    $stmt->execute();

                    echo "<div class='alert alert-success' role='alert'>Flor alterada com sucesso! ✅</div>";
                } catch (PDOException $e) {
                    echo "<div class='alert alert-danger' role='alert'>Erro ao alterar flor! ❌</div>";
                }
                
            }
            ?>
        </div>
    </form>
</body>

</html>