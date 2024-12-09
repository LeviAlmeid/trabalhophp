<?php
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

// Recebe os dados do formulário
$funcionario = $_POST['func'];
$valorVenda = $_POST['valor'];
$mes = $_POST['mes'];
$ano = $_POST['ano'];

// Verifica se uma nova imagem foi enviada
$caminhoImg = '';
if (isset($_FILES['foto']) && $_FILES['foto']['error'] == 0) {
    $extensao = pathinfo($_FILES['foto']['name'], PATHINFO_EXTENSION);
    $caminhoImg = 'img/' . uniqid() . '.' . $extensao; // Gera um nome único para a imagem

    // Move a imagem para o diretório de uploads
    move_uploaded_file($_FILES['foto']['tmp_name'], $caminhoImg);
}

// Atualiza os dados do funcionário no banco de dados
if ($caminhoImg) {
    // Se uma nova imagem foi enviada, atualiza o caminho da imagem
    $sql = "UPDATE tbfuncmes SET nome = '$funcionario', vrvenda = '$valorVenda', caminhoimg = '$caminhoImg' WHERE mes = '$mes' AND ano = '$ano'";
} else {
    // Se não houve nova imagem, apenas atualiza o nome e o valor
    $sql = "UPDATE tbfuncmes SET nome = '$funcionario', vrvenda = '$valorVenda' WHERE mes = '$mes' AND ano = '$ano'";
}

if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Registro atualizado com sucesso!'); window.history.back();</script>";
} else {
    echo "<script>alert('Erro ao atualizar registro: '" . $conn->error . "); window.history.back();</script>" . $conn->error;
}

// Fecha a conexão
$conn->close();
?>