<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbempresa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(['message' => 'Connection failed: ' . $conn->connect_error]));
}

$data = json_decode(file_get_contents('php://input'), true);
$codigo = $data['codigo'];

$sql = "DELETE FROM tbfuncmes WHERE nome = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("s", $codigo); 

if ($stmt->execute()) {
    $response = ['message' => 'Registro excluído com sucesso.'];
} else {
    $response = ['message' => 'Erro ao excluir o registro: ' . $stmt->error];
}

$stmt->close();
$conn->close();

header('Content-Type: application/json');
echo json_encode($response);
?>