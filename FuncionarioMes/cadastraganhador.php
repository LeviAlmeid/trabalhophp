<?php


$servername = "localhost";
$database = "dbempresa";
$username = "root";
$password = "";
// Create connection
$conn = mysqli_connect($servername, $username, $password, $database);
// Check connection
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
echo "Connected successfully";







if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Dados do formulário
    $funcionario = $_POST['func'];
    $valor_vendas = $_POST['valor'];
    $mes = strftime('%B', strtotime('now'));
    $ano = date('Y');

    $arquivo = $_FILES['foto'];
    $caminho_img = 'img/' . $arquivo['name'];

    // Verificar se já existe registro para o mesmo mês e ano
    $sql_verificar = "SELECT * FROM tbfuncmes WHERE mes = ? AND ano = ?";
    $stmt = $conn->prepare($sql_verificar);
    $stmt->bind_param('si', $mes, $ano);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($resultado->num_rows > 0) {
        echo "<script>alert('Erro: Já existe um cadastro para este mês e ano.'); window.history.back();</script>";
        exit();
    }

    // Calcular o bônus
    $bonus = calcular_bonus($valor_vendas);

    // Inserir os dados no banco de dados
    $sql_inserir = "INSERT INTO tbfuncmes (nome, vrvenda, vrbonus, caminhoimg, mes, ano) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($sql_inserir);
    $stmt->bind_param('sddssi', $funcionario, $valor_vendas, $bonus, $caminho_img, $mes, $ano);

    if ($stmt->execute()) {
        // Salvar a imagem no diretório
        if (move_uploaded_file($arquivo['tmp_name'], $caminho_img)) {
            echo "<script>alert('Funcionário do Mês cadastrado com sucesso!'); window.location.href = 'cadastro.php';</script>";
        } else {
            echo "<script>alert('Erro: Não foi possível salvar a imagem.'); window.history.back();</script>";
        }
    } else {
        echo "<script>alert('Erro: Não foi possível cadastrar os dados.'); window.history.back();</script>";
    }
}

$conn->close();

// Função para calcular o bônus
function calcular_bonus($valor_vendas) {
    if ($valor_vendas < 500) {
        return $valor_vendas * 0.01;
    } elseif ($valor_vendas <= 3000) {
        return $valor_vendas * 0.05;
    } elseif ($valor_vendas <= 10000) {
        return $valor_vendas * 0.10;
    } else {
        return $valor_vendas * 0.15;
    }
}
?>
