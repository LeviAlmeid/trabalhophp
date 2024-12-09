<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "dbempresa";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$mes = $_GET['mes'];
$ano = $_GET['ano'];

$sql = "SELECT nome, vrvenda, caminhoimg FROM tbfuncmes WHERE mes = '$mes' AND ano = '$ano'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    echo json_encode($row);
} else {
    echo json_encode([]);
}

$conn->close();
?>