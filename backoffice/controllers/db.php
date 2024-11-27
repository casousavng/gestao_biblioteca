<?php
// Configurações de conexão com a base de dados Oracle
$host = 'localhost';
$port = '1521';
$sid = 'xe';
$username = 'c##biblioteca';
$password = 'senha123';

$dsn = "oci:dbname=(DESCRIPTION=(ADDRESS=(PROTOCOL=TCP)(HOST=$host)(PORT=$port))(CONNECT_DATA=(SID=$sid)));charset=UTF8";

try {
    // Conexão com o banco de dados Oracle usando PDO
    $conn = new PDO($dsn, $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Erro ao conectar ao Oracle: " . $e->getMessage();
    exit;
}
