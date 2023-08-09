<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="global.css">
    <title>🌼</title>
</head>
<body>
    <h1>Cadastro de Planta</h1>
    <form method="POST" enctype="multipart/form-data">
        <div class="input">
            <label for="cod">Código:</label>
            <input type="text" name="cod" id="cod">
        </div>
        

        <div class="input">
            <label for="especie">Espécie:</label>
            <input type="text" id="especie" name="especie" required>
        </div>

        <div class="input">
            <label for="altura">Altura (cm):</label>
            <input type="number" id="altura" name="altura" min="1">
        </div>
        
        <div class="input">
            <label for="peso">Peso (g):</label>
            <input type="number" id="peso" name="peso" min="1">
        </div>
        

        <div class="input">
            <label for="foto">Foto:</label>
            <input type="file" id="foto" name="foto" accept="image/*" style="width: 100%;">
        </div>
        

        <div class="input"><label for="tipo_planta">Tipo da Planta:</label>
        <select name="tipo_planta" id="tipo_planta">
            <option value=""></option>
            <option value="Suculenta">Suculenta</option>
            <option value="Orquídea">Orquídea</option>
            <option value="Cacto">Cacto</option>
            <option value="Bromélia">Bromélia</option>
            <option value="Samambaia">Samambaia</option>
            <option value="Bonsai">Bonsai</option>
            <option value="Outro">Outro</option>
        </select></div>
        

        <input type="submit" style="width:30%;margin-top:3vh;"></input>
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