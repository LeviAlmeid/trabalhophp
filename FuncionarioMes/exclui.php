<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Excluir Registro</title>
    <link rel="stylesheet" href="bootstrap/css/bootstrap.css">
    <link rel="stylesheet" href="css/estilo.css">
</head>
<body>

<div class="container">
    <h1>Excluir Registro</h1>
    <form  id="deleteForm">
        <div class="form-group">
            <label for="funcionario">Selecione o Funcionário:</label>
            <select class="form-control" id="funcionario" name="funcionario" required>
                <option value="">Selecione um funcionário</option>
                <?php
                $servername = "localhost";
                $username = "root";
                $password = "";
                $dbname = "dbempresa";

                $conn = new mysqli($servername, $username, $password, $dbname);

                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $sql = "SELECT codigo, nome FROM tbfuncmes group by nome";
                $result = $conn->query($sql);

                if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) {
                        echo "<option value='" . $row["nome"] . "'>" . htmlspecialchars($row["nome"]) . "</option>";
                    }
                } else {
                    echo "<option value=''>Nenhum funcionário encontrado</option>";
                }

                $conn->close();
                ?>
            </select>
        </div>
        <button type="submit" class="btn btn-danger">Excluir</button>
    </form>
    <div id="response" class="mt-3"></div>
</div>

<script src="bootstrap/js/bootstrap.bundle.min.js"></script>
<script>
    document.getElementById('deleteForm').addEventListener('submit', function(event) {
        event.preventDefault(); 

        const codigo = document.getElementById('funcionario').value;

        fetch('excluiraction.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ codigo: codigo })
        })
        .then(response => response.json())
        .then(data => {
            document.getElementById('response').innerHTML = data.message;
            if (data.message.includes('sucesso')) {
                setTimeout(() => {
                    location.reload();
                }, 2000); 
            }
        })
        .catch(error => {
            console.error('Erro:', error);
        });
    });
</script>
</body>
</html>