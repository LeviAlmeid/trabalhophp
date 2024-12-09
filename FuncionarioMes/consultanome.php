<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Consulta de Vendas</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

<div class="container">
    <?php
    // Verifica se o parâmetro 'nome' está definido
    if (isset($_GET['nome']) && !empty($_GET['nome'])) {
        $nome = $_GET['nome'];

        // Conexão com o banco de dados
        $servername = "localhost";
        $username = "root";
        $password = "";
        $dbname = "dbempresa";

        $conn = new mysqli($servername, $username, $password, $dbname);

        // Verifica a conexão
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }

        // Prepara a consulta SQL
        $sql = "SELECT * FROM tbfuncmes WHERE nome = ?";
        $stmt = $conn->prepare($sql); 

        // Vincula o parâmetro do nome
        $stmt->bind_param("s", $nome); 

        // Executa a consulta
        $stmt->execute();

        // Obtém o conjunto de resultados
        $result = $stmt->get_result();

        // Exibe os resultados
        if ($result->num_rows > 0) {
            echo "<h1>CONSULTA</h1>";
            echo "<table class='table table-bordered'>";

            while ($row = $result->fetch_assoc()) {
                echo "<tr>";
                echo "<td colspan='5' style='text-align: center;'><img src='" . $row["caminhoimg"] . "' alt='" . $row["nome"] . "' width='100'> </td>";
                echo "</tr>";
                echo "<tr><th>Nome</th><th>Mês</th><th>Ano</th><th>Valor Venda</th><th>Valor Bônus</th></tr>";
                echo "<tbody>";
                echo "<tr>";
                echo "<td>" . htmlspecialchars($row["nome"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["mes"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["ano"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["vrvenda"]) . "</td>";
                echo "<td>" . htmlspecialchars($row["vrbonus"]) . "</td>";
                echo "</tr>";
            }
            echo "</tbody></table>";
        } else {
            echo "<h2>Nenhum resultado encontrado para " . htmlspecialchars($nome) . "</h2>";
        }

        // Fecha a conexão
        $conn->close();
    } else {
        echo "<h2>Por favor, selecione um funcionário para consultar.</h2>";

    }
    ?>
</div>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
</body>
</html>